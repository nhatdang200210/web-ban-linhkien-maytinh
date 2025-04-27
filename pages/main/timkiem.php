<?php
// Kiểm tra xem người dùng đã nhập từ khóa tìm kiếm chưa
if (isset($_POST['timkiem']) && !empty($_POST['tukhoa'])) {
    // Lấy từ khóa tìm kiếm từ biến POST
    $tukhoa = $_POST['tukhoa'];

    // Thực hiện truy vấn SQL để lấy sản phẩm phù hợp với từ khóa tìm kiếm
    $sql_pro = "SELECT * FROM tbl_sanpham WHERE tensanpham LIKE '%$tukhoa%' ";
    $query_pro = mysqli_query($mysqli, $sql_pro);

    // Hiển thị từ khoá tìm kiếm
    echo "<h4 style='text-align:center'>Kết quả tìm kiếm: $tukhoa</h4><hr>";

    // Kiểm tra xem có sản phẩm phù hợp không
    if (mysqli_num_rows($query_pro) > 0) {
?>
        </head>
        <title>An Phát Computer - Search: <?php echo $tukhoa ?></title>
        </head>

        <div class="layout">
            <?php
            while ($row = mysqli_fetch_array($query_pro)) {

                $id_sanpham = $row['id_sanpham'];
                $sql_sao = "SELECT AVG(sao) AS avg_sao FROM tbl_danhgia WHERE id_sanpham = '$id_sanpham' AND trangthai IN (1, 2)";
                $query_sao = mysqli_query($mysqli, $sql_sao);
                $result_sao = mysqli_fetch_array($query_sao);
                $sao = $result_sao['avg_sao'];
                if (isset($_SESSION['dangky'])) {
                    $gia = $row['giasanpham'];
                    $tien = $gia - $gia * 5 / 100;
                } else {
                    $gia = $row['giasanpham'];
                    $tien = $gia;
                }
                // $sao = $row['avg_sao'];
                // if(isset($_SESSION['id_khachhang'])) {
                //     $id_nguoidung = $_SESSION['id_khachhang'];

                //     // Kiểm tra xem người dùng đã yêu thích sản phẩm này hay chưa
                //     // $sql_check_like = "SELECT * FROM tbl_yeuthich WHERE product_id = '$row[id_sanpham]' AND id_dangky = '$id_nguoidung'";
                //     // $result_check_like = mysqli_query($mysqli, $sql_check_like);
                //     // $num_rows_like = mysqli_fetch_array($result_check_like);
                // }
            ?>
                <div class="item">
                    <a href="index.php?quanly=chitietsp&id=<?php echo $row['id_sanpham'] ?>">
                        <div class="img-sp">
                            <img src="admin/modules/quanlysanpham/uploads/<?php echo $row['avatar'] ?>" alt="">
                        </div>
                        <div class="title-sp">
                            <div class="ten">
                                <h5>
                                    <!-- <?php echo $row['tensanpham'] ?> -->
                                    <?php
                                    $tensanpham = $row['tensanpham'];
                                    if (strlen($tensanpham) > 100) {
                                        echo substr($tensanpham, 0, 100) . ' ';
                                    } else {
                                        echo $tensanpham;
                                    }
                                    ?>
                                </h5>
                            </div>
                            <div class="price">
                                <p class="price_show"><?php echo number_format($tien, 0, ',', '.') . 'vnđ' ?></p>
                                <?php
                                if (isset($_SESSION['dangky'])) {
                                ?>
                                    <p class="price_through"><?php echo number_format($row['giasanpham'], 0, ',', '.') . 'vnđ' ?></p>
                                <?php
                                }
                                ?>
                            </div>
                            <div class="cmt">
                                <div class="sao">
                                    <?php
                                    if ($sao == 0) { //nếu giá trị sao trung bình lấy từ cột sao theo id sp bằng 0 thì hiển thị sao xám

                                    } else {
                                    ?>
                                        <div style="display: flex; flex-wrap:nowrap; width:100%"><?php echo drawStarRatings(number_format($sao, 1)) ?></div>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="like">
                                    <button type="submit" name="bo_yeu_thich" class="btn">
                                        <i class="fa fa-heart"></i>
                                    </button>
                                </div>
                            </div>
                            <?php
                            if (isset($_SESSION['dangky'])) {
                            ?>
                                <div class="sale">
                                    <p>
                                        Giảm 5%
                                    </p>
                                </div>
                            <?php } ?>
                        </div>
                    </a>
                </div>
            <?php
            }

            function drawStarRatings($rating)
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
                        // $starColor = 'color: #CCCCCC;';
                    } else {
                        // Nếu sao không được đánh giá, sử dụng màu xám
                        $starColor = 'color: #CCCCCC;';
                    }
                    // Hiển thị biểu tượng sao với màu tương ứng
                    echo "<h4 style='width:15%'><i class='fa fa-star fa-fw' style='$starColor; margin: 30% 1% 4%;'></i></h4>";
                }
            }
            ?>
        </div>
<?php
    } else {
        // Hiển thị thông báo nếu không tìm thấy sản phẩm nào phù hợp
        echo "<p>Không tìm thấy sản phẩm phù hợp với từ khoá tìm kiếm.</p>";
    }
} else {
    // Hiển thị thông báo yêu cầu nhập từ khóa tìm kiếm
    echo "<p>Vui lòng nhập từ khóa tìm kiếm.</p>";
}
?>