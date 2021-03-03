$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let html;
    let id = $('#id');
    let name = $('#name');
    let phone = $('#phone');
    let email = $('#email');
    let address = $('#address');
    let master = $('#master');
    let status = $('#status');
    let btnClose = $('.btn-close');

    $('.btnModal').click(function () {
        $('#titleModal').text($(this).text())
        switch ($(this).attr('id')) {
            case "btnModalCreate":
                $('.modal-body').show();
                id.val('');
                name.val('');
                phone.val('');
                email.val('');
                address.val('');
                master.val('');
                status.val('');
                $(".btnSubmit").text("Create");
                break;
        }
    });

    $('.btnModalEdit').click(function () {
        $('.modal-body').show();
        let idEdit = $(this).attr('id').slice(5);
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

    $('.btnModalDelete').click(function (){
        $('.modal-body').hide();
        $('.modal-title').text("Bạn có chắc muốn xóa đại lý này?");
        $(".btnSubmit").text("Delete");
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
                    url: window.origin + "/update",
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
                        $('#shop_'+res.id).html(html)
                    }
                });
                break;
            case "Delete":
                $.ajax({
                    url: window.origin + "/delete/".id.val(),
                    method: 'GET',
                    success: function (res) {
                        $("#shop_".res).remove()
                    }
                });
                break;
        }
    });

});
