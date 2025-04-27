<?php
//chi tiết 1 sp
$sql_chitiet = "SELECT * FROM tbl_sanpham, tbl_danhmuc WHERE tbl_sanpham.id_danhmuc = tbl_danhmuc.id_danhmucsp AND tbl_sanpham.id_sanpham='$_GET[id]' LIMIT 1";
$query_chitiet = mysqli_query($mysqli, $sql_chitiet);
while ($row_chitiet = mysqli_fetch_array($query_chitiet)) {

    if (isset($_SESSION['dangky'])) {
        //lấy thông tin từ tbl đăng ký
        $id_dangky = $_SESSION['id_khachhang'];
        $gia = $row_chitiet['giasanpham'];
        $tien = $gia - $gia * 5 / 100;
    } else {
        $id_dangky = 0;
        $gia = $row_chitiet['giasanpham'];
        $tien = $gia;
    }


    // Lấy và phân tách các hình ảnh
    $hinhanh = explode(',', $row_chitiet['hinhanh']);
?>
    <div style="padding-top: 1%;">
        <a href="index.php" style="padding-right: 5px;">Trang chủ ></a>
        <a href="index.php?quanly=sptheodm&id=<?php echo $row_chitiet['id_danhmucsp'] ?>" style="padding-right: 5px;">
            <?php
            echo $row_chitiet['tendanhmuc'] . ' >';
            ?>
        </a>
        <a>
            <?php
            echo $row_chitiet['tensanpham']
            ?>
        </a>
    </div>
    <hr color="red" style="margin-bottom: 2%;">
    </head>
    <title>An Phát Store - <?php echo $row_chitiet['tensanpham'] ?></title>
    </head>
    <div class="chitiet">
        <div class="product">
            <!-- xử lý hiển thị nhiều hình ảnh -->
            <?php
            // Giả sử $row_chitiet là kết quả của truy vấn lấy thông tin sản phẩm
            $hinhanh = explode(',', $row_chitiet['hinhanh']);
            ?>
            <div class="pic">
                <div class="img-product">
                    <?php foreach ($hinhanh as $image) { ?>
                        <img class="img img-responsive image-hienthi" style="" src="admin/modules/quanlysanpham/uploads/<?php echo $image; ?>" alt="">
                    <?php } ?>
                </div>
                <div class="dots">
                    <div class="dot-left_bc dot_bc"><i class="fa fa-chevron-left" aria-hidden="true"></i></div>
                    <div class="dot-right_bc dot_bc"><i class="fa fa-chevron-right" aria-hidden="true"></i></div>
                </div>
                <!-- ảnh nhỏ minh hoạ điều hướng -->
                <div class="thumbnails">
                    <?php foreach ($hinhanh as $index => $image) { ?>
                        <img class="thumbnail" src="admin/modules/quanlysanpham/uploads/<?php echo $image; ?>" alt="">
                    <?php } ?>
                </div>
            </div>


            <div class="chitiet-product">
                <div class="name-product">
                    <h3 style="line-height: 1.5;"><?php echo $row_chitiet['tensanpham'] ?></h3>
                    <h5 style="line-height: 1.5;">Mã sản phẩm: <?php echo $row_chitiet['id_sanpham'] ?> </h5>
                    <h5 style="line-height: 1.5;">Số lượng sản phẩm: <?php echo $row_chitiet['soluong'] ?> </h5>
                    <div style="display: flex; flex-wrap:nowrap; ">
                        <h4 class="gia">Giá: <?php echo number_format($tien, 0, ',', '.') . 'vnđ' ?></h4>

                        <!-- <h5 class="gia_sale"><?php echo number_format($row_chitiet['giasanpham'], 0, ',', '.') . 'vnđ' ?></h5> -->
                        <?php
                        if (isset($_SESSION['dangky'])) {
                        ?>
                            <p class="price_through"><?php echo number_format($row_chitiet['giasanpham'], 0, ',', '.') . 'vnđ' ?></p>
                        <?php
                        }
                        ?>
                    </div>

                </div>

                <form action="pages/main/card/addcard.php?idsanpham=<?php echo $row_chitiet['id_sanpham'] ?>&idkhach=<?php echo $id_dangky ?>" method="POST">
                    <div>
                        <input class="themgiohang" type="submit" value="Thêm giỏ hàng" name="themgiohang">
                    </div>
                </form>
            </div>
        </div>
        <hr>
        <div class="thongtin">
            <div class="tabs">
                <ul id="tabs-nav">
                    <li><a href="#tab1">Thông tin chi tiết</a></li>
                    <!-- <li><a href="#tab2">Hình ảnh</a></li> -->
                </ul>
                <div id="tabs-content">
                    <div id="tab1" class="tab-content" style="text-align:justify;">
                        <div class="nd">
                            <div class="content-wrapper">
                                <?php echo $row_chitiet['noidung'] ?>
                            </div>
                            <div style="text-align: center;">
                                <button class="expand-btn">Xem thêm <i class="fa fa-arrow-down" aria-hidden="true"></i></button>
                            </div>
                        </div>

                        <div class="tskt">
                            <div style="border:0px solid; width:100%;text-align:center; padding:3% 0 1%; margin-top:1%">
                                <h2 style="font-weight:600; font-size:24px; opacity:0.8">Thông số kỹ thuật</h2>
                            </div>
                            <div class="chitietts">
                                <div class="content-wrapper1">
                                    <?php echo $row_chitiet['tomtat'] ?>
                                </div>

                            </div>
                            <div style="text-align: center;">
                                <button class="expand-btn1">Xem thêm <i class="fa fa-arrow-down" aria-hidden="true"></i></button>
                            </div>

                        </div>
                    </div>
                    <!-- <div id="tab2" class="tab-content">
                        <h2>hình ảnh</h2>
                        <p></p>
                    </div> -->
                </div>
            </div>
        </div>
    </div>

    <style>
        .dot_bc {
            font-size: 50px;
            position: absolute;
            top: 50%;
            transform: translateY(-105%);
            color: #aaaaaa47;
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

        .thumbnails {
            display: flex;
            justify-content: center;
            margin-top: 4%;
            /* border: 1px solid; */
        }

        .thumbnails img {
            width: 80px;
            height: auto;
            margin: 0 5px;
            cursor: pointer;
            /* border: 1px solid transparent; */
            transition: border-color 0.3s;
            border: 1px solid #686868;
            border-radius: 8px;
            padding: 0.6%;
        }

        .thumbnails img.selected {
            border: 1.5px solid blue;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // nội dung chính
            var contentWrapper = document.querySelector(".content-wrapper");
            var expandBtn = document.querySelector(".expand-btn");

            // Kiểm tra chiều cao của nội dung
            if (contentWrapper.scrollHeight <= 1000) {
                // Nếu nội dung ít hơn 1000px, ẩn nút "Xem thêm"
                expandBtn.style.display = 'none';
            } else {
                // Nếu nội dung lớn hơn 1000px, hiển thị nút "Xem thêm" và cho phép mở rộng/thu gọn

                expandBtn.addEventListener("click", function() {
                    if (contentWrapper.classList.contains("expanded")) {
                        contentWrapper.style.maxHeight = "1000px";
                        contentWrapper.classList.remove("expanded");
                        // expandBtn.textContent = "Xem thêm";
                        expandBtn.innerHTML = 'Xem thêm <i class="fa fa-arrow-down" aria-hidden="true"></i>';
                    } else {
                        contentWrapper.style.maxHeight = contentWrapper.scrollHeight + "px";
                        contentWrapper.classList.add("expanded");
                        // expandBtn.textContent = "Thu gọn";
                        expandBtn.innerHTML = 'Thu gọn <i class="fa fa-arrow-up" aria-hidden="true"></i>';
                    }
                });
            }

            // });

            //thông số kĩ thuật
            // document.addEventListener("DOMContentLoaded", function() {
            var contentWrapper1 = document.querySelector(".content-wrapper1");
            var expandBtn1 = document.querySelector(".expand-btn1");

            // Kiểm tra chiều cao của nội dung
            if (contentWrapper1.scrollHeight <= 340) {
                // Nếu nội dung ít hơn 340px, ẩn nút "Xem thêm"
                expandBtn1.style.display = 'none';
            } else {
                // Nếu nội dung lớn hơn 340px, hiển thị nút "Xem thêm" và cho phép mở rộng/thu gọn

                expandBtn1.addEventListener("click", function() {
                    if (contentWrapper1.classList.contains("expanded")) {
                        contentWrapper1.style.maxHeight = "340px"; //thu lại mức 900px
                        contentWrapper1.classList.remove("expanded");
                        // expandBtn1.textContent = "Xem thêm";
                        expandBtn1.innerHTML = 'Xem thêm <i class="fa fa-arrow-down" aria-hidden="true"></i>';
                    } else {
                        contentWrapper1.style.maxHeight = contentWrapper1.scrollHeight + "px";
                        contentWrapper1.classList.add("expanded");
                        // expandBtn1.textContent = "Thu gọn";
                        expandBtn1.innerHTML = 'Thu gọn <i class="fa fa-arrow-up" aria-hidden="true"></i>';
                    }
                });
            }

        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const imgProduct = document.querySelector('.img-product');
            const images = Array.from(imgProduct.querySelectorAll('img'));
            const thumbnails = Array.from(document.querySelectorAll('.thumbnail'));
            let currentIndex = 0;

            function updateImages() {
                images.forEach((img, index) => {
                    img.style.display = index === currentIndex ? 'block' : 'none';
                });
                thumbnails.forEach((thumb, index) => {
                    thumb.classList.toggle('selected', index === currentIndex);
                });
            }

            document.querySelector('.dot-left_bc').addEventListener('click', function() {
                currentIndex = (currentIndex - 1 + images.length) % images.length;
                updateImages();
            });

            document.querySelector('.dot-right_bc').addEventListener('click', function() {
                currentIndex = (currentIndex + 1) % images.length;
                updateImages();
            });

            thumbnails.forEach((thumb, index) => {
                thumb.addEventListener('click', function() {
                    currentIndex = index;
                    updateImages();
                });
            });

            updateImages();
        });
    </script>
<?php
    include('danhgiasp.php');
}
?>
<style>

</style>