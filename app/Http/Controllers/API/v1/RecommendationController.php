<?php

namespace App\Http\Controllers\API\v1;


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
        $currentUser = $this->user;
        $users = User::all();
        $products = Product::all();
        $matrix = [];
        $temp = [];
        foreach ($users as $user) {
            foreach ($products as $product) {
                $review = $user->reviews->where('product_id', $product->id)->first();
                $matrix[$user->id][$product->id] = $review ? $review->star : 0;
            }
        }
        //dd($currentUser->id);

        foreach ($matrix as $userID => $rows) {
            if ($userID != $currentUser->id) {
                $temp[] = [
                    'user_id' => $userID,
                    'value' => $this->calcSimCosine($matrix[$currentUser->id], $rows),
                    'items' => $rows
                ];
            }
        }

        $similars = $this->sort($temp);
        //dd($similars);
        $tempCurrentUser = ['user_id' => $currentUser->id, 'items' => $matrix[$currentUser->id]];
        $productIDs = $this->getPrediction($tempCurrentUser, $similars);
        //dd($productIDs);
        $builder = Product::whereIn('id', $productIDs);
        //dd($builder->get());
        $brands = $builder->getElementRelation('brand');
        $suppliers = $builder->getElementRelation('supplier');
        $products = new Paginate($builder);
        $list_sort = [
            ['key' => 'default', 'value' => 'Bán chạy'],
            ['key' => 'new_products', 'value' => 'Hàng mới'],
            ['key' => 'low_price', 'value' => 'Giá thấp'],
            ['key' => 'high_price', 'value' => 'Giá cao'],
        ];
        $listDataToArray = (object)[
            'products' => $products, 'brands' => $brands,
            'suppliers' => $suppliers, 'sort_settings' => collect($list_sort)
        ];
        return $this->responded('Get list recommend successfully', new SearchResultR($listDataToArray));
    }


    private function printMatrix($matrix)
    {

        /*foreach ($matrix as $userID => $rows) {
            if ($userID == 1) {
                echo "\t\t";
                foreach ($rows as $product_id => $item) {
                    echo "$product_id\t";
                }
                echo "\n";
            }
            echo "$userID\t\t";

            foreach ($rows as $item) {
                echo "$item\t";
            }
            echo "\n";
        }*/

        //dd("ok");
    }

    private function calcSimCosine($userA, $userB)
    {
        $dotProduct = $this->calcDotProduct($userA, $userB);
        return $dotProduct / ($this->calcMagnitude($userA) * $this->calcMagnitude($userB));
    }

    private function calcDotProduct($userA, $userB)
    {
        return collect($userA)->reduce(function ($acc, $item, $index) use ($userB) {
            return $acc + $item * $userB[$index];
        }, 0);
    }

    private function calcMagnitude($user)
    {
        $tempValue = collect($user)->reduce(function ($acc, $item) {
            return $acc + pow($item, 2);
        }, 0);
        return sqrt($tempValue);
    }

    private function calcAVGRate($rows)
    {
        //$data = collect($rows);
        $data = collect(array_filter($rows));
        if ($data->count() == 0) return 0;
        return $data->reduce(function ($acc, $item) {
                return $acc + $item;
            }, 0) / count($data);
    }

    private function sort($matrix)
    {
        return collect($matrix)->filter(function ($item) {
            return $item['value'];
        })->sortByDesc('value')->values()->toArray();
        /*return collect($matrix)->filter(function ($item) {
            return $item['similar'];
        })->sortBy('similar')->values()->toArray();*/
    }

    private function getPrediction($currentUser, $similars)
    {
        $matrix = collect([]);
        $AVGRateCurrentUser = $this->calcAVGRate($currentUser['items']);
        $notBuyProducts = collect($currentUser['items'])->filter(function ($item) {
            return $item == 0;
        })->toArray();
        //dd($notBuyProducts);

        foreach ($notBuyProducts as $productID => $rate) {
            foreach ($similars as $similar) {
                //dd($similar);
                $avg = $this->calcAVGRate($similar['items']);
                //dd($similar['items'],$avg);
                $process1 = $similar['value'] * ($similar['items'][$productID] - $avg);
                $process2 = $similar['value'];
                $predict = $AVGRateCurrentUser + ($process1 / $process2);
                $temp = [
                    'product_id' => $productID,
                    'predict' => $predict,
                    'user_id' => $currentUser['user_id']
                ];
                $matrix->push((object)$temp);
            }
        }

        $data = $matrix->sortByDesc('predict')->values()->take(10);
        //dd($data);
        return $data->pluck('product_id');
    }
}


