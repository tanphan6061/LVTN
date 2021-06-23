@extends('layouts.app')
@section('content')
    <div class="border-bottom">
        <ul class="nav--header">
            <li><a href="/">Trang chủ</a></li>
            <li><span>Sản phẩm</span></li>
            <li><span>Sửa sản phẩm</span></li>
        </ul>
        <h1>Sửa sản phẩm</h1>
    </div>
    <div class="mt-4">
        <form method="post" enctype="multipart/form-data" class="needs-validation" novalidate
            action="{{ route('products.store') }}">
            @csrf
            <div class="border rounded">
                <div class="border-bottom p-4">
                    1. Thông tin chung
                </div>
                <div class="p-4">
                    <div class="d-flex justify-content-between mb-3">
                        <h2>Ảnh sản phẩm</h2>
                        <button type="button" data-toggle="modal" data-target="#myModal" class="btn-primary btn">Quản lý ảnh sản
                            phẩm
                        </button>
                    </div>
                    <div>
                        <div id="demo" class="carousel slide" data-ride="carousel">
                            <!-- Indicators -->
                            <ul class="carousel-indicators">
                                <li data-target="#demo" data-slide-to="0" class="active"></li>
                                <li data-target="#demo" data-slide-to="1"></li>
                                <li data-target="#demo" data-slide-to="2"></li>
                            </ul>

                            <!-- The slideshow -->
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="https://www.w3schools.com/bootstrap4/chicago.jpg" alt="Los Angeles">
                                </div>
                                <div class="carousel-item active">
                                    <img src="https://www.w3schools.com/bootstrap4/la.jpg" alt="Los Angeles">
                                </div>
                                <div class="carousel-item active">
                                    <img src="https://www.w3schools.com/bootstrap4/ny.jpg" alt="Los Angeles">
                                </div>
                            </div>

                            <!-- Left and right controls -->
                            <a class="carousel-control-prev" href="#demo" data-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </a>
                            <a class="carousel-control-next" href="#demo" data-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </a>
                        </div>
                    </div>
                    <div class="form-group mt-4">
                        <label for="name"><span class="text-danger">*</span> Tên sản phẩm:</label>
                        <input type="name" name="name" value="{{ old('name') ?? $product->name }}"
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
                            <input name="price" type="number" value="{{ old('price') ?? $product->price }}" type="number"
                                min="1000" step="1000"
                                class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}"
                                placeholder="Nhập giá sản phẩm" id="price">
                            @if ($errors->has('price'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('price') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-6">
                            <label for="discount"><span class="text-danger">*</span> Giảm (%):</label>
                            <input name="discount" type="number" value="{{ old('discount') ?? $product->discount }}"
                                type="number" min="0" step="1"
                                class="form-control {{ $errors->has('discount') ? 'is-invalid' : '' }}"
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
                                    <th class="d-flex justify-content-between align-items-center">
                                        <div>
                                            Thuộc tính
                                        </div>
                                        <div onclick="renderDetailBody()" data-toggle="tooltip" data-placement="top"
                                            style="border-radius:50%;background:blue;color:white;cursor: pointer; width:25px;height:25px"
                                            class="d-flex bg-primary justify-content-center align-items-center"
                                            title="Thêm thuộc tính">+</div>
                                    </th>
                                    <th>Chi tiết</th>
                                </tr>
                            </thead>
                            <tbody id="detail-body">

                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4 ">
                        <label for="description"><span class="text-danger">*</span> Mô tả sản phẩm:</label>
                        <textarea style="min-height:200px" name="description" type="number" value="1" type="number" min="1"
                            step="1" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}"
                            placeholder="Nhập mô tả sản phẩm"
                            id="description">{{ old('description') ?? $product->description }}</textarea>
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

            <div class="modal" id="myModal">
                <div class="modal-dialog" style="min-width:85%;">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Ảnh sản phẩm</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                            <h2>Thêm ảnh</h2>
                            <div class="custom-file">
                                <input accept="image/png, image/gif, image/jpeg" type="file" class="custom-file-input"
                                    id="customFile" multiple>
                                <label id="custom-file-label" class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                            <div class="list-image-product mt-3" id="list-image-product">

                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Lưu</button>
                        </div>

                    </div>
                </div>
            </div>

        </form>
    </div>

    <script>
        const categoryData = @json($categories);
        let subCategoryData = [];
        const defaultItem = `
                    <td><input name="key[]" type="text" value=""
                            class="form-control {{ $errors->has('key') ? 'is-invalid' : '' }}"
                            placeholder="Nhập tên thuộc tính"></td>
                    <td><input name="value[]" type="text" value=""
                            class="form-control {{ $errors->has('value') ? 'is-invalid' : '' }}"
                            placeholder="Nhập chi tiết"></td>
                `;
        const details = [defaultItem];

        const parentCategoryDOM = document.getElementById('parent_category');
        const categoryDOM = document.getElementById('category');
        const categoryGroup = document.getElementById('categoryGroup');
        const detailBody = document.getElementById('detail-body');

        const renderDetailBody = (details) => {
            const tr = document.createElement('tr');
            tr.innerHTML = defaultItem;
            detailBody.appendChild(tr)
        }
        renderDetailBody(details);

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

        document.getElementById('customFile').addEventListener('change', (e) => {
            const listImageProduct = document.getElementById('list-image-product');
            const files = e.target.files;
            listImageProduct.innerHTML = ''
            const label = document.getElementById('custom-file-label');
            label.setAttribute('class', 'custom-file-label selected');
            label.innerHTML = files.length > 1 ? `${files[0].name} và ${files.length -1} ảnh khác` : files[0].name
            Array.from(files).forEach(file => {
                const img = document.createElement('img')
                const urlImage = URL.createObjectURL(file);
                img.src = urlImage;
                listImageProduct.appendChild(img);
            })

        })

    </script>
@endsection
