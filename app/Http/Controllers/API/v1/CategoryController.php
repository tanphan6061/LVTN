<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Resources\CategoryR;
use App\Models\Category;
use App\Taka\Filters\CategoryFilter;

class CategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @param CategoryFilter $filter
     * @return \Illuminate\Http\Response
     */
    public function index(CategoryFilter $filter)
    {
        $categories = Category::filter($filter)->get();
        return $this->responded("Get categories successfully", CategoryR::collection($categories));
    }


    /**
     * Display the specified resource.
     *
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return $this->responded("Get category successfully", new CategoryR($category));
    }
}
