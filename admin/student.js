var studentTbl = "";
$(function () {
    // draw function [called if the database updates]
    function draw_data() {
        if ($.fn.dataTable.isDataTable('#student-tbl') && studentTbl != '') {
            studentTbl.draw(true);
        } else {
            load_data();
        }
    }

    function load_data() {
        studentTbl = $('#student-tbl').DataTable({
            "aLengthMenu": [
                [5, 10, 15, 20],
                [5, 10, 15, 20]
            ],
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "get_students.php",
                method: 'POST',
                data: function (data) {
                    //Read Values
                    const searchByCourse = document.querySelector('#course').value;
                    const searchByYrlevel = document.querySelector('#ylvl').value;
                    //Append Data
                    data.searchByCourse = searchByCourse;
                    data.searchByYrlevel = searchByYrlevel;
                },
            },
            columns: [{
                    data: 'studnum',
                },
                {
                    data: 'name',
                },
                {
                    data: 'course',
                },
                {
                    data: 'ylvl',
                }
            ],
            //drawCallback: function (settings) {},
        });
    }

    load_data();

    $('#ylvl').change(function () {
        studentTbl.draw();
        // console.log(document.querySelector('#ylvl').value);
    });
    $('#course').change(function () {
        studentTbl.draw();
    });
});