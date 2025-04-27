<head>
    <title>
        An Phát Computer - Xem đơn hàng
    </title>
</head>

<?php
// $sql_lietke_donhang = "SELECT COUNT(tbl_cartdetail.madon) AS soluongsp,* FROM tbl_cartdetail,tbl_sanpham WHERE tbl_cartdetail.id_sanpham=tbl_sanpham.id_sanpham AND tbl_cartdetail.madon='$_GET[madon]' ORDER BY tbl_cartdetail.id_detail DESC";
// $query_lietke_donhang = mysqli_query($mysqli, $sql_lietke_donhang);
$sql_lietke_donhang = "SELECT tbl_cartdetail.*, COUNT(tbl_cartdetail.madon) AS soluongsp, tbl_sanpham.*
FROM tbl_cartdetail
JOIN tbl_sanpham ON tbl_cartdetail.id_sanpham = tbl_sanpham.id_sanpham
WHERE tbl_cartdetail.madon = '$_GET[madon]'
GROUP BY tbl_cartdetail.madon, tbl_sanpham.id_sanpham
ORDER BY tbl_cartdetail.id_detail DESC";
$query_lietke_donhang = mysqli_query($mysqli, $sql_lietke_donhang);

$query_donhang = mysqli_query($mysqli, $sql_lietke_donhang);
$rows = mysqli_fetch_array($query_donhang);
$soluongsp = $rows['soluongsp'];

?>

