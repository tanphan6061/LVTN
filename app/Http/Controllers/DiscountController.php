<?php

namespace App\Http\Controllers;

use App\Http\Requests\DiscountRequest;
use App\Models\Discount_code;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $discount_codes = Auth::user()->discount_codes()->where([
            ['code', 'like', "%$request->q%"],
            ['is_deleted', false]
        ])->orderBy('created_at', 'DESC')->paginate(10);

        if ($request->q) {
            $discount_codes->setPath('?q=' . $request->q);
        }
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
        return view('discounts.create');
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
                        'unique' => Rule::unique('discount_codes')->where(function ($query) {
                            return $query->where('is_deleted', '!=', true);
                        })
                    ]
                ]
            ),
            $request->messages(),
            $request->attributes()
        );
        $discount = Auth::user()->discount_codes()->create($data);
        return redirect()->route('discounts.index')->with('success', 'Thêm mã giảm giá thành công');
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

        return view('discounts.edit', compact('discount_code'));
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
                            return $query->where('id', '!=', $discount_code->id)->where('is_deleted', '!=', true);
                        })
                    ]
                ]
            ),
            $request->messages(),
            $request->attributes()
        );

        $discount_code->update($data);
        return redirect()->route('discounts.index')->with('success', 'Cập nhật mã giảm giá thành công');
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
