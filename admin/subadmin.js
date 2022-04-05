var subadminTbl = '';
$(function () {
    function clearBS_Validation() {
        $('input.error').removeClass('error');
        $('select.error').removeClass('error');
        $('input').removeClass('is-valid');
        $('select').removeClass('is-valid');
        $('input').removeClass('is-invalid');
        $('select').removeClass('is-invalid');
    }
    
    // draw function [called if the database updates]
    function draw_data() {
        if ($.fn.dataTable.isDataTable('#subadmin-tbl') && subadminTbl != '') {
            subadminTbl.draw(true);
        } else {
            load_data();
        }
    }

    function load_data() {
        subadminTbl = $('#subadmin-tbl').DataTable({
            "columnDefs": [{
                "orderable": false,
                "targets": [1, 3]
            }],
            "aLengthMenu": [
                [5, 10, 15, -1],
                [5, 10, 15, "All"]
            ],
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "./get_subadmins.php",
                method: 'POST',
            },
            columns: [{
                    data: 'Name',
                },
                {
                    data: 'Email',
                },
                {
                    data: 'Org_Name',
                },
                {
                    data: null,
                    orderable: false,
                    className: 'text-center',
                    render: function (data, type, row, meta) {
                        return '<a class="edit_data me-1" href="javascript:void(0)" data-id="' + (row.id) + '"title="Edit Sub Admin"><i class="fas fa-edit fa-xs fs-5 text-primary"></i></a>' +
                            '<a class="delete_data" href="javascript:void(0)" data-id="' + (row.id) + '"title="Delete Sub-Admin"><i class="fas fa-trash fa-xs fs-5 text-danger"></i></a>';
                    }
                }
            ],
            drawCallback: function (settings) {
                $('#staticBackdropCreate').on('hidden.bs.modal', function () {
                    $(this).find('form').trigger('reset');
                    validator.resetForm();
                    clearBS_Validation();
                    $('.alert-danger').remove();
                });
                $('.edit_data').click(function () {
                    updValidator.resetForm();
                    clearBS_Validation();
                    $('.alert-danger').remove();
                    $.ajax({
                        url: './get_single.php',
                        data: {
                            id: $(this).attr('data-id')
                        },
                        method: 'POST',
                        dataType: 'json',
                        error: err => {
                            alert("An error occured while fetching single data");
                        },
                        success: function (resp) {
                            if (!!resp.status) {
                                let select = document.getElementById('org');
                                Object.keys(resp.data[0]).map(k => {
                                    if ($('#staticBackdropView').find('input[name="' + k + '"]').length > 0)
                                        $('#staticBackdropView').find('input[name="' + k + '"]').val(resp.data[0][k]);
                                });
                                $('#staticBackdropView').modal('show');
                                select.value = resp.data[0]['org_id'];
                                $('#staticBackdropView #sa_id').val(resp.data[0]['id']);
                            } else {
                                alert("An error occured while fetching single data");
                            }
                        }
                    })
                })
                $('.delete_data').click(function () {
                    $.ajax({
                        url: './get_single.php',
                        data: {
                            id: $(this).attr('data-id')
                        },
                        method: 'POST',
                        dataType: 'json',
                        error: err => {
                            alert("An error occured while fetching single data");
                        },
                        success: function (resp) {
                            if (!!resp.status) {
                                $('#staticBackdropDelete').find('input[name="sa_name"]').val(resp.data[0]['fname'] + " " + resp.data[0]['lname']);
                                $('#staticBackdropDelete').find('input[name="sa_org"]').val(resp.data[0]['Org_Name']);
                                $('#staticBackdropDelete').modal('show');
                                $('#staticBackdropDelete #sa_id').val(resp.data[0]['id']);
                            } else {
                                alert("An error occured while fetching single data");
                            }
                        }
                    })
                })
            },
        });
    }
    //Load Data
    load_data()
    //Saving new Data
    var validator = $('#frm_create_sub').validate({
        rules: {
            fname: {
                required: true,
                validateName: true
            },
            lname: {
                required: true,
                validateName: true
            },
            email: {
                required: true,
                validateEmail: true
            },
            mname: {
                validateName: true
            },
            org: "required"
        },
        messages: {
            fname: {
                required: "Please enter your firstname",
                validateName: "Please enter a valid firstname"
            },
            lname: {
                required: "Please enter your lastname",
                validateName: "Please enter a valid lastname"
            },
            mname: {
                validateName: "Please enter a valid middlename"
            },
            org: "Please select a student organization",
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass("is-invalid").removeClass("is-valid");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).addClass("is-valid").removeClass("is-invalid");
        },
        submitHandler: function () {
            $('.alert-danger').remove();
            $('#cancel-btn').remove();
            $('#staticBackdropCreate button[form="frm_create_sub"]').text("");
            $('#staticBackdropCreate button').attr('disabled', true);
            $('#staticBackdropCreate button[type="submit"]').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');

            let serializedForm = $('#frm_create_sub').serializeArray();
            const formdata = new Object();
            $.each(serializedForm, function (i, field) {
                formdata[field.name] = $.trim(field.value);
            });

            $.ajax({
                url: 'save_new_sa.php',
                data: formdata,
                method: 'POST',
                dataType: "json",
                error: err => {
                    alert("An error occured. Please check the source code and try again");
                },
                success: function (resp) {
                    if (!!resp.status) {
                        if (resp.status == 'success') {
                            let notify = document.querySelector('#notify');
                            if (notify != null) {notify.remove()}
                            var _el = $('<div>');
                            _el.hide();
                            _el.addClass('alert alert-light alert_msg fw-bold');
                            _el.attr('id', 'notify');
                            _el.text("Sub Admin Info Successfully Saved! ");
                            _el.append('<i class="fa fa-check fs-3 ms-2 text-success"></i>');
                            $('#frm_create_sub').get(0).reset();
                            $('.modal').modal('hide');
                            $('#msg').append(_el);
                            alert(resp.feedback);
                            _el.show('slow');
                            draw_data();
                            setTimeout(() => {
                                _el.hide('slow')
                                    .remove();
                            }, 5000);
                        } else if (resp.status == 'success' && !!resp.msg) {
                            let notify = document.querySelector('#notify');
                            if (notify != null) {notify.remove()}
                            var _el = $('<div>');
                            _el.hide();
                            _el.addClass('alert alert-danger alert_msg form-group');
                            _el.attr('id','notify');
                            _el.text(resp.msg);
                            $('#frm_create_sub').prepend(_el);
                            _el.show('slow');
                        } else {
                            let notify = document.querySelector('#notify');
                            if (notify != null) {notify.remove()}
                            var _el = $('<div>');
                            _el.hide();
                            _el.addClass('alert alert-danger alert_msg form-group');
                            _el.attr('id','notify');
                            _el.text(resp.msg);
                            $('#frm_create_sub').prepend(_el);
                            _el.show('slow');
                            setTimeout(() => {
                                _el.hide('slow')
                                    .remove();
                            }, 10000);
                        }
                    } else {
                        alert("An error occurred. Please check the source code and try again");
                    }

                    $('#staticBackdropCreate .modal-footer').prepend('<button type="button" id="cancel-btn" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>');
                    $('#staticBackdropCreate button').attr('disabled', false);
                    $('#staticBackdropCreate button[form="frm_create_sub"]').text("Save");
                }
            })
        }
    });
    // Validator custom methods
    $.validator.addMethod("validateEmail", function (value, element) {
        const regexEmail = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return regexEmail.test(value);
    }, "Please enter a valid email address.");

    $.validator.addMethod("validateName", function (value, element) {
        const regexName = /^[a-zA-ZÑñ ]+(([',. -][a-zA-Z Ññ])?[a-zA-ZÑñ]*)*$/;
        return this.optional(element) || regexName.test(value);
    });


    // UPDATE Data
    var updValidator = $('#frm_edit_sub').validate({
        rules: {
            fname: {
                required: true,
                validateName: true
            },
            lname: {
                required: true,
                validateName: true
            },
            email: {
                required: true,
                validateEmail: true
            },
            mname: {
                validateName: true
            },
            org: "required"
        },
        messages: {
            fname: {
                required: "Please enter your firstname",
                validateName: "Please enter a valid first name"
            },
            mname: {
                validateName: "Please enter a valid middle name"
            },
            lname: {
                required: "Please enter your lastname",
                validateName: "Please enter a valid last name"
            },
            org: "Please select a student organization",
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass("is-invalid").removeClass("is-valid");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).addClass("is-valid").removeClass("is-invalid");
        },
        submitHandler: function () {
            $('#staticBackdropView #cancel-btn').remove();
            $('#staticBackdropView button[form="frm_edit_sub"]').text("");
            $('#staticBackdropView button').attr('disabled', true)
            $('#staticBackdropView button[type="submit"]').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');

            let serializedForm = $('#frm_edit_sub').serializeArray();
            const formdata = new Object();
            $.each(serializedForm, function (i, field) {
                formdata[field.name] = $.trim(field.value);
            });
//            console.log(formdata);
            $.ajax({
                url: 'update_sa.php',
                data: formdata,
                method: 'POST',
                dataType: "json",
                error: err => {
                    alert("An error occured. Please check the source code and try again");
                },
                success: function (resp) {
                    if (!!resp.status) {
                        if (resp.status == 'success') {
                            let notify = document.querySelector('#notify');
                            if (notify != null) {notify.remove()}
                            var _el = $('<div>')
                            _el.hide()
                            _el.addClass('alert alert-light alert_msg fw-bold')
                            _el.attr('id', 'notify');
                            _el.text("Sub Admin Successfully Updated");
                            _el.append('<i class="fa fa-check fs-3 ms-2 text-success"></i>');
                            $('#frm_edit_sub').get(0).reset()
                            $('.modal').modal('hide')
                            $('#msg').append(_el)
                            _el.show('slow')
                            draw_data();
                            setTimeout(() => {
                                _el.hide('slow')
                                    .remove()
                            }, 5000)
                        } else if (resp.status == 'success' && !!resp.msg) {
                            let notify = document.querySelector('#notify');
                            if (notify != null) {notify.remove()}
                            var _el = $('<div>')
                            _el.hide()
                            _el.addClass('alert alert-danger alert_msg form-group')
                            _el.attr('id', 'notify');
                            _el.text(resp.msg);
                            $('#frm_edit_sub').prepend(_el)
                            _el.show('slow')
                        } else {
                            let notify = document.querySelector('#notify');
                            if (notify != null) {notify.remove()}
                            var _el = $('<div>');
                            _el.hide();
                            _el.addClass('alert alert-danger alert_msg form-group');
                            _el.attr('id', 'notify');
                            _el.text(resp.msg);
                            $('#frm_edit_sub').prepend(_el);
                            _el.show('slow');
                            setTimeout(() => {
                                _el.hide('slow')
                                    .remove();
                            }, 3000);
                        }
                    } else {
                        alert("An error occurred. Please check the source code and try again");
                    }
                    $('#staticBackdropView .modal-footer').prepend('<button type="button" id="cancel-btn" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>');
                    $('#staticBackdropView button').attr('disabled', false)
                    $('#staticBackdropView button[form="frm_edit_sub"]').text("Edit");
                }
            })
        }
    });

    // DELETE Data
    $('#frm_delete_sub').submit(function (e) {
        e.preventDefault();
        $('#staticBackdropDelete #cancel-btn').remove();
        $('#staticBackdropDelete button[form="frm_delete_sub"]').text("");
        $('#staticBackdropDelete button').attr('disabled', true)
        $('#staticBackdropDelete button[type="submit"]').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Deleting...');

        $.ajax({
            url: 'delete_sa.php',
            data: $(this).serialize(),
            method: 'POST',
            dataType: "json",
            error: err => {
                alert("An error occured. Please check the source code and try again")
            },
            success: function (resp) {

                if (!!resp.status) {
                    if (resp.status == 'success') {
                        let notify = document.querySelector('#notify');
                        if (notify != null) {notify.remove()}
                        var _el = $('<div>')
                        _el.hide()
                        _el.addClass('alert alert-light alert_msg fw-bold')
                        _el.attr('id', 'notify');
                        _el.text("Sub Admin Successfully Deleted");
                        _el.append('<i class="fa fa-check fs-3 ms-2 text-success"></i>');
                        $('#frm_delete_sub').get(0).reset()
                        $('.modal').modal('hide')
                        $('#msg').append(_el)
                        _el.show('slow')
                        draw_data();
                        setTimeout(() => {
                            _el.hide('slow')
                                .remove()
                        }, 3000)
                    } else if (resp.status == 'success' && !!resp.msg) {
                        var _el = $('<div>')
                        let notify = document.querySelector('#notify');
                        if (notify != null) {notify.remove()}
                        _el.hide()
                        _el.addClass('alert alert-danger alert_msg form-group');
                        _el.attr('id', 'notify');
                        _el.text(resp.msg);
                        $('#frm_delete_sub').prepend(_el)
                        _el.show('slow')
                    } else {
                        alert("An error occured. Please check the source code and try again")
                    }
                } else {
                    alert("An error occurred. Please check the source code and try again")
                }
                $('#staticBackdropDelete .modal-footer').prepend('<button type="button" id="cancel-btn" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>');
                $('#staticBackdropDelete button').attr('disabled', false)
                $('#staticBackdropDelete button[form="frm_delete_sub"]').text("Yes")
            }
        })
    });

});