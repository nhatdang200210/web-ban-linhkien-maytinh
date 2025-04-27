<div class="clear"></div>
<div class="main-admin">
    <?php
    include 'modules/sidebar/sidebar.php';
    ?>

</div>


<style type="text/css">
    .main-admin {
        display: flex;
        max-width: 100%;
        /* border: 1px solid blue; */
        margin: 0;
        height: auto;
        /* padding: 10px; */
        /* background-color: green */
    }

    @import "https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700";
    @media (max-width: 768px) {
        #sidebar {
            margin-left: -270px;
        }

        #sidebar.active {
            margin-left: 0;
        }

        #sidebarCollapse span {
            display: none;
        }
    }
</style>