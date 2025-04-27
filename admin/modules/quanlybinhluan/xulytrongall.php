<?php
include("../../config/conect.php");
// Lấy các giá trị từ form POST và GET

$id_sanpham = $_POST['id_sanpham'];
$id_danhgia = $_POST['id_danhgia'];

// Kiểm tra xem có dữ liệu được gửi từ form POST hay không
if (isset($_POST['repcoment'])) {
    // Kiểm tra xem các biến cần thiết đã được gửi hay không
    if (isset($_POST['reply']) && isset($_POST['id_danhgia']) && !empty($_POST['reply'])) {
        $noidung = $_POST['reply'];
        // Thực hiện truy vấn để thêm dữ liệu vào bảng tbl_repcoment
        $sql_rep = "INSERT INTO tbl_repcoment (noidung_rep, id_sanpham, id_danhgia, thoigian) VALUES ('$noidung', '$id_sanpham', '$id_danhgia', NOW())";
        mysqli_query($mysqli, $sql_rep);

        // Cập nhật trạng thái của đánh giá
        $sql_danhgia = "UPDATE tbl_danhgia SET trangthai = 2 WHERE id_danhgia = '$id_danhgia'";
        mysqli_query($mysqli, $sql_danhgia);

        echo "<script>
            alert('Bạn đã trả lời bình luận thành công.');
            window.location ='../../index.php?action=danhgia&query=chitietdanhgia&id=$id_sanpham';
        </script>";
    } else {
        echo "<script>
            alert('Bạn hãy nhập nội dung để phản hồi.');
            window.location ='../../index.php?action=danhgia&query=chitietdanhgia&id=$id_sanpham';
        </script>";
    }

}
else{
    $idrep=$_GET['idrep'];
    $idsp = $_GET['idsp'];
    $sql_xoa = "DELETE FROM tbl_repcoment WHERE id_rep ='".$idrep."'";
    mysqli_query($mysqli,$sql_xoa);
    echo "<script>

            window.location ='../../index.php?action=danhgia&query=chitietdanhgia&id=$idsp';
        </script>";
}