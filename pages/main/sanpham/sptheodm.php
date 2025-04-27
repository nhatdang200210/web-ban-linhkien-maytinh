<?php
// // Mặc định sắp xếp theo ID giảm dần
$order_by = "tbl_sanpham.id_sanpham DESC";

// // Kiểm tra xem có lựa chọn sắp xếp không
// if (isset($_GET['sort'])) {
//     if ($_GET['sort'] == 'NONE') {
//         $order_by = "tbl_sanpham.id_sanpham DESC";
//     } elseif ($_GET['sort'] == 'ASC') {
//         $order_by = "tbl_sanpham.giasanpham ASC";
//     } else {
//         $order_by = "tbl_sanpham.giasanpham DESC";
//     }
// }

$sql_pro = "SELECT tbl_sanpham.*
       FROM tbl_sanpham 
       
       WHERE tbl_sanpham.id_danhmuc = '$_GET[id]' AND tbl_sanpham.tinhtrang = 1
    --    LEFT JOIN tbl_yeuthich ON tbl_sanpham.id_sanpham = tbl_yeuthich.product_id 
    --    LEFT JOIN tbl_danhgia ON tbl_danhgia.masanpham_dg=tbl_sanpham.id_sanpham
       GROUP BY tbl_sanpham.id_sanpham 
       ORDER BY $order_by";

$query_pro = mysqli_query($mysqli, $sql_pro);

//lấy tên danh mục sản phẩm
$sql_name = "SELECT * FROM tbl_danhmuc WHERE tbl_danhmuc.id_danhmucsp = '$_GET[id]' LIMIT 1";
$query_name = mysqli_query($mysqli, $sql_name);
$row_tendanhmuc = mysqli_fetch_array($query_name);
?>
<div>
    <a href="index.php" style="padding-right: 5px;">Trang chủ ></a>
    <a href="index.php?quanly=sptheodm&id=<?php echo $row_tendanhmuc['id_danhmucsp'] ?>" style="padding-right: 5px;">
        <?php
        echo $row_tendanhmuc['tendanhmuc'];
        ?>
    </a>
</div>
</head>
<title>An Phát Store - <?php echo $row_tendanhmuc['tendanhmuc'] ?></title>
</head>
<div class="all_item">
    <div class="cf-title-02 cf-title-alt-two title_all_sp">
        <h2>Các sản phẩm <?php echo $row_tendanhmuc['tendanhmuc'] ?><br />
            <span>Mua ngay liền tay</span><br />
        </h2>
    </div>
    <hr style="margin-right: 10px; margin-bottom: 30px; border-width:2px ">
    <!-- <form method="GET">
        <label for="sort">Sắp xếp theo giá:</label>
        <select name="sort" id="sort">
            <option value="NONE" <?php if (isset($_GET['sort']) && $_GET['sort'] == "NONE") echo "selected"; ?>>none</option>
            <option value="ASC" <?php if (isset($_GET['sort']) && $_GET['sort'] == "ASC") echo "selected"; ?>>Tăng dần</option>
            <option value="DESC" <?php if (isset($_GET['sort']) && $_GET['sort'] == "DESC") echo "selected"; ?>>Giảm dần </option>
        </select>
       
        <button type="submit" class="bnt-sapxep">Áp dụng</button>
    </form> -->

    <div class="layout">
        <?php
        while ($row = mysqli_fetch_array($query_pro)) {
            $gia = $row['giasanpham'];
            $tien = $gia - $gia * 10 / 100;
            $id_sanpham = $row['id_sanpham'];
            $sql_sao = "SELECT AVG(sao) AS avg_sao FROM tbl_danhgia WHERE id_sanpham = '$id_sanpham' AND trangthai = 1";
            $query_sao = mysqli_query($mysqli, $sql_sao);
            $result_sao = mysqli_fetch_array($query_sao);
            $sao = $result_sao['avg_sao'];
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
                            <p class="price_show"><?php echo number_format($row['giasanpham'], 0, ',', '.') . 'vnđ' ?></p>
                            <p class="price_through"><?php echo number_format($tien, 0, ',', '.') . 'vnđ' ?></p>
                        </div>
                        <div class="cmt">
                            <div class="sao">

                                <?php
                                if ($sao == 0) { //nếu giá trị sao trung bình lấy từ cột sao theo id sp bằng 0 thì hiển thị sao xám
                                    // Hiển thị số icon sao tương ứng với số sao trong cột sao
                                    // for ($i = 0; $i < 5; $i++) {
                                    //     echo "<i class='fa fa-star fa-fw' style='color: #CCCCCC ; font-size: 25px; margin: 3% 1% 0%;'></i>"; 
                                    // }
                                } else {
                                ?>
                                    <div style="display: flex; flex-wrap:nowrap; width:100%"><?php echo drawStarRating(number_format($sao, 1)) ?></div>
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
        ?>
    </div>
</div>
<style>
    .item {
        transition: all 0.3s ease;
    }

    .item:hover {
        transform: scale(1.01);
        /* Phóng to sản phẩm */
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
    }

    div.sale {
        height: 31px;
        left: 0px;
        position: absolute;
        top: 0px;
        width: 80px;
        border: 1px solid;
        border-top-left-radius: 12px;
        border-bottom-right-radius: 12px;
        width: 30%;
        height: 7%;
        padding-left: 3%;
        padding-top: 2%;
        background-color: red;
        color: white;
        font-weight: 600;
    }

    .item {
        position: relative;
    }

    .return {
        background-color: #E9E9E9;

    }
</style>
<?php

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