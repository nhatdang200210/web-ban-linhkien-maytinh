<?php
include "../../config/conect.php";
$tensanpham = $_POST['tensanpham'];
$giasanpham = $_POST['giasanpham'];
$soluong = $_POST['soluong'];
//xu ly hinh ảnh
// $hinhanh = $_FILES['hinhanh']['name'];
// $hinhanh_tmp = $_FILES['hinhanh']['tmp_name'];
// $hinhanh = time() . 'hinhanh';
$hinhanh_arr = [];
foreach ($_FILES['hinhanh']['name'] as $key => $name) {
    $filename = time() . '_' . $name;
    move_uploaded_file($_FILES['hinhanh']['tmp_name'][$key], 'uploads/' . $filename);
    $hinhanh_arr[] = $filename;
}
$hinhanh = implode(',', $hinhanh_arr); // Ghép các tên file thành một chuỗi, ngăn cách bởi dấu phẩy

//xử lý avt
$avt = $_FILES['avt']['name'];
$avt_tmp = $_FILES['avt']['tmp_name'];
// tạo tên hình avt theo thời gian
$avt = time() . 'avt';

$tomtat = $_POST['tomtat'];
$noidung = $_POST['noidung'];
$tinhtrang = $_POST['tinhtrang'];
$danhmuc = $_POST['danhmuc'];

if (isset($_POST['themsanpham'])) {
    //thêm
    $sql_them = "INSERT INTO tbl_sanpham(tensanpham,giasanpham,soluong,hinhanh,avatar,tomtat,noidung,tinhtrang,id_danhmuc) 
    VALUES ('" . $tensanpham . "','" . $giasanpham . "','" . $soluong . "','" . $hinhanh . "','" . $avt . "','" . $tomtat . "','" . $noidung . "','" . $tinhtrang . "','" . $danhmuc . "')";
    mysqli_query($mysqli, $sql_them);
    move_uploaded_file($avt_tmp, 'uploads/' . $avt);
    // sau khi đã thêm thì quay về vị trí ban đầu
    // header('Location:../../index.php?action=quanlysanpham&query=them');

    echo "<script>
            alert('Bạn đã thêm sản phẩm \"$tensanpham\" thành công.');
            window.location = '../../index.php?action=quanlysanpham&query=them';
        </script>";
} elseif (isset($_POST['suasanpham'])) {
    //sửa
    $id_sanpham = $_GET['idsanpham'];

    // Xử lý hình ảnh đại diện
    if (!empty($_FILES['image_avt']['name'])) {
        $avt = time() . '_' . $_FILES['image_avt']['name'];
        $avt_tmp = $_FILES['image_avt']['tmp_name'];
        move_uploaded_file($avt_tmp, 'uploads/' . $avt);
    } else {
        // Nếu không có hình ảnh đại diện mới, giữ lại giá trị cũ
        $sql = "SELECT avatar FROM tbl_sanpham WHERE id_sanpham = '$id_sanpham' LIMIT 1";
        $query = mysqli_query($mysqli, $sql);
        $row = mysqli_fetch_array($query);
        $avt = $row['avatar'];
    }

    // Xử lý hình ảnh chính
    if (!empty($_FILES['hinhanh']['name'][0])) {
        // Xóa các hình ảnh cũ khỏi folder
        $sql = "SELECT hinhanh FROM tbl_sanpham WHERE id_sanpham = '$id_sanpham' LIMIT 1";
        $query = mysqli_query($mysqli, $sql);
        $row = mysqli_fetch_array($query);
        $old_images = explode(',', $row['hinhanh']);
        foreach ($old_images as $img) {
            if (file_exists('uploads/' . $img)) {
                unlink('uploads/' . $img);
            }
        }

        // Xử lý và lưu các hình ảnh mới
        $hinhanh_arr = [];
        foreach ($_FILES['hinhanh']['name'] as $key => $name) {
            $filename = time() . '_' . $name;
            move_uploaded_file($_FILES['hinhanh']['tmp_name'][$key], 'uploads/' . $filename);
            $hinhanh_arr[] = $filename;
        }
        $hinhanh = implode(',', $hinhanh_arr);
    } else {
        // Nếu không có hình ảnh chính mới, giữ lại giá trị cũ
        $sql = "SELECT hinhanh FROM tbl_sanpham WHERE id_sanpham = '$id_sanpham' LIMIT 1";
        $query = mysqli_query($mysqli, $sql);
        $row = mysqli_fetch_array($query);
        $hinhanh = $row['hinhanh'];
    }

    // Cập nhật sản phẩm
    $sql_sua = "UPDATE tbl_sanpham 
    SET tensanpham='" . $tensanpham . "', giasanpham='" . $giasanpham . "', soluong='" . $soluong . "', hinhanh='" . $hinhanh . "', avatar='" . $avt . "', tomtat='" . $tomtat . "', noidung='" . $noidung . "', tinhtrang='" . $tinhtrang . "', id_danhmuc='" . $danhmuc . "' 
    WHERE id_sanpham='" . $id_sanpham . "'";
    mysqli_query($mysqli, $sql_sua);

    // Lấy ID của danh mục từ sản phẩm đã sửa
    $sql_lay_danhmuc = "SELECT id_danhmuc FROM tbl_sanpham WHERE id_sanpham = '$id_sanpham' LIMIT 1";
    $query_lay_danhmuc = mysqli_query($mysqli, $sql_lay_danhmuc);
    $row_lay_danhmuc = mysqli_fetch_array($query_lay_danhmuc);
    $id_danhmuc_sua = $row_lay_danhmuc['id_danhmuc'];

    // Quay về vị trí ban đầu
    echo "<script>
        alert('Bạn đã sửa sản phẩm thành công.');
        window.location = '../../index.php?action=quanlysanpham&query=lietke&id=$id_danhmuc_sua';
    </script>";
} else {
    $id = $_GET['idsanpham'];
    $sql = "SELECT * FROM tbl_sanpham WHERE id_sanpham = '$id' LIMIT 1";
    $query = mysqli_query($mysqli, $sql);
    while ($row = mysqli_fetch_array($query)) {
        unlink('uploads/' . $row['hinhanh']);
    }
    $sql_xoa = "DELETE FROM tbl_sanpham WHERE id_sanpham ='" . $id . "'";
    mysqli_query($mysqli, $sql_xoa);
    // header('Location:../../index.php?action=quanlysanpham&query=them');
    echo "<script>
            
            window.location = '../../index.php?action=quanlysanpham&query=lietkeall';
        </script>";
}
