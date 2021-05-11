<?php

namespace App\Http\Controllers;

use App\Models\Discount_code;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $discount_codes = Auth::user()->discount_codes()->paginate(10);
        return view('discounts.list',compact('discount_codes'));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Discount_code  $discount_code
     * @return \Illuminate\Http\Response
     */
    public function show(Discount_code $discount_code)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Discount_code  $discount_code
     * @return \Illuminate\Http\Response
     */
    public function edit(Discount_code $discount_code)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Discount_code  $discount_code
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Discount_code $discount_code)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Discount_code  $discount_code
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $discount_code = Discount_code::find($id);
        if(!$discount_code)
            return abort('404');
        $discount_code->delete();
        return redirect()->back()->with('success', 'Xóa mã giảm giá thành công');;
    }
}
