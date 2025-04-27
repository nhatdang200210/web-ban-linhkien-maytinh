<?php
$sql_lietke_donhang = "SELECT * FROM tbl_cartdetail,tbl_sanpham WHERE tbl_cartdetail.id_sanpham=tbl_sanpham.id_sanpham AND tbl_cartdetail.madon='$_GET[madon]' ORDER BY tbl_cartdetail.id_detail DESC";
$query_lietke_donhang = mysqli_query($mysqli, $sql_lietke_donhang);

$id_dangky = $_SESSION['id_khachhang']; //lấy id khách hàng

//lấy mã đơn
$query_donhang = mysqli_query($mysqli, $sql_lietke_donhang);
$donhang = mysqli_fetch_array($query_donhang);
$id_sanpham = $donhang['id_sanpham'];
// $id_sanpham = $donhang['id_sanpham'];  
while ($row = mysqli_fetch_array($query_lietke_donhang)) {
    $id_sanpham = $row['id_sanpham'];
    if ($row['giao'] == 1 && $row['dg_status'] == 0) {

?>
        <tr class="border_bottom">
            <td colspan="6">
                <form action="" method="POST" style="margin-top: 1%;">
                    <!-- <table border="0" style="border-collapse:collapse; width:97%;" class="table_dg"> -->
        <tr>
            <td style="width:70%; text-align: left;">
                <h5 style="color:blue; padding: 2% 0% 1% 4%;">Đánh giá & nhận xét <?php echo $row['tensanpham'] ?></h5>
            </td>
            <td style="text-align: right;">
                <!-- <b style="text-align: center; padding: 4%; color:#FF6600">Đánh giá sao</b> -->
                <section class='rating-widget'>
                    <?php
                    $product_id = $row['id_sanpham'];

                    $sql_sao = "SELECT AVG(sao) AS avg_sao FROM tbl_danhgiasao WHERE id_sanpham_sao = '$product_id'";
                    $query_sao = mysqli_query($mysqli, $sql_sao);
                    $result_sao = mysqli_fetch_array($query_sao);

                    ?>
                    <!-- Rating Stars Box -->
                    <div class='rating-stars text-center'>
                        <p> <b style="color:#FF6600">Đánh giá sao</b></p>
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
                <hr style="border-width:2px">
            </td>
        </tr>
        <tr>

            <td class="td_dg" colspan="2">
                <textarea rows="5" style="width:95%; border-radius:8px" type="text" size="60" name="noidung_dg_<?php echo $id_sanpham ?>" placeholder="Cho ý kiến của bạn về sản phẩm..." class="noidung-dg"></textarea>

            </td>
        </tr>

        <tr>

            <td colspan="2">
                <input class="nut_dg" type="submit" name="gui_dg_<?php echo $id_sanpham ?>" value="Gửi đánh giá"><br>
            </td>
        </tr>

        </table>
        </form>

        </td>

        </tr>

        <?php
        $madon = $donhang["madon"];

        if (isset($_POST['gui_dg_' . $id_sanpham])) {


            $id_sanpham_dg = $row['id_sanpham'];
            $noidung_dg = $_POST['noidung_dg_' . $id_sanpham];

            if (isset($_SESSION['dangky'])) {
                //lấy thông tin từ tbl đăng ký
                $id_dangky = $_SESSION['id_khachhang'];
            } else {
                $id_dangky = gethostbyname(gethostname());
            }

            $sql_khach = "SELECT * FROM tbl_nguoinhan WHERE id_dangky ='$id_dangky' AND madon_nguoinhan = '$madon' ";
            $query_khach = mysqli_query($mysqli, $sql_khach);
            $thongtin_khach = mysqli_fetch_array($query_khach);

            //thông tin khách được lấy ra 
            $name_dg = $thongtin_khach['tennguoinhan'];
            $id_khach = $thongtin_khach['id_dangky'];

            //lấy thông tin đánh giá sao
            $sql_danhgiasao = "SELECT * FROM tbl_danhgiasao WHERE madon = '$madon' AND id_sanpham_sao = '$id_sanpham'";
            $query_danhgiasao = mysqli_query($mysqli, $sql_danhgiasao);
            $danhgiasao = mysqli_fetch_array($query_danhgiasao);

            $sao = $danhgiasao['sao'];

            if (empty($noidung_dg)) {
                echo '<p style="color:red">Vui lòng nhập đánh giá của bạn cho sản phẩm.</p>';
            } else {

                $sql_danhgia = mysqli_query($mysqli, "INSERT INTO tbl_danhgia (masanpham_dg, noidung_dg,name_dg, id_dangky, sao, thoigian_dg, dg_status) 
                 VALUES ('$id_sanpham_dg', '$noidung_dg', '$name_dg', '$id_khach', '$sao', NOW(),1)");

                $sql_donhang = "UPDATE tbl_donhang SET dg_status = 1 WHERE tbl_donhang.madon='$_GET[madon]' AND tbl_donhang.id_sanpham = '$id_sanpham' ";
                $result = mysqli_query($mysqli, $sql_donhang);

                if ($sql_danhgia) {
                    $sql_sao = "DELETE FROM tbl_danhgiasao WHERE madon = $madon AND id_sanpham_sao = '$id_sanpham_dg'";
                    mysqli_query($mysqli, $sql_sao);
                    echo "<script>
                         alert('Bạn đã đánh giá sản phẩm thành công.');
                         window.location = 'index.php?quanly=xemdonhang&madon=$madon';
                     </script>";
                } else {
                    echo '<p style="color:red">Đã có lỗi xảy ra. Vui lòng thử lại sau.</p>';
                }
            }
        }
    } elseif ($row['giao'] == 1 && $row['dg_status'] == 1) {
        ?>
        <tr style=" border-bottom:20px solid white">
            <td colspan="6" style="padding: 1%; text-align:right; color:red; font-size:18px">
                <b>Đã đánh giá sản phẩm</b>
            </td>
        </tr>
    <?php
    } else {
    ?>
        <tr style=" border-bottom:20px solid white">
            <td colspan="6">

            </td>
        </tr>
<?php
    }
}
?>