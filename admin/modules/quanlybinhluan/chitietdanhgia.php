</head>
<title>Comment</title>
</head>
<!-- <div style="padding-top: 10px;">
    <a href="http://localhost/web-thuctap/admin/index.php?action=danhgia&query=cmtmoi"><i class="fa-solid fa-reply"></i> Trở lại</a>
</div> -->
<?php

$sql_danhgia = "SELECT * , COUNT(CASE WHEN trangthai = 1 THEN 1 END) AS moi,
            COUNT(CASE WHEN trangthai = 2 THEN 1 END) AS rep
            FROM tbl_danhgia";
$query_danhgia = mysqli_query($mysqli, $sql_danhgia);
$row = mysqli_fetch_array($query_danhgia);
$moi = $row['moi'];
$rep = $row['rep'];

//chi tiết 1 sp
$sql_chitiet = "SELECT * FROM tbl_sanpham WHERE tbl_sanpham.id_sanpham='$_GET[id]' LIMIT 1";
$query_chitiet = mysqli_query($mysqli, $sql_chitiet);
while ($row_chitiet = mysqli_fetch_array($query_chitiet)) {
    $id_sp = $row_chitiet['id_sanpham'];
?>
    <div class="all-dg">
        <div class="chitiet_sp_dg">
            <div class="ha">
                <img class="img img-responsive" width="100%" style="box-shadow: 0px 3px 5px 5px rgba(0, 0, 0, 0.3); border-radius: 16px;" src="modules/quanlysanpham/uploads/<?php echo $row_chitiet['avatar'] ?>">
            </div>
            <div class="tt_sp">
                <h3><?php echo $row_chitiet['tensanpham'] ?></h3>
                <h5>Mã sản phẩm: <?php echo $row_chitiet['id_sanpham'] ?></h5>
                <h5 class="price-product">Giá: <?php echo number_format($row_chitiet['giasanpham'], 0, ',', '.') . 'vnđ' ?></h5>
                <h5>Số lượng sản phẩm: <?php echo $row_chitiet['soluong'] ?></h5>
                <h5 style="color:chocolate"> Tổng <?php echo $rep ?> đánh giá</h5>
            </div>
        <?php
    }
        ?>
        </div>
        <!-- Hiển thị các đánh giá của sản phẩm muốn xem -->
        <div>
            <?php

            $sql_danhgia = "SELECT * FROM tbl_danhgia, tbl_sanpham WHERE trangthai IN (1,2) AND '$id_sp' = tbl_danhgia.id_sanpham ORDER BY id_danhgia DESC ";
            $query_danhgia = mysqli_query($mysqli, $sql_danhgia);

            // Tạo mảng lưu trữ các ID đánh giá đã hiển thị
            $displayed_comments = array();

            while ($row = (mysqli_fetch_array($query_danhgia))) {
                
                $id_danhgia = $row['id_danhgia'];
                 // Kiểm tra xem bình luận này đã được hiển thị chưa
                 if (in_array($id_danhgia, $displayed_comments)) {
                    continue; // Nếu đã hiển thị thì bỏ qua
                }

                // Nếu chưa hiển thị, thêm vào mảng và tiếp tục hiển thị
                $displayed_comments[] = $id_danhgia;
                // $id_danhgia = $row['id_danhgia'];
                $sao_dg = $row['sao'];
                $name = $row['name'];
                // Tạo avatar ngẫu nhiên dựa trên tên của khách hàng
                $avatarBackgroundColors = array("#006633", "#993366", "#003366", "#990000", "#999900", "#003300", "#0066CC"); // Mảng chứa các màu nền cho avatar
                $avatarColor = $avatarBackgroundColors[array_rand($avatarBackgroundColors)]; // Chọn ngẫu nhiên một màu nền từ mảng
                // Chỉ lấy ký tự đầu tiên của tên khách hàng
                $avatarInitial = mb_substr($name, 0, 1);
            ?>
                <div style=" clear: both;">
                </div>
                <table border="0" class="table_rep_cmt_ct">
                    <tr>
                        <td style=" padding: 1% 0 0px; padding-left: 15px;vertical-align: middle;" colspan="2">
                            <div style="display: flex;">
                                <div style="background-color: <?php echo $avatarColor; ?>; width: 45px;height: 45px; text-align:center;padding:10px; border-radius:35px; ">
                                    <b class="initials" style="color: white; font-size:18px"><?php echo $avatarInitial; ?></b>
                                </div>

                                <div style="margin-left: 6px; margin-top: 10px; width:30%">
                                    <h4 style="font-size: 19px;"><?php echo $row['name'] ?></h4>
                                </div>

                                <div style="text-align: right; width:65%">
                                    <p style="opacity:0.5; margin-top:1%"><?php echo $row['thoigian'] ?></p>
                                </div>
                            </div>

                        </td>
                    </tr>
                    <tr>
                        <td class="sao-dg">
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
                        <td colspan="2" class="nd-dg">
                            <p style="pointer-events: none;margin-bottom:0; opacity: 0.8"> <?php echo $row['noidung_dg'] ?> </p>
                        </td>
                    </tr>

                    <?php
                    $sql_rep = "SELECT * FROM tbl_repcoment WHERE id_danhgia = $id_danhgia ORDER BY id_rep DESC";
                    $query_rep = mysqli_query($mysqli, $sql_rep);
                    while ($result_rep = mysqli_fetch_array($query_rep)) {
                    ?>
                        <tr>
                            <!-- <td rowspan="2"></td> -->
                            <td colspan="2" style=" padding:0 1% 0 4%;">
                                <hr color="#BBBBBB">
                                <b style="font-size: 18px;font-family: Roboto, sans-serif !important; color:red;"><i class="fa-solid fa-user"></i> Quản Trị Viên</b>

                                <p style="opacity:0.5; margin-bottom:0; float:right; pointer-events: none;"><i class="fa-regular fa-clock"></i> <?php echo $result_rep['thoigian'] ?></p>
                            </td>
                            <td style="padding-top: 25px; width:40px ">
                                <button class="xoa-cmt" onclick="confirmDelete(<?php echo $result_rep['id_rep'] ?>,<?php echo $id_sp ?>)">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="nd-rep" style="padding-bottom:0 ">
                                <div style="width:100%">
                                    <p style="pointer-events: none; opacity: 0.7; margin: 5px 0px 0 6%; font-size:16px; line-height: 1.6"> <?php echo $result_rep['noidung_rep'] ?> </p>
                                </div>
                            </td>

                        </tr>
                    <?php
                    }
                    ?>
                    <tr>
                        <td colspan="3" style="padding: 0 2%;">
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
                                <form method="POST" action="modules/quanlybinhluan/xulytrongall.php" id="replyForm_<?php echo $row['id_danhgia'] ?>" style="display: none;">
                                    <div style="padding-top: 5px;display:flex">
                                        <button type="submit" name="repcoment" style="margin-right: 1%; padding: 2px 20px; border:none; background-color:#DDDDDD; border-radius:7px">Gửi</button>
                                        <textarea required='true' rows="1" cols="100" name="reply" style="padding:7px 10px; max-height:200px" placeholder="Nhập nội dung trả lời" id="myTextarea" oninput="autoResize(this)"></textarea>
                                        <input type="hidden" name="id_danhgia" value="<?php echo $row['id_danhgia'] ?>">
                                        <input type="hidden" name="id_sanpham" value="<?php echo $id_sp ?>">
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

                    function confirmDelete(id, idsp) {
                        var result = confirm("Bạn có chắc chắn muốn xoá câu trả lời không?");
                        if (result) {
                            window.location.href = "modules/quanlybinhluan/xulytrongall.php?idrep=" + id + "&idsp=" + idsp;
                        }
                    }
                </script>

            <?php
            }

            ?>
        </div>
    </div>



    <style>



    </style>