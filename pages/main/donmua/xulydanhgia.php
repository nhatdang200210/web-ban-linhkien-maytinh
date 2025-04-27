<?php
include("../../../admin/config/conect.php");
// Kiểm tra xem dữ liệu đã được gửi từ Ajax chưa
if (isset($_POST['ratingValue'])) {
    // Lấy dữ liệu được gửi từ Ajax
    $product_id = $_POST['product_id'];
    $danhgia = $_POST['ratingValue'];
    // Truy vấn để kiểm tra xem đã có dòng dữ liệu tương ứng trong bảng tbl_danhgiasao chưa

    $sql_sao = "SELECT * FROM tbl_danhgia,tbl_cartdetail WHERE tbl_danhgia.id_sanpham = tbl_cartdetail.id_sanpham 
        AND tbl_danhgia.madon = tbl_cartdetail.madon AND tbl_danhgia.id_sanpham  = '$product_id'";
    $mysqli_sao = mysqli_query($mysqli, $sql_sao);
    $result_sao = mysqli_fetch_array($mysqli_sao);

    $madon = $result_sao['madon'];
    $id_donhang = $result_sao['id_detail'];

    // Chạy truy vấn để thêm dữ liệu đánh giá sao vào cơ sở dữ liệu
    $sql_themdanhgia = "UPDATE tbl_danhgia SET sao = $danhgia WHERE madon = '$madon' AND id_sanpham = $product_id";
    $result = mysqli_query($mysqli, $sql_themdanhgia);

    // Kiểm tra xem truy vấn đã thực hiện thành công hay không
    if ($result) {
        // Trả về thông báo thành công cho Ajax
        echo 'done';
    } else {
        // Trả về thông báo lỗi cho Ajax nếu có lỗi xảy ra trong quá trình thêm dữ liệu
        echo 'error';
    }

    // Đóng kết nối đến cơ sở dữ liệu

} else {
    // Nếu không có dữ liệu gửi từ Ajax, trả về thông báo lỗi
    echo 'error';
}
