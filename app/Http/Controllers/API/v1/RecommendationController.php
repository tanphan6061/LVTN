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
        $productIDs = $this->getRecommendProducts($limit);
        $products = $productIDs->reduce(function ($acc, $productID) {
            $product = Product::find($productID);
            return $acc->push($product);
        }, collect([]));

        return $this->responded('Get list recommend successfully', ProductR::collection($products));
    }

    private function getRecommendProducts($limit = 10)
    {
        $currentUser = $this->user;
        $matrix = $this->initTheMatrix();
        $similars = $this->getTheSimilars($matrix, $currentUser);
        $similars = $this->sortSimilars($similars);
        $tempCurrentUser = ['user_id' => $currentUser->id, 'items' => $matrix[$currentUser->id]];
        return $this->getPrediction($tempCurrentUser, $similars, $limit);
    }


    private function printMatrix($matrix)
    {
        foreach ($matrix as $userID => $rows) {
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
        }
    }

    private function initTheMatrix()
    {
        $tempMatrix = [];
        $users = User::all();
        $products = Product::all();
        foreach ($users as $user) {
            foreach ($products as $product) {
                $review = $user->reviews->where('product_id', $product->id)->first();
                $tempMatrix[$user->id][$product->id] = $review ? $review->star : 0;
            }
        }
        return $tempMatrix;
    }

    private function getTheSimilars($matrix, $currentUser)
    {
        $tempSimilars = [];
        foreach ($matrix as $userID => $rows) {
            if ($userID != $currentUser->id) {
                $tempSimilars[] = [
                    'user_id' => $userID,
                    'value' => $this->calcSimilarityCosine($matrix[$currentUser->id], $rows),
                    'items' => $rows
                ];
            }
        }
        return $tempSimilars;
    }

    private function sortSimilars($matrix)
    {
        return collect($matrix)->filter(function ($item) {
            return $item['value'];
        })->sortByDesc('value')->values()->toArray();
        /*return collect($matrix)->filter(function ($item) {
            return $item['similar'];
        })->sortBy('similar')->values()->toArray();*/
    }

    private function calcSimilarityCosine($userA, $userB)
    {
        $dotProduct = $this->calcDotProduct($userA, $userB);
        return $dotProduct / ($this->calcDistanceVector($userA) * $this->calcDistanceVector($userB));
    }

    private function calcDotProduct($userA, $userB)
    {
        return collect($userA)->reduce(function ($acc, $item, $index) use ($userB) {
            return $acc + $item * $userB[$index];
        }, 0);
    }

    private function calcDistanceVector($user)
    {
        $tempValue = collect($user)->reduce(function ($acc, $item) {
            return $acc + pow($item, 2);
        }, 0);
        return sqrt($tempValue);
    }

    private function calcAverageRating($items)
    {
        //$data = collect($rows);
        $data = collect(array_filter($items));
        if ($data->count() == 0) return 0;
        return $data->reduce(function ($acc, $item) {
                return $acc + $item;
            }, 0) / count($data);
    }


    private function getPrediction($currentUser, $similars, $limit = 10)
    {
        $matrix = collect([]);
        $averageRatingCurrentUser = $this->calcAverageRating($currentUser['items']);
        $notPurchasedProducts = collect($currentUser['items'])->filter(function ($item) {
            return $item == 0;
        })->toArray();
        //dd($notPurchasedProducts);

        foreach ($notPurchasedProducts as $productID => $rate) {
            foreach ($similars as $similar) {
                //dd($similar);
                $avg = $this->calcAverageRating($similar['items']);
                //dd($similar['items'],$avg);
                $process1 = $similar['value'] * ($similar['items'][$productID] - $avg);
                $process2 = $similar['value'];
                $predict = $averageRatingCurrentUser + ($process1 / $process2);
                $temp = [
                    'product_id' => $productID,
                    'predict' => $predict,
                    'user_id' => $currentUser['user_id']
                ];
                $matrix->push((object)$temp);
            }
        }

        $data = $matrix->sortByDesc('predict')->values()->take($limit);
        //dd($data);
        return $data->pluck('product_id');
    }
}


