<head>
    <title>Admin - Sửa sản phẩm</title>
</head>

<?php
$sql_sua_sanpham = "SELECT * FROM tbl_sanpham WHERE id_sanpham='$_GET[idsanpham]' LIMIT 1";
// $query_sua_sanpham = mysqli_query($mysqli,$sql_sua_sanpham);

$query_sanpham = mysqli_query($mysqli, $sql_sua_sanpham);
$rows = mysqli_fetch_array($query_sanpham);

// $sql_sua_sanpham = "SELECT * FROM tbl_sanpham WHERE id_sanpham='$_GET[idsanpham]' LIMIT 1"; 
// Lấy ID của danh mục từ sản phẩm đã sửa
// $id_sanpham_sua = $_GET['idsanpham'];
$sql_lay_danhmuc = "SELECT id_danhmuc FROM tbl_sanpham WHERE id_sanpham = $_GET[idsanpham] LIMIT 1";
$query_lay_danhmuc = mysqli_query($mysqli, $sql_lay_danhmuc);
$row_lay_danhmuc = mysqli_fetch_array($query_lay_danhmuc);
$id_danhmuc_sua = $row_lay_danhmuc['id_danhmuc'];

?>
<div style="padding-bottom: 1%; padding-left: 1%">
    <a href="<?php echo './index.php?action=quanlysanpham&query=lietke&id=' . $id_danhmuc_sua ?>"><i class="fa-solid fa-reply"></i> Trở lại</a>
</div>
<div style="text-align: center; padding-top:1%">
    <div class="cf-title-02 cf-title-alt-two title_all_sp">
        <h2 class="thembaiviet">Sửa sản phẩm <?php echo '<span style="color:blue">' . $rows['tensanpham'] . '</span>' ?></h2>
    </div>

    <hr style="margin-right: 10px;" color="red">
</div>
<div class="form_them_sp">

    <form class="row g-3" enctype="multipart/form-data" action="modules/quanlysanpham/xuly.php?idsanpham=<?php echo $_GET['idsanpham'] ?>" method="POST">
        <div class="col-md-5 ten_sp">
            <label for="inputEmail4" class="form-label"><b>Tên sản phẩm</b></label>
            <input type="text" required='true' class="form-control" id="inputEmail4" name="tensanpham" value="<?php echo $rows['tensanpham'] ?>">
            <hr style="margin-bottom: 5%;">
        </div>
        <div class="col-md-5 gia_sp">
            <label for="inputPassword4" class="form-label"><b>Giá sản phẩm</b></label>
            <input type="number" required='true' class="form-control" id="inputPassword4" name="giasanpham" value="<?php echo $rows['giasanpham'] ?>">
            <hr>
        </div>

        <div class="col-md-5 sl_sp">
            <label for="inputsl" class="form-label"><b>Số lượng sản phẩm</b></label>
            <input type="number" required='true' class="form-control" id="inputsl" name="soluong" value="<?php echo $rows['soluong'] ?>">
            <hr style="margin-bottom: 5%;">
        </div>
        <div class="col-md-5 thuocdanhmuc">
            <label for="inputState" class="form-label"><b>Thuộc danh mục</b></label>
            <select id="inputState" class="form-select" name="danhmuc">
                <?php
                $sql_danhmucsp = "SELECT * FROM tbl_danhmuc ORDER BY id_danhmucsp DESC";
                $query_danhmucsp = mysqli_query($mysqli, $sql_danhmucsp);
                while ($row_danhmuc = mysqli_fetch_array($query_danhmucsp)) {
                    if ($row_danhmuc['id_danhmucsp'] == $rows['id_danhmuc']) {
                ?>
                        <option selected value="<?php echo $row_danhmuc['id_danhmucsp'] ?>"><?php echo $row_danhmuc['tendanhmuc'] ?></option>
                    <?php
                    } else {
                    ?>
                        <option value="<?php echo $row_danhmuc['id_danhmucsp'] ?>"><?php echo $row_danhmuc['tendanhmuc'] ?></option>
                <?php
                    }
                }
                ?>
            </select>
            <hr>
        </div>

        <div class="col-md-5 ha_sp">
            <label for="inputtt" class="form-label"><b>Trạng thái</b></label>
            <select id="inputtt" class="form-select" name="tinhtrang">
                <?php
                if ($rows['tinhtrang'] == 1) {
                ?>
                    <option value="1">Hiển thị</option>
                    <option value="0">Ẩn</option>
                <?php
                } else {
                ?>
                    <option value="1">Hiển thị</option>
                    <option value="0" selected>Ẩn</option>
                <?php
                }
                ?>
            </select>
            <hr>
        </div>

        <div class="col-md-5 ha_sp">
            <label for="image_avt" class="form-label"><b>Hình ảnh đại diện</b></label>
            <input class="form-control" id="image_avt" type="file" name="avt">
            <h4 style="margin-top: 2%;">Thay thế </h4>
            <div id="preview_avt"></div>
            <h4 style="margin-top: 2%;">Ảnh cũ </h4>
            <img src="modules/quanlysanpham/uploads/<?php echo $rows['avatar'] ?>" style="border: 1px solid; margin-left:30%">


            <!-- <img src="modules/quanlysanpham/uploads/<?php echo $rows['hinhanh'] ?>"> -->
            <hr style="margin-bottom: 5%;">
        </div>

        <div class="col-md-5">
            <label for="image" class="form-label"><b>Hình ảnh chi tiết</b></label>
            <!-- <input class="form-control" id="image" type="file" name="hinhanh"> -->
            <input class="form-control" id="image" type="file" name="hinhanh[]" multiple>
            <h4 style="margin-top: 2%;">Thay thế </h4>
            <div id="preview"></div>
            <h4 style="margin-top: 2%;">Ảnh cũ </h4>
            <?php
            $images = explode(',', $rows['hinhanh']); // hình ảnh được lưu dưới dạng chuỗi phân cách bằng dấu phẩy trong cơ sở dữ liệu
            foreach ($images as $image) {
                $image = trim($image); // loại bỏ khoảng trắng không cần thiết
                if (!empty($image) && file_exists("modules/quanlysanpham/uploads/" . $image)) {
                    echo '<img src="modules/quanlysanpham/uploads/' . htmlspecialchars($image) . '" alt="Image" width="23.5%" height="auto%" style="max-width: 100%; height: auto;margin: 5px; border: 1px solid; border-radius: 5px">';
                }
            }
            ?>
            <!-- <img src="modules/quanlysanpham/uploads/<?php echo $rows['hinhanh'] ?>"> -->
            <hr style="margin-bottom: 5%;">
        </div>

        <!--  -->
        <div class="col-md-6">
            <label for="thongso" class="form-label"><b>Thông số kỹ thuật</b></label>
            <textarea required='true' class="form-control" id="thongso" name="tomtat"><?php echo $rows['tomtat'] ?></textarea>
            <hr style="margin-bottom: 5%;">
        </div>
        <div class="col-md-6" style="padding: 0;">
            <label for="mota" class="form-label"><b>Mô tả</b></label>
            <textarea required='true' class="form-control" id="mota" name="noidung"><?php echo $rows['noidung'] ?></textarea>
            <hr>
        </div>
        <div class="col-12" style="text-align: center;">
            <button type="submit" class="btn btn-primary" name="suasanpham">Sửa sản phẩm</button>
        </div>
    </form>

</div>
<style>

</style>