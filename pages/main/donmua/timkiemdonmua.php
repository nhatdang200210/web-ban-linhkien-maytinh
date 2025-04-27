</head>
<title>An Phát Computer - Search</title>
</head>
<?php
// Kiểm tra xem người dùng đã nhập từ khóa tìm kiếm chưa
if (isset($_POST['timkiem']) && !empty($_POST['madon'])) {
    // Lấy từ khóa tìm kiếm từ biến POST
    $madon = $_POST['madon'];

    // Thực hiện truy vấn SQL để lấy sản phẩm phù hợp với từ khóa tìm kiếm
    $sql_pro = "SELECT * FROM tbl_nguoinhan WHERE phonenguoinhan = '$madon' ";
    $query_pro = mysqli_query($mysqli, $sql_pro);
?>
    <a href="index.php"><i class="fa-solid fa-reply"></i> Trở lại</a>
    <div class="vtsdm">
        <form class="form-inline " action="" method="POST" style="width:100%">
            <div class="input-wrapper">
                <span class="prefix">+84</span>
                <input class="form-control mr-sm-2" required='true' type="number" placeholder="Nhập số điện thoại để tìm đơn hàng" name="madon" aria-label="Search" size="40">
            </div>
            <button class="btn my-2 my-sm-0" type="submit" name="timkiem" style="color: red;font-size:18px; border:red 1px solid"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>
    </div>
    <?php
    // Hiển thị từ khoá tìm kiếm
    echo "<h4 style='text-align:center; color:cadetblue; margin-top:1%'>Đơn hàng có số điện thoại: $madon</h4> <hr color='red' style='margin-bottom: 2%;'>";

    // Kiểm tra xem có sản phẩm phù hợp không
    if (mysqli_num_rows($query_pro) > 0) {
    ?>
        <div class="dondadat">
            <?php

            $sql_lietke_donhang = "SELECT * FROM tbl_cart,tbl_nguoinhan
                                    WHERE tbl_nguoinhan.id_nguoinhan=tbl_cart.id_nguoinhan AND tbl_nguoinhan.phonenguoinhan = '$madon'";
            $query_lietke_donhang = mysqli_query($mysqli, $sql_lietke_donhang);

            ?>

            <?php
            $tongtien = 0;
            $i = 0;
            while ($row = mysqli_fetch_array($query_lietke_donhang)) {
                $i++;
                $madonhang = $row['id_cart'];
                // lấy số lượng sản phẩm trong đơn hàng
                $sql_donhang = "SELECT SUM(soluongmua) AS soluong_sp, SUM(CASE WHEN tbl_cartdetail.dg_status = 1 THEN 1 ELSE 0 END) AS dadanhgia FROM tbl_cartdetail,tbl_sanpham 
                                WHERE tbl_cartdetail.id_sanpham=tbl_sanpham.id_sanpham 
                                AND tbl_cartdetail.madon = '$madonhang'";
                $query_donhang = mysqli_query($mysqli, $sql_donhang);
                $donhang = mysqli_fetch_array($query_donhang);
                $soluong_sp = $donhang['soluong_sp'];
                $not = $donhang['dadanhgia'];
                $chua_dg = $soluong_sp - $not;

            ?>
                <table class="table" style=" background-color:rgba(208, 234, 245, 0.367); border-radius: 10px">
                    <thead>
                        <tr>
                            <th scope="col" colspan="3" class="afk">
                                <div style="width:58%; padding-left: 10px;">
                                    <b>Mã đơn: </b> <?php echo $madonhang ?><br>
                                    <div style=" opacity:0.6; line-height: 1.5;">
                                        <?php echo $soluong_sp ?> sản phẩm
                                        <?php
                                        if ($row['giao'] == 1 && $chua_dg != 0) {
                                            echo ' <span style="margin-left:10px">(' . $chua_dg . ' chưa đánh giá)</span>';
                                        } elseif ($row['giao'] == 1 && $chua_dg == 0) {
                                            echo ' <span style="margin-left:10px">(Đã đánh giá)</span>';
                                        } else {
                                            echo '';
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="tg_don_block" style="text-align: right; padding:0.5% 0; opacity:0.6">
                                    <?php echo DATE($row['thoigiandathang']) ?> <br>
                                    đang xử lý
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
                                    <b style="margin-left: 10px;"><?php echo $row['cart_payment'] ?></b>
                                    <hr>
                                    <?php if ($row['cart_status'] == 0) {
                                        echo '<a >Đang chờ xử lý</a><br>';
                                        echo '<a href="pages/main/donmua/xulynguoinhan.php?madon=' . $row['id_cart'] . '&huy=1">
                                            <button style="background-color:#FA3B03; color:white; margin-top:3%; border-radius:8px; border:0; padding: 3px 10px">
                                            <b>Huỷ đơn</b>
                                            </button>
                                        </a>';
                                    } elseif ($row['cart_status'] == 1 && $row['giao'] == 0) {
                                        echo '<b style="color:green">Đang giao hàng</b><br>';
                                        echo '<a href="pages/main/donmua/xulynguoinhan.php?madon=' . $row['id_cart'] . '&huy=0&nguoinhan=' . $row['id_nguoinhan'] . '">
                                            <button style="background-color:red; color:white; margin-top:3%; border-radius:8px; border:0; padding: 3px 10px">
                                           <b> Đã nhận hàng</b>
                                            </button>
                                        </a>';
                                    } else {
                                        echo '<b style="color:green">Giao hàng thành công</b>';
                                    }
                                    ?>
                                    <hr>
                                    <a href="index.php?quanly=xemdonhang&madon=<?php echo $row['id_cart'] ?>  ">
                                        <button type="button" class="btn btn-light" style="background-color: #EBEBEB; width:100%">Xem đơn hàng</button>
                                    </a>
                                </div>

                            </td>
                            <td style="vertical-align: middle; width:22%" class="httt_don">
                                <b>Hình thức thanh toán: </b><br><?php echo $row['cart_payment'] ?>
                            </td>

                            <td style="vertical-align: middle; width:22%" class="httt_don">
                                <?php if ($row['cart_status'] == 0) {
                                    echo '<a >Đang chờ xử lý</a><br>';
                                    echo '<a href="pages/main/donmua/xulynguoinhan.php?madon=' . $row['id_cart'] . '&huy=1">
                                            <button style="background-color:#FA3B03; color:white; margin-top:3%; border-radius:8px; border:0; padding: 3px 10px">
                                            <b>Huỷ đơn</b>
                                            </button>
                                        </a>';
                                } elseif ($row['cart_status'] == 1 && $row['giao'] == 0) {
                                    echo '<b style="color:green">Đang giao hàng</b><br>';
                                    echo '<a href="pages/main/donmua/xulynguoinhan.php?madon=' . $row['id_cart'] . '&huy=0&nguoinhan=' . $row['id_nguoinhan'] . '">
                                            <button style="background-color:red; color:white; margin-top:3%; border-radius:8px; border:0; padding: 3px 10px">
                                           <b> Đã nhận hàng</b>
                                            </button>
                                        </a>';
                                } else {
                                    echo '<b style="color:green">Giao hàng thành công</b>';
                                }
                                ?>
                            </td>
                            <td style="width:14%; text-align: center;vertical-align: middle;" class="xemdon">
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
    <?php

    } else {
        // Hiển thị thông báo nếu không tìm thấy sản phẩm nào phù hợp
        echo "<p style='color:red'>Không tìm thấy đơn hàng có số điện thoại  0$madon.</p>";
    }
} else {
    ?>
    <a href="index.php"><i class="fa-solid fa-reply"></i> Trở lại</a>
    <div class="vtsdm1">
        <form class="form-inline " action="" method="POST" style="width:100%; display:flex; flex-wrap:nowrap">
            <div class="input-wrapper">
                <span class="prefix">+84</span>
                <input class="form-control mr-sm-2" required='true' type="text" placeholder="Nhập số điện thoại để tìm đơn hàng" name="madon" aria-label="Search" size="40">
            </div>
            <button class="btn my-2 my-sm-0" type="submit" name="timkiem" style="color: red;font-size:18px; border:red 1px solid; width:15%"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>
    </div>
<?php
}
?>
<style>
    .input-wrapper {
        position: relative;
        display: inline-block;
    }

    .prefix {
        position: absolute;
        top: 50%;
        left: 10px;
        transform: translateY(-50%);
        color: #000;
        pointer-events: none;
        /* Không ảnh hưởng khi nhấn vào */
    }

    .input-wrapper input {
        padding-left: 60px;
        /* Đảm bảo đủ không gian cho tiền tố */
    }
</style>