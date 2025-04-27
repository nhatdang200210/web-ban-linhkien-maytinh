<?php

//chi tiết 1 sp
$sql_chitiet = "SELECT * FROM tbl_sanpham, tbl_danhmuc WHERE tbl_sanpham.id_danhmuc = tbl_danhmuc.id_danhmucsp AND tbl_sanpham.id_sanpham='$_GET[id]' LIMIT 1";
$query_chitiet = mysqli_query($mysqli, $sql_chitiet);
$row_chitiet = mysqli_fetch_array($query_chitiet);


$sql_danhgia = "SELECT * FROM tbl_danhgia WHERE tbl_danhgia.id_sanpham='$_GET[id]' AND trangthai IN (1, 2) ORDER BY id_danhgia DESC";
$query_danhgia = mysqli_query($mysqli, $sql_danhgia);

$sql_trungbinh = "SELECT AVG(sao) AS avg_sao, COUNT(id_sanpham) AS count_id FROM tbl_danhgia WHERE tbl_danhgia.id_sanpham='$_GET[id]' AND trangthai IN (1, 2) ORDER BY id_danhgia DESC";
$query_trungbinhsao = mysqli_query($mysqli, $sql_trungbinh);
$tb = (mysqli_fetch_array($query_trungbinhsao));
$sao = $tb['avg_sao'];
$count_id = $tb['count_id'];

if ($count_id > 0) {
    $sql_5sao = "SELECT COUNT(id_sanpham) AS namsao FROM tbl_danhgia WHERE tbl_danhgia.id_sanpham='$_GET[id]' AND tbl_danhgia.sao = 5 AND trangthai IN (1, 2) ORDER BY id_danhgia DESC";
    $tb_5sao = mysqli_fetch_array($query_5sao = mysqli_query($mysqli, $sql_5sao));
    // $tb_sao5 = mysqli_fetch_array($query_5sao);
    $sql_4sao = "SELECT COUNT(id_sanpham) AS bonsao FROM tbl_danhgia WHERE tbl_danhgia.id_sanpham='$_GET[id]' AND tbl_danhgia.sao = 4 AND trangthai IN (1, 2) ORDER BY id_danhgia DESC";
    $tb_4sao = mysqli_fetch_array($query_4sao = mysqli_query($mysqli, $sql_4sao));

    $sql_3sao = "SELECT COUNT(id_sanpham) AS basao FROM tbl_danhgia WHERE tbl_danhgia.id_sanpham='$_GET[id]' AND tbl_danhgia.sao = 3 AND trangthai IN (1, 2) ORDER BY id_danhgia DESC";
    $tb_3sao = mysqli_fetch_array($query_3sao = mysqli_query($mysqli, $sql_3sao));

    $sql_2sao = "SELECT COUNT(id_sanpham) AS haisao FROM tbl_danhgia WHERE tbl_danhgia.id_sanpham='$_GET[id]' AND tbl_danhgia.sao = 2 AND trangthai IN (1, 2) ORDER BY id_danhgia DESC";
    $tb_2sao = mysqli_fetch_array($query_2sao = mysqli_query($mysqli, $sql_2sao));

    $sql_1sao = "SELECT COUNT(id_sanpham) AS motsao FROM tbl_danhgia WHERE tbl_danhgia.id_sanpham='$_GET[id]' AND tbl_danhgia.sao = 1 AND trangthai IN (1, 2) ORDER BY id_danhgia DESC";
    $tb_1sao = mysqli_fetch_array($query_1sao = mysqli_query($mysqli, $sql_1sao));

    $namsao = $tb_5sao['namsao'] * 100 / $count_id;
    $bonsao = $tb_4sao['bonsao'] * 100 / $count_id;
    $basao = $tb_3sao['basao'] * 100 / $count_id;
    $haisao = $tb_2sao['haisao'] * 100 / $count_id;
    $motsao = $tb_1sao['motsao'] * 100 / $count_id;
}

