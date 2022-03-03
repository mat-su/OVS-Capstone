var schedTbl = '';
$(function () {
    function clearBS_Validation() {
        $('#startdate').removeClass('is-invalid');
        $('#enddate').removeClass('is-invalid');
        $('#startdate').removeClass('is-valid');
        $('#enddate').removeClass('is-valid');
        $('#error-msg').removeClass('alert alert-danger');
        document.querySelector("#error-msg").innerHTML = "";
    }
    // draw function [called if the database updates]
    function draw_data() {
        if ($.fn.dataTable.isDataTable('#sched-tbl') && schedTbl != '') {
            schedTbl.draw(true);
        } else {
            load_data();
        }
    }

    function load_data() {
        schedTbl = $('#sched-tbl').DataTable({
            "aaSorting": [],
            "aLengthMenu": [
                [5, 10, 15, -1],
                [5, 10, 15, "All"]
            ],
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "./get_schedules.php",
                method: 'POST',
            },
            columns: [{
                    data: 'organization',
                },
                {
                    data: 'startdate',
                },
                {
                    data: 'enddate',
                },
                {
                    data: null,
                    orderable: false,
                    className: 'text-center',
                    render: function (data, type, row, meta) {
                        let htmlScript = '';
                        if (data.startdate == null || data.enddate == null) {
                            htmlScript = '<a class="edit_data me-1" href="javascript:void(0)" data-id="' + (row.id) + '"title="Set Schedule"><i class="far fa-calendar-alt fa-xs fs-5 text-primary"></i></a>';
                        } else {
                            htmlScript = '<a class="edit_data me-1" href="javascript:void(0)" data-id="' + (row.id) + '"title="Set Schedule"><i class="far fa-calendar-alt fa-xs fs-5 text-primary"></i></a>' +
                                '<a class="delete_data" href="javascript:void(0)" data-id="' + (row.id) + '"title="Clear Schedule"><i class="fas fa-eraser fa-xs fs-5 text-danger"></i></a>';
                        }
                        return htmlScript;

                    }
                }
            ],
            drawCallback: function (settings) {
                $('.edit_data').click(function () {
                    validator.resetForm();
                    clearBS_Validation();
                    $.ajax({
                        url: './get_selected_sched.php',
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
                                let myid = document.querySelector('form#sched input[name="id"]');

                                myid.value = `${resp.data['id']}`;
                                let curDate = new Date();
                                let strt = document.querySelector("#startdate");
                                let end = document.querySelector("#enddate");
                                if (resp.data.startdate !== null && resp.data.enddate !== null) {
                                    let date = new Date(resp.data['startdate']);
                                    strt.value = date.yyyymmddT();

                                    date = new Date(resp.data['enddate']);
                                    end.value = date.yyyymmddT();

                                } else {
                                    strt.value = "";
                                    end.value = "";
                                }
                                strt.setAttribute('min', `${curDate.yyyymmddT()}`);
                                end.setAttribute('min', `${curDate.yyyymmddT()}`);
                                $('#staticBackdropSched').modal('show');

                            } else {
                                alert("An error occured while fetching single data");
                            }
                        }
                    })
                })
                $('.delete_data').click(function () {
                    $.ajax({
                        url: './get_selected_sched.php',
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
                                $('#staticBackdropClrSched').modal('show');
                                const myid = document.querySelector('form#clrsched input[name="id"]');
                                myid.value = resp.data['id'];
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


    var validator = $('#sched').validate({
        rules: {
            startdate: "required",
            enddate: {
                required: true
            }
        },
        messages: {
            startdate: {
                required: "Please select the starting date and time",
                min: "Please set the value greater or equal to current date and time"
            },
            enddate: {
                required: "Please select the ending date and time",
                min: "Please set the value greater than the selected starting date and time"
            }
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass("is-invalid").removeClass("is-valid");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).addClass("is-valid").removeClass("is-invalid");
        },
        submitHandler: function () {
            $('#staticBackdropSched #cancel').remove();
            $('#staticBackdropSched button[form="sched"]').text("");
            $('#staticBackdropSched button').attr('disabled', true)
            $('#staticBackdropSched button[type="submit"]').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');

            let serializedForm = $('#sched').serializeArray();
            const formdata = new Object();
            $.each(serializedForm, function (i, field) {
                formdata[field.name] = $.trim(field.value);
            });
            let curDate = new Date();
            const err_container = document.querySelector('#error-msg');
            if (Date.parse(formdata.startdate) > Date.parse(formdata.enddate) && Date.parse(formdata.startdate) > curDate) {
                err_container.classList.add('alert', 'alert-danger');
                err_container.innerHTML = '<b>Start date is ahead on End date!</b>';

                $('#startdate').addClass('is-invalid');
                $('#staticBackdropSched .modal-footer').prepend('<button type="button" id="cancel" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>');
                $('#staticBackdropSched button').attr('disabled', false)
                $('#staticBackdropSched button[form="sched').text("Save Schedule");
            } else if (formdata.startdate === formdata.enddate) {
                err_container.classList.add('alert', 'alert-danger');
                err_container.innerHTML = '<b>Start date and End date cannot be the same!</b>';

                $('#startdate').addClass('is-invalid');
                $('#enddate').addClass('is-invalid');
                $('#staticBackdropSched .modal-footer').prepend('<button type="button" id="cancel" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>');
                $('#staticBackdropSched button').attr('disabled', false)
                $('#staticBackdropSched button[form="sched').text("Save Schedule");
            } else if (Date.parse(formdata.startdate) < curDate) {

                err_container.classList.add('alert', 'alert-danger');
                err_container.innerHTML = '<b>Starting date already passed!</b>';

                $('#startdate').addClass('is-invalid');
                $('#enddate').addClass('is-invalid');
                $('#staticBackdropSched .modal-footer').prepend('<button type="button" id="cancel" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>');
                $('#staticBackdropSched button').attr('disabled', false)
                $('#staticBackdropSched button[form="sched').text("Save Schedule");
            } else {
                err_container.classList.remove('alert', 'alert-danger', 'container-fluid');
                err_container.innerHTML = "";
                $.ajax({
                    url: 'setVS.php',
                    data: formdata,
                    method: 'POST',
                    dataType: 'json',
                    error: function (request, error, status) {
                        alert("An error occured. Please check the source code and try again!!" + status + '  ' + request + ' - ' + error);
                    },
                    success: function (resp) {
                        if (!!resp.status) {
                            if (resp.status == 'success') {
                                let notify = document.querySelector('#notify');
                                if (notify != null) {
                                    notify.remove()
                                };
                                var _el = $('<div>')
                                _el.hide()
                                _el.attr('id', 'notify');
                                _el.addClass('alert alert-light alert_msg fw-bold');
                                _el.text("Schedule Successfully Saved!");
                                _el.append('<i class="fa fa-check fs-3 ms-2 text-success"></i>');

                                $('.modal').modal('hide')
                                draw_data();
                                $('#response-msg').append(_el)
                                _el.show('slow')

                                setTimeout(() => {
                                    _el.hide('slow')
                                        .remove()
                                }, 5000)
                            } else if (resp.status == 'failed' && !!resp.msg) {
                                err_container.classList.add('alert', 'alert-danger');
                                err_container.innerHTML = `<b>${resp.msg}</b>`;

                                $('#startdate').addClass('is-invalid');
                                $('#enddate').addClass('is-invalid');
                            } else {
                                let notify = document.querySelector('#notify');
                                if (notify != null) {
                                    notify.remove()
                                };
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
                            alert("An error occurred. Please check the source code and try again!");
                        }

                        $('#staticBackdropSched .modal-footer').prepend('<button type="button" id="cancel" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>');
                        $('#staticBackdropSched button').attr('disabled', false)
                        $('#staticBackdropSched button[form="sched').text("Save Schedule");
                    }
                });
            }

        }
    });

    $('#clrsched').submit(function (e) {
        e.preventDefault();
        $('#staticBackdropClrSched #cancel-btn').remove();
        $('#staticBackdropClrSched button[form="clrsched"]').text("");
        $('#staticBackdropClrSched button').attr('disabled', true)
        $('#staticBackdropClrSched button[type="submit"]').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Clearing...');

        $.ajax({
            url: 'clear-now.php',
            data: $(this).serialize(),
            method: 'POST',
            dataType: "json",
            error: function (request, error, status) {
                alert("An error occured. Please check the source code and try again!!" + status + '  ' + request + ' - ' + error);
            },
            success: function (resp) {
                if (!!resp.status) {
                    if (resp.status == 'success') {
                        let notify = document.querySelector('#notify');
                        if (notify != null) {
                            notify.remove()
                        };
                        var _el = $('<div>')
                        _el.hide()
                        _el.attr('id', 'notify');
                        _el.addClass('alert alert-light alert_msg fw-bold');
                        _el.text("Schedule Successfully Cleared!");
                        _el.append('<i class="fa fa-check fs-3 ms-2 text-success"></i>');

                        $('.modal').modal('hide')
                        draw_data();
                        $('#response-msg').append(_el)
                        _el.show('slow')

                        setTimeout(() => {
                            _el.hide('slow')
                                .remove()
                        }, 5000)
                    } else if(resp.status == 'failed' && !!resp.msg) {
                        var _el = $('<div>')
                        _el.hide()
                        _el.addClass('alert alert-danger alert_msg form-group')
                        _el.text(resp.msg);
                        $('#clrsched').prepend(_el)
                        _el.show('slow')
                    } else {
                        alert("An error occured. Please check the source code and try again")
                    }
                    $('#staticBackdropClrSched .modal-footer').prepend('<button type="button" id="cancel-btn" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>');
                    $('#staticBackdropClrSched button').attr('disabled', false)
                    $('#staticBackdropClrSched button[form="clrsched"]').text("Yes")
                }
            }
        });

    });
});

Date.prototype.yyyymmddT = function () {
    let mm = this.getMonth() + 1; // getMonth() is zero-based
    let dd = this.getDate();
    let hr = this.getHours();
    let min = this.getMinutes();
    let yyyy = this.getFullYear();
    mm = (mm > 9) ? mm : `0${mm}`;
    dd = (dd > 9) ? dd : `0${dd}`;
    hr = (hr > 9) ? hr : `0${hr}`;
    min = (min > 9) ? min : `0${min}`;

    return `${yyyy}-${mm}-${dd}T${hr}:${min}`;
};

const startingdate = document.querySelector('#startdate');
const endingdate = document.querySelector('#enddate');

startingdate.addEventListener('change', function (e) {
    endingdate.setAttribute('min', startingdate.value);
});