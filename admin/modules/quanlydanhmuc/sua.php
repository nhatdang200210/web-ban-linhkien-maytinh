<head>
    <title>Admin - Sửa danh mục</title>
</head>
<?php
$sql_sua_danhmucsp = "SELECT * FROM tbl_danhmuc WHERE id_danhmucsp='$_GET[iddanhmucsp]' LIMIT 1";
$query_sua_danhmucsp = mysqli_query($mysqli, $sql_sua_danhmucsp);

$query_sua = mysqli_query($mysqli, $sql_sua_danhmucsp);
$row = mysqli_fetch_array($query_sua)
?>
<div class="cf-title-02 cf-title-alt-two title_all_sp">
    <h2>Sửa danh mục</h2>
</div>
<hr style="margin-right: 10px;" color="red">
<div class="form_them">
    <form method="POST" action="modules/quanlydanhmuc/xuly.php?iddanhmucsp=<?php echo $_GET['iddanhmucsp'] ?>">
        <?php
        while ($dong = mysqli_fetch_array($query_sua_danhmucsp)) {
        ?>
            <div class="form-group" style="padding:4% 5% 0">
                <label for="formGroupExampleInput" class="form-label">Tên danh mục</label>
                <input required="true" type="text" name="tendanhmuc" class="form-control" id="formGroupExampleInput" value="<?php echo $dong['tendanhmuc'] ?>" style="font-weight: 700;">
            </div>
            <hr>
            <div class="mb-3" style="padding:4% 5% 0">
                <label for="formGroupExampleInput2" class="form-label">STT</label>
                <input required="true" type="text" name="thutu" class="form-control" id="formGroupExampleInput2" value="<?php echo $dong['thutu'] ?>" style="font-weight: 700;">
            </div>
            <hr>
            <div class="nut_them">
                <input class="nut" type="submit" name="suadanhmuc" value="Sửa danh mục">
            </div>
        <?php
        }
        ?>
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