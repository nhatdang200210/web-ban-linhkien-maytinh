<head>
    <title>Admin - Thêm danh mục sản phẩm</title>
</head>

<div class="cf-title-02 cf-title-alt-two title_all_sp" style="padding-top: 18px;">
    <h2>Thêm danh mục mới</h2>
</div>
<hr style="margin-right: 10px;" color="red">
<div class="form_them">
    <form method="POST" action="modules/quanlydanhmuc/xuly.php">
        <div class="form-group" style="padding:4% 5% 0">
            <label for="formGroupExampleInput" class="form-label">Tên danh mục</label>
            <input required="true" type="text" name="tendanhmuc" class="form-control" id="formGroupExampleInput" placeholder="Điền tên danh mục sản phẩm">
        </div>
        <hr>
        <div class="mb-3" style="padding:4% 5% 0">
            <label for="formGroupExampleInput2" class="form-label">STT</label>
            <input required="true" type="text" name="thutu" class="form-control" id="formGroupExampleInput2" placeholder="Số thứ tự">
        </div>
        <hr>
        <div class="nut_them">
            <input class="nut" type="submit" name="themdanhmuc" value="Thêm danh mục">
        </div>
    </form>
</div>
<style>
    .form_them {
        width: 50%;
        margin: auto;
    }

    .nut {
        padding: 7px 20px;
        border-radius: 10px;
        border: 1px solid blue;
        background-color: #177EF9;
        color: white;
        transition: all 0.3s ease;
        width: 100%;
    }

    .nut:hover {
        background-color: green;
        transform: scale(1.1);
    }

    .nut_them {
        padding-top: 4%;
        width: 18%;
        margin: auto;
        /* border: 1px solid; */
    }
</style>
<!-- </table> -->