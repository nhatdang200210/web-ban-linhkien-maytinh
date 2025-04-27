<?php
// Kiểm tra nếu form đã được gửi đi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['vanchuyen'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $note = $_POST['note'];
    if (isset($_SESSION['dangky'])) {
        $id_khach = $_SESSION['id_khachhang'];
    } else {
        function isNumberExists($number, $mysqli)
        {
            $query = "SELECT COUNT(*) as count FROM tbl_dangky WHERE id_dangky = $number";
            $result = $mysqli->query($query);
            $row = $result->fetch_assoc();
            return $row['count'] > 0;
        }

        // Hàm tạo số ngẫu nhiên không trùng
        function generateUniqueRandomNumber($mysqli)
        {
            do {
                $random_number = rand(100, 999999); // Tạo số ngẫu nhiên
            } while (isNumberExists($random_number, $mysqli)); // Kiểm tra sự tồn tại của số
            return $random_number;
        }

        // Sử dụng hàm để tạo số ngẫu nhiên không trùng
        $id_khach = generateUniqueRandomNumber($mysqli);
    }
    // Kiểm tra xem thông tin vận chuyển đã tồn tại trong cơ sở dữ liệu cho người dùng hiện tại hay không
    $sql_check_existing = mysqli_query($mysqli, "SELECT * FROM tbl_shippingkhac WHERE id_dangky='$id_khach'");
    $count_existing = mysqli_num_rows($sql_check_existing);


    if ($count_existing > 0) {
        //     // thay đổi tt nếu đã tồn tại, thực hiện cập nhật thông tin
        $sql_update_vanchuyen = mysqli_query($mysqli, "UPDATE tbl_shippingkhac SET name = '$name', phone = '$phone', address = '$address', note = '$note' WHERE id_dangky='$id_khach'");
        if ($sql_update_vanchuyen) {
            $get = mysqli_query($mysqli, "SELECT * FROM tbl_shippingkhac WHERE id_dangky = '$id_khach' LIMIT 1");
            $vanchuyen = mysqli_fetch_array($get);
            $diachi = $vanchuyen['address'];
            echo "<script>alert('Giao hàng đến địa chỉ $diachi ');
                             window.location='index.php?quanly=thongtinthanhtoan&id=$id_khach';
                     </script>";
        } else {
            echo '<script>alert("Thêm thông tin vận chuyển không thành công. Vui lòng thử lại.")</script>';
        }
    } else {

        //     // Nếu chưa tồn tại, thêm thông tin mới vào cơ sở dữ liệu
        $sql_vanchuyen = mysqli_query($mysqli, "INSERT INTO tbl_shippingkhac (name, phone, address, note, id_dangky) VALUES ('$name', '$phone', '$address', '$note', '$id_khach')");
        $get = mysqli_query($mysqli, "SELECT * FROM tbl_shippingkhac WHERE id_dangky = '$id_khach' LIMIT 1");
        $vanchuyen = mysqli_fetch_array($get);
        $diachi = $vanchuyen['address'];
        if ($sql_vanchuyen) {
            echo "<script>alert('Giao hàng đến địa chỉ $diachi ');
                             window.location='index.php?quanly=thongtinthanhtoan&id=$id_khach';
                     </script>";
        } else {
            echo '<script>alert("Thêm thông tin vận chuyển không thành công. Vui lòng thử lại.")</script>';
            //     }
        }
    }
}