?>
<!-- hiển thị đánh giá sp     -->
<div style="width:100%;">
    <div style="border:0px solid; margin: 1% 0.5%;border-radius:10px;box-shadow: 0px 6px 11px 2px rgba(0, 0, 0, 0.3); padding-bottom:2%">
        <h3 style="padding-top: 1%; padding-left:4%">Đánh giá <?php echo $row_chitiet['tensanpham'] ?></h3>
        <hr>
        <table border="1" style="width:90%; margin: 10px 4% 2%;">
            <tr>
                <td style="width:40%; height:70px; text-align:center; padding:3% 0; border-right:1px solid">
                    <?php
                    if ($sao == 0) { //nếu giá trị sao trung bình lấy từ cột sao theo id sp bằng 0 thì hiển thị sao xám
                    ?>

                        <b style="font-size:30px">0/5</b><br>
                        <?php
                        // Hiển thị số icon sao tương ứng với số sao trong cột sao
                        for ($i = 0; $i < 5; $i++) {
                            echo "<i class='fa fa-star fa-fw' style='color: #CCCCCC ; font-size: 30px; margin: 3% 3% 5%;'></i>";
                        }
                        ?>
                        <br><b>Đánh giá (<?php echo $count_id ?>)</b>
                    <?php
                    } else {
                    ?>
                        <b style="font-size: 30px;"><?php echo number_format($sao, 1) ?>/5</b><br>
                        <b><?php echo drawStarRating(number_format($sao, 1)) ?></b><br>
                        <b>Đánh giá (<?php echo $count_id ?>)</b>
                </td>
            <?php
                    }
                    if ($sao == 0) { //nếu giá trị sao trung bình lấy từ cột sao theo id sp bằng 0 thì hiển thị sao xám
            ?>
                <td style="padding-left: 2%;">
                    <ul>
                        <li style="display: flex;padding-top:2%">

                            <div>
                                <b>5</b> <i class='fa fa-star fa-fw' style='color: #FFD700 ;font-size:17px'></i>
                            </div>
                            <div class="star_line">
                                <p class="star_line_avg" style="width:0%"></p>
                            </div>
                            <div style="margin-left: 3%;">0%</div>
                        </li>
                        <li style="display: flex;padding-top:1%">
                            <div>
                                <b>4</b> <i class='fa fa-star fa-fw' style='color: #FFD700 ;font-size:17px'></i>
                            </div>
                            <div class="star_line">
                                <p class="star_line_avg" style="width:0%"></p>
                            </div>
                            <div style="margin-left: 3%;">0%</div>
                        </li>
                        <li style="display: flex;padding-top:1%">

                            <div>
                                <b>3</b> <i class='fa fa-star fa-fw' style='color: #FFD700 ;font-size:17px'></i>
                            </div>
                            <div class="star_line">
                                <p class="star_line_avg" style="width:0%"></p>
                            </div>
                            <div style="margin-left: 3%;">0%</div>
                        </li>
                        <li style="display: flex;padding-top:1%">

                            <div>
                                <b>2</b> <i class='fa fa-star fa-fw' style='color: #FFD700 ;font-size:17px'></i>
                            </div>
                            <div class="star_line">
                                <p class="star_line_avg" style="width:0%"></p>
                            </div>
                            <div style="margin-left: 3%;">0%</div>
                        </li>
                        <li style="display: flex;padding-top:1%">

                            <div>
                                <b>1</b> <i class='fa fa-star fa-fw' style='color: #FFD700 ;font-size:17px; margin-left:2px'></i>
                            </div>
                            <div class="star_line">
                                <p class="star_line_avg" style="width:0%"></p>
                            </div>
                            <div style="margin-left: 3%;">0%</div>
                        </li>
                    </ul>
                </td>
            <?php
                    } else {
            ?>
                <td style="padding-left: 2%;">
                    <ul>
                        <li style="display: flex;padding-top:2%">

                            <div>
                                <b>5</b> <i class='fa fa-star fa-fw' style='color: #FFD700 ;font-size:17px'></i>
                            </div>
                            <div class="star_line">
                                <p class="star_line_avg" style="width:<?php echo $namsao ?>%"></p>
                            </div>
                            <div style="margin-left: 3%;">
                                <?php echo number_format($namsao) . '%' ?>
                            </div>
                        </li>
                        <li style="display: flex;padding-top:1%">
                            <div>
                                <b>4</b> <i class='fa fa-star fa-fw' style='color: #FFD700 ;font-size:17px'></i>
                            </div>
                            <div class="star_line">
                                <p class="star_line_avg" style="width:<?php echo $bonsao ?>%"></p>
                            </div>
                            <div style="margin-left: 3%;"><?php echo number_format($bonsao) . '%' ?></div>
                        </li>
                        <li style="display: flex;padding-top:1%">

                            <div>
                                <b>3</b> <i class='fa fa-star fa-fw' style='color: #FFD700 ;font-size:17px'></i>
                            </div>
                            <div class="star_line">
                                <p class="star_line_avg" style="width:<?php echo $basao ?>%"></p>
                            </div>
                            <div style="margin-left: 3%;"><?php echo number_format($basao) . '%' ?></div>
                        </li>
                        <li style="display: flex;padding-top:1%">

                            <div>
                                <b>2</b> <i class='fa fa-star fa-fw' style='color: #FFD700 ;font-size:17px'></i>
                            </div>
                            <div class="star_line">
                                <p class="star_line_avg" style="width:<?php echo $haisao ?>%"></p>
                            </div>
                            <div style="margin-left: 3%;"><?php echo number_format($haisao) . '%' ?></div>
                        </li>
                        <li style="display: flex;padding-top:1%">

                            <div>
                                <b>1</b> <i class='fa fa-star fa-fw' style='color: #FFD700 ;font-size:17px; margin-left:2px'></i>
                            </div>
                            <div class="star_line">
                                <p class="star_line_avg" style="width:<?php echo $motsao ?>%"></p>
                            </div>
                            <div style="margin-left: 3%;"><?php echo number_format($motsao) . '%' ?></div>
                        </li>
                    </ul>

                </td>
            <?php
                    }
            ?>
            </tr>
        </table>
        <!-- //đánh giá của người mua -->
        <?php
        while ($row = (mysqli_fetch_array($query_danhgia))) {
            $sao_dg = $row['sao'];
            $id_danhgia = $row['id_danhgia'];

            $name = $row['name'];
            // Tạo avatar ngẫu nhiên dựa trên tên của khách hàng
            $avatarBackgroundColors = array("#006633", "#993366", "#003366", "#990000", "#999900", "#003300", "#0066CC"); // Mảng chứa các màu nền cho avatar
            $avatarColor = $avatarBackgroundColors[array_rand($avatarBackgroundColors)]; // Chọn ngẫu nhiên một màu nền từ mảng
            // Chỉ lấy ký tự đầu tiên của tên khách hàng
            $avatarInitial = mb_substr($name, 0, 1);
        ?>
            <div style="clear: both;"></div>
            <table border="0" style="width:90%; margin: 10px 4% 1%; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);border-radius:8px">
                <tr>
                    <td style=" padding: 1% 0 10px; padding-left: 15px;vertical-align: middle;" colspan="2">
                        <div style="display: flex;">
                            <div style="background-color: <?php echo $avatarColor; ?>; width: 45px;height: 45px; text-align:center;padding:10px; border-radius:35px; ">
                                <b class="initials" style="color: white; font-size:18px"><?php echo $avatarInitial; ?></b>
                            </div>

                            <div style="margin-left: 6px; margin-top: 10px; width:50%">
                                <b style="font-size: 19px;"><?php echo $row['name'] ?></b>
                            </div>

                            <div style="text-align: right; width:45%">
                                <p style="opacity:0.5; margin-top:1%"><?php echo $row['thoigian'] ?></p>
                            </div>
                        </div>

                    </td>
                </tr>
                <tr>
                    <td style="padding-left: 65px; padding-bottom:8px">
                        <?php
                        // Hiển thị số icon sao tương ứng với số sao trong cột sao
                        for ($i = 0; $i < $sao_dg; $i++) {
                            echo "<i class='fa fa-star fa-fw' style='color: #FFBF00'></i>";
                        }
                        ?>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="2" style=" padding:0 67px;">
                        <p style="pointer-events: none;margin-bottom:0px; opacity: 0.8; line-height:1.6"> <?php echo $row['noidung_dg'] ?> </p>
                    </td>
                </tr>
                <?php
                $sql_rep = "SELECT * FROM tbl_repcoment WHERE id_danhgia = $id_danhgia ORDER BY id_rep DESC";
                $query_rep = mysqli_query($mysqli, $sql_rep);
                while ($result_rep = mysqli_fetch_array($query_rep)) {
                ?>
                    <tr>
                        <!-- <td rowspan="2"></td> -->
                        <td colspan="2" style=" padding:0 1% 0 4%;">
                            <hr color="#BBBBBB">
                            <b style="font-size: 18px;font-family: Roboto, sans-serif !important; color:red;"><i class="fa-solid fa-user"></i> Quản Trị Viên</b>

                            <p style="opacity:0.5; margin-bottom:0; float:right; pointer-events: none;"><i class="fa-regular fa-clock"></i> <?php echo $result_rep['thoigian'] ?></p>
                        </td>

                    </tr>
                    <tr>
                        <td colspan="3" style=" padding: 0 30px 15px 0px; text-align:justify">
                            <div style="width:100%">
                                <p style="pointer-events: none; opacity: 0.7; margin: 5px 0px 0 6%; font-size:16px; line-height:1.6"> <?php echo $result_rep['noidung_rep'] ?> </p>
                            </div>
                        </td>

                    </tr>
                <?php
                }
                ?>
            </table>



        <?php
        }
        function drawStarRating($rating)
        {
            // Số lượng sao tối đa là 5
            $maxStars = 5;
            // Tính toán phần trăm của số lẻ để xác định màu của từng sao
            $fraction = $rating - floor($rating);
            // Sử dụng một vòng lặp để vẽ các biểu tượng sao
            for ($i = 1; $i <= $maxStars; $i++) {
                // Tính toán màu cho từng sao dựa trên phần trăm số lẻ
                if ($i <= $rating) {
                    // Nếu sao đang được đánh giá, sử dụng màu vàng
                    $starColor = 'color: #FFD700;';
                } elseif ($i - 1 < $rating) {
                    // Nếu sao gần với phần trăm số lẻ, tính toán màu dựa trên phần trăm
                    $colorFraction = 255 * $fraction;
                    $starColor = "color: rgb(255, $colorFraction, 0);";
                } else {
                    // Nếu sao không được đánh giá, sử dụng màu xám
                    $starColor = 'color: #CCCCCC;';
                }
                // Hiển thị biểu tượng sao với màu tương ứng
                echo "<i class='fa fa-star fa-fw' style='$starColor; font-size:30px; margin: 3% 2% 4%;'></i>";
            }
        }

        ?>
    </div>
</div>