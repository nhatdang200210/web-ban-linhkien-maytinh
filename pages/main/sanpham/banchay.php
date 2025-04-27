<?php
$number = 10;


$sql_pro = "SELECT tbl_sanpham.*, tbl_danhmuc.*, 
SUM(tbl_cartdetail.soluongmua) AS soluongmua_count, 
AVG(sao) AS avg_sao
       FROM tbl_sanpham 
       LEFT JOIN tbl_danhmuc ON tbl_sanpham.id_danhmuc = tbl_danhmuc.id_danhmucsp 
    --    LEFT JOIN tbl_yeuthich ON tbl_sanphham.id_sanpham = tbl_yeuthich.product_id  
       LEFT JOIN tbl_danhgia ON tbl_danhgia.id_sanpham=tbl_sanpham.id_sanpham
       JOIN tbl_cartdetail ON tbl_cartdetail.id_sanpham = tbl_sanpham.id_sanpham
       WHERE 
        tbl_cartdetail.giao = 1
       GROUP BY tbl_sanpham.id_sanpham
       ORDER BY soluongmua_count DESC 
       LIMIT $number";

$query_pro = mysqli_query($mysqli, $sql_pro);


?>

<div class="banchay">
    <div class="title-bc">
        <h3>Các sản phẩm bán chạy</h3>
    </div>
    <div class="layout-bc slides_bc">
        <?php
        while ($row = mysqli_fetch_array($query_pro)) {

            $id_sanpham = $row['id_sanpham'];

            $soluongmua_count = $row['soluongmua_count'];

            $sql_sao = "SELECT AVG(sao) AS avg_sao FROM tbl_danhgia WHERE id_sanpham = '$id_sanpham' AND trangthai = 1";
            $query_sao = mysqli_query($mysqli, $sql_sao);
            $result_sao = mysqli_fetch_array($query_sao);
            $sao = $result_sao['avg_sao'];
            // $sao = $row['avg_sao'];
            // $soluongmua_count = $row['soluongmua_count'];
            if (isset($_SESSION['dangky'])) {
                $gia = $row['giasanpham'];
                $tien = $gia - $gia * 5 / 100;
            } else {
                $gia = $row['giasanpham'];
                $tien = $gia;
            }
            // if (isset($_SESSION['id_khachhang'])) {
            //     $id_nguoidung = $_SESSION['id_khachhang'];

            //     // Kiểm tra xem người dùng đã yêu thích sản phẩm này hay chưa
            //     // $sql_check_like = "SELECT * FROM tbl_yeuthich WHERE product_id = '$row[id_sanpham]' AND id_dangky = '$id_nguoidung'";
            //     // $result_check_like = mysqli_query($mysqli, $sql_check_like);
            //     // $num_rows_like = mysqli_fetch_array($result_check_like);
            // }
        ?>
            <div class="item slide_bc">
                <a href="index.php?quanly=chitietsp&id=<?php echo $row['id_sanpham'] ?>">
                    <div class="img-sp">
                        <img src="admin/modules/quanlysanpham/uploads/<?php echo $row['avatar'] ?>" alt="" style="width:100%">
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
                            <div class="like" style="">
                                <p style="color:black; margin:0; margin-top:0.5rem">Đã bán:<span id="like-count"> <?php echo $soluongmua_count; ?></p>
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
    <div class="dots">
        <div class="dot-left_bc dot_bc"><i class="fa fa-chevron-left" aria-hidden="true"></i></div>
        <div class="dot-right_bc dot_bc"><i class="fa fa-chevron-right" aria-hidden="true"></i></div>
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
        height: 37px;
        left: 0px;
        position: absolute;
        top: 0px;
        width: 100px;
        border: 1px solid;
        border-top-left-radius: 12px;
        border-bottom-right-radius: 12px;

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

    .title-bc {
        /* border: 1px solid; */
        text-align: center;
        color: cadetblue;
        padding-top: 10px;
        margin-top: 10px;
    }

    /* --------------------------------------------slide bán chạy--------------------- */

    .banchay {
        width: 100%;
        overflow: hidden;
        position: relative;
        border-radius: 10px;

        box-shadow: 0 0 8px rgba(0, 0, 0, 0.5);
        width: 100%;
        height: auto;
        margin-top: 20px;
        /* padding-left: 40px; */
    }

    .slides_bc {
        transition: 0.5s;
        align-items: center;
    }

    /* .dots {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
    } */

    .dot_bc {
        font-size: 40px;
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        color: #AAAAAA;
    }

    .dot_bc:hover {
        color: red;
    }

    .dot-left_bc {
        left: 0;
    }

    .dot-right_bc {
        right: 0;
    }
</style>
<script>
    const slides_bc = document.querySelector('.slides_bc');
    const imgs_bc = document.querySelectorAll('.slide_bc');
    const dotleft_bc = document.querySelector('.dot-left_bc');
    const dotright_bc = document.querySelector('.dot-right_bc');
    const indexItems_bc = document.querySelectorAll('.index-item_bc');
    const length_bc = imgs_bc.length;
    const slideWidth_bc = 100 / 4; // Kích thước của mỗi slide (%)
    let current_bc = 0;
    let direction = 'next';

    const handleChangeSlide_bc = (direction = 'next') => {
        if (direction === 'next') {
            if (current_bc === length_bc - 4) { //di chuyển đến slide thứ n-4 thì dừng
                current_bc = 0;
            } else {
                current_bc++;
            }
        } else {
            if (current_bc === 0) {
                current_bc = length_bc - 1;
            } else {
                current_bc--;
            }
        }
        const offset = -current_bc * slideWidth_bc;
        slides_bc.style.transform = `translateX(${offset}%)`;
        updateIndex_bc(current_bc);
    };

    let handleEventChangeSlide_bc = setInterval(handleChangeSlide_bc, 6000);

    dotright_bc.addEventListener('click', () => {
        clearInterval(handleEventChangeSlide_bc);
        handleChangeSlide_bc('next');
        handleEventChangeSlide_bc = setInterval(handleChangeSlide_bc, 6000);
    });

    dotleft_bc.addEventListener('click', () => {
        clearInterval(handleEventChangeSlide_bc);
        handleChangeSlide_bc('prev');
        handleEventChangeSlide_bc = setInterval(handleChangeSlide_bc, 6000);
    });

    indexItems_bc.forEach((item_bc, index_bc) => {
        item_bc.addEventListener('click', () => {
            clearInterval(handleEventChangeSlide_bc);
            current_bc = index_bc;
            const offset = -current_bc * slideWidth_bc;
            slides_bc.style.transform = `translateX(${offset}%)`;
            updateIndex_bc(current_bc);
            handleEventChangeSlide_bc = setInterval(handleChangeSlide_bc, 6000);
        });
    });

    function updateIndex_bc(currentIndex_bc) {
        indexItems_bc.forEach((item_bc, index_bc) => {
            if (index_bc === currentIndex_bc) {
                item_bc.classList.add('active');
            } else {
                item_bc.classList.remove('active');
            }
        });
    }
</script>
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