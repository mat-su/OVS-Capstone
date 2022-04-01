<?php
session_start();
include '../functions.php';
$conn = MYSQL_DB_Connection();
if (isset($_SESSION['v_id']) && isset($_SESSION['v_email']) && isset($_SESSION['org_id'])) {
    $studnum = $_SESSION['v_studnum'];
    $stmt = $conn->prepare("SELECT c_studnum, c_id FROM tbl_candidates WHERE c_studnum = :studnum");
    $stmt->bindParam(':studnum', $studnum, PDO::PARAM_STR);
    $stmt->execute();
    if ($stmt->rowCount() == 1) {
        $c = $stmt->fetch(PDO::FETCH_ASSOC);
        $can = SelectAll_CandidateWithInfo($c['c_id']);
        $_SESSION['c_id'] = $c['c_id'];

        $fullname = $can['Name'];
        $position = $can['Position'];
        $platform = (!empty($can['Platform'])) ? $can['Platform'] : '<p style="text-align:center;">Nothing to show.</p>';
        $dir_img_file = './img-uploads/' . $can['Profile Image'];
        $candidate_img = (!empty($can['Profile Image'])) ? $dir_img_file  : '../assets/img/default_candi.png';
        $course = $can['Course'];
        $ylvl = $can['Year Level'];
        $partylist = $can['Partylist'];
    } else {
        if (isset($_SESSION['dashboard']) && $_SESSION['dashboard'] === true) {
            header("Location: dashboard.php?err=Sorry your not an official candidate!");
        } else {
            header("Location: partylist.php?err=Sorry your not an official candidate!");
        }
    }

?>

    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <title>Candidate Page</title>

        <link rel="stylesheet" href="style.css">
        <!-- Tab Logo -->
        <link rel="shortcut icon" type="image/jpg" href="https://ik.imagekit.io/nwlfpk0xpdg/img/ovs_logo_x6ne_tPjZ7.jpg?ik-sdk-version=javascript-1.4.3&updatedAt=1648299575563" />

        <!--FontAwesome Kit-->
        <script src="https://kit.fontawesome.com/8acebfc2d4.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

        <!--JQuery Link-->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

        <!-- Summernote -->
        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

        <!-- Cropper CSS -->
        <link href="../cropperjs/cropper.min.css" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <style type="text/css">
            #image {
                display: block;
                max-width: 100%;
            }

            .preview {
                overflow: hidden;
                width: 160px;
                height: 160px;
                margin: 10px;
                border: 1px solid red;
            }
        </style>

        <div class="d-flex toggled" id="wrapper">
            <div id="page-content-wrapper">
                <div class="container" id="candidate-container">
                    <div id="notify"></div>
                    <!--Candidate 1-->
                    <?php if (isset($_GET['err'])) { ?>
                        <div class="alert alert-danger mt-3" role="alert">
                            <i class="fas fa-times fs-4 me-3"></i><span><?= $_GET['err'] ?></span>
                        </div>
                    <?php } ?>
                    <?php if (isset($_GET['info'])) { ?>
                        <div class="alert alert-success mt-3" role="alert">
                            <i class="fas fa-check fs-4 me-3"></i><span><?= $_GET['info'] ?></span>
                        </div>
                    <?php } ?>
                    <div class="row bg-white m-2 p-3 shadow-lg justify-content-around align-items-center rounded border border-primary border-3">
                        <div class=""><a href="dashboard.php" class="btn btn-secondary float-end">Back</a></div>
                        <div class="col-md-6 text-center">
                            <div>
                                <img class="rounded-circle border img-fluid my-3" src="<?= $candidate_img ?>" alt="" style="width: auto; height:10rem;">
                                <div class="mb-3"><button class="btn btn-outline-primary" type="button" id="btn-edit-prof">Update Picture <i class="fas fa-camera"></i></button></div>
                            </div>
                            <div class="mb-3 card card-body shadow" id="upload-sec" hidden>
                                <div>
                                    <button type="button" class="btn-close float-end" aria-label="Close"></button>
                                    <p class="text-start">
                                        Please select an image from your device
                                        <br><small class="text-danger">*Image must be less than 1mb</small>
                                    </p>
                                </div>
                                <form method="POST" enctype="multipart/form-data">
                                    <div class="input-group input-group-sm ">
                                        <input type="file" name="profile-img" class="form-control" id="profile-img" aria-label="Upload" accept="image/*" required>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- Modal for crop -->
                        <div class="modal fade" id="modal" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalLabel">Crop image</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="img-container">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <!--  default image where we will set the src via jquery-->
                                                    <img id="image">
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="preview"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button id="btn-cancel" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="button" class="btn btn-primary" id="crop">Upload and Crop</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Modal for crop -->

                        <div class="col-md-6">
                            <h3 class="fs-2"><?= $fullname ?></h3>
                            <h5 class="fs-3"><?= $position ?></h5>
                            <p class="fs-5">Get to know me!</p>
                        </div>

                        <div class="divider div-transparent mb-3"></div>
                        <div><button class="btn btn-secondary float-end mx-4 " id="btn-edit-platform">Edit <i class="fas fa-edit"></i></button></div>
                        <div class="col-md-12">
                            <div class="text-center">
                                <i class="fas fa-bullhorn fs-1 primary-text  secondary-bg p-4"></i>
                            </div>

                            <div id="display-platform" style="word-wrap: break-word;" class="container">
                                <h3 class="fs-3 text-center">Platform</h3>
                                <p class="fs-6"><?= htmlspecialchars_decode($platform) ?></p>
                            </div>

                            <div class="card card-body col-12 shadow mb-3" id="platform-sec" hidden>
                                <div class="mb-3">
                                    <div class="text-center"><span class="fs-3">Platform</span><button type="button" class="btn-close float-end" aria-label="Close" id="btn-close-platform1"></button></div>
                                </div>
                                <form action="candi-plat.php" method="POST" id="frmPlatform">
                                    <div class="form-floating">
                                        <textarea id="platform" name="platform"><?= $platform ?></textarea>
                                    </div>
                                </form>

                                <div class="mt-2">
                                    <button type="submit" class="btn btn-primary float-end" form="frmPlatform" name="submit">Save</button>
                                    <button type="button" class="btn btn-secondary float-end me-2" id="btn-close-platform2">Close</button>
                                </div>
                            </div>

                        </div>
                        <div class="divider div-transparent"></div>

                        <div class="col-md-6 text-center">
                            <i class="fas fa-id-card-alt fs-1 primary-text  secondary-bg p-4"></i>
                            <h3 class="fs-3 ">Info</h3>
                            <p class="fs-6"><?= $fullname ?></p>
                            <p class="fs-6"><?= $course ?></p>
                            <p class="fs-6"><?= $ylvl ?></p>
                            <p class="fs-6"><?= $partylist ?></p>
                        </div>
                    </div>
                    <!--End Candidate 1-->
                </div>
            </div>

        </div>


        <?= template_footer() ?>


        <script>
            $(document).ready(function() {
                $("#btn-edit-prof").click(function() {
                    $("#upload-sec").prop('hidden', false);
                    $("#btn-edit-prof").prop('hidden', true);
                });
                $(".btn-close").click(function() {
                    $("#upload-sec").prop('hidden', true);
                    $("#btn-edit-prof").prop('hidden', false);
                    $('#profile-img').val('');
                });
                $('.alert').delay(3000).slideUp(200, function() {
                    $(this).alert('close');
                });
                $("#btn-edit-platform").click(function() {
                    $("#platform-sec").prop("hidden", false);
                    $("#btn-edit-platform").prop("hidden", true);
                    $("#display-platform").prop("hidden", true);
                });
                $('#btn-close-platform1, #btn-close-platform2').click(function() {
                    $("#platform-sec").prop("hidden", true);
                    $("#btn-edit-platform").prop("hidden", false);
                    $("#display-platform").prop("hidden", false);
                    $('#platform').summernote('reset');
                    $('span.note-icon-caret').remove();
                });
            });
            $('#platform').summernote({
                placeholder: 'Place your platform here.',
                tabsize: 2,
                height: 120,
                lineHeights: ['0.2', '0.3', '0.4', '0.5', '0.6', '0.8', '1.0', '1.2', '1.4', '1.5', '2.0', '3.0'],
                fontSizes: ['8', '9', '10', '11', '12', '14', '16', '18', '20', '22', '36', '40', '72'],
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph', 'height']],
                    ['table', ['table']],
                    ['insert', ['hr']],
                    ['view', ['help']]
                ],
                disableDragAndDrop: true,
                fontNames: ['sans-serif', 'Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Helvetica', 'Impact', 'Lucida Grande', 'Tahoma', 'Times New Roman', 'Verdana', 'Sacramento'],
                callbacks: { //restrict the pasting of images
                    onImageUpload: function(data) {
                        data.pop();
                    }
                }
            });
            $('span.note-icon-caret').remove();
        </script>
        <!-- Cropper JS -->
        <script src="../cropperjs/cropper.min.js" type="text/javascript"></script>
        <script>
            var bs_modal = $('#modal');
            var image = document.getElementById('image');
            var cropper, reader, file;


            $("body").on("change", "#profile-img", function(e) {
                var files = e.target.files;
                console.log(files.length);
                file = files[0];
                if (files.length > 0) {
                    var extension = file.name.split('.').pop().toLowerCase();

                    const validExtension = ['jpg', 'jpeg', 'png', 'gif'];
                    if (validExtension.includes(extension)) {
                        if (file.size < 1048576) {
                            var done = function(url) {
                                image.src = url;
                                bs_modal.modal('show');
                            };

                            if (files && files.length > 0) {
                                if (URL) {
                                    done(URL.createObjectURL(file));
                                } else if (FileReader) {
                                    reader = new FileReader();
                                    reader.onload = function(e) {
                                        done(reader.result);
                                    };
                                    reader.readAsDataURL(file);
                                }
                            }
                        } else {
                            let notify = document.querySelector('#notify');
                            if (notify != null) {
                                notify.remove();
                            }
                            var _icon = $('<i>');
                            _icon.attr('id', 'x-icon');
                            _icon.addClass('fas fa-times fs-4 me-3');
                            var _el = $('<div>');
                            _el.hide();
                            _el.addClass('alert alert-danger alert_msg form-group');
                            _el.attr('id', 'notify');
                            _el.text('File must be less than 1MB.');
                            _el.prepend(_icon);
                            $('#candidate-container').prepend(_el);
                            _el.show('slow');
                        }
                    } else {
                        let notify = document.querySelector('#notify');
                        if (notify != null) {
                            notify.remove();
                        }
                        var _icon = $('<i>');
                        _icon.attr('id', 'x-icon');
                        _icon.addClass('fas fa-times fs-4 me-3');
                        var _el = $('<div>');
                        _el.hide();
                        _el.addClass('alert alert-danger alert_msg form-group');
                        _el.attr('id', 'notify');
                        _el.text('Must be a valid image file extension.');
                        _el.prepend(_icon);
                        $('#candidate-container').prepend(_el)
                        _el.show('slow');
                    }
                    $('.alert').delay(3000).slideUp(200, function() {
                        $(this).alert('close');
                    });
                    $('#profile-img').val("");
                }
            });

            bs_modal.on('shown.bs.modal', function() {
                cropper = new Cropper(image, {
                    aspectRatio: 1,
                    viewMode: 0,
                    preview: '.preview'
                });
            }).on('hidden.bs.modal', function() {
                cropper.destroy();
                cropper = null;
                $('#profile-img').val("");
            });

            $("#crop").click(function() {
                $('#modal #btn-cancel').remove();
                $('#modal #crop').text("");
                $('#modal button').attr('disabled', true)
                $('#modal #crop').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Uploading...');


                canvas = cropper.getCroppedCanvas({
                    width: 720,
                    height: 720,
                });

                canvas.toBlob(function(blob) {
                    url = URL.createObjectURL(blob);
                    var reader = new FileReader();
                    reader.readAsDataURL(blob);
                    reader.onloadend = function() {
                        var base64data = reader.result;

                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: "upload-profile-img.php",
                            data: {
                                image: base64data
                            },
                            success: function(resp) {
                                bs_modal.modal('hide');
                                if (!!resp.success) {
                                    alert("Image Successfully Uploaded!");
                                    window.location.href = resp.action;
                                } else {
                                    alert(resp.action);
                                }
                            }
                        });
                    };
                });
            });
        </script>
    </body>


    </html>


<?php
} else {
    header("Location: ../index.php");
}
?>