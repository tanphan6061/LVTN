@extends('layouts.app')
@section('content')
    <div class="border-bottom">
        <ul class="nav--header">
            <li><a href="/">Trang chủ</a></li>
            <li><a href="{{route('products.index')}}">Trang chủ</a></li>
            <li><span>Tạo mới</span></li>
        </ul>
        <h1>Tạo sản phẩm</h1>
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
                    <button type="button" data-toggle="modal" data-target="#myModal" class="btn-primary btn">Thêm ảnh sản
                        phẩm</button>
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
                            <input onchange="document.getElementById('max_buy').value=this.value" name="amount"
                                type="number" value="{{ old('amount') ?? 1 }}" type="number" min="1" step="1"
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

                    <div class="row mt-4 ">
                        {{-- {{ dd($brands) }} --}}
                        <div id="categoryGroup" class="form-group col-6">
                            <label for="max_buy"><span class="text-danger">*</span> Số lượng mua tối đa:</label>
                            <input name="max_buy" id="max_buy" type="number" value="{{ old('amount') ?? 1 }}" type="number"
                                min="1" step="1" class="form-control {{ $errors->has('max_buy') ? 'is-invalid' : '' }}"
                                placeholder="Nhập số lượng mua tối đa" id="max_buy">
                            @if ($errors->has('max_buy'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('max_buy') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-6">
                            <label for="status"><span class="text-danger">*</span> Trạng thái:</label>
                            <select id="status" name="status"
                                class="custom-select {{ $errors->has('status') ? 'is-invalid' : '' }}">
                                <option value="available">Có sẵn</option>
                                <option value="hidden">Ẩn</option>
                            </select>
                            @if ($errors->has('status'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('status') }}
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
                            placeholder="Nhập mô tả sản phẩm" id="description">{{ old('description') }}</textarea>
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
                                <input accept="image/png, image/gif, image/jpeg" type="file" name="images[]"
                                    class="custom-file-input" id="customFile" multiple>
                                <label id="custom-file-label" class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                            <div class="list-image-product mt-3" id="list-image-product">
                            </div>
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" id="cancel-file" class="btn btn-secondary">Huỷ</button>
                            <button type="button" id="save-file" class="btn btn-primary" data-dismiss="modal">Lưu</button>
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
                <td style="position:relative">
                    <input name="value[]" type="text" value=""
                        class="form-control {{ $errors->has('value') ? 'is-invalid' : '' }}"
                        placeholder="Nhập chi tiết">
                    <button onclick="this.parentElement.parentElement.remove();" style="position:absolute;right:-20px;top:11px" type="button" class="btn btn-danger btn-remove-detail-item">x</button>
                        </td>
            `;
        const details = [defaultItem];

        const parentCategoryDOM = document.getElementById('parent_category');
        const categoryDOM = document.getElementById('category');
        const categoryGroup = document.getElementById('categoryGroup');
        const detailBody = document.getElementById('detail-body');
        const cancelFileBtn = document.getElementById('cancel-file');
        const saveFileBtn = document.getElementById('save-file');
        const label = document.getElementById('custom-file-label');
        const listImageProduct = document.getElementById('list-image-product');

        cancelFileBtn.addEventListener('click', (e) => {
            $('#myModal').modal('hide')
            document.getElementById('customFile').value = "";
            label.innerHTML = "Choose file";
            listImageProduct.innerHTML = '';
        });

        const renderDetailBody = (details) => {
            const tr = document.createElement('tr');
            tr.innerHTML = defaultItem;
            detailBody.appendChild(tr)
            const action = (e) => {
                console.log(e);
            }
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
            const files = e.target.files;
            console.log(e.target.files);
            listImageProduct.innerHTML = ''
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
