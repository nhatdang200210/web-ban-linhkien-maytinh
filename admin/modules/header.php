<div class="header">
    <div class="login">
        <?php
        if (isset($_GET['dangxuat']) && $_GET['dangxuat'] == 1) {
            unset($_SESSION['dangnhap']);
            header('Location:login.php');
        }
        ?>
        <span style="padding-left: 20px; font-size:20px; font-weight:600;" class="dx">
            <a href="index.php?dangxuat=1" style="color:white">
                Đăng xuất: ADMIN <i class="fa-solid fa-right-from-bracket"></i>
            </a>
        </span>
    </div>
</div>
<style>

</style>