<head>

</head>
<?php
$sql_lietke_danhmucsp = "SELECT * FROM tbl_danhmuc ORDER BY thutu ASC";
$query_lietke_danhmucsp = mysqli_query($mysqli, $sql_lietke_danhmucsp);

// $sql_lietke_donhang = "SELECT * FROM tbl_giohang,tbl_dangky WHERE tbl_giohang.id_khachhang=tbl_dangky.id_dangky ORDER BY id_cart DESC"; 
$sql_lietke_donhang = "SELECT *, COUNT(CASE WHEN tbl_cart.cart_status = 0 THEN 1 END) AS sodonmoi, COUNT(CASE WHEN tbl_cart.cart_status = 1 AND tbl_cart.giao = 0 THEN 1 END) AS danggiao
    FROM tbl_cart 
    ";

$query_lietke_donhang = mysqli_query($mysqli, $sql_lietke_donhang);
$row = mysqli_fetch_array($query_lietke_donhang);
$donmoi = $row['sodonmoi'];
$danggiao = $row['danggiao'];
?>
<div class="wrapper">
    <!-- Sidebar  -->
    <nav id="sidebar">
        <div class="sidebar-header">
            <h3>An Phát Computer</h3>
        </div>

        <ul class="list-unstyled components">

            <li>
                <a href="#danhmucSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle a"><i class="fa-solid fa-bars"></i> Danh mục sản phẩm</a>
                <ul class="collapse list-unstyled" id="danhmucSubmenu" style="font-size: 17px;">
                    <li class="bot">
                        <a href="index.php?action=quanlydanhmuc&query=them"><i class="fa-solid fa-circle-plus"></i> Thêm danh mục</a>
                    </li>
                    <li>
                        <a href="index.php?action=quanlydanhmuc&query=lietke"> <i class="fa-solid fa-clipboard"></i> Liệt kê danh mục</a>
                    </li>
                </ul>
            </li>
            <hr>
           
            <li>
                <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle a"><i class="fa-solid fa-headphones-simple"></i> Sản phẩm</a>
                <ul class="collapse list-unstyled" id="homeSubmenu">
                    <li style="border-bottom:1px solid white">
                        <a href="index.php?action=quanlysanpham&query=them"><i class="fa-solid fa-circle-plus"></i> Thêm sản phẩm</a>
                    </li>
                    <li class="bot">
                        <a href="#spSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle b">Các sản phẩm</a>
                        <ul class="collapse list-unstyled" id="spSubmenu">
                            <li class="bot">
                                <a href="index.php?action=quanlysanpham&query=lietkeall">Tất cả</a>
                            </li>
                            <?php
                            $i = 0;
                            while ($row = mysqli_fetch_array($query_lietke_danhmucsp)) {
                                $i++;
                            ?>
                                <li>
                                    <a href="index.php?action=quanlysanpham&query=lietke&id=<?php echo $row['id_danhmucsp'] ?>">
                                        <?php echo $i . '. ' . $row['tendanhmuc'] ?>
                                    </a>
                                </li>
                            <?php
                            }
                            ?>
                        </ul>
                    </li>

                </ul>
            </li>
            <hr>
            <li>
                <a href="#bv" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"> <i class="fa-solid fa-pen-nib"></i> Bài viết</a>
                <ul class="collapse list-unstyled" id="bv">
                    <li class="bot">
                        <a href="index.php?action=quanlybaiviet&query=them"><i class="fa-solid fa-pen-to-square"></i> Thêm bài viết </a>
                    </li>
                    <li>
                        <a href="index.php?action=quanlybaiviet&query=lietke"><i class="fa-solid fa-newspaper"></i> Tất cả bài viết </a>
                    </li>

                </ul>
            </li>
            <hr>
            <li>
                <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle a"> <i class="fa-solid fa-cart-plus"></i> Đơn hàng</a>
                <ul class="collapse list-unstyled" id="pageSubmenu">
                    <li class="bot">
                        <a href="index.php?action=quanlydonhang&query=donmoi">Đơn mới <i class="fa fa-bell" aria-hidden="true" style="font-size: 19px;"></i> (<?php echo $donmoi ?>)</a>
                    </li>
                    <li class="bot">
                        <a href="index.php?action=quanlydonhang&query=danggiao">Đang giao <i class="fa fa-truck" aria-hidden="true" style="font-size: 19px;"></i> (<?php echo $danggiao ?>)</a>
                    </li>
                    <li>
                        <a href="index.php?action=quanlydonhang&query=dagiao">Đã giao <i class="fa fa-calendar-check" aria-hidden="true" style="font-size: 19px;"></i> </a>
                    </li>
                </ul>
            </li>
            <hr>
            <li>
                <a href="index.php?action=quanlytaikhoan&query=lietketaikhoan" class="dropdown-item"> <i class="fa-regular fa-user"></i> Tài khoản</a>
            </li>
            <hr>
            <li>
                <a href="index.php?action=thongke&query=tuan" class="dropdown-item"> <i class="fa-regular fa-user"></i> Thống kê</a>
            </li>
            <hr>
            <?php
            $sql_danhgia = "SELECT * , COUNT(CASE WHEN trangthai = 1 THEN 2 END) AS moi,
                        COUNT(CASE WHEN trangthai = 2 THEN 1 END) AS rep
                        FROM tbl_danhgia";
            $query_danhgia = mysqli_query($mysqli, $sql_danhgia);
            $row = mysqli_fetch_array($query_danhgia);
            $moi = $row['moi'];
            $rep = $row['rep'];
            ?>
            <li>
                <a href="#thongke" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle a"> <i class="fa-solid fa-chart-simple"></i>Đánh giá</a>
                <ul class="collapse list-unstyled" id="thongke">
                    <li class="bot">
                        <a href="index.php?action=danhgia&query=cmtmoi">Mới <i class="fa-solid fa-comment-medical" style="font-size: 19px;"></i> (<?php echo $moi ?>)</a>
                    </li>
                    <li class="bot">
                        <a href="index.php?action=danhgia&query=darep">Đã trả lời <i class="fa-solid fa-circle-check" style="font-size: 19px;"></i></a>
                    </li>

                </ul>
            </li>
            <hr>
        </ul>
    </nav>

    <!-- Page Content  -->
    <div id="content">

        <nav class="navbar navbar-expand-lg navbar-light bg-light" style="margin-bottom:0.5%">
            <div class="container-fluid">
                <button type="button" id="sidebarCollapse" class="btn btn-info">
                    <i class="fas fa-align-left"></i>
                    <span>Menu</span>
                </button>
            </div>
        </nav>


        <div class="quanly">
            <?php
            if (isset($_GET['action']) && $_GET['query']) {
                $tam = $_GET['action'];
                $query = $_GET['query'];
            } else {
                $tam = '';
                $query = '';
            }
            //thêm danh mục
            if ($tam == 'quanlydanhmuc' && $query == 'them') {
                include 'modules/quanlydanhmuc/them.php';
            }
            //liêyj kê danh mục
            elseif ($tam == 'quanlydanhmuc' && $query == 'lietke') {
                include 'modules/quanlydanhmuc/lietke.php';
            }
            // sửa danh mục
            elseif ($tam == 'quanlydanhmuc' && $query == 'sua') {
                include 'modules/quanlydanhmuc/sua.php';
            }
            //Thêm sản phẩm
            elseif ($tam == 'quanlysanpham' && $query == 'them') {
                include 'modules/quanlysanpham/them.php';
            }
            //Sửa sản phẩm
            elseif ($tam == 'quanlysanpham' && $query == 'sua') {
                include 'modules/quanlysanpham/sua.php';
            }
            //Liệt kê sản phẩm theo danh mục
            elseif ($tam == 'quanlysanpham' && $query == 'lietke') {
                include 'modules/quanlysanpham/lietke.php';
            }
            //Liệt kê all sản phẩm
            elseif ($tam == 'quanlysanpham' && $query == 'lietkeall') {
                include 'modules/quanlysanpham/allsp.php';
            }
            //Liệt kê all tài khoản
            elseif ($tam == 'quanlytaikhoan' && $query == 'lietketaikhoan') {
                include 'modules/quanlytaikhoan/lietketaikhoan.php';
            }
            //Liệt kê đơn mới
            elseif ($tam == 'quanlydonhang' && $query == 'donmoi') {
                include 'modules/quanlydonhang/donmoi.php';
            }
            //Liệt kê đơn đang giao
            elseif ($tam == 'quanlydonhang' && $query == 'danggiao') {
                include 'modules/quanlydonhang/danggiao.php';
            }
            //Liệt kê đơn đã giao
            elseif ($tam == 'quanlydonhang' && $query == 'dagiao') {
                include 'modules/quanlydonhang/dagiao.php';
            }
            //Xem chi tiết đơn hàng
            elseif ($tam == 'quanlydonhang' && $query == 'xemdonhang') {
                include 'modules/quanlydonhang/xemdonhang.php';
            }
            //thêm bài viết
            elseif ($tam == 'quanlybaiviet' && $query == 'them') {
                include 'modules/quanlybaiviet/them.php';
            }
            //liệt kê bài viết
            elseif ($tam == 'quanlybaiviet' && $query == 'lietke') {
                include 'modules/quanlybaiviet/lietke.php';
            }
            //sửa bài viết
            elseif ($tam == 'quanlybaiviet' && $query == 'sua') {
                include 'modules/quanlybaiviet/sua.php';
            }
            // thống kê tuần
            elseif ($tam == 'thongke' && $query == 'tuan') {
                include 'modules/thongke/tuan.php';
            }
            // thống kê tháng
            elseif ($tam == 'thongke' && $query == 'thang') {
                include 'modules/thongke/thang.php';
            }
            // Thống kê năm
            elseif ($tam == 'thongke' && $query == 'nam') {
                include 'modules/thongke/nam.php';
            }
            //dánh giá mới
            elseif ($tam == 'danhgia' && $query == 'cmtmoi') {
                include 'modules/quanlybinhluan/cmtmoi.php';

            } elseif ($tam == 'danhgia' && $query == 'darep') {
                include 'modules/quanlybinhluan/darep.php';

            } elseif ($tam == 'danhgia' && $query == 'chitietdanhgia') {
                include 'modules/quanlybinhluan/chitietdanhgia.php';
            }
            ?>
        </div>
    </div>
</div>

<style>
    ul#homeSubmenu li a,
    ul#pageSubmenu li a,
    ul#danhmucSubmenu li a {
        /* color: red; */
        font-weight: 600;
    }

    ul#homeSubmenu,
    ul#danhmucSubmenu,
    ul#pageSubmenu {
        font-size: 17px;
        font-style: inherit;
    }

    *:hover a {
        text-decoration: none;
    }

    .dropdown-toggle,
    mn {
        color: white;
    }

    .dropdown-item {
        color: white
    }

    .fa-bars,
    .fa-headphones-simple,
    .fa-pen-nib,
    .fa-cart-plus,
    .fa-user,
    .fa-pen-to-square,
    .fa-newspaper,
    .fa-circle-plus,
    .fa-clipboard,
    .fa-chart-simple {
        font-size: 22px;
        padding-right: 6px;
    }

    .bot {
        border-bottom: 1px solid white;
    }
</style>