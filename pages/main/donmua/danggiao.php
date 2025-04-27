<?php
$current_page = isset($_GET['quanly']) ? $_GET['quanly'] : 'donmua';
?>
<head>
    <title>Đang giao</title>
</head>
<div class="cart">
    <!-- <h2 style="color:cadetblue; text-align:center;margin-top:2%;">Tất cả đơn hàng</h2> -->
    <div class="menu-donmua">
        <nav class="navbar navbar-light bg-light">
            <form class="container-fluid justify-content-start" style="flex-wrap: nowrap; text-align:center">
                <a href="index.php?quanly=donmua" style="width:20%"><button class="btn btn-outline-success me-2 " type="button">Tất cả đơn</button></a>
                <a href="index.php?quanly=dangxuly" style="width:20%" class="none"><button class="btn btn-outline-success me-2" type="button"><i class="fa-solid fa-clock"></i> Chờ xử lý</button></a>
                <a href="index.php?quanly=dangxuly" style="width:20%" class="unnone"><button class="btn btn-outline-success me-2" type="button"><i class="fa-solid fa-clock"></i> Đang chờ</button></a>
                <a href="index.php?quanly=danggiao" style="width:20%"><button class="btn btn-outline-success me-2 <?php echo ($current_page == 'danggiao') ? 'active' : ''; ?>" type="button"><i class="fa-solid fa-truck-fast"></i> Đang giao</button></a>
                <a href="index.php?quanly=dagiao" style="width:20%"><button class="btn btn-outline-success me-2" type="button"><i class="fa-solid fa-square-check"></i> Hoàn thành</button></a>
                <a href="index.php?quanly=huy" style="width:20%"><button class="btn btn-outline-success me-2" type="button"><i class="fa-solid fa-file-circle-xmark"></i> Đã huỷ</button></a>
            </form>
        </nav>
    </div>
    <hr style="margin: 15px auto; width: 78%">
    <div class="dondadat">
        <?php
        if (isset($_SESSION['dangky'])) {
            $id_khachhang = $_SESSION['id_khachhang'];
            $sql_lietke_donhang = "SELECT * FROM tbl_cart,tbl_nguoinhan
                                    WHERE tbl_cart.id_dangky=$id_khachhang 
                                    AND tbl_nguoinhan.id_nguoinhan=tbl_cart.id_nguoinhan AND tbl_cart.cart_status = 1 AND tbl_cart.giao = 0
                                    ORDER BY tbl_cart.id_cart DESC";
            $query_lietke_donhang = mysqli_query($mysqli, $sql_lietke_donhang);
        } else {
            $id_khachhang = $_GET['id'];
            $sql_lietke_donhang = "SELECT * FROM tbl_cart,tbl_nguoinhan
                                WHERE tbl_cart.id_dangky = '$id_khachhang'
                                AND tbl_nguoinhan.id_nguoinhan=tbl_cart.id_nguoinhan AND tbl_cart.cart_status = 1 AND tbl_cart.giao = 0
                                ORDER BY tbl_cart.id_cart DESC";
            $query_lietke_donhang = mysqli_query($mysqli, $sql_lietke_donhang);
        }
        ?>

        <?php
        $tongtien = 0;
        $i = 0;
        while ($row = mysqli_fetch_array($query_lietke_donhang)) {
            $i++;
            $madonhang = $row['id_cart'];
            // lấy số lượng sản phẩm trong đơn hàng
            $sql_donhang = "SELECT SUM(soluongmua) AS soluong_sp FROM tbl_cartdetail,tbl_sanpham 
                                WHERE tbl_cartdetail.id_sanpham=tbl_sanpham.id_sanpham 
                                AND tbl_cartdetail.madon = '$madonhang'";
            $query_donhang = mysqli_query($mysqli, $sql_donhang);
            $donhang = mysqli_fetch_array($query_donhang);
            $soluong_sp = $donhang['soluong_sp'];

        ?>
            <table class="table" style=" background-color:rgba(208, 234, 245, 0.367); border-radius: 10px">
                <thead>
                    <tr>
                        <th scope="col" colspan="3" class="afk">
                            <div style="width:58%; padding-left: 10px;">
                                <b>Mã đơn: </b> <?php echo $madonhang ?><br>
                                <div style=" opacity:0.6; line-height: 1.5;"><?php echo $soluong_sp ?> sản phẩm</div>
                            </div>
                            <div class="tg_don_block" style="text-align: right; padding:0.5% 0; opacity:0.6">
                                <?php echo DATE($row['thoigiandathang']) ?> <br>
                                đnag xử lý
                            </div>
                        </th>
                        <th scope="col" colspan="2" class="tg_don" style="padding-right: 15px; padding:0.5% 1%; opacity:0.6">
                            <?php echo DATE($row['thoigiandathang']) ?><br>
                            <?php if ($row['cart_status'] == 0) {
                                echo '<a >Đơn hàng đang được xử lý</a>';
                            } elseif ($row['cart_status'] == 1 && $row['giao'] == 0) {
                                echo '<a >Đơn hàng đang được giao</a>';
                            } else {
                                echo '<a>Hoàn thành</a>';
                            }
                            ?>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="font-size:17px">
                        <th scope="row" class="stt_don" style="padding-top: 6%; border-right:1px solid #C4C3C3"><i class="fa-solid fa-cube"></i></th>
                        <td style="vertical-align: middle;">
                            <ul style="text-align:left; margin-top:3%;padding-right: 1%;font-weight: 500; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; ">
                                <li><b>Tên người nhận:</b> <?php echo $row['tennguoinhan'] ?></li>
                                <li><b>Số điện thoại:</b> <?php echo "0" . $row['phonenguoinhan'] ?></li>
                                <li><b>Địa chỉ: </b><?php echo $row['diachinguoinhan'] ?></li>
                                <li><b>Ghi chú: </b><?php echo $row['note'] ?></li>
                            </ul>
                            <div class="tg_don_block" style="text-align: center;">
                                <hr>
                                <b style="margin-left: 10px;"><?php echo $row['cart_payment'] ?> </b>
                                <hr>
                                <?php 
                                    echo '<b style="color:green">Đang giao hàng</b><br>';
                                    echo '<a href="pages/main/donmua/xulynguoinhan.php?madon=' . $row['id_cart'] . '&huy=0&nguoinhan=' . $row['id_nguoinhan'] . '">
                                            <button style="background-color:red; color:white; margin-top:3%; border-radius:8px; border:0; padding: 3px 10px">
                                           <b> Đã nhận hàng</b>
                                            </button>
                                        </a>';
                                
                                ?>
                                <hr>
                                <a href="index.php?quanly=xemdonhang&madon=<?php echo $row['id_cart'] ?> ">
                                    <button type="button" class="btn btn-light" style="background-color: #dcdcdc; width:100%">Xem đơn hàng</button>
                                </a>
                            </div>

                        </td>
                        <td style="vertical-align: middle; width:22%" class="httt_don">
                            <b>Hình thức thanh toán: </b><br><?php echo $row['cart_payment'] ?>
                        </td>

                        <td style="vertical-align: middle; width:22%" class="httt_don">
                            <?php

                            echo '<b style="color:green">Đang giao hàng</b><br>';
                            echo '<a href="pages/main/donmua/xulynguoinhan.php?madon=' . $row['id_cart'] . '&huy=0&nguoinhan=' . $row['id_nguoinhan'] . '">
                                            <button style="background-color:red; color:white; margin-top:3%; border-radius:8px; border:0; padding: 3px 10px">
                                           <b> Đã nhận hàng</b>
                                            </button>
                                        </a>';

                            ?>
                        </td>
                        <td style="width:14%; text-align: center;vertical-align: middle;" class="xemdon">
                            <a href="index.php?quanly=xemdonhang&madon=<?php echo $row['id_cart'] ?> ">
                                <button type="button" class="btn btn-light" style="background-color: #dcdcdc;">Xem đơn hàng</button>
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        <?php
        }
        ?>
    </div>
</div>
<style>
    
    .btn.active {
        background-color: #28a745;
        /* Màu nền khi nút ở trạng thái active */
        color: white;
        /* Màu chữ khi nút ở trạng thái active */
        border-color: #014B23;
        /* Màu viền khi nút ở trạng thái active */
    }
</style>