<?php
$sql_baiviet = "SELECT * FROM tbl_baiviet WHERE tbl_baiviet.id_baiviet= '$_GET[id]' LIMIT 1";
$query_baiviet = mysqli_query($mysqli, $sql_baiviet);
$query_baiviet_all = mysqli_query($mysqli, $sql_baiviet);

$row_baiviet = mysqli_fetch_array($query_baiviet);
?>
</head>
<title>An Phát Computer - <?php echo $row_baiviet['tenbaiviet'] ?></title>
</head>
<div style="margin: 0">
    <a href="index.php?quanly=tintuc">
        Tin tức >
    </a>
    <a href="index.php?quanly=chitiettin&id">
        <?php echo 'Bài viết ' . $row_baiviet['tenbaiviet'] ?>
    </a>
</div>
<div class="chitiet_tin">
    <div class="thongtin">
        <div class="tabs" style="background-color: white;">
            <ul style="padding: 0;">
                <li>
                    <img class=" img img-responsive col-md-12" width="100%" src="admin/modules/quanlybaiviet/uploads/<?php echo $row_baiviet['hinhanh'] ?>">
                </li>
            </ul>
            <div id="tabs-content">
                <div id="tab1" class="tab-content" style="text-align:justify;">
                    <div class="nd_tin">
                        <div class="content-wrapper2">
                            <h1 style="font-weight: 600;"><?php echo $row_baiviet['tenbaiviet'] ?></h1>
                            <div class="image_tin">
                                <?php echo $row_baiviet['noidung'] ?>
                            </div>

                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .nd_tin {
        width: 80%;
        margin: auto;
        padding: 3% 7% 5%;
        border-radius: 10px;
        box-shadow: 0 1px 2px 0 rgba(60, 64, 67, .1), 0 2px 6px 2px rgba(60, 64, 67, .15);
    }

    .chitiet_tin {
        padding: 10px;
    }

    .image_tin img {
        width: 100%
    }
</style>