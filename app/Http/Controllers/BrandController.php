<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $brands = Brand::where([
            ['name', 'like', "%$request->q%"],
            ['is_deleted', false]
        ])->paginate(12);

        if ($request->q) {
            $brands->setPath('?q=' . $request->q);
        }
        return view('supper-admin.brands.list', compact('brands'));
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
    public function store(BrandRequest $request)
    {
        $data = $request->validated();
        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(BrandRequest $request, $id)
    {
        $brand = Brand::find($id);
        if (!$brand)
            return redirect()->back()->with('error', 'Thương hiệu không tồn tại');
        $data = $request->validated();
        $brand->update($data);
        session(['success' => 'Cập nhật thương hiệu thành công']);
        return $this->responded('Cập nhật thương hiệu thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brand = Brand::find($id);
        if (!$brand)
            return abort('404');
        if ($brand->products->count() > 0)
            return redirect()->back()->with('error', 'Không thể xoá thương hiệu đã có sản phẩm');
        $brand->update(['is_deleted' => true]);
        return redirect()->back()->with('success', 'Xóa thương hiệu thành công');
    }
}
