@extends('layouts.app')
@section('content')
    <div class="border-bottom">
        <ul class="nav--header">
            <li><a href="#">Trang chủ</a></li>
            <li><span>Sản phẩm</span></li>
            <li><span>Tạo mới</span></li>
        </ul>
        <h1>Tạo sản phẩm</h1>
    </div>
    <div class="mt-4">
        <form action="">
            <div class="border rounded">
                <div class="border-bottom p-4">
                    1. Thông tin chung
                </div>
                <div class="p-4">
                    <div class="form-group mt-4">
                        <label for="name"><span class="text-danger">*</span> Tên sản phẩm:</label>
                        <input type="name" name="name" class="form-control" placeholder="Nhập tên sản phẩm" id="name">
                    </div>
                    <div class="form-group mt-4">
                        <label for="price"><span class="text-danger">*</span> Giá:</label>
                        <input name="price" type="number" value="1000" type="number" min="1000" step="1000"
                            class="form-control" placeholder="Nhập tên sản phẩm" id="price">
                    </div>

                    <div class="row mt-4 ">
                        <div class="form-group col-6">
                            <label for="parent_category"><span class="text-danger">*</span> Doanh mục:</label>
                            <select id="parent_category" name="parent_category" class="custom-select">
                                @foreach ($categories as $category)
                                    @if ($category->parent_category_id === null)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div id="categoryGroup" class="form-group col-6">
                            <label for="category"><span class="text-danger">*</span> Loại sản phẩm:</label>
                            <select id="category" name="category" class="custom-select">
                            </select>
                        </div>
                    </div>
                    <div class="row mt-4 ">
                        {{-- {{ dd($brands) }} --}}
                        <div id="categoryGroup" class="form-group col-6">
                            <label for="amount"><span class="text-danger">*</span> Số lượng:</label>
                            <input name="amount" type="number" value="1" type="number" min="1" step="1" class="form-control"
                                placeholder="Nhập tên sản phẩm" id="amount">
                        </div>
                        <div class="form-group col-6">
                            <label for="brand"><span class="text-danger">*</span> Nhãn Hiệu:</label>
                            <select id="brand" name="brand" class="custom-select">
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        const categoryData = @json($categories);
        let subCategoryData = [];

        const parentCategoryDOM = document.getElementById('parent_category');
        const categoryDOM = document.getElementById('category');
        const categoryGroup = document.getElementById('categoryGroup')

        const renderCategory = (id) => {
            subCategoryData = categoryData.filter(i => i.parent_category_id == id)
            console.log(subCategoryData, id);
            if (subCategoryData.length < 1) {
                return categoryGroup.setAttribute('style', 'display: none');
            }
            categoryGroup.setAttribute('style', 'display: block');
            categoryDOM.innerHTML = '';
            subCategoryData.forEach(i => {
                categoryDOM.innerHTML += `<option value="${i.id}">${i.name}</option>`
            })
        }
        renderCategory(categoryData.find(i => i.parent_category_id === null).id)

        parentCategoryDOM.onchange = (e) => {
            renderCategory(e.target.value);
        }

    </script>
@endsection
