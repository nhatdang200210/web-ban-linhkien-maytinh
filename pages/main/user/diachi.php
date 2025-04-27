</head>
<title>An Phát Computer - Cập nhật địa chỉ giao hàng của bạn</title>
</head>
<div style="padding-top: 10px;">
    <a href="index.php"><i class="fa-solid fa-reply"></i> Trở lại</a>
</div>

<?php
$id_dangky = $_SESSION['id_khachhang'];

// Kiểm tra xem thông tin vận chuyển đã tồn tại trong cơ sở dữ liệu cho người dùng hiện tại hay không
$sql_check_existing = mysqli_query($mysqli, "SELECT * FROM tbl_shipping WHERE id_dangky='$id_dangky'");
$count_existing = mysqli_num_rows($sql_check_existing);

// Kiểm tra nếu form đã được gửi đi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['capnhat'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];


    if ($count_existing > 0) {
        // thay đổi tt nếu đã tồn tại, thực hiện cập nhật thông tin
        $sql_update_vanchuyen = mysqli_query($mysqli, "UPDATE tbl_shipping SET name='$name', phone='$phone', address='$address' WHERE id_dangky='$id_dangky'");
        if ($sql_update_vanchuyen) {
            echo '<script>alert("Cập nhật thành công")</script>';
            echo "<script>
                       
                        window.location = 'index.php?quanly=diachi';
                    </script>";
        } else {
            echo '<script>alert("Cập nhật không thành công. Vui lòng thử lại.")</script>';
        }
    } else {
        // Nếu chưa tồn tại, thêm thông tin mới vào cơ sở dữ liệu
        $sql_vanchuyen = mysqli_query($mysqli, "INSERT INTO tbl_shipping (name, phone, address, id_dangky) VALUES ('$name', '$phone', '$address', '$id_dangky')");
        if ($sql_vanchuyen) {
            echo '<script>alert("Thêm thông tin vận chuyển thành công")</script>';
        } else {
            echo '<script>alert("Thêm thông tin vận chuyển không thành công. Vui lòng thử lại.")</script>';
        }
    }
}

// Lấy thông tin vận chuyển từ cơ sở dữ liệu nếu có
$id_dangky = $_SESSION['id_khachhang'];
$sql_get_vanchuyen = mysqli_query($mysqli, "SELECT * FROM tbl_shipping WHERE id_dangky='$id_dangky' LIMIT 1");
$count = mysqli_num_rows($sql_get_vanchuyen);

if ($count > 0) {
    $row_get_vanchuyen = mysqli_fetch_array($sql_get_vanchuyen);
    $name = $row_get_vanchuyen['name'];
    $phone = $row_get_vanchuyen['phone'];
    $address = $row_get_vanchuyen['address'];
} else {
    $name = '';
    $phone = '';
    $address = '';
}
?>
<div class="diachi">
    <form action="" autocomplete="off" method="POST">
        <?php
        if (empty($count)) {
        ?>
            <div class="form-group">
                <label for="email">Họ và tên</label>
                <input type="text" name="name" placeholder="..." class="form-control">
            </div>
            <div class="form-group">
                <label for="email">Phone</label>
                <input type="text" name="phone" placeholder="..." class="form-control">
            </div>
            <div class="form-group">
                <label for="pwd">Địa chỉ</label>
                <input type="text" name="address" placeholder="..." class="form-control">
            </div>
            <button type="submit" name="capnhat" class="btn btn-success">Thêm địa chỉ</button>
        <?php
        } elseif (isset($_POST['suadc'])) {
        ?>
            <div class="form-group">
                <label for="email">Họ và tên</label>
                <input type="text" name="name" value="<?php echo $name ?>" class="form-control" style=" font-weight:bold; color:black;">
            </div>
            <div class="form-group">
                <label for="email">Phone</label>
                <input type="number" name="phone" value="<?php echo $phone ?>" class="form-control" style=" font-weight:bold; color:black; padding: 25px 15px;">
            </div>
            <div class="form-group">
                <label for="pwd">Địa chỉ</label>
                <input type="text" name="address" value="<?php echo $address ?>" class="form-control " style=" font-weight:bold; color:black; padding: 25px 15px;">
            </div>
            <button type="submit" name="capnhat" class="btn btn-success">Cập nhật</button>
            <a href="index.php?quanly=diachi"><button class="btn btn-danger">Huỷ</button></a>

        <?php
        } else {
        ?>
            <div class="form-group">
                <label for="email">Họ và tên</label>
                <input type="text" name="name" value="<?php echo $name ?>" class="form-control" readonly style=" font-weight:bold; color:black; pointer-events: none;">
            </div>
            <div class="form-group">
                <label for="email">Phone</label>
                <input type="text" name="phone" value="<?php echo $phone ?>" class="form-control" readonly style=" font-weight:bold; color:black; pointer-events: none;">
            </div>
            <div class="form-group">
                <label for="pwd">Địa chỉ</label>
                <input type="text" name="address" value="<?php echo $address ?>" class="form-control" readonly style=" font-weight:bold; color:black; pointer-events: none;">
            </div>
            <?php

            $id_dangky = $_SESSION['id_khachhang'];

            // Kiểm tra xem thông tin vận chuyển đã tồn tại trong cơ sở dữ liệu cho người dùng hiện tại hay không
            $sql_check_existing = mysqli_query($mysqli, "SELECT * FROM tbl_shipping WHERE id_dangky='$id_dangky'");
            $count_existing = mysqli_num_rows($sql_check_existing);
            if ($count_existing > 0) { ?>
                <!-- <button type="submit" name="vanchuyen" class="btn btn-success">Cập nhật</button> -->
                <button type="submit" name="suadc" class="btn btn-primary">Sửa địa chỉ</button>
        <?php
            }
        }
        ?>
    </form>
</div>
<style>
    .diachi {
        width: 70%;
        margin: auto;
    }

    .diachi div.form-group {
        margin-bottom: 3%;
    }
</style>