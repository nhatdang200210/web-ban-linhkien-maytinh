<?php

if (isset($_POST['doimatkhau'])) {
    $taikhoan = $_POST['email'];
    $matkhau_cu = md5($_POST['password_cu']);
    $matkhau_moi = md5($_POST['password_moi']);
    $nhaplaimk = md5($_POST['nhaplaimatkhau']);
    $id_dangky = $_POST['id_dangky'];
    $sql = "SELECT * FROM tbl_dangky WHERE email ='" . $taikhoan . "' AND matkhau ='" . $matkhau_cu . "' AND id_dangky = '" . $id_dangky . "' LIMIT 1";
    $row = mysqli_query($mysqli, $sql);
    $count = mysqli_num_rows($row);

    if ($matkhau_moi != $nhaplaimk) {
        echo '<p style="color:red">Mật khẩu nhập lại không đúng.</p>';
    } else {
        if ($count > 0) {
            $sql_sua = mysqli_query($mysqli, "UPDATE tbl_dangky SET matkhau= '" . $matkhau_moi . "'  WHERE id_dangky = '" . $id_dangky . "' ");
            echo '<p style="color:green">Mật khẩu được thay đổi thành công.</p>';
        } else {
            echo '<p style="color:red">Tài khoản hoặc mật khẩu không đúng, vui lòng nhập lại.</p>';
        }
    }
}
?>

<head>
    <title>
    An Phát Computer - Đổi mật khẩu tài khoản
    </title>
</head>
<div class="dangnhap">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h2 class="text-center">Đổi mật khẩu của bạn</h2>
        </div>
        <div class="panel-body">
            <form action="" method="POST">

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input required="true" type="email" class="form-control" id="email" placeholder="Nhập email" style="padding: 25px 15px 25px; font-size:18px" name="email">
                    <input type="hidden" class="form-control" placeholder="Nhập email" style="padding: 25px 15px 25px; font-size:18px" name="id_dangky" value="<?php echo $_SESSION['id_khachhang'] ?>">
                </div>

                <div class="form-group">
                    <label for="old_pwd">Khật khẩu cũ:</label>
                    <div class="input-group">
                        <input required="true" type="password" class="form-control" id="old_pwd" placeholder="Nhập mật khẩu" style="padding: 25px 15px 25px; font-size:18px" name="password_cu">
                        <button type="button" class="toggle-password" onclick="togglePassword('old_pwd')"><i class="fa-solid fa-eye-slash"></i></button>
                    </div>
                </div>
                <div class="form-group">
                    <label for="new_pwd">Khật khẩu mới:</label>
                    <div class="input-group">
                        <input required="true" type="password" class="form-control" id="new_pwd" placeholder="Nhập mật khẩu" style="padding: 25px 15px 25px; font-size:18px" name="password_moi">
                        <button type="button" class="toggle-password" onclick="togglePassword('new_pwd')"><i class="fa-solid fa-eye-slash"></i></button>
                    </div>
                </div>
                <div class="form-group">
                    <label for="confirmation_pwd">Nhập lại mật khẩu:</label>
                    <div class="input-group">
                        <input required="true" type="password" class="form-control" id="confirmation_pwd" placeholder="Nhập lại mật khẩu" style="padding: 25px 15px 25px; font-size:18px" name="nhaplaimatkhau">
                        <button type="button" class="toggle-password" onclick="togglePassword('confirmation_pwd')"><i class="fa-solid fa-eye-slash"></i></button>
                    </div>
                </div>
                <div style="width:100%; margin-top:5%; height:auto">
                    <button type="submit" class="btn btndk" name="doimatkhau"><b>Đổi mật khẩu</b></button>
                </div>

            </form>
        </div>
    </div>
</div>
<style>
    .form-group {
        margin-bottom: 3%;
    }

    .text-center {
        color: blue
    }

    .btndk {
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
<!-- <script>
    function togglePassword(fieldId) {
        var field = document.getElementById(fieldId);
        var button = field.nextElementSibling;
        var icon = button.querySelector('i');
        if (field.type === "password") {
            field.type = "text";
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        } else {
            field.type = "password";
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        }
    }
</script> -->