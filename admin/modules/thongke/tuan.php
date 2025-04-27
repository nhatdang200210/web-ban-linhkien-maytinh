<?php
// Mặc định ngày là ngày hiện tại nếu không có ngày nào được chọn
$selected_date = isset($_POST['selected_date']) ? $_POST['selected_date'] : date('Y-m-d');

// Lấy ngày đầu tiên và cuối cùng trong tuần của ngày được chọn
$first_day_of_week = date('Y-m-d', strtotime('monday this week', strtotime($selected_date)));
$last_day_of_week = date('Y-m-d', strtotime('sunday this week', strtotime($selected_date)));

// Thống kê theo khoảng thời gian (tuần)
$sql_statistics = "SELECT DATE(tbl_cart.ngaygiaohang) AS order_date, 
                        COUNT(DISTINCT tbl_cartdetail.madon) AS total_orders, 
                        SUM(tbl_cartdetail.soluongmua * tbl_sanpham.giasanpham) AS total_revenue 
                    FROM tbl_cart
                    JOIN tbl_cartdetail ON tbl_cart.id_cart = tbl_cartdetail.madon 
                    JOIN tbl_sanpham ON tbl_sanpham.id_sanpham = tbl_cartdetail.id_sanpham
                    WHERE tbl_cart.giao = 1
                        AND DATE(tbl_cart.ngaygiaohang) BETWEEN '$first_day_of_week' AND '$last_day_of_week'
                    GROUP BY DATE(tbl_cart.ngaygiaohang)
                    ORDER BY DATE(tbl_cart.ngaygiaohang)";

$result_statistics = mysqli_query($mysqli, $sql_statistics);

// Khởi tạo mảng lưu trữ dữ liệu theo ngày trong tuần
$week_data = array_fill(0, 7, ['order_date' => '', 'total_orders' => 0, 'total_revenue' => 0, 'product_name_most_sold' => '', 'total_quantity_most_sold' => 0]);

// Lấy dữ liệu từ kết quả truy vấn và gán vào mảng $week_data
while ($row = mysqli_fetch_array($result_statistics)) {
    $order_date = date('N', strtotime($row['order_date'])) - 1; // Chuyển đổi ngày thành số từ 0 (thứ 2) đến 6 (Chủ Nhật)
    $week_data[$order_date]['order_date'] = $row['order_date'];
    $week_data[$order_date]['total_orders'] = $row['total_orders'];
    $week_data[$order_date]['total_revenue'] = $row['total_revenue'];
    //tính tổng đơn hàng đã bán trong tuần
    $total_orders = 0;
    foreach ($week_data as $data) {
        $total_orders += $data['total_orders'];
    }
    //tính tổng doanh thu đã bán trong tuần
    $total_revenue = 0;
    foreach ($week_data as $data) {
        $total_revenue += $data['total_revenue'];
    }
}

/// Lấy dữ liệu sản phẩm được bán trong mỗi ngày
$sql_most_sold_product = "SELECT DATE(tbl_cart.ngaygiaohang) AS order_date,
                            (tbl_sanpham.tensanpham) AS product_name_most_sold,
                            SUM(tbl_cartdetail.soluongmua) AS total_quantity_most_sold
                          FROM tbl_cart
                          JOIN tbl_cartdetail ON tbl_cart.id_cart = tbl_cartdetail.madon
                          JOIN tbl_sanpham ON tbl_cartdetail.id_sanpham = tbl_sanpham.id_sanpham
                          WHERE tbl_cart.giao = 1
                            AND DATE(tbl_cart.ngaygiaohang) BETWEEN '$first_day_of_week' AND '$last_day_of_week'
                          GROUP BY DATE(tbl_cart.ngaygiaohang), tbl_sanpham.tensanpham
                          ORDER BY total_quantity_most_sold DESC";

$result_most_sold_product = mysqli_query($mysqli, $sql_most_sold_product);

