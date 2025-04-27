<p>thêm sản phẩm vào giỏ hàng</p>
<?php
// session_destroy();
session_start();
include('../../../admin/config/conect.php');

//tăng số lượng
// Tăng số lượng sản phẩm
if (isset($_GET['cong'])) {
    $id = $_GET['cong'];
    $sql_soluong_sp = "SELECT soluong FROM tbl_sanpham WHERE id_sanpham = '$id'";
    $query_soluong_sp = mysqli_query($mysqli, $sql_soluong_sp);
    $row_soluong_sp = mysqli_fetch_array($query_soluong_sp);

    if ($row_soluong_sp) {
        $soluong_sp = $row_soluong_sp['soluong'];
        foreach ($_SESSION['linhkien'] as &$sp_item) {
            if ($sp_item['id'] == $id && $sp_item['soluong'] < $soluong_sp) {
                $sp_item['soluong']++;
                break;
            }
        }
    }
    header('Location:../../../index.php?quanly=giohang');
    exit();
}

//giảm số lượng
if (isset($_GET['tru'])) {
    $id = $_GET['tru'];
    foreach ($_SESSION['linhkien'] as &$sp_item) {
        if ($sp_item['id'] == $id) {
            if ($sp_item['soluong'] > 1) {
                $sp_item['soluong']--; // Giảm số lượng sản phẩm xuống 1, nếu số lượng lớn hơn 1
            }
            break; // Thoát khỏi vòng lặp sau khi giảm số lượng
        }
    }
    header('Location:../../../index.php?quanly=giohang');
    exit();
}


// Xóa sản phẩm
if (isset($_SESSION['linhkien']) && isset($_GET['xoa'])) {
    $id = $_GET['xoa'];
    $idkhach = $_GET['idkhach'];
    $_SESSION['linhkien'] = array_filter($_SESSION['linhkien'], function($sp_item) use ($id) {
        return $sp_item['id'] != $id;
    });
    header('Location:../../../index.php?quanly=giohang');
    exit();
}

//xoá tất cả sp
if (isset($_GET['xoatatca']) && $_GET['xoatatca'] == 1) {
    unset($_SESSION['sp']);
    header('Location:../../../index.php?quanly=giohang');
}
// thêm
if (isset($_POST['themgiohang'])) {
    $id = $_GET['idsanpham'];
    $idkhach = $_GET['idkhach'];
    $sql = "SELECT * FROM tbl_sanpham WHERE id_sanpham = '$id' LIMIT 1";
    $query = mysqli_query($mysqli, $sql);
    $row = mysqli_fetch_array($query);

    if ($row) {
        $new_linhkien = array(
            array(
                'tensanpham' => $row['tensanpham'], 'id' => $id, 'soluong' => 1,
                'giasanpham' => $row['giasanpham'], 'hinhanh' => $row['avatar'], 'idkhach' => $idkhach
            )
        );

        if (isset($_SESSION['linhkien'])) {
            $found = false;
            foreach ($_SESSION['linhkien'] as &$sp_item) {
                if ($sp_item['id'] == $id) {
                    $sp_item['soluong']++;
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $_SESSION['linhkien'] = array_merge($_SESSION['linhkien'], $new_linhkien);
            }
        } else {
            $_SESSION['linhkien'] = $new_linhkien;
        }
    }
    header('Location:../../../index.php?quanly=giohang');
    exit();
}
?>