<div class="xemdonhang">
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
                                                <hr class="my-4">
                                                <?php
                                                $i = 0;
                                                $tongtien = 0;
                                                $sl = 0;
                                                while ($row = mysqli_fetch_array($query_lietke_donhang)) {
                                                    $i++;
                                                    if (isset($_SESSION['dangky'])) {
                                                        $tien = $row['giasanpham'] - $row['giasanpham'] * 5 / 100;
                                                        $thanhtien = $row['soluongmua'] * $tien;
                                                    } else {
                                                        $tien = $row['giasanpham'];
                                                        $thanhtien = $row['giasanpham'] * $row['soluongmua'];
                                                    }

                                                    $tongtien += $thanhtien;
                                                    $sl += $row['soluongmua'];
                                                ?>
                                                    <!-- sản phẩm -->
                                                    <div class="row d-flex justify-content-between align-items-center">
                                                        <div class="col-md-3 col-lg-3 col-xl-3" style="padding: 2%; width:21%">
                                                            <img src="admin/modules/quanlysanpham/uploads/<?php echo $row['avatar'] ?>" class="img-fluid rounded-3" alt="sản phẩm" width="100%">
                                                        </div>
                                                        <div class="col-md-4 col-lg-4 col-xl-5" style="padding-left: 2%;">
                                                            <h5 class="text-muted"><?php echo $row['tensanpham'] ?></h5>

                                                            <h5 class="text-black mb-0" style="line-height: 2; color:#d70018;">Giá thành viên:
                                                                <?php echo number_format($tien, 0, ',', '.') . 'vnđ' ?>
                                                            </h5>
                                                            <h5 class="gia_sale"><?php echo number_format($row['giasanpham'], 0, ',', '.') . 'vnđ' ?></h5>
                                                        </div>
                                                        <div class=" col-md-5 col-lg-5 col-xl-4 d-flex sl_gia" style="justify-content: center; align-items: center;">
                                                            <!-- ttawng giảm số lượng -->
                                                            <div class="col-md-6 col-lg-6 col-xl-6 d-flex add_sl">
                                                                <input id="form1" min="1" name="quantity" value="<?php echo $row['soluongmua'] ?>" style="font-size: 16px; text-align:center;pointer-events: none;" class="form-control form-control-sm" />
                                                            </div>
                                                            <div class="col-md-6 col-lg-6 col-xl-6 gia_sp">
                                                                <h5 class=""><?php echo '<a style="color:#d70018;">' . number_format($thanhtien, 0, ',', '.') . 'đ</a>' ?></h5>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <!-------------------------------------- đánh giá sản phẩm đã nhận ------------------------------- -->
                                                    <div>
                                                        <?php
                                                        $id_sanpham = $row['id_sanpham'];
                                                        if ($row['giao'] == 1 && $row['dg_status'] == 0) {
                                                        ?>
                                                            <form action="" method="POST" style="margin-top: 1%;">
                                                                <table style="width:100%;" border='0'>

                                                                    <tr style="border: 1px solid">
                                                                        <td style="width:70%; text-align: left; border-right:1px solid ">
                                                                            <h5 style="color:blue; padding: 2% 0% 1% 4%;">Đánh giá & nhận xét</h5>
                                                                        </td>
                                                                        <td>
                                                                            <section class='rating-widget'>
                                                                                <?php
                                                                                $product_id = $row['id_sanpham'];

                                                                                // $sql_sao = "SELECT AVG(sao) AS avg_sao FROM tbl_danhgia WHERE id_sanpham = '$product_id'";
                                                                                // $query_sao = mysqli_query($mysqli, $sql_sao);
                                                                                // $result_sao = mysqli_fetch_array($query_sao);
                                                                                // $sao = $result_sao['avg_sao'];

                                                                                ?>
                                                                                <!-- Rating Stars Box -->
                                                                                <div class='rating-stars text-center'>
                                                                                    <p> <b style="color:#FF6600">Đánh giá sao </b></p>
                                                                                    <ul id='stars'>
                                                                                        <li class='star' title='Poor' data-value='1' data-product_id=<?php echo $row['id_sanpham'] ?>>
                                                                                            <i class='fa fa-star fa-fw'></i>
                                                                                        </li>
                                                                                        <li class='star' title='Fair' data-value='2' data-product_id=<?php echo $row['id_sanpham'] ?>>
                                                                                            <i class='fa fa-star fa-fw'></i>
                                                                                        </li>
                                                                                        <li class='star' title='Good' data-value='3' data-product_id=<?php echo $row['id_sanpham'] ?>>
                                                                                            <i class='fa fa-star fa-fw'></i>
                                                                                        </li>
                                                                                        <li class='star' title='Excellent' data-value='4' data-product_id=<?php echo $row['id_sanpham'] ?>>
                                                                                            <i class='fa fa-star fa-fw'></i>
                                                                                        </li>
                                                                                        <li class='star' title='WOW!!!' data-value='5' data-product_id=<?php echo $row['id_sanpham'] ?>>
                                                                                            <i class='fa fa-star fa-fw'></i>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </section>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2">
                                                                            <hr>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2">
                                                                            <textarea required='true' rows="5" style="width:95%; border-radius:8px; resize:none; padding: 10px 15px" type="text" size="60" name="noidung_dg_<?php echo $id_sanpham ?>" placeholder="Cho ý kiến của bạn về sản phẩm..." class="noidung-dg"></textarea>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2">
                                                                            <input class="nut_dg" type="submit" name="gui_dg_<?php echo $id_sanpham ?>" value="Gửi đánh giá"><br>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </form>
                                                            <?php
                                                            $madon = $row['madon'];
                                                            if (isset($_POST['gui_dg_' . $id_sanpham])) {
                                                                $id_sanpham = $row['id_sanpham'];
                                                                $noidung = $_POST['noidung_dg_' . $id_sanpham];

                                                                $sql_danhgia = "UPDATE tbl_danhgia SET noidung_dg = '$noidung', trangthai = '1' WHERE madon = '$_GET[madon]' AND id_sanpham = '$id_sanpham'";
                                                                $result = mysqli_query($mysqli, $sql_danhgia);

                                                                $sql_danhgia = "UPDATE tbl_cartdetail SET dg_status = '1' WHERE madon = '$_GET[madon]' AND id_sanpham = '$id_sanpham'";
                                                                $result = mysqli_query($mysqli, $sql_danhgia);

                                                                if ($result) {
                                                                    echo "<script>
                                                                     alert('Bạn đã đánh giá sản phẩm thành công.');
                                                                     window.location = 'index.php?quanly=xemdonhang&madon=$madon';
                                                                 </script>";
                                                                } else {
                                                                    echo '<p style="color:red">Đã có lỗi xảy ra. Vui lòng thử lại sau.</p>';
                                                                }
                                                            }
                                                        } elseif ($row['giao'] == 1 && $row['dg_status'] == 1) {
                                                            ?>
                                                            <div class="before_dg">
                                                                <h5 style="font-size: 18px; font-weight:600;">Đã đánh giá sản phẩm</h5>
                                                            </div>
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>


                                                    <hr class="my-4">
                                                <?php
                                                }
                                                ?>

                                                <!-- nút quay lại -->
                                                <div class="">
                                                    <h6 class="mb-0">
                                                        <a href="index.php?quanly=donmua" class="text-body" style="text-decoration: none;">
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
    .gia_sale {
        color: #707070;
        display: inline-block;
        font-size: 19px;
        text-decoration: line-through;
        margin-bottom: 0;
        font-weight: 600;
        padding-top: 5px;
        line-height: 1.3;
    }

    table td {
        /* border: 1px solid */
    }

    tr td input.nut_dg {
        padding: 0 3%;
        background-color: rgba(255, 0, 0, 0.899);
        color: white;
        font-size: 18px;
        height: 40px;
        border-radius: 10px;
        float: right;
    }
</style>