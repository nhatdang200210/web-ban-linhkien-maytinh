<?php
// $sql_lietke_donhang = "SELECT * FROM tbl_giohang,tbl_dangky WHERE tbl_giohang.id_khachhang=tbl_dangky.id_dangky ORDER BY id_cart DESC"; 
$sql_lietke_donhang = "SELECT *, DATE_FORMAT(tbl_cart.thoigiandathang, '%d-%m-%Y') AS ngay 
    FROM tbl_cart
    LEFT OUTER JOIN tbl_dangky ON tbl_cart.id_dangky = tbl_dangky.id_dangky 
    LEFT JOIN tbl_nguoinhan ON tbl_nguoinhan.id_nguoinhan = tbl_cart.id_nguoinhan
    WHERE tbl_cart.cart_status = 0
    ORDER BY tbl_cart.id_cart DESC";
$query_lietke_donhang = mysqli_query($mysqli, $sql_lietke_donhang);

$current_page = isset($_GET['query']) ? $_GET['query'] : 'donmoi';


// $sql_lietke_donhang = "SELECT * FROM tbl_giohang,tbl_dangky WHERE tbl_giohang.id_khachhang=tbl_dangky.id_dangky ORDER BY id_cart DESC"; 
$sql_lietke = "SELECT *, COUNT(CASE WHEN tbl_cart.cart_status = 0 THEN 1 END) AS sodonmoi, COUNT(CASE WHEN tbl_cart.cart_status = 1 AND tbl_cart.giao = 0 THEN 1 END) AS danggiao
    FROM tbl_cart ";

$query_lietke = mysqli_query($mysqli, $sql_lietke);
$rows = mysqli_fetch_array($query_lietke);
$donmoi = $rows['sodonmoi'];
$danggiao = $rows['danggiao'];

?>
<div class="donmoi">
    <div class="menu_dh">
        <nav class="navbar navbar-light bg-light" style="margin-bottom:0; padding-left:0">
            <form class="container-fluid justify-content-start" style="flex-wrap: nowrap; text-align:center">
                <a href="index.php?action=quanlydonhang&query=donmoi" class="task1"><button class="btn btn-outline-success me-2 <?php echo ($current_page == 'donmoi') ? 'active' : 'donmoi'; ?>" type="button">Đơn mới (<?php echo $donmoi ?>)</button></a>
                <a href="index.php?action=quanlydonhang&query=danggiao" class="task2"><button class="btn btn-outline-success me-2" type="button">Đang giao (<?php echo $danggiao ?>)</button></a>
                <a href="index.php?action=quanlydonhang&query=dagiao" class="task3"><button class="btn btn-outline-success me-2" type="button">Đã giao</button></a>
            </form>
        </nav>
    </div>
    <div class="table-responsive">
        <table class="table table-hover table-bordered" style="text-align: center; font-size:18px; border:1px solid">
            <thead class="thead-dark" style="text-align: center;">
                <tr>
                    <th scope="col" style="width:15px">STT</th>
                    <th scope="col" style="width:6%">Mã đơn</th>
                    <th scope="col" style="width:20%">Thông tin tài khoản</th>
                    <th scope="col" style="width:30%">Thông tin giao hàng</th>
                    <th scope="col" style="width:10%">Ngày đặt</th>
                    <th scope="col" style="width:20%">Tình trạng</th>
                    <th scope="col">Quản lý</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                while ($row = mysqli_fetch_array($query_lietke_donhang)) {
                    $i++;
                ?>
                    <tr>
                        <th scope="row" style="vertical-align: middle;"><?php echo $i ?></th>

                        <td style="vertical-align: middle;"><?php echo $row['id_cart'] ?></td>

                        <td style="vertical-align: middle;">
                            <?php
                            if (!empty($row['tenkhach'])) :
                            ?>
                                <ul style="text-align:left; margin-top:3%; list-style:none; padding-left:2%">
                                    <li><b>Tên: </b><?php echo $row['tenkhach'] ?></li>
                                    <li><b>Email: </b><?php echo $row['email'] ?></li>
                                    <li><b>Số điện thoại: </b><?php echo $row['dienthoai'] ?></li>
                                </ul>
                            <?php
                            else : echo "Tài khoản chưa đăng ký";
                            endif;
                            ?>
                        </td>

                        <td style="vertical-align: middle;">
                            <ul style="text-align:left; margin-top:3%; list-style:none; padding-left:2%">
                                <li><b>Tên: </b><?php echo $row['tennguoinhan'] ?></li>
                                <li><b>Số điện thoại: </b>0<?php echo $row['phonenguoinhan'] ?></li>
                                <li><b>Địa chỉ:</b><?php echo $row['diachinguoinhan'] ?></li>
                                <li><b>Ghi chú: </b><?php echo $row['note'] ?></li>
                            </ul>
                        </td>

                        <td style="vertical-align: middle;"><?php echo $row['ngay'] ?></td>

                        <td style="vertical-align: middle;">
                            <?php
                            echo '<a href="modules/quanlydonhang/xulydonhang.php?madon=' . $row['id_cart'] . '">Duyệt đơn hàng</a>';
                            ?>
                        </td>

                        <td style="text-align: center; padding:4px; vertical-align: middle;">
                            <button class="xemdon_moi">
                                <a href="index.php?action=quanlydonhang&query=xemdonhang&madon=<?php echo $row['id_cart'] ?> ">Xem đơn hàng</a>
                            </button>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<style>
    .donmoi {
        margin-left: 1.2%;
    }

    .xemdon_moi {
        padding: 4px 7px;
        border-radius: 5px;
        border: 1px rgb(183, 183, 184) solid;
        transition: all 0.3s ease;
    }

    .xemdon_moi:hover {
        background-color: #CDFFC4;
        transform: scale(1.1);
    }
</style>