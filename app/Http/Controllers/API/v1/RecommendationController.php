<?php

namespace App\Http\Controllers\API\v1;


use App\Http\Resources\ProductR;
use App\Http\Resources\SearchResultR;
use App\Models\Product;
use App\Models\User;
use App\Taka\Paginate\Paginate;
use Illuminate\Support\Facades\Auth;

class RecommendationController extends ApiController
{

    public function __construct()
    {
        $this->user = Auth::guard('api')->user();
    }

    public function index()
    {
        $limit = 10;
        $product_ids = $this->get_recommend_products($limit);
        $products = $product_ids->reduce(function ($acc, $product_id) {
            $product = Product::find($product_id);
            return $product ? $acc->push($product) : $acc;
        }, collect([]));

        return $this->responded('Get list recommend successfully', ProductR::collection($products));
    }

    //lấy danh sách mã sản phẩm gợi ý cho người dùng
    private function get_recommend_products($limit = 10)
    {
        $current_user = $this->user;
        $current_user_id = $current_user->id;
        $matrix = $this->init_matrix();
        $similarity_users = $this->sort_similarity_users($this->get_similarity_users($matrix, $current_user_id));
        $format_current_user = ['user_id' => $current_user_id, 'reviews' => $matrix[$current_user_id]];
        return $this->get_prediction($format_current_user, $similarity_users, $limit);
    }



    //khởi tạo ma trận người dùng - sản phẩm - điểm đánh giá
    private function init_matrix()
    {
        $temp_matrix = [];
        $users = User::all();
        $products = Product::all();
        foreach ($users as $user) {
            $user_id = $user->id;
            foreach ($products as $product) {
                $product_id = $product->id;
                $review = $user->reviews->where('product_id', $product->id)->first();
                $temp_matrix[$user_id][$product_id] = $review ? $review->star : 0;
            }
        }
        return $temp_matrix;
    }


    //lấy mảng chứa tính toán độ tương tự người dùng
    private function get_similarity_users($matrix, $current_user_id)
    {
        $similarity_users = [];
        $current_user_data = $matrix[$current_user_id];
        foreach ($matrix as $other_user_id => $other_user_data) {
            if ($other_user_id != $current_user_id) {
                $similarity_users[] = [
                    'user_id' => $other_user_id,
                    'value' => $this->calc_similary_cosine($current_user_data, $other_user_data),
                    'reviews' => $other_user_data
                ];
            }
        }
        return $similarity_users;
    }

    //sắp xếp mảng chứa người dùng có độ tương tự theo thứ tự giảm giầm
    private function sort_similarity_users($matrix)
    {
        dd(collect($matrix)->filter());
        return collect($matrix)->filter(function ($item) {
            return $item['value'];
        })->sortByDesc('value')->values()->toArray();
    }


    //tính toán độ tương tự giữa 2 người dùng bằng công thức cô-sin
    private function calc_similary_cosine($user_a, $user_b)
    {
        $dotProduct = $this->calc_dot_vectors($user_a, $user_b);
        return $dotProduct / ($this->calc_distance_vector($user_a) * $this->calc_distance_vector($user_b));
    }


    //tính toán tích vô hướng giữa 2 vec tơ đại diện cho mảng đánh giá của 2 người dùng
    private function calc_dot_vectors($current_user_data, $other_user_data)
    {
        return collect($current_user_data)->reduce(function ($acc, $value, $index) use ($other_user_data) {
            return $acc + $value * $other_user_data[$index];
        }, 0);
    }

    //tính toán độ dài véc tơ
    private function calc_distance_vector($user_data)
    {
        $value = collect($user_data)->reduce(function ($acc, $value) {
            return $acc + pow($value, 2);
        }, 0);
        return sqrt($value);
    }

    //tính toán diểm đánh giá trung bình của người dùng
    private function calc_average_ratings($user)
    {
        $reviews = $user['reviews'];
        $data = collect(array_filter($reviews)); //convert array just filter null to collection
        if ($data->count() == 0) return 0;
        return $data->reduce(function ($acc, $item) {
                return $acc + $item;
            }, 0) / count($data);
    }


    //lấy danh sách giá trị dự đoán sản phẩm cho người dùng
    private function get_prediction($current_user, $similarity_users, $limit = 10)
    {
        $matrix = collect([]);
        $current_user_avg_ratings = $this->calc_average_ratings($current_user);
        $not_purchased_products = $this->get_not_purchased_products($current_user);
        foreach ($not_purchased_products as $product_id => $rating) {
            $process1 = 0;
            $process2 = 0;
            foreach ($similarity_users as $other_user) {
                $avg_ratings = $this->calc_average_ratings($other_user);
                $process1 += $other_user['value'] * ($other_user['reviews'][$product_id] - $avg_ratings);
                $process2 += $other_user['value'];
            }

            $predicted_value = $current_user_avg_ratings + ($process1 / $process2);
            $temp = (object)[
                'product_id' => $product_id,
                'predicted_value' => $predicted_value,
                'user_id' => $current_user['user_id']
            ];
            $matrix->push($temp);
        }
        //dd($not_purchased_products,$matrix);
        $data = $matrix->sortByDesc('predicted_value')->values()->take($limit);
        //dd($data);
        return $data->pluck('product_id');
    }


    //lấy danh sách những sản phẩm mà người dùng chưa mua
    private function get_not_purchased_products($user)
    {
        return collect($user['reviews'])->filter(function ($item) {
            return $item == 0;
        })->toArray();
    }
}
