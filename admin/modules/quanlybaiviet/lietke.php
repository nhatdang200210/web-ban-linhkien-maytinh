<?php

$sql_lietke_sanpham = "SELECT * FROM tbl_baiviet ORDER BY id_baiviet DESC";
$query_lietke_sanpham = mysqli_query($mysqli, $sql_lietke_sanpham);
?>

<div class="table-responsive lk_sp">
    <table class="table table-hover table-bordered">
        <thead class="thead-dark" style="text-align: center;">
            <tr>
                <th scope="col" style="width:14px" class="">STT</th>
                <th scope="col">Tên và hình</th>
                <th scope="col" style="width:50%">Nội dung</th>
                <th scope="col" class="">Trạng thái</th>
                <th scope="col" class="">Quản lý</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            while ($row = mysqli_fetch_array($query_lietke_sanpham)) {
                $i++;
            ?>
                <tr>
                    <th scope="row" class="" style="text-align: center;vertical-align: middle;"><?php echo $i ?></th>
                    <td style="width:20%; text-align:center; vertical-align: middle;" class="">
                        <img src="modules/quanlybaiviet/uploads/<?php echo $row['hinhanh'] ?>" width="100%" style="border-radius:20px">
                        <div class="ten_sp" style="text-align: justify; font-size: 18px;">
                            <?php echo substr($row['tenbaiviet'], 0, 200) . '...' ?>
                        </div>
                    </td>

                    <td style="padding-left: 1%;">
                        <?php echo substr($row['noidung'], 0, 1000) . '....'; // Chỉ hiển thị một số ký tự đầu tiên
                        ?>
                    </td>

                    <td style="text-align: center; vertical-align: middle;" class="">
                        <?php if ($row['tinhtrang'] == 1) {
                            echo '<b style="color:green;background-color: green; padding:2% 10%; margin-top: 10%; border-radius: 10px; color:white">Hiện</b>';
                        } else {
                            echo '<b style="color:green;background-color: #FC4712; padding:2% 10%; margin-top: 10%; border-radius: 10px; color:white">Ẩn</b>';
                        }
                        ?>
                    </td>
                    <td style="text-align: center;vertical-align: middle;">
                        <i class="fa-solid fa-trash" onclick="confirmDelete(<?php echo $row['id_baiviet']; ?>)"></i> |
                        <a href="?action=quanlybaiviet&query=sua&idbaiviet=<?php echo $row['id_baiviet'] ?>" style="color: #008FFF;"><i class="fa-solid fa-pen-to-square"></i></a>

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
        var result = confirm("Bạn có chắc chắn muốn xoá bài viết này không?");
        if (result) {
            window.location.href = "modules/quanlybaiviet/xuly.php?idbaiviet=" + id;
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

    .fa-solid:hover {
        transform: scale(1.4);
    }
</style>