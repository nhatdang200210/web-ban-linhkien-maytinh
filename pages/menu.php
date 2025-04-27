<?php
if (isset($_GET['dangxuat']) && $_GET['dangxuat'] = 1) {
  unset($_SESSION['dangky']);
}

$tongsp = 0;

// Kiểm tra xem người dùng đã đăng nhập chưa
if (isset($_SESSION['dangky'])) {
  // Lấy id_dangky của người dùng
  $id_dangky = $_SESSION['id_khachhang'];
} else {
  $id_dangky = 0;
}

// Nếu có sản phẩm trong giỏ hàng
if (isset($_SESSION['linhkien']) && !empty($_SESSION['linhkien'])) {
  foreach ($_SESSION['linhkien'] as $sp_item) {
    if ($sp_item['idkhach'] == $id_dangky) {
      $tongsp += $sp_item['soluong'];
    }
  }
}


$sql_danhmucsp = "SELECT * FROM tbl_danhmuc ORDER BY id_danhmucsp ASC";
$query_danhmucsp = mysqli_query($mysqli, $sql_danhmucsp);
?>
<div class="all-menu">
  <div class="ed-menu">
    <nav class="navbar navbar-expand-lg navbar-light menu " style="width:100%;padding: .5rem 0rem;">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto list-menu" style="width:100%">

          <li class="nav-item trangchu" style="">
            <a class="nav-link" href="index.php" style="color: white;">Trang chủ <span class="sr-only">(current)</span></a>
          </li>

          <li class="nav-item dropdown dmsp">
            <a class=" nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false" style="color: white;">
              Danh mục sản phẩm
            </a>
            <ul class="dropdown-menu">
              <?php
              while ($row_danhmuc = mysqli_fetch_array($query_danhmucsp)) {
              ?>
                <li style="margin: 10px" class="danhmuc_list">
                  <a href="index.php?quanly=sptheodm&id=<?php echo $row_danhmuc['id_danhmucsp'] ?>"><?php echo $row_danhmuc['tendanhmuc'] ?></a>
                </li>
              <?php
              }
              ?>
            </ul>
          </li>
          <li class="nav-item dropdown tintuc"><a class="nav-link " href="index.php?quanly=tintuc" style="color: white;">Tin Tức</a></li>
          <li class="nav-item gh">
            <a class="nav-link" href="index.php?quanly=giohang" style="color: white;">
              <i class="fa fa-shopping-cart" style="font-size: 30px;"></i>
              <sup style="font-size: 25px;">
                ( <?php
                  if (isset($sp_item['soluong'])) {
                    echo $tongsp;
                  } else {
                    echo '0';
                  }
                  ?> )
              </sup>
            </a>
          </li>
          <li class="nav-item dropdown donmua"><a class="nav-link " href="index.php?quanly=timkiemdonmua" style="color: white;"><i class="fa-solid fa-magnifying-glass-dollar"></i> Tìm đơn</a></li>
          <?php
          if (isset($_SESSION['dangky'])) {
          ?>
            <li class="nav-item">
              <!-- <a class="nav-link" href="index.php?quanly=user" style="color: white;">
            <i class="fa fa-user"></i>
            <?php
            echo '<span>' . '</span>' . '<span>' . $_SESSION['dangky'] . '</span>';
            ?>
          </a> -->
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false" style="color: white;">
                <i class="fa fa-user"></i>
                <?php
                echo '<span>' . '</span>' . '<span>' . $_SESSION['dangky'] . '</span>';
                ?>
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="index.php?quanly=taikhoan">Tài khoản</a></li>
                <li><a class="dropdown-item" href="index.php?quanly=diachi">Địa chỉ</a></li>
                <li><a class="dropdown-item" href="index.php?quanly=donmua">Đơn mua</a></li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="index.php?dangxuat=1" style="color:red">Đăng xuất</a></li>
              </ul>
            </li>
            <li class="nav-item">
              <!-- <a class="nav-link" href="index.php?dangxuat=1" style="color: white;"><i class="fa fa-sign-in" aria-hidden="true"></i> Đăng xuất</a> -->
            </li>
          <?php
          } else {
          ?>
            <li class="nav-item">
              <a class="nav-link" href="index.php?quanly=login" style="color: white;"><i class="fa fa-sign-in" aria-hidden="true"></i> Đăng Nhập</a>
            </li>
          <?php
          }
          ?>
        </ul>
        <form class="form-inline my-2 my-lg-0 search" action="index.php?quanly=timkiem" method="POST" style="display:flex; flex-wrap:nowrap">
          <input class="form-control mr-sm-2" type="text" placeholder="Tìm kiếm" name="tukhoa" aria-label="Search" style="width:75%">
          <button class="btn btn-light my-2 my-sm-0" type="submit" name="timkiem" style="color: red;font-size:18; style="width:25%"">Search</button>
        </form>
      </div>
    </nav>
  </div>

</div>
<style>
  .danhmuc_list:hover a {
    text-decoration: none;
    color: chocolate;
  }
</style>