<head>
    <title>Admin - Thêm bài viết</title>
</head>

<div class="cf-title-02 cf-title-alt-two title_all_sp" style="padding-top: 18px;">
    <h2>Thêm bài viết mới</h2>
</div>
<hr style="margin-left: 1%;" color="red">
<div class="form_them_sp">
    <form class="row g-3" enctype="multipart/form-data" action="modules/quanlybaiviet/xuly.php" method="POST">
        <div class="col-md-5 ten_sp">
            <label for="inputEmail4" class="form-label"><b>Tên bài viết</b></label>
            <input type="text" required='true' class="form-control" id="inputEmail4" name="tenbaiviet" placeholder="Nhập">
            <hr style="margin-bottom: 5%;">
        </div>
        <div class="col-md-5 gia_sp">
            <label for="inputtt" class="form-label"><b>Trạng thái</b></label>
            <select id="inputtt" class="form-select" name="tinhtrang">
                <option value="1">Hiển thị</option>
                <option value="0">Ẩn</option>
            </select>
            <hr>
        </div>

        <div class="col-md-5 ha_sp">
            <label for="image" class="form-label"><b>Hình ảnh</b></label>
            <input required='true' class="form-control" id="image" type="file" name="hinhanh">
            <div id="preview" style="margin-top: 2%;"></div>
            <hr style="margin-bottom: 5%;">
        </div>
        <!-- <div class="col-md-5">
            <label for="inputtt" class="form-label"><b>Trạng thái</b></label>
            <select id="inputtt" class="form-select" name="tinhtrang">
                <option value="1">Hiển thị</option>
                <option value="0">Ẩn</option>
            </select>
            <hr>
        </div> -->

        <div class="" style="padding: 0; margin:auto; width: 87%">
            <label for="mota" class="form-label"><b>nội dung</b></label>
            <textarea required='true' class="form-control" id="mota" name="noidung"></textarea>
            <hr>
        </div>
        <div class="col-12" style="text-align: center;">
            <button type="submit" class="btn btn-primary" name="thembaiviet">Thêm bài viết mới</button>
        </div>
    </form>
</div>
<style>

</style>