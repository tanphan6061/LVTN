<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReviewR;
use App\Models\Product;
use App\Models\Review;
use App\Taka\Filters\ReviewFilter;
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
        $reviews = Review::filter($filter)->get();
        $data = [
            'count' => $reviews->count(),
        ];
        return $this->responded('Get list reviews successfully', $data);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Review $review
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Review $review
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Review $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review $review)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Review $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        //
    }
}
