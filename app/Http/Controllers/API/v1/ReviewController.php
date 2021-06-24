<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ReviewCreateRequest;
use App\Http\Requests\Api\ReviewEditRequest;
use App\Http\Resources\ProductR;
use App\Http\Resources\ReviewR;
use App\Models\Product;
use App\Models\Review;
use App\Taka\Filters\ReviewFilter;
use App\Taka\Paginate\Paginate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends ApiController
{

    public function __construct()
    {
        $this->middleware('jwt.verify')->except(['index']);
        $this->user = Auth::guard('api')->user();
    }

    /**
     * Display a listing of the resource.
     *
     * @param ReviewFilter $filter
     * @return \Illuminate\Http\Response
     */
    public function index(ReviewFilter $filter)
    {
        $builder = Review::orderBy('updated_at', 'desc');
        $reviews = new Paginate($builder->filter($filter));
        $data = [
            'reviews' => ReviewR::collection($reviews->getData()),
            'count' => $reviews->getTotal(),
        ];

        return $this->responded('Get list reviews successfully', $data);
    }

    public function getListWaitingReview()
    {
        $productIDsAvailable = $this->user->listWaitingForReview;
        $builder = Product::whereIn('id', $productIDsAvailable);
        $products = new Paginate($builder);
        $data = [
            'products' => ProductR::collection($products->getData()),
            'count' => $products->getTotal()
        ];
        return $this->responded('Get list waiting for review successfully', $data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReviewCreateRequest $request)
    {
        $validated = $request->validated();
        $product = Product::find($validated['product_id']);
        $productIDsAvailable = $this->user->listWaitingForReview;
        if ($product && $product->reviewed) {
            return $this->respondedError("Ảo thật đấy", ['product' => 'Bạn đã đánh giá sản phẩm này rồi']);
        }

        if (!$productIDsAvailable->contains($product->id)) {
            return $this->respondedError("Ảo thật đấy", ['product' => 'Bạn không thể đánh giá sản phẩm này']);
        }

        $data = $this->user->reviews()->create($validated);
        return $this->responded("Create review successfully", $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Review $review
     * @return \Illuminate\Http\Response
     */
    public function update(ReviewEditRequest $request, Review $review)
    {
        //
        $validated = $request->validated();
        if ($review->user_id != $this->user->id) {
            return $this->respondedError("Ảo thật đấy", ['auth' => 'Ảo thật đấy']);
        }

        $data = $review->update($validated);
        return $this->responded("Update review successfully", $review);
    }

}
