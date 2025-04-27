<?php
if (isset($_SESSION['dangky'])) {
    if (isset($_GET['dangxuat']) && $_GET['dangxuat'] = 1) {
        unset($_SESSION['dangky']);
    }
    $sql_user = "SELECT * FROM tbl_dangky WHERE id_dangky = " . $_SESSION['id_khachhang']; // Sử dụng ID của người đăng nhập để lấy thông tin của họ
    $query_user = mysqli_query($mysqli, $sql_user);
    $row = mysqli_fetch_array($query_user)

?>

    <head>
        <title>Tài khoản</title>
    </head>
    <div class="taikhoan">
        <div class="cf-title-02 cf-title-alt-two title_all_sp" style="margin-bottom: 20px;">
            <h2>Thông tin tài khoản<br /></h2>
        </div>
        <table class="table ">
            <tbody>
                <tr>
                    <th scope="row" style="padding: 15px">Tên:</th>
                    <td><?php echo $row['tenkhach'] ?></td>

                </tr>
                <tr>
                    <th scope="row" style="padding: 15px">Email:</th>
                    <td><?php echo $row['email'] ?></td>

                </tr>
                <tr>
                    <th scope="row" style="padding: 15px">Số điện thoại:</th>
                    <td><?php echo $row['dienthoai'] ?></td>
                </tr>
                <tr>
                    <th scope="row" style="padding: 15px"><a class="doimk" href="index.php?quanly=doimatkhau">Đổi mật khẩu</a></th>
                    <td></td>
                </tr>
                <tr>
                    <td style="padding: 15px"></td>
                    <td colspan="2"><a href="index.php?dangxuat=1"><button class="btn btn-secondary dangxuat">Đăng xuất</button></a></td>
                </tr>
            </tbody>
        </table>
    </div>
<?php
}
?>
<style>
    .taikhoan {

        width: 70%;
        /* border: 1px solid; */
        /* border-left: 1px solid;
        border-right: 1px solid;
        border-left: 1px solid; */
        margin: auto;
        margin-top: 3%;
    }

    .dangxuat {
        transition: all 0.3s ease;
    }

    .dangxuat:hover {
        background-color: orangered;
        border: 0px;
        transform: scale(1.1);
    }

    .doimk {
        text-decoration: none;
        color: red;
    }

    .doimk:hover {
        text-decoration: none;
    }
</style>