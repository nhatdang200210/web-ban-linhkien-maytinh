<?php
$sql_lietke_danhmucsp = "SELECT * FROM tbl_danhmuc ORDER BY thutu ASC";
$query_lietke_danhmucsp = mysqli_query($mysqli, $sql_lietke_danhmucsp);
?>
<div style="display: flex; width:99%" class="title_all_sp">
    <div class="add_sp">
        <a href="index.php?action=quanlydanhmuc&query=them">
            <i class="fa-solid fa-circle-plus" style="font-size: 55px; color:green; padding-left:17px"></i>
        </a>
    </div>
    <div class="cf-title-02 cf-title-alt-two ten_sp">
        <h2>Các danh mục sản phẩm</h2>
    </div>
</div>
<hr style="margin-left:1%">
<div class="lietke">
    <table class="table table-striped" style="text-align: center;">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Hiển thị</th>
                <th scope="col">Tên danh mục</th>
                <th scope="col">Quản lý</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            while ($row = mysqli_fetch_array($query_lietke_danhmucsp)) {
                $i++;
            ?>
                <tr>
                    <th scope="row"><?php echo $i ?></th>
                    <td><?php echo $row['thutu'] ?></td>
                    <td><?php echo $row['tendanhmuc'] ?></td>
                    <td class="nut">
                        <!-- sửa -->
                        <a href="?action=quanlydanhmuc&query=sua&iddanhmucsp=<?php echo $row['id_danhmucsp'] ?>" style="color: #008FFF;"><i class="fa-solid fa-pen-to-square"></i></a> |
                        <!-- xoá -->
                        <i class="fa-solid fa-trash" onclick="confirmDelete(<?php echo $row['id_danhmucsp']; ?>)"></i>
                    </td>
                </tr>
                <script>
                    function confirmDelete(id) {
                        var result = confirm("Bạn có chắc chắn muốn xoá danh mục \"<?php echo $row['tendanhmuc'] ?>\" không?");
                        if (result) {
                            window.location.href = "modules/quanlydanhmuc/xuly.php?iddanhmucsp=" + id;
                        }
                    }
                </script>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>
<style>
    .fa-trash {
        color: #7B7C7C;
    }

    .fa-trash:hover {
        color: red;
    }

    .fa-solid {
        padding: 1%;
        font-size: 20px;
        transition: all 0.3s ease;
    }

    .fa-solid:hover {
        transform: scale(1.4);
    }

    .fa-circle-plus {
        transform: scale(1.2);
    }
</style>