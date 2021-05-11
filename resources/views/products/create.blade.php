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
        <form method="post" class="needs-validation" novalidate action="{{ route('products.store') }}">
            @csrf
            <div class="border rounded">
                <div class="border-bottom p-4">
                    1. Thông tin chung
                </div>
                <div class="p-4">
                    <div class="form-group mt-4">
                        <label for="name"><span class="text-danger">*</span> Tên sản phẩm:</label>
                        <input type="name" name="name" value="{{ old('name') }}"
                            class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                            placeholder="Nhập tên sản phẩm" id="name">
                        @if ($errors->has('name'))
                            <div class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                        @endif
                    </div>
                    <div class="row mt-4 ">
                        <div class="form-group col-6">
                            <label for="price"><span class="text-danger">*</span> Giá:</label>
                            <input name="price" type="number" value="{{ old('price') ?? 1000 }}" type="number" min="1000"
                                step="1000" class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}"
                                placeholder="Nhập giá sản phẩm" id="price">
                            @if ($errors->has('price'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('price') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-6">
                            <label for="discount"><span class="text-danger">*</span> Giảm (%):</label>
                            <input name="discount" type="number" value="{{ old('discount') ?? 0 }}" type="number" min="0"
                                step="1" class="form-control {{ $errors->has('discount') ? 'is-invalid' : '' }}"
                                placeholder="Nhập số tiền sản phẩm được giảm mặc định" id="discount">
                            @if ($errors->has('discount'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('discount') }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row mt-4 ">
                        <div class="form-group col-6">
                            <label for="parent_category"><span class="text-danger">*</span> Doanh mục:</label>
                            <select id="parent_category" name="parent_category"
                                class="custom-select {{ $errors->has('parent_category') ? 'is-invalid' : '' }}">
                                @foreach ($categories as $category)
                                    @if ($category->parent_category_id === null)
                                        <option {{ old('parent_category') == $category->id ? 'selected' : '' }}
                                            value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @if ($errors->has('parent_category'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('parent_category') }}
                                </div>
                            @endif
                        </div>
                        <div id="categoryGroup" class="form-group col-6">
                            <label for="category"><span class="text-danger">*</span> Loại sản phẩm:</label>
                            <select id="category" name="category_id"
                                class="custom-select {{ $errors->has('category_id') ? 'is-invalid' : '' }}">
                            </select>
                            @if ($errors->has('category_id'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('category_id') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="row mt-4 ">
                        {{-- {{ dd($brands) }} --}}
                        <div id="categoryGroup" class="form-group col-6">
                            <label for="amount"><span class="text-danger">*</span> Số lượng:</label>
                            <input name="amount" type="number" value="1" type="number" min="1" step="1"
                                class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}"
                                placeholder="Nhập số lượng sản phẩm" id="amount">
                            @if ($errors->has('amount'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('amount') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-6">
                            <label for="brand"><span class="text-danger">*</span> Nhãn Hiệu:</label>
                            <select id="brand" name="brand_id"
                                class="custom-select {{ $errors->has('brand_id') ? 'is-invalid' : '' }}">
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('brand_id'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('brand_id') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="mt-4 ">
                        <label for="detail"><span class="text-danger">*</span> Mô tả chi tiết:</label>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Thuộc tính</th>
                                    <th>Chi tiết</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input name="key[]" type="text" value=""
                                            class="form-control {{ $errors->has('key') ? 'is-invalid' : '' }}"
                                            placeholder="Nhập tên thuộc tính"></td>
                                    <td><input name="value[]" type="text" value=""
                                            class="form-control {{ $errors->has('value') ? 'is-invalid' : '' }}"
                                            placeholder="Nhập chi tiết"></td>
                                </tr>
                                <tr>
                                    <td><input name="key[]" type="text" value=""
                                            class="form-control {{ $errors->has('key') ? 'is-invalid' : '' }}"
                                            placeholder="Nhập tên thuộc tính"></td>
                                    <td><input name="value[]" type="text" value=""
                                            class="form-control {{ $errors->has('value') ? 'is-invalid' : '' }}"
                                            placeholder="Nhập chi tiết"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4 ">
                        <label for="description"><span class="text-danger">*</span> Mô tả sản phẩm:</label>
                        <textarea style="min-height:200px" name="description" type="number" value="1" type="number" min="1"
                            step="1" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}"
                            placeholder="Nhập mô tả sản phẩm" id="description"></textarea>
                        @if ($errors->has('description'))
                            <div class="invalid-feedback">
                                {{ $errors->first('description') }}
                            </div>
                        @endif
                    </div>
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-primary mt-3 px-5">Tạo</button>
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
        renderCategory(parentCategoryDOM.value ?? categoryData.find(i => i.parent_category_id === null).id)

        parentCategoryDOM.onchange = (e) => {
            renderCategory(e.target.value);
        }

    </script>
@endsection
