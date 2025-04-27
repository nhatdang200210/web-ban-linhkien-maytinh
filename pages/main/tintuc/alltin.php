</head>
<title>An Phát Computer - Tin tức</title>
</head>
<?php
$sql_baiviet = "SELECT * FROM tbl_baiviet WHERE tinhtrang=1 ORDER BY id_baiviet DESC";
$query_baiviet = mysqli_query($mysqli, $sql_baiviet);

$query_bv = mysqli_query($mysqli, $sql_baiviet);
$row_bv = mysqli_fetch_array($query_bv)

?>
<div class="all_tin">
    <?php
    while ($row_baiviet = mysqli_fetch_array($query_baiviet)) {
    ?>
        <div class="baiviet">
            <a href="index.php?quanly=chitiettin&id=<?php echo $row_baiviet['id_baiviet'] ?>" style="text-decoration:none;">
                <img class="img img-responsive" style="text-align:center" src="admin/modules/quanlybaiviet/uploads/<?php echo $row_baiviet['hinhanh'] ?>">
                <div class="bv-ten">
                    <p><?php echo $row_baiviet['tenbaiviet'] ?></p>
                </div>
                <div class="bv-tg">
                    <h5><?php echo $row_baiviet['thoigian'] ?></h5>
                </div>
            </a>
        </div>
    <?php
    }
    ?>
</div>