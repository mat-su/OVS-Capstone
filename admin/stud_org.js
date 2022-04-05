var orgTbl = "";
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
        if ($.fn.dataTable.isDataTable('#org-tbl') && orgTbl != '') {
            orgTbl.draw(true);
        } else {
            load_data();
        }
    }

    function load_data() {
        orgTbl = $('#org-tbl').DataTable({
            "columnDefs": [{
                "width": "40%",
                "targets": [0, 1, 2]
            }, {
                "orderable": false,
                "targets": [3]
            }],
            "aLengthMenu": [
                [5, 10, 15, -1],
                [5, 10, 15, "All"]
            ],
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "get_orgs.php",
                method: 'POST',
            },
            columns: [{
                    data: 'Org_Name',
                },
                {
                    data: 'Course',
                },
                {
                    data: 'Adviser',
                },
                {
                    data: null,
                    orderable: false,
                    className: 'text-center',
                    render: function (data, type, row, meta) {
                        return '<a class="edit_data me-1" href="javascript:void(0)" data-id="' + (data.org_id) + '"title="Edit Student Org"><i class="fas fa-edit fa-xs fs-5 text-primary"></i></a>' +
                            '<a class="delete_data" href="javascript:void(0)" data-id="' + (data.org_id) + '"title="Delete Student Org"><i class="fas fa-trash fa-xs fs-5 text-danger"></i></a>';
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
                        url: './get_selected_org.php',
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
                                let select = document.querySelector('form#edit [name=course_id]');

                                Object.keys(resp.data[0]).map(k => {
                                    if ($('#staticBackdropView').find('input[name="' + k + '"]').length > 0)
                                        $('#staticBackdropView').find('input[name="' + k + '"]').val(resp.data[0][k]);
                                });
                                $('#staticBackdropView').modal('show');
                                select.value = resp.data[0]['cID'];
                                $('#staticBackdropView input[name=org_id]').val(resp.data[0]['org_id']);

                            } else {
                                alert("An error occured while fetching single data");
                            }
                        }
                    })
                })
                $('.delete_data').click(function () {
                    $.ajax({
                        url: './get_selected_org.php',
                        data: {
                            id: $(this).attr('data-id')
                        },
                        method: 'POST',
                        dataType: 'json',
                        error: err => {
                            alert("An error occured while fetching single data");
                        },
                        success: function (resp) {
                            console.log(resp.data[0]);
                            if (!!resp.status) {
                                $('#staticBackdropDelete').find('input[name="org_name"]').val(resp.data[0]['org_name']);
                                $('#staticBackdropDelete').modal('show');
                                $('#staticBackdropDelete input[name=org_id]').val(resp.data[0]['org_id']);
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
    //Saving new Data
    var validator = $('#create').validate({
        rules: {
            org_name: {
                required: true,
                validateName: true
            },
            org_acronym: {
                required: true,
                validateName: true
            },
            course_id: {
                required: true,
            }
        },
        messages: {
            org_name: {
                required: "Please enter student organization name",
                validateName: "Please enter a valid student organization name"
            },
            org_acronym: {
                required: "Please enter your lastname",
                validateName: "Please enter a valid organization acronym"
            },
            course_id: {
                required: "Please select a course linked to this organization"
            },
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass("is-invalid").removeClass("is-valid");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).addClass("is-valid").removeClass("is-invalid");
        },
        submitHandler: function () {
            $('#cancel-btn').remove();
            $('#staticBackdropCreate button[form="create"]').text("");
            $('#staticBackdropCreate button').attr('disabled', true);
            $('#staticBackdropCreate button[type="submit"]').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');

            let serializedForm = $('#create').serializeArray();
            const formdata = new Object();
            $.each(serializedForm, function (i, field) {
                formdata[field.name] = $.trim(field.value);
            });

            $.ajax({
                url: 'save_new_org.php',
                data: formdata,
                method: 'POST',
                dataType: "json",
                error: err => {
                    alert("An error occured. Please check the source code and try again");
                },
                success: function (resp) {
                    if (!!resp.status) {
                        if (resp.status == 'success' && !(!!resp.msg)) {
                            let notify = document.querySelector('#notify');
                            if (notify != null) {
                                notify.remove()
                            }
                            var _el = $('<div>');
                            _el.hide();
                            _el.addClass('alert alert-light alert_msg fw-bold');
                            _el.attr('id', 'notify');
                            _el.text("Student Organization Successfully Saved! ");
                            _el.append('<i class="fa fa-check fs-3 ms-2 text-success"></i>');
                            $('#create').get(0).reset();
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
                            if (notify != null) {
                                notify.remove()
                            }
                            var _el = $('<div>');
                            _el.hide();
                            _el.addClass('alert alert-danger alert_msg form-group');
                            _el.attr('id', 'notify');
                            _el.text(resp.msg);
                            $('#create').prepend(_el);
                            _el.show('slow');
                            setTimeout(() => {
                                _el.hide('slow')
                                    .remove();
                            }, 5000);
                        } else {
                            let notify = document.querySelector('#notify');
                            if (notify != null) {
                                notify.remove()
                            }
                            var _el = $('<div>');
                            _el.hide();
                            _el.addClass('alert alert-danger alert_msg form-group');
                            _el.attr('id', 'notify');
                            _el.text(resp.msg);
                            $('#create').prepend(_el);
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
                    $('#staticBackdropCreate button[form="create"]').text("Save");
                }
            })
        }
    });

    $.validator.addMethod("validateName", function (value, element) {
        const regexName = /^[a-zA-ZÑñ ]+(([',. -][a-zA-Z Ññ])?[a-zA-ZÑñ]*)*$/;
        return this.optional(element) || regexName.test(value);
    });


    // UPDATE Data
    var updValidator = $('#edit').validate({
        rules: {
            org_name: {
                required: true,
                validateName: true
            },
            org_acronym: {
                required: true,
                validateName: true
            },
            course_id: {
                required: true,
            }
        },
        messages: {
            org_name: {
                required: "Please enter student organization name",
                validateName: "Please enter a valid student organization name"
            },
            org_acronym: {
                required: "Please enter student organization acronym",
                validateName: "Please enter a valid organization acronym"
            },
            course_id: {
                required: "Please select a course linked to this organization"
            },
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass("is-invalid").removeClass("is-valid");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).addClass("is-valid").removeClass("is-invalid");
        },
        submitHandler: function () {
            $('#staticBackdropView #cancel-btn').remove();
            $('#staticBackdropView button[form="edit"]').text("");
            $('#staticBackdropView button').attr('disabled', true)
            $('#staticBackdropView button[type="submit"]').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');

            let serializedForm = $('#edit').serializeArray();
            const formdata = new Object();
            $.each(serializedForm, function (i, field) {
                formdata[field.name] = $.trim(field.value);
            });
            //            console.log(formdata);
            $.ajax({
                url: 'update_org.php',
                data: formdata,
                method: 'POST',
                dataType: "json",
                error: err => {
                    alert("An error occured. Please check the source code and try again...");
                },
                success: function (resp) {
                    if (!!resp.status) {
                        if (resp.status == 'success' && !(!!resp.msg)) {
                            let notify = document.querySelector('#notify');
                            if (notify != null) {
                                notify.remove()
                            }
                            var _el = $('<div>');
                            _el.hide();
                            _el.addClass('alert alert-light alert_msg fw-bold');
                            _el.attr('id', 'notify');
                            _el.text("Student Organization Successfully Updated! ");
                            _el.append('<i class="fa fa-check fs-3 ms-2 text-success"></i>');
                            $('#edit').get(0).reset();
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
                            if (notify != null) {
                                notify.remove()
                            }
                            var _el = $('<div>')
                            _el.hide()
                            _el.addClass('alert alert-danger alert_msg form-group')
                            _el.attr('id', 'notify');
                            _el.text(resp.msg);
                            $('#edit').prepend(_el)
                            _el.show('slow')
                            setTimeout(() => {
                                _el.hide('slow')
                                    .remove();
                            }, 5000);
                        } else {
                            let notify = document.querySelector('#notify');
                            if (notify != null) {
                                notify.remove()
                            }
                            var _el = $('<div>');
                            _el.hide();
                            _el.addClass('alert alert-danger alert_msg form-group');
                            _el.attr('id', 'notify');
                            _el.text(resp.msg);
                            $('#edit').prepend(_el);
                            _el.show('slow');
                            setTimeout(() => {
                                _el.hide('slow')
                                    .remove();
                            }, 3000);
                        }
                    } else {
                        alert("An error occurred. Please check the source code and try again!");
                    }
                    $('#staticBackdropView .modal-footer').prepend('<button type="button" id="cancel-btn" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>');
                    $('#staticBackdropView button').attr('disabled', false)
                    $('#staticBackdropView button[form="edit"]').text("Edit");
                }
            })
        }
    });

    // DELETE Data
    $('#delete').submit(function (e) {
        e.preventDefault();
        $('#staticBackdropDelete #cancel-btn').remove();
        $('#staticBackdropDelete button[form="delete"]').text("");
        $('#staticBackdropDelete button').attr('disabled', true)
        $('#staticBackdropDelete button[type="submit"]').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Deleting...');

        $.ajax({
            url: 'delete_org.php',
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
                        if (notify != null) {
                            notify.remove()
                        }
                        var _el = $('<div>')
                        _el.hide()
                        _el.addClass('alert alert-light alert_msg fw-bold')
                        _el.attr('id', 'notify');
                        _el.text("Student Organization Successfully Deleted");
                        _el.append('<i class="fa fa-check fs-3 ms-2 text-success"></i>');
                        $('#delete').get(0).reset()
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
                        if (notify != null) {
                            notify.remove()
                        }
                        _el.hide()
                        _el.addClass('alert alert-danger alert_msg form-group');
                        _el.attr('id', 'notify');
                        _el.text(resp.msg);
                        $('#delete').prepend(_el)
                        _el.show('slow')
                        setTimeout(() => {
                            _el.hide('slow')
                                .remove();
                        }, 5000);
                    } else {
                        alert("An error occured. Please check the source code and try again")
                    }
                } else {
                    alert("An error occurred. Please check the source code and try again")
                }
                $('#staticBackdropDelete .modal-footer').prepend('<button type="button" id="cancel-btn" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>');
                $('#staticBackdropDelete button').attr('disabled', false)
                $('#staticBackdropDelete button[form="delete"]').text("Yes")
            }
        })
    });

});