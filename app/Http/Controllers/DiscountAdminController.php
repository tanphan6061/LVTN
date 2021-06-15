<?php

namespace App\Http\Controllers;

use App\Http\Requests\DiscountRequest;
use App\Models\Category;
use App\Models\Discount_code;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class DiscountAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $discount_codes = Discount_code::where('is_deleted', false)->where('is_global', true)->orderBy('created_at', 'DESC')->paginate(10);
        return view('discounts.list', compact('discount_codes'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories = Category::where('is_deleted', false)->where('parent_category_id', '!=', null)->get();
        return view('discounts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(DiscountRequest $request)
    {
        $data = $request->validate(
            array_merge(
                $request->rules(),
                [
                    'code' => [
                        'required',
                        'unique:discount_codes'
                    ]
                ]
            ),
            $request->messages(),
            $request->attributes()
        );
        $data['is_global'] = true;
        $discount = Auth::user()->discount_codes()->create($data);
        return redirect()->route('manage-discounts.index')->with('success', 'Thêm mã giảm giá thành công');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Discount_code $discount_code
     * @return \Illuminate\Http\Response
     */
    public function show(Discount_code $discount_code)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Discount_code $discount_code
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $discount_code = Discount_code::find($id);
        if (!$discount_code)
            return abort('404');

        $categories = Category::where('is_deleted', false)->where('parent_category_id', '!=', null)->get();
        return view('discounts.edit', compact('discount_code', 'categories'));
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Discount_code $discount_code
     * @return \Illuminate\Http\Response
     */
    public function update(DiscountRequest $request, $id)
    {
        //
        $discount_code = Discount_code::find($id);
        if (!$discount_code)
            return abort('404');
        $data = $request->validate(
            array_merge(
                $request->rules(),
                [
                    'code' => [
                        'required',
                        'unique' => Rule::unique('discount_codes')->where(function ($query) use ($discount_code) {
                            return $query->where('id', '!=', $discount_code->id);
                        })
                    ]
                ]
            ),
            $request->messages(),
            $request->attributes()
        );

        $discount_code->update($data);
        return redirect()->route('manage-discounts.index')->with('success', 'Cập nhật mã giảm giá thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Discount_code $discount_code
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $discount_code = Discount_code::find($id);
        if (!$discount_code)
            return abort('404');
        $discount_code->update(['is_deleted' => true]);
        return redirect()->back()->with('success', 'Xóa mã giảm giá thành công');
    }
}
