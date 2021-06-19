<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $categories = Category::where([
            ['name', 'like', "%$request->q%"],
            ['is_deleted', false],
            ['parent_category_id', null]
        ])->orderBy('created_at', 'DESC')->paginate(12);

        if ($request->q) {
            $categories->setPath('?q=' . $request->q);
        }
        return view('supper-admin.category.list', compact('categories'));
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
    public function store(CategoryRequest $request)
    {
        $data = $request->validated();

        if ($request->image) {
            $data['image'] = $request->image;
            $imageName = time() . '.' . $data['image']->extension();
            $dir = 'uploads/images/category';
            $data['image']->move(public_path($dir), $imageName);
            $data['image'] = $dir . "/" . $imageName;
        }

        if ($request->parent_category_id) {
            $error = false;
            $parentCategory = Category::find($request->parent_category_id);
            // nếu nó đã là thương hiệu cha rồi không thể là con của thằng khác
            if (!$parentCategory) {
                $error = true;
                $message = 'Danh mục không tồn tại';
            } elseif ($parentCategory->parent_category_id) {
                $error = true;
                $message = 'Không thể chọn loại sản phẩm này làm danh mục';
            }

            if ($error) {
                session(['error' => $message]);
                return $this->respondedError($message, ["isRedirect" => true]);
            }

            $data['parent_category_id'] = $request->parent_category_id;
        } else {
            $data['parent_category_id'] = null;
        }


        Category::create($data);
        session(['success' => 'Tạo thương hiệu thành công']);
        return $this->responded('Tạo thương hiệu thành công');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        $category = Category::find($id);
        if (!$category) {
            $message = 'Thương hiệu không tồn tại';
            session(['error' => $message]);
            return $this->respondedError($message, ["isRedirect" => true]);
        }
        $data = $request->validated();

        if ($request->image) {
            $data['image'] = $request->image;
            $imageName = time() . '.' . $data['image']->extension();
            $dir = 'uploads/images/category';
            $data['image']->move(public_path($dir), $imageName);
            $data['image'] = $dir . "/" . $imageName;
            if (file_exists($category->images))
                unlink($category->image);
        }


        if ($request->parent_category_id) {
            $error = false;
            $parentCategory = Category::find($request->parent_category_id);
            // nếu nó đã là thương hiệu cha rồi không thể là con của thằng khác
            if ($category->childs->count() > 0) {
                $error = true;
                $message = 'Thương hiệu này không thể thuộc một danh mục khác';
            } elseif (!$parentCategory) {
                $error = true;
                $message = 'Danh mục không tồn tại';
            } elseif ($parentCategory->parent_category_id || $request->parent_category_id == $category->id) {
                $error = true;
                $message = 'Không thể chọn loại sản phẩm này làm danh mục';
            }

            if ($error) {
                session(['error' => $message]);
                return $this->respondedError($message, ["isRedirect" => true]);
            }

            $data['parent_category_id'] = $request->parent_category_id;
        } else {
            $data['parent_category_id'] = null;
        }

        $category->update($data);
        session(['success' => 'Cập nhật thương hiệu thành công']);
        return $this->responded('Cập nhật thương hiệu thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        if (!$category)
            return abort('404');

        $check = $category->products->count() > 0; //product existence in the product category
        foreach ($category->childs as $child) {
            if ($child->products->count() > 0) //product existence in the sub-product category
                $check = true;
        }
        if ($check)
            return redirect()->back()->with('error', 'Không thể xoá loại sản phẩm đã có sản phẩm');

        $category->update(['is_deleted' => true]);
        foreach ($category->childs as $child) {
            $child->update(['is_deleted' => true]);
        }
        return redirect()->back()->with('success', 'Xóa loại sản phẩm thành công');
    }
}
