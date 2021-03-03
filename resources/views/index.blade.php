<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="{{asset('plugins/bootstrap@5.0.0.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('plugins/fontawesome/css/all.css')}}">
    <script src="{{asset('plugins/bootstrap@5.0.0.bundle.js')}}"></script>
    <script src="https://code.jquery.com/jquery-3.5.0.js"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>ASAMA VIỆT NAM</title>
</head>
<body>
<div class="container mt-5">

    {{-- Header --}}
    <div class="row border border-1 rounded mb-4 justify-content-end p-3">
        <div class="col p-0">
            <button type="button" id="btnModalCreate" class="btn btn-success btnModalCreate btnModal" data-bs-toggle="modal" data-bs-target="#modal"><i class="fas fa-plus"></i> Create</button>
        </div>
        <div class="col-4 p-0">
            <div class="input-group rounded">
                <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search"
                       aria-describedby="search-addon"/>
                <button type="button" class="btn btn-primary"><i class="fas fa-search"></i> Search</button>
            </div>
        </div>
    </div>
    {{-- End Header--}}

    {{-- Body --}}
    <div class="row border border-1 rounded p-1">
        <table class="table table-dark table-hover">
            <thead>
            <tr>
                <th scope="col">Mã số đại lý</th>
                <th scope="col">Tên đại lý</th>
                <th scope="col">Điện thoại</th>
                <th scope="col">Email</th>
                <th scope="col">Đại chỉ</th>
                <th scope="col">Tên người quản lý</th>
                <th scope="col">Trạng thái</th>
                <th scope="col">Chức năng</th>
            </tr>
            </thead>
            <tbody id="shopList">
            @foreach($shops as $shop)
                <tr id="shop_{{$shop->id}}">
                    <th scope="row">{{$shop->id}}</th>
                    <td>{{$shop->name}}</td>
                    <td>{{$shop->phone}}</td>
                    <td>{{$shop->email}}</td>
                    <td>{{$shop->address}}</td>
                    <td>{{$shop->master}}</td>
                    <td>{{$shop->status}}</td>
                    <td>
                        <button type="button" class="btn btn-warning btnModalEdit btnModal" id="edit_{{$shop->id}}" data-bs-toggle="modal" data-bs-target="#modal">Edit</button>
                        <button type="button" class="btn btn-danger btnModalDelete btnModal" id="delete_{{$shop->id}}" data-bs-toggle="modal" data-bs-target="#modal">Delete</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titleModal">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <input type="text" name="name" class="form-control disabled" id="id" placeholder="" disabled>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Tên cơ sở">
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="number" name="phone" maxlength="10" aria-valuemax="10" class="form-control" id="phone" placeholder="Số điện thoại">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="Email">
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" name="address" class="form-control" id="address" placeholder="Địa chỉ">
                </div>
                <div class="mb-3">
                    <label for="master" class="form-label">Master</label>
                    <input type="text" name="master" class="form-control" id="master" placeholder="Người quản lý">
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" aria-label="Default select example" name="status" id="status">
                        <option value="Hoạt động" selected>Hoạt động</option>
                        <option value="Ngừng hoạt động">Ngừng hoạt động</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btnSubmit">Understood</button>
            </div>
        </div>
    </div>
