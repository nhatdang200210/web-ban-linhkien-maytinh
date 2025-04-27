<?php
include("../../config/conect.php");

$tenloai = $_POST['tendanhmuc'];
$thutu = $_POST['thutu'];

if (isset ($_POST['themdanhmuc'])){
    //thêm
    $sql_them = "INSERT INTO tbl_danhmuc (tendanhmuc,thutu) VALUES ('".$tenloai."','".$thutu."')";
    mysqli_query($mysqli,$sql_them);
    // sau khi đã thêm thì quay về vị trí ban đầu
    // header('Location:../../index.php?action=quanlydanhmuc&query=them');
    echo "<script>
            alert('Bạn đã thêm danh mục \"$tenloai\" thành công.');
            window.location = '../../index.php?action=quanlydanhmuc&query=them';
        </script>"; 
}
elseif(isset($_POST['suadanhmuc'])){
    //sửa
    $sql_sua = "UPDATE tbl_danhmuc SET tendanhmuc='".$tenloai."',thutu='".$thutu."' WHERE id_danhmucsp='$_GET[iddanhmucsp]'";
    mysqli_query($mysqli,$sql_sua);
    // sau khi đã thêm thì quay về vị trí ban đầu
    echo "<script>
        alert('Bạn đã sửa danh mục thành công.');
        window.location = '../../index.php?action=quanlydanhmuc&query=lietke';
    </script>"; 
    // header('Location:../../index.php?action=quanlydanhmucsanpham&query=them');
}
else{
    // $id = $_GET['iddanhmucsp'];
    $sql_xoa = "DELETE FROM tbl_danhmuc WHERE id_danhmucsp = '$_GET[iddanhmucsp]'";
    mysqli_query($mysqli,$sql_xoa);
    echo "<script>
            alert('Bạn đã xoá danh mục \"$tenloai\" thành công.');
            window.location = '../../index.php?action=quanlydanhmuc&query=lietke';
        </script>"; 
    // header('Location:../../index.php?action=quanlydanhmucsanpham&query=them');
}
?>