<?php
// $sql_lietke_donhang = "SELECT COUNT(tbl_cartdetail.madon) AS soluongsp,* FROM tbl_cartdetail,tbl_sanpham WHERE tbl_cartdetail.id_sanpham=tbl_sanpham.id_sanpham AND tbl_cartdetail.madon='$_GET[madon]' ORDER BY tbl_cartdetail.id_detail DESC";
// $query_lietke_donhang = mysqli_query($mysqli, $sql_lietke_donhang);
$sql_lietke_donhang = "SELECT tbl_cartdetail.*, COUNT(tbl_cartdetail.madon) AS soluongsp, tbl_sanpham.*, tbl_dangky.*, tbl_cart.*
FROM tbl_cartdetail 
JOIN tbl_sanpham ON tbl_cartdetail.id_sanpham = tbl_sanpham.id_sanpham
LEFT JOIN tbl_cart ON tbl_cart.id_cart = tbl_cartdetail.madon
LEFT OUTER JOIN tbl_dangky ON tbl_cart.id_dangky = tbl_dangky.id_dangky 
WHERE tbl_cartdetail.madon = '$_GET[madon]'
GROUP BY tbl_cartdetail.madon, tbl_sanpham.id_sanpham
ORDER BY tbl_cartdetail.id_detail DESC";
$query_lietke_donhang = mysqli_query($mysqli, $sql_lietke_donhang);

$query_donhang = mysqli_query($mysqli, $sql_lietke_donhang);
$rows = mysqli_fetch_array($query_donhang);
$soluongsp = $rows['soluongsp'];

$sql_lietke = "SELECT *
    FROM tbl_cart
    LEFT OUTER JOIN tbl_dangky ON tbl_cart.id_dangky = tbl_dangky.id_dangky 
    LEFT JOIN tbl_nguoinhan ON tbl_nguoinhan.id_nguoinhan = tbl_cart.id_nguoinhan
    ORDER BY tbl_cart.id_cart DESC";
$query_lietke = mysqli_query($mysqli, $sql_lietke);
$ln = mysqli_fetch_array($query_lietke);
?>
<div class="xemdon">
    <div class="sp-cart">
        <div class="item-cart" style="background-color: white;">
            <section class="h-100 h-custom">
                <div class=" h-100" style="padding: 0 0 3rem 0">
                    <h2 style="color:cadetblue; text-align:center; padding-top:1%;">Chi tiết đơn (<?php echo $rows['madon'] ?>)</h2>
                    <div class="row d-flex justify-content-center align-items-center h-100">
                        <div class="col-12">
                            <div class="card card-registration card-registration-2" style="border-radius: 15px;  border: 1px solid rgb(80, 60, 60);">
                                <div class="card-body p-0">
                                    <div class="row g-0">
                                        <div class="col-lg-9">
                                            <div style="padding: 1rem;">
                                                <!-- tiêu đề  -->
                                                <!-- <div class="d-flex justify-content-between align-items-center mb-5">
                                                    <h6 class="mb-0 text-muted">
                                                        <?php echo $soluongsp ?></p>sản phẩm
                                                    </h6>
                                                </div> -->

                                                <hr class="my-4">
                                                <?php
                                                $i = 0;
                                                $tongtien = 0;
                                                $sl = 0;
                                                while ($row = mysqli_fetch_array($query_lietke_donhang)) {
                                                    $i++;

                                                    if (!empty($row['tenkhach'])) :
                                                        $tien = $row['giasanpham'] - $row['giasanpham'] * 5 / 100;
                                                        $thanhtien = $row['soluongmua'] * $tien;

                                                    else :
                                                        $tien = $row['giasanpham'];
                                                        $thanhtien = $row['giasanpham'] * $row['soluongmua'];;
                                                    endif;


                                                    $tongtien += $thanhtien;
                                                    $sl += $row['soluongmua'];
                                                ?>
                                                    <!-- sản phẩm -->
                                                    <div class="row d-flex justify-content-between align-items-center">
                                                        <div class="col-md-2 col-lg-2 col-xl-3" style="padding: 2%;">
                                                            <img src="modules/quanlysanpham/uploads/<?php echo $row['avatar'] ?>" class="img-fluid rounded-3" alt="sản phẩm" width="100%">
                                                        </div>
                                                        <div class="col-md-3 col-lg-4 col-xl-5" style="padding-left: 2%;">
                                                            <h5 class="text-muted"><?php echo $row['tensanpham'] ?></h5>
                                                            <!-- <h6 class="text-black mb-0" style="line-height: 1.5;">màu hồng</h6> -->

                                                            <?php
                                                            if (!empty($row['tenkhach'])) :
                                                            ?>
                                                                <h5 class="text-black mb-0" style="line-height: 2; color:#d70018;">Giá thành viên:
                                                                    <?php echo number_format($tien, 0, ',', '.') . 'vnđ' ?>
                                                                </h5>
                                                                <h5 class="gia_sale"><?php echo number_format($row['giasanpham'], 0, ',', '.') . 'vnđ' ?></h5>
                                                            <?php
                                                            else :
                                                            ?>
                                                                <h5 class="text-black mb-0" style="line-height: 2; color:#d70018;">Giá:
                                                                    <?php echo number_format($tien, 0, ',', '.') . 'vnđ' ?>
                                                                </h5>
                                                            <?php
                                                            endif;
                                                            ?>
                                                        </div>
                                                        <div class=" col-md-6 col-lg-5 col-xl-4 d-flex sl_gia">
                                                            <!-- ttawng giảm số lượng -->
                                                            <div class="col-md-6 col-lg-6 col-xl-6 d-flex add_sl">


                                                                <input id="form1" min="1" name="quantity" value="<?php echo $row['soluongmua'] ?>" style="font-size: 16px; text-align:center;pointer-events: none;" class="form-control form-control-sm" />

                                                            </div>
                                                            <div class="col-md-6 col-lg-6 col-xl-6 gia_sp">
                                                                <h5 class=""><?php echo '<a style="color:#d70018;">' . number_format($thanhtien, 0, ',', '.') . 'đ</a>' ?></h5>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <hr class="my-4">
                                                <?php
                                                }
                                                ?>

                                                <!-- nút quay lại -->
                                                <div class="">
                                                    <h6 class="mb-0">
                                                        <a href="index.php?action=quanlydonhang&query=donmoi" class="text-body" style="text-decoration: none;">
                                                            <i class="fas fa-long-arrow-alt-left me-2"></i>Back
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
                                                        echo $sl
                                                        ?>
                                                    </h5>
                                                </div>
                                                <hr class="my-4">
                                                <div class="d-flex justify-content-between mb-5">
                                                    <h5 class="text-uppercase">Tổng tiền: </h5>
                                                    <h5><?php echo '<b style="color:#d70018;">' . number_format($tongtien, 0, ',', '.') . 'đ</b>' ?></h5>
                                                </div>
                                                <!-- <a href="index.php?quanly=vanchuyen">
                                                    <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-dark btn-block btn-lg" data-mdb-ripple-color="dark">Vận chuyển</button>
                                                </a> -->
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<style>

</style>