// Lấy dữ liệu từ kết quả truy vấn và cập nhật mảng $week_data
while ($row = mysqli_fetch_array($result_most_sold_product)) {
    $order_date = date('N', strtotime($row['order_date'])) - 1; // Chuyển đổi ngày thành số từ 0 (thứ 2) đến 6 (Chủ Nhật)  
    $week_data[$order_date]['total_quantity_most_sold'] += $row['total_quantity_most_sold'];
    //tính tổng sản phẩm đã bán trong tuần
    $total_quantity_sold = 0;
    foreach ($week_data as $data) {
        $total_quantity_sold += $data['total_quantity_most_sold'];
    }
}


?>


</head>
<title>Admin - Thống kê tuần</title>
</head>

<div class="container-fluid" style="margin-top:30px">
    <div>
        <div class="nk-content-inner">
            <div class="nk-content-body" style="padding-left: 2%;">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <div class="cf-title-02 cf-title-alt-two title_all_sp" style="padding-top: 18px; margin-left:0px">
                                <h2>Thống kê doanh thu bán trong tuần</h2>
                            </div>
                            <hr style="" color="red">
                        </div>
                    </div>
                </div>
                <!-- Form để chọn ngày -->
                <form method="POST" class="mb-3">
                    <div class="form-group">
                        <label for="selected_date">Chọn ngày:</label>
                        <input style="width:150px;" type="date" id="selected_date" name="selected_date" value="<?php echo $selected_date; ?>" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Xác nhận</button>
                </form>
                <div class="row">
                    <div class="col-md-6" style="padding: 20px 0;"><canvas id="myChart3" style=""></canvas></div>
                    <div class="col-md-6" style="padding: 71px 0% 0px 2%">
                        <table class="table table-bordered" style="width:90%; ">
                            <tbody>
                                <tr>
                                    <th scope="row">Tổng doanh thu trong tuần:</th>
                                    <td>
                                        <?php
                                        if (isset($total_revenue)) {
                                            echo number_format($total_revenue, 0, ',', '.');
                                        } else {
                                            echo "0";
                                        }
                                        ?> vnđ
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Tổng đơn bán được trong tuần:</th>
                                    <td>
                                        <?php
                                        if (isset($total_orders)) {
                                            echo $total_orders;
                                        } else {
                                            echo "0";
                                        }
                                        ?> đơn
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Tổng sản phẩm bán trong tuần:</th>
                                    <td>
                                        <?php
                                        if (isset($total_quantity_sold)) {
                                            echo $total_quantity_sold;
                                        } else {
                                            echo "0";
                                        }
                                        ?> sản phẩm
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Định nghĩa một hàm để vẽ biểu đồ
    function drawChart() {
        var weekData = <?php echo json_encode($week_data); ?>;

        var ctx = document.getElementById('myChart3').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line', // Đổi từ 'bar' sang 'line'
            data: {
                labels: weekData.map(data => formatDate(data.order_date)),
                datasets: [{
                        label: 'Tổng sản phẩm đã bán',
                        data: weekData.map(data => data.total_quantity_most_sold),
                        backgroundColor: 'rgba(255, 206, 86, 0.2)',
                        borderColor: 'rgba(255, 206, 86, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Tổng số đơn hàng',
                        data: weekData.map(data => data.total_orders),
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Tổng tiền đã bán',
                        data: weekData.map(data => data.total_revenue),
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                },

            }
        });

    }

    function formatDate(dateString) {
        const options = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        };
        const date = new Date(dateString);
        if (!isNaN(date.getTime())) {
            return date.toLocaleDateString('vi-VN', options); // Trả về ngày tháng theo định dạng 'thứ, ngày tháng năm' nếu chuyển đổi thành công
        }
        return dateString; // Trả về chuỗi đầu vào nếu không thể chuyển đổi thành ngày hợp lệ
    }
    // Gọi hàm vẽ biểu đồ sau khi trang đã tải hoàn toàn
    window.onload = drawChart;
</script>