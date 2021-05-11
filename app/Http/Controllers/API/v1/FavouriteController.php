<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\FavouriteCreateRequest;
use App\Http\Resources\FavouriteR;
use App\Http\Resources\ProductR;
use App\Models\Favourite;
use App\Models\Product;
use Illuminate\Http\Request;

class FavouriteController extends ApiController
{
    public function __construct()
    {
        $this->user = auth('api')->user();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*$productIds = $this->user->favourites->where('is_deleted', 0)->pluck('product_id');
        $_productIds = Product::where('is_deleted', 0)->whereIn('id', $productIds)->pluck('id');
        $favourites = $this->user->favourites->where('is_deleted', 0)
            ->whereIn('product_id', $_productIds)->sortBy('created_at');*/
        $favourites = $this->user->favourites->where('is_deleted', 0);
        $data = FavouriteR::collection($favourites);
        return $this->responded('Get list favourites successfully', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(FavouriteCreateRequest $request)
    {
        //
        $validated = $request->validated();
        $product = Product::find($validated['product_id']);
        if (!$product) {
            $data = ['product_id' => 'Không tồn tại'];
            return $this->respondedError("Create favourite failed", $data);
        }

        if ($product->favourited) {
            $data = ['product_id' => 'Đã yêu thích'];
            return $this->respondedError("Create favourite failed", $data);
        }

        $data = $this->user->favourites()->create($validated);
        return $this->responded('Create favourite successfully', $data);

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Favourite $favourite
     * @return \Illuminate\Http\Response
     */
    public function show(Favourite $favourite)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Favourite $favourite
     * @return \Illuminate\Http\Response
     */
    public function edit(Favourite $favourite)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Favourite $favourite
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Favourite $favourite)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param FavouriteCreateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(FavouriteCreateRequest $request)
    {
        //
        $validated = $request->validated();
        $favourite = $this->user->favourites->where('is_deleted', 0)->where('product_id', $validated['product_id'])->first();
        if (!$favourite) {
            return $this->respondedError('Not authorizated');
        }
        $favourite->update(['is_deleted' => 1]);
        return $this->responded('Delete favourite successfully');
    }
}
