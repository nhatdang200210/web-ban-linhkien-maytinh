<head>
    <title>Admin - Sửa bài viết</title>
</head>
<?php
$sql_sua_baiviet = "SELECT * FROM tbl_baiviet WHERE id_baiviet='$_GET[idbaiviet]' LIMIT 1";
$query_sua_baiviet = mysqli_query($mysqli, $sql_sua_baiviet);

$sql_sua = "SELECT * FROM tbl_baiviet WHERE id_baiviet='$_GET[idbaiviet]' LIMIT 1";
$query_sua = mysqli_query($mysqli, $sql_sua);
$rows = mysqli_fetch_array($query_sua);
?>
<div class="cf-title-02 cf-title-alt-two title_all_sp">
    <h2>Sửa bài viết</h2>
</div>
<hr style="margin-right: 10px;" color="red">
<?php
while ($row = mysqli_fetch_array($query_sua_baiviet)) {
?>
    <div class="form_them_sp">
        <form class="row g-3" enctype="multipart/form-data" action="modules/quanlybaiviet/xuly.php?idbaiviet=<?php echo $_GET['idbaiviet'] ?>" method="POST">
            <div class="col-md-5 ten_sp">
                <label for="inputEmail4" class="form-label"><b>Tên bài viết</b></label>
                <textarea type="text" required='true' class="form-control" id="inputEmail4" name="tenbaiviet" placeholder="Nhập" style="font-size: 19px;"><?php echo $row['tenbaiviet'] ?></textarea>
                <hr style="margin-bottom: 5%;">
            </div>
            <div class="col-md-5 gia_sp">
                <label for="inputtt" class="form-label"><b>Trạng thái</b></label>
                <select id="inputtt" class="form-select" name="tinhtrang">
                    <?php
                    if ($row['tinhtrang'] == 1) {
                    ?>
                        <option value="1">Kích hoạt</option>
                        <option value="0">Ẩn</option>
                    <?php
                    } else {
                    ?>
                        <option value="1">Kích hoạt</option>
                        <option value="0" selected>Ẩn</option>
                    <?php
                    }
                    ?>
                </select>
                <hr>
            </div>

            <div class="col-md-5 ha_sp">
                <label for="image" class="form-label"><b>Hình ảnh</b></label>
                <input class="form-control" id="image" type="file" name="hinhanh">
                <h5 style="margin-top: 2%;">Thay thế hình ảnh</h5>
                <div id="preview" style="margin-top: 1%;"></div>
                <div class="img_sua">
                    <img src="modules/quanlybaiviet/uploads/<?php echo $row['hinhanh'] ?>" width="100%">
                </div>
                <hr style="margin-bottom: 5%;">
            </div>

            <div class="" style="padding: 0; margin:auto; width: 87%">
                <label for="mota" class="form-label"><b>nội dung</b></label>
                <textarea required='true' class="form-control" id="mota" name="noidung"><?php echo $row['noidung'] ?></textarea>
                <hr>
            </div>
            <div class="col-12" style="text-align: center;">
                <button type="submit" class="btn btn-primary" name="suabaiviet">Sửa bài viết</button>
            </div>
        </form>
    <?php
}
    ?>
    </div>
    <style>
        .img_sua {
            width: 50%;
            margin-top: 10px;
        }
    </style>