</div>
{{--<script>
    $(document).ready(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let html;
        let id = $('#id');
        let titleModal = $('#titleModal');
        let idEdit;
        let idDelete;
        let name = $('#name');
        let phone = $('#phone');
        let email = $('#email');
        let address = $('#address');
        let master = $('#master');
        let status = $('#status');
        let btnClose = $('.btn-close');

        // show modal create
        $('#btnModalCreate').click(function () {
            $('.modal-body').show();
            $('#titleModal').text($(this).text())
            id.val('');
            name.val('');
            phone.val('');
            email.val('');
            address.val('');
            master.val('');
            status.val(1);
            $(".btnSubmit").text("Create");
        });

        // show modal edit
        $('.btnModalEdit').click(function () {
            titleModal.text($(this).text())
            $('.modal-body').show();
            idEdit = $(this).attr('id').slice(5);
            $(".btnSubmit").text("Save");
            $.ajax({
                url: window.origin + "/shop/read/" + idEdit,
                method: 'GET',
                success: function (res) {
                    id.val(idEdit);
                    name.val(res.name);
                    phone.val(res.phone);
                    email.val(res.email);
                    address.val(res.address);
                    master.val(res.master);
                    status.val(res.status);
                }
            });
        });

        // show modal delete
        $('.btnModalDelete').click(function (){
            titleModal.text("Bạn có chắc muốn xóa đại lý này?");
            $(".btnSubmit").text("Delete");
            idDelete = $(this).attr('id').slice(7);
            $('.modal-body').hide();
        });

        $('.btnSubmit').click(function () {
            btnClose.trigger('click');

            switch ($(this).text()) {
                case "Create":
                    $.ajax({
                        url: window.origin + "/shop/create",
                        method: 'POST',
                        data: {
                            name: name.val(),
                            phone: phone.val(),
                            email: email.val(),
                            address: address.val(),
                            master: master.val(),
                            status: status.val(),
                        },
                        success: function (res) {
                            html = "<tr id=\"shop_"+res.id+"\">"
                                + "<th scope=\"row\">" + res.id + "</th>"
                                + "<td>" + res.name + "</td>"
                                + "<td>" + res.phone + "</td>"
                                + "<td>" + res.email + "</td>"
                                + "<td>" + res.address + "</td>"
                                + "<td>" + res.master + "</td>"
                                + "<td>" + res.status + "</td><td>"
                                + "<button type=\"button\" class=\"btn btn-warning btnModalEdit btnModal\" id=\"edit_" + res.id + "\" data-bs-toggle=\"modal\" data-bs-target=\"#modal\">Edit</button>"
                                + "<button type=\"button\" class=\"btn btn-danger btnModalDelete btnModal\" id=\"delete_" + res.id + "\" data-bs-toggle=\"modal\" data-bs-target=\"#modal\">Delete</button>"
                                + "</td></tr>";
                            $('#shopList').append(html)
                        }
                    });
                    break;
                case "Save":
                    $.ajax({
                        url: window.origin + "/shop/update",
                        method: 'POST',
                        data: {
                            id: id.val(),
                            name: name.val(),
                            phone: phone.val(),
                            email: email.val(),
                            address: address.val(),
                            master: master.val(),
                            status: status.val(),
                        },
                        success: function (res) {
                            html = "<tr id=\"shop_"+res.id+"\">"
                                + "<th scope=\"row\">" + res.id + "</th>"
                                + "<td>" + res.name + "</td>"
                                + "<td>" + res.phone + "</td>"
                                + "<td>" + res.email + "</td>"
                                + "<td>" + res.address + "</td>"
                                + "<td>" + res.master + "</td>"
                                + "<td>" + res.status + "</td><td>"
                                + "<button type=\"button\" class=\"btn btn-warning btnModalEdit btnModal\" id=\"edit_" + res.id + "\" data-bs-toggle=\"modal\" data-bs-target=\"#modal\">Edit</button>"
                                + "<button type=\"button\" class=\"btn btn-danger btnModalDelete btnModal\" id=\"delete_" + res.id + "\" data-bs-toggle=\"modal\" data-bs-target=\"#modal\">Delete</button>"
                                + "</td></tr>";
                            $('#shop_'+res.id).remove();
                            $('#shopList').append(html);
                        }
                    });
                    break;
                case "Delete":
                    $.ajax({
                        url: window.origin + "/shop/delete/" + idDelete,
                        method: 'GET',
                        success: function (res) {
                            $("#shop_"+idDelete).remove();
                        }
                    });
                    break;
            }
        });

    });
</script>--}}
</body>
</html>
