<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('config/conect.php');

if (isset($_POST['dangnhap'])) {
    $taikhoan = $_POST['username'];
    $matkhau = md5($_POST['password']);
    $sql = "SELECT * FROM tbl_admin WHERE username ='" . $taikhoan . "' AND password ='" . $matkhau . "' LIMIT 1";
    $row = mysqli_query($mysqli, $sql);
    $count = mysqli_num_rows($row);
    if ($count > 0) {
        $_SESSION['dangnhap'] = $taikhoan;
        header("Location:index.php?action=quanlysanpham&query=lietkeall");
    } else {
        echo
        "<script>
                alert('Tài khoản hoặc mật khẩu không đúng, vui lòng nhập lại.');
                window.location = 'login.php';
            </script>";
    }
}

if (isset($_SESSION['dangnhap'])){
    header("Location:index.php?action=quanlysanpham&query=lietkeall");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập admin</title>
    <link rel="stylesheet" type="text/css" href="css/style-admin.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <div class="wrapper_login">
        <form action="" method="POST">
            <div class="dangnhap">
                <h3>Đăng nhập tài khoản quản trị</h3>
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email</label>
                <input type="email" name="username" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Mật khẩu</label>
                <input type="password" name="password" class="form-control" id="exampleInputPassword1">
            </div>
            <div class="bnt_dn">
                <button type="submit" name="dangnhap" class="btn btn-primary">Đăng nhập</button>
            </div>

        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
<style type="text/css">
    body {
        background-image: url("https://png.pngtree.com/background/20211215/original/pngtree-technology-light-blue-minimalist-technology-background-picture-image_1474700.jpg");
        background-size: 100%;
        padding: 10%;
    }

    .wrapper_login {
        /* border: 2px solid red; */
        width: 50%;
        margin: auto;
        background-color: white;
        padding: 5%;
        border-radius: 30px;
    }

    .wrapper_login div.bnt_dn {
        text-align: center;
    }

    .wrapper_login div.bnt_dn button {
        transition: all 0.3s ease;
    }

    .wrapper_login div.bnt_dn button:hover {
        background-color: green;
        transform: scale(1.1);
    }

    .dangnhap {
        color: red;
        font-weight: bold;
        text-align: center;
        margin-bottom: 5%;
    }
</style>

</html>