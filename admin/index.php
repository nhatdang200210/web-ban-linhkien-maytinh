<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style-admin.css">
    <link rel="stylesheet" type="text/css" href="css/mobile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>ADMIN</title>

</head>

<body>
    <h2 class="title-admin">WELL COME TO ADMIN</h2>
    <div class="wrapper-main">
        <?php
        session_start();
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        include("config/conect.php");
        // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
        if (!isset($_SESSION['dangnhap'])) {
            header('Location: login.php');
            exit();
        } else {
            include("modules/header.php");
            include("modules/main.php");
           
        }
        // include("modules/footer.php");
        ?>
    </div>

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>


    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#sidebarCollapse').on('click', function() {
                $('#sidebar').toggleClass('active');
            });
        });
    </script>

    <script>
        function imagePreview(fileInput) {
            var files = fileInput.files;
            $('#preview').html(''); // Clear the current preview
            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                if (file) {
                    var fileReader = new FileReader();
                    fileReader.onload = (function(event) {
                        return function(e) {
                            $('#preview').append('<img src="' + e.target.result + '" width="23.5%" height="32%" style="margin: 5px; border: 2px solid #0ECA30; border-radius: 5px"/>');
                        };
                    })(file);
                    fileReader.readAsDataURL(file);
                }
            }
        }

        $(document).ready(function() {
            $("#image").change(function() {
                imagePreview(this);
            });
        });

        // xử lý avatar
        function imageAvtPreview(fileInput) {
            if (fileInput.files && fileInput.files[0]) {
                var fileReader = new FileReader();
                fileReader.onload = function(event) {
                    $('#preview_avt').html('<img src="' + event.target.result + '" width="50%" height="auto" style="margin: 1%; border: 2px solid #0ECA30; border-radius: 5px"/>');
                };
                fileReader.readAsDataURL(fileInput.files[0]);
            }
        }
        $("#image_avt").change(function() {
            imageAvtPreview(this);
        });
    </script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.24.0/ckeditor.js"></script> -->
    <!-- <script src="https://cdn.ckeditor.com/4.24.0/full/ckeditor.js"></script> -->

    <script>
        CKEDITOR.replace('tomtat');
        CKEDITOR.replace('noidung');
        // CKEDITOR.replace('thongtinlh');
        // CKEDITOR.replace('gioithieu');
    </script>
</body>

</html>