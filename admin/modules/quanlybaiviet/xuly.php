<?php
include("../../../admin/config/conect.php");

$tenbaiviet = $_POST['tenbaiviet'];
//xu ly hinh ảnh
$hinhanh = $_FILES['hinhanh']['name'];
$hinhanh_tmp = $_FILES['hinhanh']['tmp_name'];
$hinhanh = time() . 'hinhanh';

$noidung = $_POST['noidung'];
$tinhtrang = $_POST['tinhtrang'];

if (isset($_POST['thembaiviet'])) {
    //thêm
    $sql_them = "INSERT INTO tbl_baiviet(tenbaiviet,hinhanh,noidung,tinhtrang,thoigian) 
    VALUES ('" . $tenbaiviet . "','" . $hinhanh . "','" . $noidung . "','" . $tinhtrang . "', NOW())";
    mysqli_query($mysqli, $sql_them);
    move_uploaded_file($hinhanh_tmp, 'uploads/' . $hinhanh);
    // sau khi đã thêm thì quay về vị trí ban đầu
    // header('Location:../../index.php?action=quanlybaiviet&query=them');
    echo "<script>
            alert('Bạn đã thêm bài viết thành công.');
            window.location = '../../index.php?action=quanlybaiviet&query=them';
        </script>";
} elseif (isset($_POST['suabaiviet'])) {
    //sửa
    if (!empty($_FILES['hinhanh']['name'])) {
        //di chuyển hình ảnh vào folder
        move_uploaded_file($hinhanh_tmp, 'uploads/' . $hinhanh);

        $sql_sua = "UPDATE tbl_baiviet
        SET tenbaiviet='" . $tenbaiviet . "',hinhanh='" . $hinhanh . "',noidung='" . $noidung . "',tinhtrang='" . $tinhtrang . "', thoigian = NOW() WHERE id_baiviet='$_GET[idbaiviet]'";

        //xoá hình ảnh bị thay thế (sửa) khỏi folder
        $sql = "SELECT * FROM tbl_baiviet WHERE id_baiviet = '$_GET[idbaiviet]' LIMIT 1";
        $query = mysqli_query($mysqli, $sql);
        while ($row = mysqli_fetch_array($query)) {
            unlink('uploads/' . $row['hinhanh']);
        }
    } else {
        $sql_sua = "UPDATE tbl_baiviet 
        SET tenbaiviet='" . $tenbaiviet ."',noidung='" . $noidung . "',tinhtrang='" . $tinhtrang . "', thoigian = NOW() WHERE id_baiviet='$_GET[idbaiviet]'";
    }
    mysqli_query($mysqli, $sql_sua);
    // sau khi đã thêm thì quay về vị trí ban đầu
    echo "<script>
            alert('Bạn đã sửa bài viết thành công.');
            window.location = '../../index.php?action=quanlybaiviet&query=lietke';
        </script>";
    // header('Location:../../index.php?action=quanlybaiviet&query=them');
} else {
    $id = $_GET['idbaiviet'];
    $sql = "SELECT * FROM tbl_baiviet WHERE id_baiviet = '$id' LIMIT 1";
    $query = mysqli_query($mysqli, $sql);
    while ($row = mysqli_fetch_array($query)) {
        unlink('uploads/' . $row['hinhanh']);
    }
    $sql_xoa = "DELETE FROM tbl_baiviet WHERE id_baiviet ='" . $id . "'";
    mysqli_query($mysqli, $sql_xoa);
    echo "<script>

            window.location = '../../index.php?action=quanlybaiviet&query=lietke';
        </script>";
    // header('Location:../../index.php?action=quanlybaiviet&query=them');
}
