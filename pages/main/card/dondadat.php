<div class="cart">
    <div class="menu-cart">
        <div class="arrow-steps clearfix">
            <div class="step done"> <span> <a href="index.php?quanly=giohang">Giỏ hàng</a></span> </div>
            <div class="step done"> <span><a href="index.php?quanly=vanchuyen">Vận chuyển</a></span> </div>
            <div class="step done"> <b><a href="index.php?quanly=thongtinthanhtoan">Thanh toán</a><span> </div>
            <div class="step current"> <span><a href="index.php?quanly=dondadat">Đã đặt</a><span> </div>
        </div>
    </div>
    <h2 style="color:cadetblue; text-align:center;margin-top:2%;">Đơn hàng đã đặt</h2>
    <hr style="margin-right: 10px;">
    <div class="dondadat">
        <?php
        if (isset($_SESSION['dangky'])) {
            $id_khachhang = $_SESSION['id_khachhang'];
            $sql_lietke_donhang = "SELECT * FROM tbl_cart,tbl_nguoinhan
                                    WHERE tbl_cart.id_dangky=$id_khachhang 
                                    AND tbl_nguoinhan.id_nguoinhan=tbl_cart.id_nguoinhan AND tbl_cart.cart_status = 0 
                                    ORDER BY tbl_cart.id_cart DESC";
            $query_lietke_donhang = mysqli_query($mysqli, $sql_lietke_donhang);
        } else {
            $id_khachhang = $_GET['id'];
            $sql_lietke_donhang = "SELECT * FROM tbl_cart,tbl_nguoinhan
                                    WHERE tbl_cart.id_dangky = '$id_khachhang'
                                    AND tbl_nguoinhan.id_nguoinhan=tbl_cart.id_nguoinhan AND tbl_cart.cart_status = 0 
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
                        <th scope="col" colspan="2" class="afk">
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
                            }
                            ?>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="font-size:17px">
                        <th scope="row" class="stt_don" style="padding-top: 6%; border-right:1px solid #C4C3C3">1</th>
                        <td style="">
                            <ul style="text-align:left; margin-top:3%;padding-right: 1%;font-weight: 500; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; ">
                                <li><b>Tên người nhận:</b> <?php echo $row['tennguoinhan'] ?></li>
                                <li><b>Số điện thoại:</b> <?php echo "0" . $row['phonenguoinhan'] ?></li>
                                <li><b>Địa chỉ: </b><?php echo $row['diachinguoinhan'] ?></li>
                                <li><b>Ghi chú: </b><?php echo $row['note'] ?></li>
                            </ul>
                            <div class="tg_don_block">
                                <hr>
                                <b style="margin-left: 10px;">Thanh toán khi nhận hàng </b>
                                <hr>
                                <a href="index.php?quanly=xemdonhang&madon=<?php echo $row['id_cart'] ?> ">
                                    <button type="button" class="btn btn-light" style="background-color: #EBEBEB; width:100%">Xem đơn hàng</button>
                                </a>
                            </div>

                        </td>
                        <td style="padding-top:3%;" class="httt_don">
                            <b>Hình thức thanh toán: </b><br>Thanh toán khi nhận hàng
                        </td>
                        <td style="width:14%; text-align: center;padding-top:3%;" class="xemdon">
                            <a href="index.php?quanly=xemdonhang&madon=<?php echo $row['id_cart'] ?> ">
                                <button type="button" class="btn btn-light" style="background-color: #EBEBEB;">Xem đơn hàng</button>
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