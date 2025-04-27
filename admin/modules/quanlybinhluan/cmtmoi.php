<?php
$sql_danhgia = "SELECT * , COUNT(CASE WHEN trangthai = 1 THEN 2 END) AS moi,
                        COUNT(CASE WHEN trangthai = 2 THEN 1 END) AS rep
                        FROM tbl_danhgia";
$query_danhgia = mysqli_query($mysqli, $sql_danhgia);
$row = mysqli_fetch_array($query_danhgia);
$moi = $row['moi'];
$rep = $row['rep'];

$current_page = isset($_GET['query']) ? $_GET['query'] : 'cmtmoi';
?>
<div class="menu-dg">
    <nav class="navbar navbar-light bg-light" style="margin-bottom:0;  padding-left:0">
        <form class="container-fluid justify-content-start" style="flex-wrap: nowrap; text-align:center">
            <a href="index.php?action=danhgia&query=cmtmoi" class="task1"><button class="btn btn-outline-success me-2 <?php echo ($current_page == 'cmtmoi') ? 'active' : 'cmtmoi'; ?>" type="button">Đánh giá mới (<?php echo $moi ?>)</button></a>
            <a href="index.php?action=danhgia&query=darep" class="task2"><button class="btn btn-outline-success me-2 " type="button">Đã trả lời (<?php echo $rep ?>)</button></a>
        </form>
    </nav>
</div>

<div class="cf-title-02 cf-title-alt-two title_all_sp" style="padding-top: 18px;">
    <h2>Các đánh giá mới</h2>
</div>
<hr style="margin-left: 1%;" color="red">
<!-- //đánh giá của người mua -->

<head>
    <title>Admin - Đánh giá mới</title>
</head>

<?php
$sql_danhgia = "SELECT * FROM tbl_danhgia, tbl_sanpham WHERE trangthai = 1 AND tbl_sanpham.id_sanpham = tbl_danhgia.id_sanpham ORDER BY id_danhgia DESC";
$query_danhgia = mysqli_query($mysqli, $sql_danhgia);

