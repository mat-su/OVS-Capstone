var candidates_Tbl = '';
$(function () {
    function clearBS_Validation() {
        $('input.error').removeClass('error');
        $('select.error').removeClass('error');
        $('input').removeClass('is-valid');
        $('select').removeClass('is-valid');
        $('input').removeClass('is-invalid');
        $('select').removeClass('is-invalid');
    }

    function draw_data() {
        if ($.fn.dataTable.isDataTable('#candidates_tbl') && candidates_Tbl != '') {
            candidates_Tbl.draw(true);
        } else {
            load_data();
        }
    }

    function load_data() {
        candidates_Tbl = $('#candidates_tbl').DataTable({
            "columnDefs": [{
                "targets": [4],
                "orderable": false
            }],
            "aLengthMenu": [
                [5, 10, 15, -1],
                [5, 10, 15, "All"]
            ],
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "./get_candidates.php",
                method: 'POST'
            },
            columns: [{
                    data: 'studnum',
                },
                {
                    data: 'cname',
                },
                {
                    data: 'partylist',
                },
                {
                    data: 'position'
                },
                {
                    data: null,
                    orderable: false,
                    className: 'text-center',
                    render: function (data, type, row, meta) {
                        return '<a class="edit_data me-1" href="javascript:void(0)" data-id="' + (row.id) + '"title="View Candidate"><i class="fas fa-edit fa-xs fs-5 text-primary"></i></a>' +
                            '<a class="delete_data" href="javascript:void(0)" data-id="' + (row.id) + '"title="Delete Candidate"><i class="fas fa-trash fa-xs fs-5 text-danger"></i></a>';
                    }
                }
            ],
            drawCallback: function (settings) {
                $('#staticBackdropCreate').on('hidden.bs.modal', function () {
                    $(this).find('form').trigger('reset');
                    validator.resetForm();
                    clearBS_Validation();
                    $('input[name="fname"]').val('');
                    $('input[name="mname"]').val('');
                    $('input[name="lname"]').val('');
                    $('#response').remove();
                    $('#staticBackdropCreate button[form="frm_create"]').prop('disabled', false);
                });
                $('.edit_data').click(function () {
                    updValidator.resetForm();
                    clearBS_Validation();
                    $.ajax({
                        url: './getSingleCan.php',
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
                                Object.keys(resp.data[0]).map(k => {
                                    if ($('#staticBackdropView').find('input[name="' + k + '"]').length > 0)
                                        $('#staticBackdropView').find('input[name="' + k + '"]').val(resp.data[0][k]);
                                });
                                $('#staticBackdropView').modal('show');
                                $('#staticBackdropView').find('#party').val(resp.data[0]['partylist']);
                                $('#staticBackdropView').find('#position').val(resp.data[0]['position']);
                                $('#staticBackdropView').find('input[name="id"]').val(resp.data[0]['id']);
                            } else {
                                alert("An error occured while fetching single data");
                            }
                        }
                    })
                })
                $('.delete_data').click(function () {
                    $.ajax({
                        url: './getSingleCan.php',
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
                                $('#staticBackdropDelete').find('input[name="candidate"]').val(resp.data[0]['fname'] + " " + resp.data[0]['lname'])
                                $('#staticBackdropDelete').modal('show');
                                $('#staticBackdropDelete').find('input[name="id"]').val(resp.data[0]['id']);
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
    load_data();
    //Save new data
    var validator = $("#frm_create").validate({
        function(){},

        rules: {
            studnum: {
                validateStudNum: true
            },
            party: "required",
            position: "required"
        },
        messages: {
            studnum: {
                validateStudNum: "Please enter a valid student number."
            }
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass("is-invalid").removeClass("is-valid");
            $('#staticBackdropCreate button[form="frm_create"]').prop('disabled', true);
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).addClass("is-valid").removeClass("is-invalid");
            if ($('#studnum, #party, #position').hasClass('is-invalid')) {
                $('#staticBackdropCreate button[form="frm_create"]').prop('disabled', true);
            } else {
                $('#staticBackdropCreate button[form="frm_create"]').prop('disabled', false);
            }
        },
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function () {
            $('#staticBackdropCreate #btn-cancel').remove();
            $('#staticBackdropCreate button[form="frm_create"]').text("");
            $('#staticBackdropCreate button').attr('disabled', true);
            $('#staticBackdropCreate button[type="submit"]').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');

            let serializedForm = $('#frm_create').serializeArray();
            const formdata = new Object();
            $.each(serializedForm, function (i, field) {
                formdata[field.name] = $.trim(field.value);
            });
            $.ajax({
                url: 'save_new_can.php',
                data: formdata,
                method: 'POST',
                dataType: "json",
                error: err => {
                    alert("An error occured. Please check the source code and try again.");
                },
                success: function (resp) {
                    if (!!resp.status) {
                        if (resp.status == 'success') {
                            let notify = document.querySelector('#notify');
                            if (notify != null) {notify.remove()}
                            var _el = $('<div>');
                            _el.hide();
                            _el.attr('id','notify');
                            _el.addClass('alert alert-light alert_msg fw-bold');
                            _el.text("New Candidate Successfully Saved! ");
                            _el.append('<i class="fa fa-check fs-3 ms-2 text-success"></i>');
                            $('#frm_create').get(0).reset();
                            $('.modal').modal('hide');
                            $('#msg').append(_el);
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
                            _el.attr('id','notify');
                            _el.addClass('alert alert-danger alert_msg form-group');
                            _el.text(resp.msg);
                            $('#frm_create').prepend(_el);
                            _el.show('slow');

                        } else {
                            let notify = document.querySelector('#notify');
                            if (notify != null) {notify.remove()}
                            var _el = $('<div>');
                            _el.hide();
                            _el.attr('id','notify');
                            _el.addClass('alert alert-danger alert_msg form-group');
                            _el.text(resp.msg);
                            $('#frm_create').prepend(_el);
                            _el.show('slow');
                            setTimeout(() => {
                                _el.hide('slow')
                                    .remove();
                            }, 10000);

                        }
                    } else {
                        alert("An error occurred. Please check the source code and try again");
                    }

                    $('#staticBackdropCreate .modal-footer').prepend('<button type="button" id="btn-cancel" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>');
                    $('#staticBackdropCreate button').attr('disabled', false);
                    $('#staticBackdropCreate button[form="frm_create"]').text("Save");
                }
            });
        }
    });

    updValidator = $('#frm_edit').validate({
        rules: {
            party: "required",
            position: "required"
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass("is-invalid").removeClass("is-valid");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).addClass("is-valid").removeClass("is-invalid");
        },
        submitHandler: function () {
            $('#staticBackdropView #btn-cancel').remove();
            $('#staticBackdropView button[form="frm_edit"]').text("");
            $('#staticBackdropView button').attr('disabled', true);
            $('#staticBackdropView button[type="submit"]').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');

            let serializedForm = $('#frm_edit').serializeArray();
            const formdata = new Object();
            $.each(serializedForm, function (i, field) {
                formdata[field.name] = $.trim(field.value);
            });
            $.ajax({
                url: 'update_can.php',
                data: formdata,
                method: 'POST',
                dataType: "json",
                error: err => {
                    alert("An error occured. Please check the source code and try again.");
                },
                success: function (resp) {
                    if (!!resp.status) {
                        if (resp.status == 'success') {
                            let notify = document.querySelector('#notify');
                            if (notify != null) {notify.remove()}
                            var _el = $('<div>');
                            _el.hide();
                            _el.attr('id','notify');
                            _el.addClass('alert alert-light alert_msg fw-bold');
                            _el.text("Partylist Successfully Updated! ");
                            _el.append('<i class="fa fa-check fs-3 ms-2 text-success"></i>');
                            $('#frm_edit').get(0).reset();
                            $('.modal').modal('hide');
                            $('#msg').append(_el);
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
                            _el.attr('id','notify');
                            _el.addClass('alert alert-danger alert_msg form-group');
                            _el.text(resp.msg);
                            $('#frm_edit').prepend(_el);
                            _el.show('slow');

                        } else {
                            let notify = document.querySelector('#notify');
                            if (notify != null) {notify.remove()}
                            var _el = $('<div>');
                            _el.hide();
                            _el.attr('id','notify');
                            _el.addClass('alert alert-danger alert_msg form-group');
                            _el.text(resp.msg);
                            $('#frm_edit').prepend(_el);
                            _el.show('slow');
                            setTimeout(() => {
                                _el.hide('slow')
                                    .remove();
                            }, 10000);

                        }
                    } else {
                        alert("An error occurred. Please check the source code and try again");
                    }

                    $('#staticBackdropView .modal-footer').prepend('<button type="button" id="btn-cancel" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>');
                    $('#staticBackdropView button').attr('disabled', false);
                    $('#staticBackdropView button[form="frm_edit"]').text("Save");
                }
            });
        }
    });

    $('#frm_delete').submit(function (e) {
        e.preventDefault();
        $('#staticBackdropDelete #btn-cancel').remove();
        $('#staticBackdropDelete button[form="frm_delete"]').text("");
        $('#staticBackdropDelete button').attr('disabled', true)
        $('#staticBackdropDelete button[type="submit"]').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Deleting...');

        $.ajax({
            url: 'delete_can.php',
            data: $(this).serialize(),
            method: 'POST',
            dataType: "json",
            error: err => {
                alert("An error occured. Please check the source code and try again")
            },
            success: function (resp) {

                if (!!resp.status) {
                    if (resp.status == 'success') {
                        var _el = $('<div>')
                        let notify = document.querySelector('#notify');
                            if (notify != null) {notify.remove()}
                            var _el = $('<div>');
                            _el.hide();
                            _el.attr('id','notify');
                        _el.addClass('alert alert-light alert_msg fw-bold')
                        _el.text("Partylist Successfully Deleted");
                        _el.append('<i class="fa fa-check fs-3 ms-2 text-success"></i>');
                        $('#frm_delete').get(0).reset()
                        $('.modal').modal('hide')
                        $('#msg').append(_el)
                        _el.show('slow')
                        draw_data();
                        setTimeout(() => {
                            _el.hide('slow')
                                .remove()
                        }, 3000)
                    } else if (resp.status == 'success' && !!resp.msg) {
                        let notify = document.querySelector('#notify');
                            if (notify != null) {notify.remove()}
                            var _el = $('<div>');
                            _el.hide();
                            _el.attr('id','notify');
                        _el.addClass('alert alert-danger alert_msg form-group')
                        _el.text(resp.msg);
                        $('#frm_delete').prepend(_el)
                        _el.show('slow')
                    } else {
                        alert("An error occured. Please check the source code and try again")
                    }
                } else {
                    alert("An error occurred. Please check the source code and try again")
                }
                $('#staticBackdropDelete .modal-footer').prepend('<button type="button" id="btn-cancel" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>');
                $('#staticBackdropDelete button').attr('disabled', false)
                $('#staticBackdropDelete button[form="frm_delete"]').text("Yes")
            }
        });
    });
});

$.validator.addMethod("validateStudNum", function (value, element) {
    const regexStudNum = /^PM-[0-9]{2}-[0-9]{5}-[A-Z]$/;
    return regexStudNum.test(value);
});


$(document).ready(function () {
    $('#studnum').keyup(function (e) {
        $('#response').remove();
        const regexStudNum = /^PM-[0-9]{2}-[0-9]{5}-[A-Z]$/;
        var x = document.querySelector('#studnum');
        x.value = x.value.toUpperCase();
        if (regexStudNum.test(x.value)) {
            $('#searchdata').prop('disabled', false);
        } else {
            $('#searchdata').prop('disabled', true);
            $('input[name="fname"]').val('');
            $('input[name="mname"]').val('');
            $('input[name="lname"]').val('');
        }
    });
    $('#studnum').blur(function (e) {
        $('#response').remove();
        const regexStudNum = /^PM-[0-9]{2}-[0-9]{5}-[A-Z]$/;
        var x = document.querySelector('#studnum');
        x.value = x.value.toUpperCase();
        if (regexStudNum.test(x.value)) {
            $('#searchdata').prop('disabled', false);
        } else {
            $('#searchdata').prop('disabled', true);
            $('input[name="fname"]').val('');
            $('input[name="mname"]').val('');
            $('input[name="lname"]').val('');
        }
    });
    $('#searchdata').click(function (e) {
        e.preventDefault();
        var studnum = $('#studnum').val();

        $.ajax({
            type: "POST",
            url: "fetchdata.php",
            data: {
                "post_btn": 1,
                "studnum": studnum,
            },
            dataType: "text",
            success: function (response) {
                $("#getdetails").html(response);
            }
        });
    });
})