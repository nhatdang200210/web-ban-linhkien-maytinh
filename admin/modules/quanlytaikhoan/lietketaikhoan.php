<?php

$sql_lietke_taikhoan = "SELECT * FROM tbl_dangky ORDER BY id_dangky DESC";
$query_lietke_taikhoan = mysqli_query($mysqli, $sql_lietke_taikhoan);

$sql_taikhoan = "SELECT * FROM tbl_dangky ORDER BY id_dangky DESC";
$query_taikhoan = mysqli_query($mysqli, $sql_taikhoan);

while ($rows = mysqli_fetch_array($query_taikhoan)) {

    $id_dangky = $rows['id_dangky'];
    // $locked = $_POST['locked_'.$id_dangky];
    if (isset($_POST['ok_' . $id_dangky])) {
        $id_dangky = $_POST['id_dangky'];
        $locked = $_POST['locked_' . $id_dangky];
        $sql_sua = "UPDATE tbl_dangky SET locked = $locked WHERE id_dangky = $id_dangky";
        mysqli_query($mysqli, $sql_sua);
        echo "<script>
            alert('Bạn đã cập nhật thành công.');
            window.location = 'index.php?action=quanlytaikhoan&query=lietketaikhoan';
        </script>";
    }
}
?>
<div class="cf-title-02 cf-title-alt-two title_all_sp" style="padding-top: 18px;">
    <h2>Thông tin các tài khoản</h2>
</div>
<hr style="margin-left: 1%;">
<div class="taikhoan">
    <div class="table-responsive" style="border-collapse: collapse;">
        <table class="table table-hover table-bordered">
            <thead class="thead-dark" style="text-align: center;">
                <tr>
                    <th scope="col" colspan="3">Thông tin tài khoản</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                while ($row = mysqli_fetch_array($query_lietke_taikhoan)) {
                    $i++;
                ?>
                    <tr>
                        <th scope="row" class="id_tk" style=" vertical-align: middle; "><?php echo $i ?></th>

                        <td style="text-align: left">
                            <ul style="text-align:left; margin-top:1%; list-style:none; padding-left:2%">
                                <li><b>ID: </b><?php echo $row['id_dangky'] ?></li>
                                <li><b>Tên: </b><?php echo $row['tenkhach'] ?></li>
                                <li><b>Email: </b><?php echo $row['email'] ?></li>
                                <li><b>Số điện thoại: </b>0<?php echo $row['dienthoai'] ?></li>
                            </ul>
                        </td>

                        <td style="text-align: center; width:30%; vertical-align: middle; ">
                            <form action="" method="POST" autocomplete="off">
                                <?php
                                if (isset($_POST['quanly_' . $row['id_dangky']])) {
                                ?>
                                    <div>
                                        <select name="locked_<?php echo $row['id_dangky'] ?>" style="height: 25px;">
                                            <option value="0" <?php if ($row['locked'] == 0) echo 'selected'; ?>>Hoạt động</option>
                                            <option value="1" <?php if ($row['locked'] == 1) echo 'selected'; ?>>Khoá</option>
                                        </select>
                                        <input type="hidden" name="id_dangky" value="<?php echo $row['id_dangky']; ?>">
                                        <button name="ok_<?php echo $row['id_dangky'] ?>" type="submit" class="btn btn-secondary">Đồng ý</button>
                                    </div>
                                <?php
                                } else {
                                    if ($row['locked'] == 1) echo '<p style="color:red; font-weight:bold"><i class="fa-solid fa-lock"></i> Khoá</p>';
                                    if ($row['locked'] == 0) echo '<p style="color:green">Hoạt động</p>';
                                ?>
                                    <button type="submit" class="btn btn-secondary" name="quanly_<?php echo $row['id_dangky'] ?>">Quản lý</button>
                                <?php
                                } ?>
                            </form>
                        </td>

                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<style>
    .id_tk {
        text-align: center;
        width: 6%;
    }
</style>