while ($row = (mysqli_fetch_array($query_danhgia))) {
    $sao_dg = $row['sao'];
    $id_danhgia = $row['id_danhgia'];

    $name = $row['name'];
    // Tạo avatar ngẫu nhiên dựa trên tên của khách hàng
    $avatarBackgroundColors = array("#006633", "#993366", "#003366", "#990000", "#999900", "#003300", "#0066CC"); // Mảng chứa các màu nền cho avatar
    $avatarColor = $avatarBackgroundColors[array_rand($avatarBackgroundColors)]; // Chọn ngẫu nhiên một màu nền từ mảng
    // Chỉ lấy ký tự đầu tiên của tên khách hàng
    $avatarInitial = mb_substr($name, 0, 1);
?>
    <div style="clear: both;"></div>

    <table border="0" style="width:70%; margin:1% auto; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);border-radius:8px" class="table table-borderless">
        <tr>

            <td rowspan="4" style="width:180px; padding:0">
                <a href="index.php?action=danhgia&query=chitietdanhgia&id=<?php echo $row['id_sanpham'] ?>" style="text-decoration:none; color:black;">
                    <div class="click-ha">
                        <img class="img img-responsive" width="100%" style="" src="modules/quanlysanpham/uploads/<?php echo $row['avatar'] ?>">
                    </div>
                </a>
            </td>

            <td style=" padding: 1% 0 0px; padding-left: 15px;vertical-align: middle;" colspan="2">
                <div style="display: flex;">
                    <div style="background-color: <?php echo $avatarColor; ?>; width: 45px;height: 45px; text-align:center;padding:10px; border-radius:35px; ">
                        <b class="initials" style="color: white; font-size:18px"><?php echo $avatarInitial; ?></b>
                    </div>

                    <div style="margin-left: 6px; margin-top: 10px; width:50%">
                        <h4 style="font-size: 19px;"><?php echo $row['name'] ?></h4>
                    </div>

                    <div style="text-align: right; width:45%">
                        <p style="opacity:0.5; margin-top:1%"><?php echo $row['thoigian'] ?></p>
                    </div>
                </div>

            </td>
        </tr>
        <tr>
            <td style="padding-left: 65px; padding-bottom:8px">
                <?php
                // Hiển thị số icon sao tương ứng với số sao trong cột sao
                for ($i = 0; $i < $sao_dg; $i++) {
                    echo "<i class='fa fa-star fa-fw' style='color: #FFBF00'></i>";
                }
                ?>
            </td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" style=" padding:0 67px;">
                <p style="pointer-events: none;margin-bottom:10px; opacity: 0.8"> <?php echo $row['noidung_dg'] ?> </p>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="padding: 0 2%;">
                <hr color="red">
                <div style="margin-bottom:5px;">
                    <b id="replyButton_<?php echo $row['id_danhgia'] ?>" style="color: green; cursor: pointer;">
                        <i class="fa-solid fa-comments"></i> Trả lời
                    </b>
                    <b id="canButton_<?php echo $row['id_danhgia'] ?>" style="color: green;display:none; cursor: pointer;">
                        HUỶ
                    </b>
                    <!-- <b style="float: right; margin-right:20px;color: chocolate;cursor: pointer; ">
                        Ẩn đánh giá
                    </b> -->
                </div>

                <div style="margin-left: 5%; margin-bottom: 8px;">
                    <form method="POST" action="modules/quanlybinhluan/xuly.php" id="replyForm_<?php echo $row['id_danhgia'] ?>" style="display: none;">
                        <div style="padding-top: 5px;display:flex">
                            <button type="submit" name="repcoment" style="margin-right: 1%; padding: 2px 20px; border:none; background-color:#DDDDDD; border-radius:7px">Gửi</button>
                            <textarea required='true' rows="1" cols="100" name="reply" style="padding:7px 10px; max-height:200px" placeholder="Nhập nội dung trả lời" id="myTextarea" oninput="autoResize(this)"></textarea>
                            <input type="hidden" name="id_danhgia" value="<?php echo $row['id_danhgia'] ?>">
                            <input type="hidden" name="id_sanpham" value="<?php echo $row['id_sanpham'] ?>">
                        </div>
                    </form>
                    <div>
            </td>
        </tr>
    </table>

    <script>
        // reply.js
        document.getElementById("replyButton_<?php echo $row['id_danhgia'] ?>").addEventListener("click", function() {
            // Hiển thị form khi nút "Trả lời" được nhấn
            document.getElementById("replyForm_<?php echo $row['id_danhgia'] ?>").style.display = "block";
            // Ẩn nút "Trả lời"
            this.style.display = "none";
            // this.innerHTML = "Ẩn";
            // Hiển thị nút "Trả lời" khi nút "Ẩn" được nhấn
            document.getElementById("canButton_<?php echo $row['id_danhgia'] ?>").style.display = "block";
        });
        document.getElementById("canButton_<?php echo $row['id_danhgia'] ?>").addEventListener("click", function() {
            // Hiển thị nút "Trả lời" khi nút "Ẩn" được nhấn
            document.getElementById("replyButton_<?php echo $row['id_danhgia'] ?>").style.display = "block";
            // Ẩn form khi nút Ẩn được nhấn
            document.getElementById("replyForm_<?php echo $row['id_danhgia'] ?>").style.display = "none";
            // Thay thế nút "Ẩn" bằng nút "Trả lời"
            document.getElementById("replyButton_<?php echo $row['id_danhgia'] ?>").innerHTML = "Trả lời";
            this.style.display = "none";
        });

        function autoResize(textarea) {
            // Reset chiều cao để đo lại
            textarea.style.height = 'auto';
            // Đo chiều cao thực tế của văn bản
            var textHeight = textarea.scrollHeight;
            // Áp dụng chiều cao của văn bản cho textarea
            textarea.style.height = textHeight + 'px';
        }
    </script>

<?php
}

?>
<style>

</style>