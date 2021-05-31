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
            <a href="{{ route('discounts.create') }}" class="btn btn-primary">Tạo loại sản phẩm mới</a>
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
                                    <img class="img-thumbnail mr-2"  width="45px" height="45px" src="{{url($category->image)}}" alt="">
                                    {{ $category->name }}</div>
                                <div class="d-flex">
                                    <div style="font-size:1.05rem" class="text-primary">
                                        <i class="fa fa-plus"></i></i>
                                    </div>
                                    <div style="font-size:1.05rem" class="text-warning mx-3"><i class="fa fa-edit"></i></div>
                                    <div style="font-size:1.05rem" class="text-danger"><i class="fa fa-trash"></i></div>
                                </div>
                            </div>
                        </div>
                        <ul class="nested">

                            @foreach ($category->childs as $child)
                                <li>
                                    <div class="treeView__item">
                                        <div>
                                            <img class="img-thumbnail mr-2"  width="45px" height="45px" src="{{url($child->image)}}" alt="">
                                            {{ $child->name }}
                                        </div>
                                        <div class="d-flex">
                                            <div style="font-size:1.05rem" class="text-warning mx-3"><i class="fa fa-edit"></i></div>
                                            <div style="font-size:1.05rem" class="text-danger"><i class="fa fa-trash"></i></div>
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

    <div class="modal" id="modalDelete">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 id="header-modal-delete" class="modal-title">Xóa mã giảm giá</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <h2 id="mess-delete"></h2>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-secondary border">Hủy</button>
                    <button onclick="document.getElementById('delete-form').submit()" id="accept-delete-btn" type="button"
                        class="btn btn-danger">Xóa</button>
                    <form method="post" id="delete-form" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        const btns = document.querySelectorAll('.delete-discount-code');
        btns.forEach(btn => btn.addEventListener('click', (e) => {
            const {
                code,
                id
            } = e.target.dataset;
            console.log(code, id);

            const messDelete = document.getElementById('mess-delete');
            messDelete.innerHTML = `Bạn muốn xóa mã giảm giá: ${code}?`;

            const deleteForm = document.getElementById('delete-form');
            deleteForm.setAttribute('action', `${location.pathname}/${id}`)
        }))

    </script>

    <script>
        var toggler = document.getElementsByClassName("caret");
        var i;

        for (i = 0; i < toggler.length; i++) {
            toggler[i].addEventListener("click", function() {
                this.parentElement.querySelector(".nested").classList.toggle("active");
                this.classList.toggle("caret-down");
            });
        }

    </script>
@endsection
