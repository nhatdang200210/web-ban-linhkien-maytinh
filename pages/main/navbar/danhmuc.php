<div class="danhmuc">
    <div class="danhmuc_list">
        <?php
        $sql_danhmucsp = "SELECT * FROM tbl_danhmuc ORDER BY id_danhmucsp ASC";
        $query_danhmucsp = mysqli_query($mysqli, $sql_danhmucsp);
        while ($row_danhmuc = mysqli_fetch_array($query_danhmucsp)) {
        ?>
            <a href="index.php?quanly=sptheodm&id=<?php echo $row_danhmuc['id_danhmucsp'] ?>">
                <div class="list_title">

                    <span> <?php echo $row_danhmuc['tendanhmuc']; ?> </span>

                    <b style="float:right"><i class="fa-solid fa-angle-right"></i></b>
                </div>
            </a>
        <?php
        }
        ?>
    </div>
</div>