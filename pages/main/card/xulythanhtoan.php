<?php
session_start(); // Bắt đầu phiên làm việc
// // if(isset($_SESSION['sp'])){}

// Xử lý thông tin thanh toán khi người dùng nhấn nút "Thanh toán"
include("../../../admin/config/conect.php");
if (isset($_POST['thanhtoanngay']) && isset($_SESSION['linhkien'])) {

    // Lấy thông tin từ form thong tin thanh toan
    $name = $_POST['name1'];
    $phone = $_POST['phone1'];
    $address = $_POST['address1'];
    $note = $_POST['note1'];
    $khach = $_POST['iddangky'];
    $cart_payment = $_POST['payment']; // Phương thức thanh toán được chọn


    if (isset($_SESSION['dangky'])) { // Lấy ID của khách hàng từ session
        $id_dangky = $_SESSION['id_khachhang'];
        // if ($sp_item['idkhach'] == $id_dangky) {

        // Thêm thông tin vào bảng tbl_nguoinhan
        $sql_insert_nguoinhan = "INSERT INTO tbl_nguoinhan (tennguoinhan, phonenguoinhan, diachinguoinhan, id_dangky, note)
                VALUES ('$name', '$phone', '$address', '$id_dangky', '$note')";
        $result_insert_nguoinhan = mysqli_query($mysqli, $sql_insert_nguoinhan);
        $id_nguoinhan = mysqli_insert_id($mysqli);
        echo 'nnnnn';
        // Thêm thông tin đơn hàng vào cơ sở dữ liệu
        $insert_cart = "INSERT INTO tbl_cart (id_dangky, cart_status, giao, cart_payment, id_nguoinhan, thoigiandathang, ngaygiaohang) 
                VALUE ('$id_dangky', 0, 0, '$cart_payment','$id_nguoinhan', NOW(), NOW())";
        $cart_query = mysqli_query($mysqli, $insert_cart);
        $madon = mysqli_insert_id($mysqli);

        $sql_shippingkhac = "DELETE FROM tbl_shippingkhac WHERE id_dangky = $id_dangky";
        mysqli_query($mysqli, $sql_shippingkhac);


        // Kiểm tra và xử lý các sản phẩm trong giỏ hàng, 
        if ($cart_query) {
            foreach ($_SESSION['linhkien'] as $key => $value) {   //Lặp qua từng sản phẩm trong giỏ hàng đã thanh toán
                if ($value['idkhach'] == $id_dangky) {  // Chỉ xử lý sản phẩm của khách hàng hiện tại
                    $id_sanpham = $value['id'];
                    $soluong = $value['soluong'];
                    // Thêm thông tin đơn hàng chi tiết vào cơ sở dữ liệu
                    $insert_donhang = "INSERT INTO tbl_cartdetail (madon, id_sanpham, soluongmua, giao, dg_status) 
                    SELECT '$madon', id_sanpham, '$soluong', 0, 0 FROM tbl_sanpham WHERE id_sanpham = '$id_sanpham'";
                    mysqli_query($mysqli, $insert_donhang);



                    //tạo bảng đánh giá sao rỗng
                    // $insert_danhgiasao = "INSERT INTO tbl_danhgiasao (id_sanpham_sao, madon, sao) SELECT '$id_sanpham', '$code_order',5";
                    // mysqli_query($mysqli, $insert_danhgiasao);

                    $update_soluong = "UPDATE tbl_sanpham 
                        SET soluong = soluong - $soluong
                        WHERE id_sanpham = '$id_sanpham'";
                    mysqli_query($mysqli, $update_soluong);

                    $update_tinhtrang = "UPDATE tbl_sanpham 
                        SET tinhtrang = 0
                        WHERE soluong = 0";
                    mysqli_query($mysqli, $update_tinhtrang);
                }
            }

            // Xóa giỏ hàng sau khi đã thanh toán
            unset($_SESSION['linhkien']);

            echo "<script>
                            alert('Bạn đã thanh toán thành công.');
                            window.location = '../../../index.php?quanly=dondadat';
                        </script>";
            exit(); // Kết thúc kịch bản
        } else {
            echo "Lỗi: Không thể tạo đơn hàng";
        }
    } else {
        $id_dangky = $khach;

        // Thêm thông tin vào bảng tbl_nguoinhan
        $sql_insert_nguoinhan = "INSERT INTO tbl_nguoinhan (tennguoinhan, phonenguoinhan, diachinguoinhan, id_dangky, note)
                VALUES ('$name', '$phone', '$address', '$id_dangky', '$note')";
        $result_insert_nguoinhan = mysqli_query($mysqli, $sql_insert_nguoinhan);
        $id_nguoinhan = mysqli_insert_id($mysqli);

        // Thêm thông tin đơn hàng vào cơ sở dữ liệu
        $insert_cart = "INSERT INTO tbl_cart (id_dangky, cart_status, giao, cart_payment, id_nguoinhan, thoigiandathang, ngaygiaohang) 
                        VALUE ('$id_dangky', 0, 0, '$cart_payment','$id_nguoinhan', NOW(), NOW())";
        $cart_query = mysqli_query($mysqli, $insert_cart);
        $madon = mysqli_insert_id($mysqli);

        $sql_shippingkhac = "DELETE FROM tbl_shippingkhac WHERE id_dangky = $id_dangky";
        mysqli_query($mysqli, $sql_shippingkhac);
        // Kiểm tra và xử lý các sản phẩm trong giỏ hàng, 
        if ($cart_query) {
            foreach ($_SESSION['linhkien'] as $key => $value) {   //Lặp qua từng sản phẩm trong giỏ hàng đã thanh toán
                $id_sanpham = $value['id'];
                $soluong = $value['soluong'];
                // Thêm thông tin đơn hàng chi tiết vào cơ sở dữ liệu
                $insert_donhang = "INSERT INTO tbl_cartdetail (madon, id_sanpham, soluongmua, giao, dg_status) 
                SELECT '$madon', id_sanpham, '$soluong', 0, 0 FROM tbl_sanpham WHERE id_sanpham = '$id_sanpham'";
                mysqli_query($mysqli, $insert_donhang);



                //tạo bảng đánh giá sao rỗng
                // $insert_danhgiasao = "INSERT INTO tbl_danhgiasao (id_sanpham_sao, madon, sao) SELECT '$id_sanpham', '$code_order',5";
                // mysqli_query($mysqli, $insert_danhgiasao);

                $update_soluong = "UPDATE tbl_sanpham 
                    SET soluong = soluong - $soluong
                    WHERE id_sanpham = '$id_sanpham'";
                mysqli_query($mysqli, $update_soluong);

                $update_tinhtrang = "UPDATE tbl_sanpham 
                    SET tinhtrang = 0
                    WHERE soluong = 0";
                mysqli_query($mysqli, $update_tinhtrang);
            }

            // Xóa giỏ hàng sau khi đã thanh toán
            unset($_SESSION['linhkien']);

            echo "<script>
                        alert('Bạn đã thanh toán thành công. MÃ ĐƠN CỦA BẠN LÀ $madon');
                        window.location = '../../../index.php?quanly=dondadat&id=$id_dangky';
                    </script>";
            exit(); // Kết thúc kịch bản
        } else {
            echo "Lỗi: Không thể tạo đơn hàng";
        }
    }
}
// } 
else {
    echo '<script>
            alert("Vui long thêm sản phẩm vào giỏ hàng trước khi thanh toán !!");
            window.location = "../../../index.php";
        </script>';
    // header('Location: index.php');
    exit();
}
