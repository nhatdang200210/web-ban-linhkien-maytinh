<?php

// Khởi tạo biến đếm số lượng sản phẩm
$tongsp = 0;
$phantu = 0;

// Kiểm tra xem người dùng đã đăng nhập chưa
if (isset($_SESSION['dangky'])) {
    // Lấy id_dangky của người dùng
    $id_dangky = $_SESSION['id_khachhang'];
} else {
    $id_dangky = 0;
}

// Nếu có sản phẩm trong giỏ hàng
if (isset($_SESSION['linhkien']) && !empty($_SESSION['linhkien'])) {
    foreach ($_SESSION['linhkien'] as $sp_item) {
        if ($sp_item['idkhach'] == $id_dangky) {
            $phantu++;
        }
    }
}

// if (isset($_SESSION['sanpham'] ) && !empty($_SESSION['sanpham'])) {
//     $tongsp = 0;
//     // Đếm số lượng phần tử trong mảng
//     $phantu = count($_SESSION['sanpham']);
// }
// $sql_sp = "SELECT tbl_sanpham.*, tbl_danhmuc.*
//     FROM tbl_sanpham 
//     LEFT JOIN tbl_danhmuc ON tbl_sanpham.id_danhmuc = tbl_danhmuc.id_danhmucsp 
//     GROUP BY tbl_sanpham.id_sanpham ";

// $query_sp = mysqli_query($mysqli, $sql_sp);
// $row_sp = mysqli_fetch_array($query_sp);
// $id_sanpham = $row_sp['id_sanpham'];
?>

<div class="cart">
    <div class="menu-cart">
        <div class="arrow-steps clearfix">
            <!-- <div class="step  current"> <span> <a href="index.php?quanly=giohang" >Giỏ hàng</a></span> </div> -->
            <div class="step  current"> <b> <a href="index.php?quanly=giohang">Giỏ hàng</a></b> </div>
            <div class="step"> <span><a href="index.php?quanly=vanchuyen">Vận chuyển</a></span> </div>
            <div class="step"> <span><a href="index.php?quanly=thongtinthanhtoan">Thanh toán</a><span> </div>
            <div class="step"> <span><a href="index.php?quanly=dondadat">Đã đặt</a><span> </div>
        </div>
    </div>

    <div class="sp-cart">
        <div class="item-cart" style="background: none;">
            <section class="h-100 h-custom">
                <div class=" h-100" style="padding: 0 0 3rem 0">
                    <h2 style="color:cadetblue; text-align:center; padding-top:1%;">Giỏ hàng của bạn</h2>
                    <div class="row d-flex justify-content-center align-items-center h-100">
                        <div class="col-12">
                            <div class="card card-registration card-registration-2" style="border-radius: 15px;  border: 1px solid rgb(80, 60, 60);">
                                <div class="card-body p-0">
                                    <div class="row g-0">
                                        <div class="col-lg-9">
                                            <div style="padding: 1rem;">
                                                <!-- tiêu đề  -->
                                                <div class="d-flex justify-content-between align-items-center mb-5">
                                                    <h6 class="mb-0 text-muted">

                                                        <?php
                                                        if (isset($_SESSION['linhkien'])) {
                                                            echo "( " . $phantu . " )";
                                                        } else {
                                                            echo "";
                                                        }
                                                        ?>
                                                        sản phẩm
                                                    </h6>
                                                </div>

                                                <hr class="my-4">
                                                <?php
                                                // if (isset($_SESSION['dangky'])) {
                                                //     //lấy thông tin từ tbl đăng ký
                                                //     $id_dangky = $_SESSION['id_khachhang'];
                                                // } else {
                                                //     $id_dangky = 0;
                                                // }
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
                                                    // $gia = $row_chitiet['giasanpham'];
                                                    // $tien = $gia - $gia * 5 / 100;
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
                                                                <!-- <a href="localhost/web-thuctap/index.php?quanly=chitietsanpham&id=<?php echo $id_sanpham ?>" style="text-decoration: none; color:black" > -->
                                                                <div class="col-md-2 col-lg-2 col-xl-3" style="padding: 2%;">
                                                                    <a href="index.php?quanly=chitietsp&id=<?php echo $id_sanpham ?>"><img src="admin/modules/quanlysanpham/uploads/<?php echo $sp_item['hinhanh'] ?>" class="img-fluid rounded-3" alt="sản phẩm" width="100%"></a>
                                                                </div>
                                                                <div class="col-md-3 col-lg-4 col-xl-4" style="padding-left: 2%;">
                                                                    <h5 class="text-muted"><?php echo $sp_item['tensanpham'] ?></h5>
                                                                    <!-- <h5 class="text-muted"><?php echo '"' . $sp_item['idkhach'] . '"' ?>id khách hàng</h5> -->
                                                                    
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

                                                                <div class=" col-md-6 col-lg-5 col-xl-4 d-flex sl_gia">
                                                                    <!-- ttawng giảm số lượng -->
                                                                    <div class="col-md-6 col-lg-6 col-xl-6 d-flex add_sl">
                                                                        <a href="pages/main/card/addcard.php?tru=<?php echo $sp_item['id'] ?>">
                                                                            <button data-mdb-button-init data-mdb-ripple-init class="btn btn-link px-2" onclick="this.parentNode.querySelector('input[type=number]').stepDown()">
                                                                                <i class="fas fa-minus"></i>
                                                                            </button>
                                                                        </a>

                                                                        <input id="form1" min="1" name="quantity" value="<?php echo $sp_item['soluong'] ?>" style="font-size: 16px; text-align:center" class="form-control form-control-sm" />

                                                                        <a href="pages/main/card/addcard.php?cong=<?php echo $sp_item['id'] ?>">
                                                                            <button data-mdb-button-init data-mdb-ripple-init class="btn btn-link px-2" onclick="this.parentNode.querySelector('input[type=number]').stepUp()">
                                                                                <i class="fas fa-plus"></i>
                                                                            </button>
                                                                        </a>
                                                                    </div>
                                                                    <div class="col-md-6 col-lg-6 col-xl-6 gia_sp">
                                                                        <h5 class=""><?php echo '<a style="color:#d70018;">' . number_format($thanhtien, 0, ',', '.') . 'đ</a>' ?></h5>
                                                                    </div>
                                                                </div>


                                                                <div class="col-md-1 col-lg-1 col-xl-1 text-end">
                                                                    <!-- nút xoá sản phẩm-->
                                                                    <a href="pages/main/card/addcard.php?xoa=<?php echo $sp_item['id'] ?>&idkhach=<?php echo $id_dangky ?>" class="text-muted">
                                                                        <button class="nut_xoa_sp"><i class="fas fa-trash-alt"></i></button>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <hr class="my-4">
                                                    <?php
                                                        }
                                                    }
                                                    ?>

                                                    <!-- nút quay lại -->
                                                    <div class="pt-5">
                                                        <h6 class="mb-0">
                                                            <a href="index.php" class="text-body" style="text-decoration: none;">
                                                                <i class="fas fa-long-arrow-alt-left me-2"></i>Back to shop
                                                            </a>
                                                        </h6>
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 bg-grey">
                                            <div class="p-5">
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
                                                <a href="index.php?quanly=vanchuyen">
                                                    <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-dark btn-block btn-lg" data-mdb-ripple-color="dark">Tiến hành mua</button>
                                                </a>
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
</div>