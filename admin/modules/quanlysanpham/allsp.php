<?php
$sql_lietke_sanpham = "SELECT * FROM tbl_sanpham,tbl_danhmuc WHERE tbl_sanpham.id_danhmuc=tbl_danhmuc.id_danhmucsp ORDER BY id_sanpham DESC";
$query_lietke_sanpham = mysqli_query($mysqli, $sql_lietke_sanpham);

$sql_sanpham = "SELECT COUNT(id_sanpham) AS dem FROM tbl_sanpham,tbl_danhmuc WHERE tbl_sanpham.id_danhmuc=tbl_danhmuc.id_danhmucsp ORDER BY id_sanpham DESC";
$query_sanpham = mysqli_query($mysqli, $sql_sanpham);
$rows = mysqli_fetch_array($query_sanpham);
$dem  = $rows['dem'];
?>
<div style="text-align: center; padding-top:0.5%">
    <div style="display: flex; width:100%">
        <div style="width: 6%">
            <a href="index.php?action=quanlysanpham&query=them">
                <i class="fa-solid fa-circle-plus" style="font-size: 55px; color:green; padding-left:17px"></i>
            </a>
        </div>
        <div style="margin-top: 10px; width:94%">
            <h2 class="lkbaiviet">Tổng <?php echo $dem ?> sản phẩm</h2>
        </div>
    </div>
    <hr style="margin-right: 10px;" color="red">
</div>

<div class="table-responsive lk_sp">
    <table class="table table-hover table-bordered">
        <thead class="thead-dark" style="text-align: center;">
            <tr>
                <th scope="col" class="none">ID</th>
                <th scope="col">Tên và hình</th>
                <th scope="col">Giá sản phẩm</th>
                <th scope="col" class="none">Số lượng</th>
                <th scope="col" class="none">Danh mục</th>
                <th scope="col" class="none" style="width:35%">Thông số</th>
                <th scope="col">Trạng thái</th>
                <th scope="col">Quản lý</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            while ($row = mysqli_fetch_array($query_lietke_sanpham)) {

            ?>
                <tr>
                    <th scope="row" class="none" style="text-align: center;vertical-align: middle;"><?php echo $row['id_sanpham'] ?></th>
                    <td style="width:20%; text-align:center; vertical-align: middle;">
                        <img src="modules/quanlysanpham/uploads/<?php echo $row['avatar'] ?>" width="50%" style="border-radius:20px">
                        <div class="ten_sp">
                            <?php echo $row['tensanpham'] ?>
                        </div>
                    </td>
                    <td style="text-align: center;vertical-align: middle;"><?php echo number_format($row['giasanpham'], 0, ',', '.') . 'vnđ' ?></td>
                    <td class="none" style="text-align: center;vertical-align: middle;"><?php echo $row['soluong'] ?></td>
                    <td class="none" style="text-align: center;vertical-align: middle;">
                        <?php echo $row['tendanhmuc'] ?>
                    </td>
                    <td class="none">
                        <?php echo substr($row['tomtat'], 0, 300) . '....'; // Chỉ hiển thị một số ký tự đầu tiên
                        ?>
                    </td>
                    <td style="text-align: center; vertical-align: middle;">
                        <?php if ($row['tinhtrang'] == 1) {
                            echo '<b style="color:green;background-color: green; padding:4% 18%; margin-top: 10%; border-radius: 10px; color:white">HĐ</b>';
                        } else {
                            echo '<b style="color:green;background-color: #FC4712; padding:4% 18%; margin-top: 10%; border-radius: 10px; color:white">Ẩn</b>';
                        }
                        ?>
                    </td>
                    <td style="text-align: center;vertical-align: middle;">
                        <i class="fa-solid fa-trash" onclick="confirmDelete(<?php echo $row['id_sanpham']; ?>)"></i> |
                        <a href="?action=quanlysanpham&query=sua&idsanpham=<?php echo $row['id_sanpham'] ?>" style="color: #008FFF;"><i class="fa-solid fa-pen-to-square"></i></a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>
<script>
    function confirmDelete(id) {
        var result = confirm("Bạn có chắc chắn muốn xoá sản phẩm không?");
        if (result) {
            window.location.href = "modules/quanlysanpham/xuly.php?idsanpham=" + id;
        }
    }
</script>
<style>
    .lk_sp {
        /* background-color: blue; */
        margin-left: 0.5%;
    }

    .fa-trash {
        color: #7B7C7C;
    }

    .fa-trash:hover {
        color: red;
    }

    .fa-solid {
        padding: 1%;
        font-size: 25px;
        transition: all 0.3s ease;
    }

    .fa-trash:hover,
    .fa-pen-to-square:hover {
        transform: scale(1.4);
    }

    .fa-circle-plus:hover {
        transform: scale(1.2);
    }
</style>