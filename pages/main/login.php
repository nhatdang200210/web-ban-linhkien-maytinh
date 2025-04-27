<head>
    <title>
        An Phát Computer - Đăng nhập tài khoản
    </title>
</head>

<?php
if (isset($_POST['dangnhap'])) {
    $email = $_POST['email'];
    $matkhau = md5($_POST['password']);

    // Kiểm tra trạng thái khoá trước khi lấy dữ liệu
    $sql = "SELECT * FROM tbl_dangky WHERE email ='" . $email . "' AND locked = 0 LIMIT 1";
    $row = mysqli_query($mysqli, $sql);
    $count = mysqli_num_rows($row);

    if ($count > 0) {
        $row_data = mysqli_fetch_array($row);

        // Kiểm tra mật khẩu sau khi lấy dữ liệu
        if ($row_data['matkhau'] == $matkhau) {
            $_SESSION['dangky'] = $row_data['tenkhach'];
            $_SESSION['id_khachhang'] = $row_data['id_dangky'];
            // header("Location:index.php?quanly=giohang");
            echo "<script>
                            window.location = 'index.php';
                        </script>";
        } else {
            echo '<p style="color:red"> Mật khẩu hoặc email sai. Vui lòng nhập lại. </p>';
        }
    } else {
        echo '<p style="color:red"> Tài khoản không tồn tại hoặc đã bị khoá. </p>';
    }
}
?>

<div class="dangnhap">
    <div>
        <h2 class="text-center">Đăng Nhập khách hàng</h2>
    </div>

    <form action="" method="POST">
        <div class="form-group">
            <label for="exampleInputEmail1">Tài khoản</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Nhập email" style="padding: 25px 15px 25px; font-size:18px" name="email">
            <small id="emailHelp" class="form-text text-muted">Chúng tôi sẽ không bao giờ chia sẻ email của bạn với bất kỳ ai khác.</small>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <div class="input-group">
                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Nhập mật khẩu" style="padding: 25px 15px 25px; font-size:18px" name="password">
                <button type="button" class="toggle-password" onclick="togglePassword('exampleInputPassword1')"><i class="fa-solid fa-eye-slash"></i></button>
            </div>
        </div>
        <div style="width:100%; margin-top:5%; height:auto">
            <button type="submit" class="btn btndn" name="dangnhap"><b>Đăng nhập</b></button><br>
        </div>
        <div style=" text-align:center; margin-top:10px">
            <a style="color: blue; font-size:18px; " href="index.php?quanly=dangky">Đăng ký nếu bạn chưa có tài khoản</a>
        </div>
    </form>
</div>
<style>
    .form-group {
        margin-bottom: 3%;
    }

    .text-center {
        color: blue
    }

    .btndn {
        padding: 10px;
        width: 100%;
        background-color: red;
        color: white;
        font-size: 18px;
    }

    .btn:hover {
        background-color: #D90000;
        color: white;
    }
</style>