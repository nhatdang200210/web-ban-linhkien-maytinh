<?php
if (isset($_GET['trang'])) {
    $page = $_GET['trang'];
} else {
    $page = '1';
}
if ($page == '' || $page == 1) {
    $begin = 0;
} else {
    $begin = ($page * 16) - 16;
}

// Mặc định sắp xếp theo ID giảm dần
$order_by = "tbl_sanpham.id_sanpham DESC";

// Kiểm tra xem có lựa chọn sắp xếp không
if (isset($_GET['sort'])) {
    if ($_GET['sort'] == 'NONE') {
        $order_by = "tbl_sanpham.id_sanpham DESC";
    } elseif ($_GET['sort'] == 'ASC') {
        $order_by = "tbl_sanpham.giasanpham ASC";
    } else {
        $order_by = "tbl_sanpham.giasanpham DESC";
    }
}

$sql_pro = "SELECT tbl_sanpham.*, tbl_danhmuc.*, AVG(sao) AS avg_sao 
       FROM tbl_sanpham 
       LEFT JOIN tbl_danhmuc ON tbl_sanpham.id_danhmuc = tbl_danhmuc.id_danhmucsp 
    --    LEFT JOIN tbl_yeuthich ON tbl_sanpham.id_sanpham = tbl_yeuthich.product_id 
       LEFT JOIN tbl_danhgia ON tbl_danhgia.id_sanpham=tbl_sanpham.id_sanpham
        WHERE tbl_sanpham.tinhtrang = 1 
       GROUP BY tbl_sanpham.id_sanpham
       ORDER BY $order_by 
       LIMIT $begin, 16";

$query_pro = mysqli_query($mysqli, $sql_pro);
?>
<div class="all_item">
    <!-- <div class="title_all_sp">
        <h2 style="text-align:center;">Các sản phẩm tại N&NStore</h2>
    </div> -->


    <div class="cf-title-02 cf-title-alt-two title_all_sp">
        <h2>Các sản phẩm tại An Phát Computer<br />
            <span>Mua ngay liền tay</span><br />
        </h2>
    </div>

    <hr style="margin-right: 10px; margin-bottom: 30px; border-width:2px ">
    <form method="GET">
        <label for="sort">Sắp xếp theo giá:</label>
        <select name="sort" id="sort">
            <option value="NONE" <?php if (isset($_GET['sort']) && $_GET['sort'] == "NONE") echo "selected"; ?>>none</option>
            <option value="ASC" <?php if (isset($_GET['sort']) && $_GET['sort'] == "ASC") echo "selected"; ?>>Tăng dần</option>
            <option value="DESC" <?php if (isset($_GET['sort']) && $_GET['sort'] == "DESC") echo "selected"; ?>>Giảm dần </option>
        </select>
        <input type="hidden" name="trang" value="<?php echo isset($_GET['trang']) ? $_GET['trang'] : 1; ?>">
        <button type="submit" class="bnt-sapxep">Áp dụng</button>
    </form>

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
</div>
<div style="clear: both;"></div>
<!-- <p>Trang:</p> -->
<?php
$sql_trang = mysqli_query($mysqli, "SELECT * FROM tbl_sanpham WHERE tinhtrang = 1");
$row_count = mysqli_num_rows($sql_trang);
$trang = ceil($row_count / 16);
?>

<ul class="list_trang">
    <?php
    for ($i = 1; $i <= $trang; $i++) {
    ?>
        <li <?php if ($i == $page) {
                echo 'style="background:chocolate"';
            } else {
                echo '';
            } ?>><a href="index.php?trang=<?php echo $i ?> "><?php echo $i ?></a></li>
    <?php
    }
    ?>
</ul>
<style>
    ul.list_trang {
        padding: 0;
        margin: 0;
        list-style: none;
        margin-left: 49%;
        margin-top: 1%;
        display: flex;
    }

    ul.list_trang li {
        /* float: left; */
        padding: 6px 7px;
        margin: 5px 3px;
        background: burlywood;
        display: block;
        width: 22px;
    }

    ul.list_trang li a {
        color: black;
        text-align: center;
        text-decoration: none;
        font-weight: 600;
    }


    .item {
        transition: all 0.3s ease;
    }

    .item:hover {
        transform: scale(1.01);
        /* Phóng to sản phẩm */
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
    }

    div.sale {
        height: 37px;
        left: 0px;
        position: absolute;
        top: 0px;
        width: 100px;
        border: 1px solid;
        border-top-left-radius: 12px;
        border-bottom-right-radius: 12px;
        /* width: 30%;
        height: 7%; */
        padding-left: 3%;
        padding-top: 2%;
        background-color: red;
        color: white;
        font-weight: 600;
        text-align: center;
    }

    .item {
        position: relative;
    }
</style>