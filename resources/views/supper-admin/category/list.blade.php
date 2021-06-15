@extends('layouts.app')


@section('css')
    <style>
        ul,
        .treeView {
            list-style-type: none;
        }

        /* Remove margins and padding from the parent ul */
        .treeView {
            margin: 0;
            padding: 0;
        }

        /* Style the caret/arrow */
        .caret {
            cursor: pointer;
            user-select: none;
            /* Prevent text selection */
        }

        /* Create the caret/arrow with a unicode, and style it */
        .caret::before {
            content: "\25B6";
            color: black;
            display: inline-block;
            margin-right: 6px;
        }

        /* Rotate the caret/arrow icon when clicked on (using JavaScript) */
        .caret-down::before {
            transform: rotate(90deg);
        }

        /* Hide the nested list */
        .nested {
            display: none;
        }

        /* Show the nested list when the user clicks on the caret/arrow (with JavaScript) */
        .active {
            display: block;
        }

        .treeView__item {
            padding: 15px;
            background: white;
            border: 1px solid #ccc;
            border-radius: 15px;
            margin-top: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

    </style>
@endsection
@section('content')
    <div class="border-bottom mb-5">
        <ul class="nav--header">
            <li><span>Loại sản phẩm</span></li>
            <li><span>Danh sách loại sản phẩm</span></li>
        </ul>
        <div class="d-flex justify-content-between align-items-center">
            <h1>Danh sách loại sản phẩm</h1>
            <button id="btn-modal-add" class="btn btn-primary" data-target="#modal-handle" data-toggle="modal">Tạo loại sản phẩm mới</button>
        </div>
    </div>
    <div class="table-responsive">
        <form action="" class="mb-2">
            <div class="form-group d-flex">
                <input value="{{ request()->get('q') }}" name="q" placeholder="Nhập từ khoá cần tìm" type="text"
                    class="form-control" id="usr" autofocus>
                <button class="btn btn-primary px-4 ml-1">Tìm</button>
            </div>
        </form>
        <div>
            @foreach ($categories as $category)
                <ul class="treeView mt-3">
                    <li>
                        <div class="caret d-flex align-items-center">
                            <div class="treeView__item flex-grow-1">
                                <div>
                                    <img class="img-thumbnail mr-2" width="45px" height="45px"
                                        src="{{ url($category->image) }}" alt="">
                                    {{ $category->name }}
                                </div>
                                <div class="d-flex">
                                    <div style="font-size:1.05rem; cursor: pointer;" class="text-primary">
                                        <i class="fa fa-plus btn-modal-add-sub"
                                        data-data='@json($category)'
                                        data-target="#modal-handle" data-toggle="modal"></i>
                                    </div>
                                    <div style="font-size:1.05rem; cursor: pointer;" class="text-warning mx-3">
                                        <i data-data='@json($category)' data-target="#modal-handle" data-toggle="modal"
                                            class="fa fa-edit btn-modal-edit"></i>

                                    </div>
                                    <div style="font-size:1.05rem; cursor: pointer;" class='text-danger'>
                                        <i data-target="#modal-delete" data-id="{{ $category->id }}"
                                            data-name="{{ $category->name }}" data-toggle="modal"
                                            class="btn-modal-delete  fa fa-trash"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <ul class="nested">

                            @foreach ($category->childs as $child)
                                <li>
                                    <div class="treeView__item">
                                        <div>
                                            <img class="img-thumbnail mr-2" width="45px" height="45px"
                                                src="{{ url($child->image) }}" alt="">
                                            {{ $child->name }}
                                        </div>
                                        <div class="d-flex">
                                            <div style="font-size:1.05rem; cursor: pointer;" class="text-warning mx-3">
                                                <i data-data='@json($child)' data-target="#modal-handle" data-toggle="modal"
                                            class="fa fa-edit btn-modal-edit"></i>
                                                </div>
                                            <div style="font-size:1.05rem; cursor: pointer;" class='text-danger'>
                                                <i data-target="#modal-delete" data-id="{{ $child->id }}"
                                                    data-name="{{ $child->name }}" data-toggle="modal"
                                                    class="btn-modal-delete  fa fa-trash"></i>
                                            </div>
                                        </div>
                                    </div>

                                </li>
                            @endforeach
                        </ul>
                    </li>
                </ul>
            @endforeach
        </div>
    </div>
    <div class="d-flex justify-content-center mt-4">
        {!! $categories->render('pagination::bootstrap-4') !!}
    </div>

@endsection

@section('bodyModalHandle')
<div class="row">
    {{-- <div class="col-8 d-flex flex-column justify-content-around"> --}}
    <div class="col-8">
         <div class="form-group">
             <label for="name"><span class="text-danger">*</span> Tên loại sản phẩm:</label>
             <input type="name" class="form-control" placeholder="Nhập tên loại sản phẩm" name="name" id="name">
         </div>
         <div class="form-group">
             <label for="parent_category_id"><span class="text-danger">*</span> Thuộc danh mục:</label>
             <select name="parent_category_id" class="form-control" id="parent_category_id">
                <option value=''>Không có</option>
                @foreach ($categories as $category)
                <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
              </select>
         </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label for="name" style="text-align: center;display:block">Ảnh loại sản phẩm:</label>
            <img id="avatar-image" class="border edit-avatar">
            <input type="file" accept="image/png, image/gif, image/jpeg" id="image" class="form-control-file border" name="image">
        </div>
    </div>
</div>

@endsection

@section('bodyScript')
    <script>

    const namePage = 'loại sản phẩm';
    setModalDeleteInListPage(namePage);
    setModalHandle(namePage);
    document.getElementById('image').addEventListener('change', (e) => {
        const urlImage = URL.createObjectURL(e.target.files[0]);
        document.getElementById('avatar-image').setAttribute('src', urlImage);
    })


    const btnAdds = document.querySelectorAll('.btn-modal-add-sub');
    // open modal add sub
    btnAdds.forEach(btn=> btn.addEventListener('click', (e)=>{
        let {
                data
            } = e.target.dataset;
        data = JSON.parse(data)
        for (element of formHandle.elements) {
            if (!['_method', '_token'].includes(element.name)) {
                switch(element.type) {
                    case 'file':
                        document.getElementById('avatar-image').setAttribute('src', `${location.protocol}//${location.host}/assets/images/placeholder-images.png`);
                        break;
                    case 'select-one':
                        const indexOfOption = [...element.options].findIndex(i=>i.value== data.id );
                        if(indexOfOption>-1){
                            element.options.selectedIndex  = indexOfOption;
                        }
                        break;
                    default:
                        element.value = '';
                }
                resetValidForm(element);
            }
        }
        headerModalHandle.innerHTML = `Thêm ${namePage}`;
        btnAcceptHandle.innerHTML = 'Thêm';
        formHandle.action = `${location.pathname}`
        formHandle['_method'].value = 'POST';
    }))



    const toggler = document.getElementsByClassName("caret");
    for (let i = 0; i < toggler.length; i++) {
        toggler[i].addEventListener("click", function() {
            this.parentElement.querySelector(".nested").classList.toggle("active");
            this.classList.toggle("caret-down");
        });
    }

    </script>
@endsection
