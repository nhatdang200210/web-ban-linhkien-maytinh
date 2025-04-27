<?php
include('../../config/conect.php');
if (isset($_GET['madon'])) {
    // $status = $_GET['cart_status'];
    $madon = $_GET['madon'];
    $sql_sua = "UPDATE tbl_cart SET cart_status = 1 WHERE id_cart='" . $madon . "'";
    $query = mysqli_query($mysqli, $sql_sua);
    // header('Location:../../index.php?action=quanlydonhang&query=lietkedonhang');
    echo "<script>
        alert('Duyệt thành công. Tiến hành giao hàng.');
        window.location = '../../index.php?action=quanlydonhang&query=donmoi';
    </script>";
}
