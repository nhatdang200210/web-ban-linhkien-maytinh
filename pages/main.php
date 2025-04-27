<div class="main">
    <?php
    if (isset($_GET['quanly'])) {
        $tam = $_GET['quanly'];
    } else {
        $tam = '';
    }
    //đăng nhập
    if ($tam == 'login') {
        include("main/login.php");
    }
    //đăng ký
    elseif ($tam == 'dangky') {
        include("main/dangky.php");
    }
    //giỏ hàng
    elseif ($tam == 'giohang') {
        include("main/card/giohang.php");
    }
    //vận chuyển
    elseif ($tam == 'vanchuyen') {
        include("main/card/vanchuyen.php");
    }
    //thông tin thanh toán
    elseif ($tam == 'thongtinthanhtoan') {
        include("main/card/thongtinthanhtoan.php");
    }
    //đơn hàng đã đặt
    elseif ($tam == 'dondadat') {
        include("main/card/dondadat.php");
    }
    //all đơn hàng
    elseif ($tam == 'donmua') {
        include("main/donmua/all.php");
    }
    //đơn hàng đang xử lý
    elseif ($tam == 'dangxuly') {
        include("main/donmua/dangxuly.php");
    }
    //đơn hàng đang giao
    elseif ($tam == 'danggiao') {
        include("main/donmua/danggiao.php");
    }
    //đơn hàng đa giao
    elseif ($tam == 'dagiao') {
        include("main/donmua/dagiao.php");
    }
    //đơn hàng đa giao
    elseif ($tam == 'huy') {
        include("main/donmua/huy.php");
    }
    //xem đơn hàng
    elseif ($tam == 'xemdonhang') {
        include("main/donmua/xemdonhang.php");
    }
    //tin tức
    elseif ($tam == 'tintuc') {
        include("main/tintuc/alltin.php");
    }
    //chi tiết tin tức
    elseif ($tam == 'chitiettin') {
        include("main/tintuc/chitiet.php");
    }
    //chi tiét sản phẩm
    elseif ($tam == 'chitietsp') {
        include("main/sanpham/chitietsp.php");
    }
    //sp theo danh mục
    elseif ($tam == 'sptheodm') {
        include("main/sanpham/sptheodm.php");
    }
    //tài khoản
    elseif ($tam == 'taikhoan') {
        include("main/user/taikhoan.php");
    }
    //địa chỉ
    elseif ($tam == 'diachi') {
        include("main/user/diachi.php");
    }
    //địa chỉ
    elseif ($tam == 'doimatkhau') {
        include("main/user/doimatkhau.php");
    }
    //tìm kiếm
    elseif ($tam == 'timkiem') {
        include("main/timkiem.php");
    }
    //tìm kiếm dơn mua
    elseif ($tam == 'timkiemdonmua') {
        include("main/donmua/timkiemdonmua.php");
    }
    
    //trang chủ
    else {
        include 'main/index.php';
    }

    ?>
</div>