// Lấy thông tin vận chuyển từ cơ sở dữ liệu nếu có
if (isset($_SESSION['dangky'])) {
    $id_dangky = $_SESSION['id_khachhang'];
    $sql_get_vanchuyen = mysqli_query($mysqli, "SELECT * FROM tbl_shipping WHERE id_dangky='$id_dangky' LIMIT 1");
    $count = mysqli_num_rows($sql_get_vanchuyen);

    if ($count > 0) {
        $row_get_vanchuyen = mysqli_fetch_array($sql_get_vanchuyen);
        $name = $row_get_vanchuyen['name'];
        $phone = '0' . $row_get_vanchuyen['phone'];
        $address = $row_get_vanchuyen['address'];
    } else {
        $name = '';
        $phone = '';
        $address = '';
        $note = '';
    }
} else {
    $name = '';
    $phone = '';
    $address = '';
    $note = '';
}
?>
<div class="cart">
    <div class="menu-cart">
        <div class="arrow-steps clearfix">
            <div class="step done"> <span> <a href="index.php?quanly=giohang">Giỏ hàng</a></span> </div>
            <div class="step current"> <b><a href="index.php?quanly=vanchuyen">Vận chuyển</a></b> </div>
            <div class="step"> <span><a href="index.php?quanly=thongtinthanhtoan">Thanh toán</a><span> </div>
            <div class="step"> <span><a href="index.php?quanly=dondadat">Đã đặt</a><span> </div>
        </div>
    </div>
    <div class="vanchuyen">
        <h2 style="color:cadetblue; text-align:center;margin-top:2%;">Thông tin vận chuyển</h2>
        <div class="address">
            <form action="" autocomplete="off" method="POST">
                <div class="form-group">
                    <label for="email">Họ và tên</label>
                    <input type="text" required='true' name="name" value="<?php echo $name ?>" placeholder="..." class="form-control" style=" font-weight:bold; color:black;">
                </div>
                <div class="form-group">
                    <label for="email">Phone</label>
                    <input type="number" required='true' name="phone" value="<?php echo  $phone ?>" placeholder="..." class="form-control" style=" font-weight:bold; color:black;" maxlength="10" oninput="this.value = this.value.slice(0, 10)">
                </div>
                <div class="form-group">
                    <label for="pwd">Địa chỉ</label>
                    <input type="text" required='true' name="address" value="<?php echo $address ?>" placeholder="..." class="form-control" style=" font-weight:bold; color:black;">
                </div>
                <div class="form-group">
                    <label for="pwd">Ghi chú</label>
                    <input type="text" name="note" placeholder="note" class="form-control">
                </div>

                <button type="submit" name="vanchuyen" class="btn btn-success" style="margin-bottom: 10px;">Đồng ý</button>
                </form>
                <?php
                if (isset($_SESSION['dangky'])) {
                    $id_dangky = $_SESSION['id_khachhang'];

                    // Kiểm tra xem thông tin vận chuyển đã tồn tại trong cơ sở dữ liệu cho người dùng hiện tại hay không
                    $sql_check_existing = mysqli_query($mysqli, "SELECT * FROM tbl_shipping WHERE id_dangky='$id_dangky'");
                    $count_existing = mysqli_num_rows($sql_check_existing);
                    if ($count_existing > 0) {
                        echo "";
                    } else {
                ?>
                        <a href="index.php?quanly=diachi">
                            <button class="btn btn-success" style="margin-bottom: 10px;">Tạo địa chỉ của bạn</button>
                        </a>
                <?php
                    }
                }
                ?>
        </div>
    </div>
    <!-- phần giỏ hàng--------------- -->
    <?php
    if (isset($_SESSION['linhkien']) && !empty($_SESSION['linhkien'])) {
        $tongsp = 0;
        // Đếm số lượng phần tử trong mảng
        $phantu = count($_SESSION['linhkien']);
    }
    ?>
    <div class="giohang_vanchuyen">
        <div class="item-cart">
            <section class="h-100 h-custom" style="background-color: white;">
                <div class=" h-100" style="padding: 0 0 3rem 0">
                    <h2 style="color:cadetblue; text-align:center;margin-top:2%;">Giỏ hàng</h2>
                    <div class="row d-flex justify-content-center align-items-center h-100">
                        <div class="col-12">
                            <div class="card card-registration card-registration-2" style="border-radius: 15px;border: 1px solid rgb(80, 60, 60);">
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
                                                                    <img style="width:100%" src="admin/modules/quanlysanpham/uploads/<?php echo $sp_item['hinhanh'] ?>" class="img-fluid rounded-3" alt="sản phẩm">
                                                                </div>
                                                                <div class="col-md-4 col-lg-4 col-xl-5" style="padding-left: 2%;">
                                                                    <h5 class="text-muted"><?php echo $sp_item['tensanpham'] ?></h5>
                                                                    <!-- <h5 class="text-muted"><?php echo '"' . $sp_item['idkhach'] . '"' ?>id khách hàng</h5> -->
                                                                    <!-- <h5 class="text-black mb-0" style="line-height: 2;">màu hồng</h5> -->
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
                                                            <a href="index.php?quanly=giohang" class="text-body" style="text-decoration: none;">
                                                                <i class="fas fa-long-arrow-alt-left me-2"></i>Giỏ hàng
                                                            </a>
                                                        </h6>
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 bg-grey">
                                            <div style="padding: 6%;">
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

                                                <div class="d-flex justify-content-between mb-5" style="color:red">
                                                    <h5 class="text-uppercase" style="font-size: 18px;">Tổng tiền: </h5>
                                                    <h5><?php echo '<b style="color:#d70018;">' . number_format($tongtien, 0, ',', '.') . 'đ</b>' ?></h5>
                                                </div>
                                                <a href="index.php?quanly=thongtinthanhtoan">
                                                    <button type="submit" name="vanchuyen" data-mdb-button-init data-mdb-ripple-init class="btn btn-dark btn-block btn-lg" data-mdb-ripple-color="dark">Thông tin thanh toán</button>
                                                </a>
                                            </div>
                                            </form>
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
</div>
<style type="text/css">
    .p-5 {
        padding: 1rem;
    }

    .form-group input {
        padding: 20px;
    }
</style>