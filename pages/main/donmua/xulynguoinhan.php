<?php
session_start();
include('../../../admin/config/conect.php');
$huy = $_GET['huy'];
$id_nguoinhan = $_GET['nguoinhan'];
if (isset($_GET['madon']) && $huy == 0) {
    // echo 'mmmmm';
    $madon = $_GET['madon'];
    $id_nguoinhan = $_GET['nguoinhan'];
    $sql_sua = "UPDATE tbl_cart SET giao = 1, ngaygiaohang =  NOW() WHERE id_cart='" . $madon . "'";
    $query = mysqli_query($mysqli, $sql_sua);
    // echo $_GET['huy'];

    // Sau khi thêm sản phẩm vào tbl_donhang, cập nhật giá trị giao trong tbl_giohang
    $update_giao_donhang = "UPDATE tbl_cartdetail SET giao = 1  WHERE madon='" . $madon . "'";
    $query = mysqli_query($mysqli, $update_giao_donhang);

    //lấy dữ liệu ng nhận
    $sql_khach = "SELECT * FROM tbl_nguoinhan WHERE id_nguoinhan ='$id_nguoinhan' ";
    $query_khach = mysqli_query($mysqli, $sql_khach);
    $thongtin_khach = mysqli_fetch_array($query_khach);

    //lấy dữ liệu đơn hàng
    $sql_lietke_donhang = "SELECT * FROM tbl_cartdetail,tbl_sanpham WHERE tbl_cartdetail.id_sanpham=tbl_sanpham.id_sanpham AND tbl_cartdetail.madon='$madon' ORDER BY tbl_cartdetail.id_detail DESC";
    $query_lietke_donhang = mysqli_query($mysqli, $sql_lietke_donhang);
    while ($row = mysqli_fetch_array($query_lietke_donhang)) {

        //láy thông tin
        $id_sanpham = $row['id_sanpham'];
        $noidung = '0';
        $name = $thongtin_khach['tennguoinhan'];
        $id_dangky = $thongtin_khach['id_dangky'];
        $sao = '5';

        $sql_danhgia = mysqli_query($mysqli, "INSERT INTO tbl_danhgia (madon,id_sanpham, noidung_dg,name, id_dangky, sao, thoigian, trangthai) 
    VALUES ('$madon','$id_sanpham', '$noidung', '$name', '$id_dangky', '$sao', NOW(), '0')");
    }
    echo "<script>
                alert('Bạn đã nhận hàng thành công.');
                window.location = '../../../index.php?quanly=dagiao';

            </script>";
} elseif (isset($_GET['madon']) && $huy == 1) {
    $madon = $_GET['madon'];
    $sql_sua = "UPDATE tbl_cart SET cart_status = 2, thoigiandathang =  NOW() WHERE id_cart='" . $madon . "'";
    $query = mysqli_query($mysqli, $sql_sua);

    $update_giao_donhang = "UPDATE tbl_cartdetail SET giao = 2  WHERE madon='" . $madon . "'";
    $query = mysqli_query($mysqli, $update_giao_donhang);

    echo "<script>
                alert('Bạn đã huỷ đơn hàng thành công.');
                window.location = '../../../index.php?quanly=donmua';

                </script>";
}
