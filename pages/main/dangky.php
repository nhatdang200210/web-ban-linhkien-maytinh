<head>
	<title>Đăng ký tài khoản</title>
</head>
<?php
if (isset($_POST['dangky'])) {
	// Lấy dữ liệu từ form
	$tenkhach = $_POST['hoten'];
	$email = $_POST['email'];
	$dienthoai = $_POST['dienthoai'];
	$matkhau = $_POST['matkhau'];
	$nhaplaimk = $_POST['nhaplaimatkhau'];
	// Kiểm tra xem email đã tồn tại trong cơ sở dữ liệu hay chưa
	$sql_check_email = "SELECT * FROM tbl_dangky WHERE email = '$email'";
	$result_check_email = mysqli_query($mysqli, $sql_check_email);
	// $row = mysqli_fetch_array($result_check_email);

	if (mysqli_num_rows($result_check_email) > 0) {
		echo '<p style="color:red">Email đã tồn tại. Vui lòng sử dụng email khác.</p>';
	} elseif ($matkhau != $nhaplaimk) {
		echo '<p style="color:red">Mật khẩu không giống nhau vui lòng nhập lại.</p>';
	} else {
		// Thực hiện mã hóa mật khẩu
		$matkhau = md5($matkhau);

		// Thực hiện truy vấn SQL để thêm dữ liệu vào cơ sở dữ liệu
		$sql_dangky = mysqli_query($mysqli, "INSERT INTO tbl_dangky (tenkhach, email, matkhau, dienthoai, locked) VALUES ('$tenkhach', '$email', '$matkhau', '$dienthoai',0)");

		if ($sql_dangky) {
			echo "<script>
                            alert('Bạn đã đăng ký thành công.');
                            window.location = 'index.php?quanly=login';
                        </script>";
		} else {
			echo '<p style="color:red">Đã có lỗi xảy ra. Vui lòng thử lại sau.</p>';
		}
	}
}
?>
<div class="dangnhap">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h2 class="text-center">Đăng ký thành viên</h2>
		</div>
		<div class="panel-body">
			<form action="" method="POST">
				<div class="form-group">
					<label for="usr">Name:</label>
					<input required="true" type="text" class="form-control" id="usr" placeholder="Nhập họ tên" style="padding: 25px 15px 25px; font-size:18px" name="hoten">
				</div>
				<div class="form-group">
					<label for="email">Email:</label>
					<input required="true" type="email" class="form-control" id="email" placeholder="Nhập email" style="padding: 25px 15px 25px; font-size:18px" name="email">
				</div>
				<div class="form-group">
					<label for="dt">Số điện thoại</label>
					<input required="true" type="text" class="form-control" id="dt" placeholder="Nhập số điện thoại" style="padding: 25px 15px 25px; font-size:18px" name="dienthoai">
				</div>
				<div class="form-group">
					<label for="pwd">Khật khẩu:</label>
					<div class="input-group">
						<input required="true" type="password" class="form-control" id="pwd" placeholder="Nhập mật khẩu" style="padding: 25px 15px 25px; font-size:18px" name="matkhau">
						<button type="button" class="toggle-password" onclick="togglePassword('pwd')"><i class="fa-solid fa-eye-slash"></i></button>
					</div>
				</div>
				<div class="form-group">
					<label for="confirmation_pwd">Nhập lại mật khẩu:</label>
					<div class="input-group">
						<input required="true" type="password" class="form-control" id="confirmation_pwd" placeholder="Nhập lại nật khẩu" style="padding: 25px 15px 25px; font-size:18px" name="nhaplaimatkhau">
						<button type="button" class="toggle-password" onclick="togglePassword('confirmation_pwd')"><i class="fa-solid fa-eye-slash"></i></button>
					</div>
				</div>
				<div style="width:100%; margin-top:5%; height:auto">
					<button class="btn btndk" name="dangky"><b>Đăng ký</b></button>
				</div>
				<div style="text-align:center; margin-top:10px">
					<a style="color: blue; font-size:18px; " href="index.php?quanly=login">Đăng nhập nếu bạn đã có tài khoản</a>
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