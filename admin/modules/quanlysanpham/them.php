<head>
    <title>Admin - Thêm sản phẩm mới</title>
</head>

<div class="cf-title-02 cf-title-alt-two title_all_sp" style="padding-top: 18px;">
    <h2>Thêm sản phẩm mới</h2>
</div>
<hr style="margin-left: 1%;" color="red">
<div class="form_them_sp">
    <form class="row g-3" enctype="multipart/form-data" action="modules/quanlysanpham/xuly.php" method="POST">
        <div class="col-md-5 ten_sp">
            <label for="inputEmail4" class="form-label"><b>Tên sản phẩm</b></label>
            <input type="text" required='true' class="form-control" id="inputEmail4" name="tensanpham" placeholder="Nhập">
            <hr style="margin-bottom: 5%;">
        </div>
        <div class="col-md-5 gia_sp">
            <label for="inputPassword4" class="form-label"><b>Giá sản phẩm</b></label>
            <input type="number" required='true' class="form-control" id="inputPassword4" name="giasanpham" placeholder="nhập">
            <hr>
        </div>

        <div class="col-md-5 sl_sp">
            <label for="inputsl" class="form-label"><b>Số lượng sản phẩm</b></label>
            <input type="number" required='true' class="form-control" id="inputsl" name="soluong" placeholder="nhập">
            <hr style="margin-bottom: 5%;">
        </div>
        <div class="col-md-5">
            <label for="inputState" class="form-label"><b>Thuộc danh mục</b></label>
            <select id="inputState" class="form-select" name="danhmuc">
                <?php
                $sql_danhmucsp = "SELECT * FROM tbl_danhmuc ORDER BY id_danhmucsp DESC";
                $query_danhmucsp = mysqli_query($mysqli, $sql_danhmucsp);
                while ($row_danhmuc = mysqli_fetch_array($query_danhmucsp)) {
                ?>
                    <option value="<?php echo $row_danhmuc['id_danhmucsp'] ?>"><?php echo $row_danhmuc['tendanhmuc'] ?></option>
                <?php
                }
                ?>
            </select>
            <hr>
        </div>

        <!--nhiều hình ảnh -->
        <div class="col-md-5 ha_sp">
            <label for="inputtt" class="form-label"><b>Trạng thái</b></label>
            <select id="inputtt" class="form-select" name="tinhtrang">
                <option value="1">Hiển thị</option>
                <option value="0">Ẩn</option>
            </select>
            <hr>
        </div>

        <div class="col-md-5 ha_sp">
            <label for="image_avt" class="form-label"><b>Hình đại diện</b></label>
            <input required='true' class="form-control" id="image_avt" type="file" name="avt">
            <div id="preview_avt" style="margin-top: 2%; margin-left:30%; width:100%"></div>
            <hr style="margin-bottom: 5%;">
        </div>


        <div class="col-md-5">
            <label for="image" class="form-label"><b>Hình ảnh chi tiết</b></label>
            <input class="form-control" id="image" type="file" name="hinhanh[]" multiple>
            <div id="preview" style="margin-top: 1%;"></div>
            <hr style="margin-bottom: 5%;">
        </div>
        <div class="col-md-6">
            <label for="thongso" class="form-label"><b>Thông số kỹ thuật</b></label>
            <textarea required='true' class="form-control" id="thongso" name="tomtat"></textarea>
            <hr style="margin-bottom: 5%;">
        </div>
        <div class="col-md-6" style="padding: 0;">
            <label for="mota" class="form-label"><b>Mô tả</b></label>
            <textarea required='true' class="form-control" id="mota" name="noidung"></textarea>
            <hr>
        </div>
        <div class="col-12" style="text-align: center;">
            <button type="submit" class="btn btn-primary" name="themsanpham">Thêm sản phẩm mới</button>
        </div>
    </form>
</div>
<style>

</style>