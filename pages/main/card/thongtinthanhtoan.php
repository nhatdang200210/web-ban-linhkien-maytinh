<div class="cart">
    <div class="menu-cart">
        <div class="arrow-steps clearfix">
            <div class="step done"> <span> <a href="index.php?quanly=giohang">Giỏ hàng</a></span> </div>
            <div class="step done"> <span><a href="index.php?quanly=vanchuyen">Vận chuyển</a></span> </div>
            <div class="step current"> <b><a href="index.php?quanly=thongtinthanhtoan">Thanh toán</a><span> </div>
            <div class="step"> <span><a href="index.php?quanly=dondadat">Đã đặt</a><span> </div>
        </div>
    </div>
    <h2 style="color:cadetblue; text-align:center;margin-top:2%;">Thông tin thanh toán</h2>
    <hr style="margin-right: 10px;">
    <div class="thongtinthanhtoan">

        <!-- <div class="address"> -->
        <form action="pages/main/card/xulythanhtoan.php" method="POST">
            <div class="thongtinthanhtoan-address">
                <?php
                if (isset($_SESSION['dangky'])) {
                    $id_dangky = $_SESSION['id_khachhang'];
                } else {
                    $id_dangky = $_GET['id'];
                }
                $sql_get_vanchuyen = mysqli_query($mysqli, "SELECT * FROM tbl_shippingkhac WHERE id_dangky='$id_dangky' LIMIT 1");
                $count = mysqli_num_rows($sql_get_vanchuyen);

                $vanchuyen = mysqli_query($mysqli, "SELECT * FROM tbl_shippingkhac WHERE id_dangky='$id_dangky' LIMIT 1");
                // $result_vc = mysqli_num_rows($vanchuyen);
                // $row = mysqli_fetch_array($vanchuyen);
                // $dc = $row['address'];
                if ($count > 0) {
                    $row_get_vanchuyen = mysqli_fetch_array($sql_get_vanchuyen);
                    $dc = $row_get_vanchuyen['address'];
                    $name = $row_get_vanchuyen['name'];
                    $phone = '0' . $row_get_vanchuyen['phone'];
                    $address = $row_get_vanchuyen['address'];
                    $note = $row_get_vanchuyen['note'];
                    $id_khach = $row_get_vanchuyen['id_dangky'];
                } else {
                    $name = '';
                    $phone = '';
                    $address = '';
                    $note = '';
                }
                ?>
                <div class="adr">
                    <!-- <h2 style="color:cadetblue; text-align:left;">Thông tin thanh toán</h2><hr style="margin-right: 10px;"> -->
                    <ul style="width:98%">
                        <li>Họ và tên người nhận:</li>
                        <div class="form-group">
                            <input name="name1" class="form-control" value="<?php echo $name ?>" readonly style=" font-weight:bold; color:black; pointer-events: none; padding:20px">
                            <input name="iddangky" value="<?php echo $id_khach ?>" type="hidden">
                        </div>
                        <li>Số điện thoại người nhận:</li>
                        <div class="form-group">
                            <input name="phone1" class="form-control" value="<?php echo $phone ?>" readonly style=" font-weight:bold; color:black; pointer-events: none; padding:20px">
                        </div>
                        <li>Địa chỉ người nhận:</li>
                        <div class="form-group">
                            <textarea name="address1" class="form-control" readonly rows="2" style="font-weight:bold;color:black;resize: none; pointer-events: none;padding:10px 20px"><?php echo $address; ?></textarea>
                        </div>
                        <li>Ghi chú:</li>
                        <div class="form-group">
                            <textarea name="note1" class="form-control" readonly rows="2" style="resize: none; pointer-events: none;padding:10px 20px"><?php echo $note; ?></textarea>
                        </div>

                    </ul>

                </div>
            </div>
            <!-- Giỏ hàng -->
            <?php
            if (isset($_SESSION['linhkien']) && !empty($_SESSION['linhkien'])) {
                $tongsp = 0;
                // Đếm số lượng phần tử trong mảng
                $phantu = count($_SESSION['linhkien']);
            }
            ?>
            <div class="giohang_thanhtoan">
                <div class="item-cart">
                    <section class="h-100 h-custom" style="background-color: white">
                        <div class=" h-100" style="margin: 0 0 3rem 0;">
                            <h2 style="color:cadetblue; text-align:center;margin-top:2%; padding-top:2%">Giỏ hàng</h2>
                            <div class="row d-flex justify-content-center align-items-center h-100">
                                <div class="col-12">
                                    <div class="card card-registration card-registration-2" style="border-radius: 15px; border: 1px solid rgb(80, 60, 60);">
                                        <div class="card-body p-0">
                                            <div class="row g-0">
                                                <div class="col-lg-9">
                                                    <div class="row" style="padding:1rem">
                                                        <!-- tiêu đề  -->
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <!-- <h1 class="fw-bold mb-0 text-black">Giỏ hàng của bạn</h1> -->
                                                            <h6 class="mb-0 text-muted">

                                                                <?php
                                                                if (isset($_SESSION['linhkien'])) {
                                                                    echo "( " . $phantu . " )";
                                                                } else {
                                                                    echo '';
                                                                }
                                                                ?>
                                                                sản phẩm
                                                            </h6>
                                                        </div>
                                                        <hr style="width:90%; margin:20px auto">
                                                        <?php
                                                        if (isset($_SESSION['linhkien'])) {
                                                            if (isset($_SESSION['dangky'])) {
                                                                //lấy thông tin từ tbl đăng ký
                                                                $id_dangky = $_SESSION['id_khachhang'];
                                                            } else {
                                                                $id_dangky = 0;
                                                            }
                                                            $i = 0;
                                                            $tongtien = 0;
                                                            $tongsp = 0;
                                                            foreach (array_reverse($_SESSION['linhkien']) as $sp_item) {
                                                                if ($sp_item['idkhach'] == $id_dangky) {
                                                                    if (isset($_SESSION['dangky'])) {
                                                                        $tien = $sp_item['giasanpham'] - $sp_item['giasanpham'] * 5 / 100;
                                                                        $thanhtien = $sp_item['soluong'] * $tien;
                                                                    } else {
                                                                        $tien = $sp_item['giasanpham'];
                                                                        $thanhtien = $sp_item['soluong'] * $tien;
                                                                    }
                                                                    $tongtien += $thanhtien;
                                                                    $i++;
                                                                    $id_sanpham = $sp_item['id'];
                                                                    $tongsp += $sp_item['soluong'];
                                                        ?>
                                                                    <!-- sản phẩm -->
                                                                    <div class="row d-flex justify-content-between align-items-center">
                                                                        <div class="col-md-2 col-lg-2 col-xl-3" style="padding:2%">
                                                                            <img style="width: 100%" src="admin/modules/quanlysanpham/uploads/<?php echo $sp_item['hinhanh'] ?>" class="img-fluid rounded-3" alt="<?php echo $sp_item['tensanpham'] ?>">
                                                                        </div>
                                                                        <div class="col-md-3 col-lg-3 col-xl-5" style="padding-left: 1%; padding-right:0">
                                                                            <h5 class="text-muted"><?php echo $sp_item['tensanpham'] ?></h5>
                                                                            <h5 class="text-muted"><?php echo '"' . $sp_item['idkhach'] . '"' ?>id khách hàng</h5>
                                                                            <h5 class="text-black mb-0" style="line-height: 1.5;">màu hồng</h5>
                                                                            <?php
                                                                            if (isset($_SESSION['dangky'])) {
                                                                            ?>
                                                                                <h5 class="text-black mb-0" style="line-height: 2; color:#d70018;">Giá thành viên:
                                                                                    <?php echo number_format($tien, 0, ',', '.') . 'vnđ' ?>
                                                                                </h5>
                                                                                <h5 class="gia_sale"><?php echo number_format($sp_item['giasanpham'], 0, ',', '.') . 'vnđ' ?></h5>
                                                                            <?php
                                                                            } else {
                                                                            ?>
                                                                                <h5 class="text-black mb-0" style="line-height: 2; color:#d70018;">Giá:
                                                                                    <?php echo number_format($tien, 0, ',', '.') . 'vnđ' ?>
                                                                                </h5>
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                        </div>
                                                                        <!-- ttawng giảm số lượng -->
                                                                        <div class=" col-md-6 col-lg-6 col-xl-4 d-flex sl_gia">
                                                                            <div class="col-md-6 col-lg-6 col-xl-6 d-flex add_sl">
                                                                                <input id="form1" min="1" name="quantity" value="<?php echo $sp_item['soluong'] ?>" style="font-size: 16px; text-align:center; pointer-events: none;" class="form-control form-control-sm" />
                                                                            </div>

                                                                            <div class="col-md-6 col-lg-6 col-xl-6 gia_sp">
                                                                                <h5 class=""><?php echo '<a style="color:#d70018;">' . number_format($thanhtien, 0, ',', '.') . 'đ</a>' ?></h5>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <hr style="width:90%; margin:10px auto">
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                            <!-- nút quay lại -->
                                                            <div class="pt-5">
                                                                <h6 class="mb-0">
                                                                    <a href="index.php?quanly=vanchuyen" class="text-body" style="text-decoration: none;">
                                                                        <i class="fas fa-long-arrow-alt-left me-2"></i>Vận chuyển
                                                                    </a>
                                                                </h6>
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 bg-grey">
                                                    <div class="buy-tt">
                                                        <h3 class="fw-bold mb-5 mt-2 pt-1">Tổng Tiền</h3>
                                                        <hr class="my-4">

                                                        <div class="d-flex justify-content-between mb-4">
                                                            <h5 class="text-uppercase">Số lượng:
                                                                <?php
                                                                if (isset($sp_item['soluong'])) {
                                                                    echo $tongsp;
                                                                }
                                                                ?>
                                                            </h5>
                                                        </div>

                                                        <hr class="my-4">
                                                        <div class="d-flex justify-content-between mb-5">
                                                            <h5 class="text-uppercase">Tổng tiền: </h5>
                                                            <h5><?php echo '<b style="color:#d70018;">' . number_format($tongtien, 0, ',', '.') . 'đ</b>' ?></h5>
                                                        </div>

                                                        <hr class="my-4">
                                                        <h4>Phương thức thanh toán</h4>
                                                        <div class="tt" style="width:100%">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="payment" id="exampleRadios1" value="Tiền mặt" checked>
                                                                <label class="form-check-label" for="exampleRadios1">
                                                                    Thanh toán khi nhận hàng
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="payment" id="exampleRadios2" value="Chuyển khoản" checked>
                                                                <label class="form-check-label" for="exampleRadios2">
                                                                    Chuyển khoản
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="payment" id="exampleRadios3" value="Momo" checked>
                                                                <img src="https://play-lh.googleusercontent.com/dQbjuW6Jrwzavx7UCwvGzA_sleZe3-Km1KISpMLGVf1Be5N6hN6-tdKxE5RDQvOiGRg" height="35" width="35">
                                                                <label class="form-check-label" for="exampleRadios3">
                                                                    Momo
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="payment" id="exampleRadios4" value="VNPay" checked>
                                                                <img src="https://play-lh.googleusercontent.com/2WHgcuwhtbmfrDEF-D-lYQ4sAk0TlI-aFtqx7lJXK5KV7f8smnofaedP_Opcd3edR2c" height="35" width="35">
                                                                <label class="form-check-label" for="exampleRadios4">
                                                                    VNPay
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <button type="submit" name="thanhtoanngay" data-mdb-button-init data-mdb-ripple-init class="btn btn-danger btn-block btn-lg" data-mdb-ripple-color="dark" style="margin-top: 10%;">Thanh Toán</button>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                                        } else {
                                    ?>
                                        <p>Giỏ hàng trống</p>
                                    <?php
                                                        }
                                    ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </form>
        <!-- </div> -->
    </div>
</div>
<style>
    .tt .form-check {
        margin-top: 10%;
    }
</style>
<script>
    <?php
    $thongtin = 'Giao hàng đến địa chỉ: ' . $address . '<br> Tên người nhận: ' . $name
    ?>

    function confirmPayment() {
        var result = confirm("<?php echo '<p>' . 'Giao địa chỉ: ' . $address . '</p>' ?>");
        if (result) {
            // Nếu người dùng chọn "OK", form sẽ được submit
            return true;
        } else {
            // Nếu người dùng chọn "Cancel", form sẽ không được submit
            return false;
        }
    }
</script>