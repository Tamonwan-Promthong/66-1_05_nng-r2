<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
  $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!';
  header('location: login.php');
}
// Check if the user is not logged in, redirect to login page

require('dbConfig.php');

// Retrieve the roleId from the session
$roleId = isset($_SESSION['roleId']) ? $_SESSION['roleId'] : null;

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Forms / Elements - NiceAdmin Bootstrap Template</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/Tu1.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Jan 09 2024 with Bootstrap v5.3.2
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>



<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center bg-primary ">

    <div class="d-flex align-items-center justify-content-between">
    <img src="assets/img/Tu.png" alt="" style="width: 150px; height: 40px;">
      
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="content">
      <!-- notification message -->
      <?php if (isset($_SESSION['success'])) : ?>
        <div class="success">
          <h3>
            <?php
              echo $_SESSION['success'];
              unset($_SESSION['success']);
            ?>
          </h3>
        </div>
      <?php endif ?>


      <!-- logged in user information -->
      <?php if(isset($_SESSION['username'])) : ?>
        <!-- <p>Welcome <strong><?php echo $_SESSION['username']; ?></strong></p> -->
        <!-- <p><a href="index.php?logout='1'" style="color: red;">Logout</a></p> -->
      <?php endif ?>
    </div>
    
    <nav class="header-nav ms-auto ">
    <ul class="d-flex align-items-center">
    <li class="nav-item dropdown pe-3">
        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
        <span class="ri-user-line"></span>
            <?php
            // Prepare and execute the query to fetch the name of the logged-in user
            $sql = "SELECT name FROM user_account WHERE username = :username";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':username', $_SESSION['username']); // Bind the session username to the SQL parameter
            $stmt->execute();

            // Fetch the result
            $name = $stmt->fetchColumn();

            // Display the name if it's found, otherwise show a message
            if ($name) {
            ?>
            
                <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $name; ?></span>
        </a><!-- End Profile Image Icon -->
        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
                <h6><?php echo $name; ?></h6>
            </li>
            <li>
                <hr class="dropdown-divider">
            </li>
            <li>
                <a class="dropdown-item d-flex align-items-center" href="logout.php">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Sign Out</span>
                </a>
            </li>
            <?php
            } else {
                echo "User not found!";
            }
            ?>
        </ul><!-- End Profile Dropdown Items -->
    </li><!-- End Profile Nav -->
</ul>

    </nav><!-- End Icons Navigation -->
        
      </div>
  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
   <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">
  <?php include 'sidebar.php'; ?>
  </aside><!-- End Sidebar-->
  

  <main id="main" class="main d-flex justify-content-center align-items-center">
    
  

    

<section class="section dashboard" >
    <div >
        <h1 style="display: inline-block;">แดชบอร์ด</h1>
    </div><!-- End Page Title -->
  <div class="row">

                <!-- Left side columns -->
    <div  class="main d-flex justify-content-center align-items-center">
      <div class="row">
                    
                  <?php
    
            function getOrderCount($conn, $filter) {
                switch ($filter) {
                    case 'daily':
                        $sql = "SELECT COUNT(*) AS orderCount FROM orders WHERE DATE(timestamp) = CURDATE()";
                        break;
                    case 'monthly':
                        $sql = "SELECT COUNT(*) AS orderCount FROM orders WHERE YEAR(timestamp) = YEAR(CURRENT_DATE()) AND MONTH(timestamp) = MONTH(CURRENT_DATE())";
                        break;
                    case 'yearly':
                        $sql = "SELECT COUNT(*) AS orderCount FROM orders WHERE YEAR(timestamp) = YEAR(CURRENT_DATE())";
                        break;
                    default:
                        $sql = ""; // Handle default case
                }

                if (!empty($sql)) {
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    return $result['orderCount'];
                } else {
                    return 0; // Return 0 for default case or error
                }
            }

            // Get order count based on the selected filter
            $filter = isset($_GET['filter']) ? $_GET['filter'] : 'daily';
            $orderCount = getOrderCount($conn, $filter);
            ?>

            <!-- Sales Card -->
            <div class="col-lg-4 col-md-6">
              <div class="card info-card sales-card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="?filter=daily">วันนี้</a></li>
                    <li><a class="dropdown-item" href="?filter=monthly">เดือนนี้</a></li>
                    <li><a class="dropdown-item" href="?filter=yearly">ปีนี้</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">คำสั่งซื้อ <span>| <?php echo ucfirst($filter); ?></span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-cart"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?php echo $orderCount; ?></h6>
                      <!-- You can style the percentage change and add appropriate logic here -->
                      
                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Sales Card -->


            <?php

function getTotal($conn, $filter) {
    switch ($filter) {
        case 'daily':
            $sql = "SELECT SUM(totalAmount) AS totalRevenue FROM orders WHERE DATE(timestamp) = CURDATE()";
            break;
        case 'monthly':
            $sql = "SELECT SUM(totalAmount) AS totalRevenue FROM orders WHERE YEAR(timestamp) = YEAR(CURRENT_DATE()) AND MONTH(timestamp) = MONTH(CURRENT_DATE())";
            break;
        case 'yearly':
            $sql = "SELECT SUM(totalAmount) AS totalRevenue FROM orders WHERE YEAR(timestamp) = YEAR(CURRENT_DATE())";
            break;
        default:
            $sql = ""; // Handle default case
    }

    if (!empty($sql)) {
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['totalRevenue'] ? $result['totalRevenue'] : 0;
    } else {
        return 0; // Return 0 for default case or error
    }
}

// Get total revenue based on the selected filter
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'daily';
$total = getTotal($conn, $filter);
?>

<!-- Revenue Card -->
<div class="col-xxl-4 col-md-6">
  <div class="card info-card revenue-card">

    <div class="filter">
      <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
        <li class="dropdown-header text-start">
          <h6>Filter</h6>
        </li>

        <li><a class="dropdown-item" href="?filter=daily">วันนี้</a></li>
        <li><a class="dropdown-item" href="?filter=monthly">เดือนนี้</a></li>
        <li><a class="dropdown-item" href="?filter=yearly">ปีนี้</a></li>
      </ul>
    </div>

    <div class="card-body">
      <h5 class="card-title">ยอดขาย <span>| <?php echo ucfirst($filter); ?></span></h5>

      <div class="d-flex align-items-center">
        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
          <i class="bi bi-cash-coin"></i>
        </div>
        <div class="ps-3">
          <h6>฿<?php echo number_format($total, 2); ?></h6>
          <!-- You can style the percentage change and add appropriate logic here -->
        
        </div>
      </div>
    </div>

  </div>
</div><!-- End Revenue Card -->

   <!-- Customers Card -->
<div class="col-xxl-4 col-xl-12">
    <div class="card info-card customers-card">
        <div class="filter">
            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                    <h6>Filter</h6>
                </li>
                <li><a class="dropdown-item" href="?filter=daily">วันนี้</a></li>
                <li><a class="dropdown-item" href="?filter=monthly">เดือนนี้</a></li>
                <li><a class="dropdown-item" href="?filter=yearly">ปีนี้</a></li>
            </ul>
        </div>

        <div class="card-body">
            <h5 class="card-title">เฉลี่ยต่อบิล <span>| 
                <?php 
                switch($filter) {
                    case 'daily':
                        echo 'วันนี้';
                        break;
                    case 'monthly':
                        echo 'เดือนนี้';
                        break;
                    case 'yearly':
                        echo 'ปีนี้';
                        break;
                }
                ?>
            </span></h5>

            <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-graph-up"></i>
                </div>
                <div class="ps-3">
                    <?php
                    if ($orderCount > 0) {
                        $average = $total / $orderCount;
                        echo '<h6>฿' . number_format($average, 2) . '</h6>';
                    } else {
                        echo '<h6>฿0.00</h6>'; 
                    }
                    ?>
                    <!-- You can style the percentage change and add appropriate logic here -->
                    

                </div>
            </div>

        </div>
    </div>
</div><!-- End Customers Card -->
<?php
    // Fetch data from the database
    $stmt = $conn->prepare("SELECT SUM(totalAmount) AS sumTotal, dmonth FROM orders GROUP BY dmonth ORDER BY CAST(dmonth AS DATE)");

    $stmt->execute();
    $orderDataForReports = $stmt->fetchAll(PDO::FETCH_ASSOC);

  
    $salesData = array_column($orderDataForReports, 'sumTotal');
    $months = array_column($orderDataForReports, 'dmonth');
?>

<div class="col-12">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">รายงาน </h5>
            <div id="reportsChart"></div>
            <script>
                document.addEventListener("DOMContentLoaded", () => {
                    new ApexCharts(document.querySelector("#reportsChart"), {
                        series: [{
                            name: 'ยอดขาย',
                            data: <?php echo json_encode($salesData); ?>,
                        }],
                        chart: {
                            height: 400,
                            type: 'area',
                            toolbar: {
                                show: false
                            },
                        },
                        markers: {
                            size: 4
                        },
                        colors: ['#4154f1', '#2eca6a', '#ff771d'],
                        fill: {
                            type: "gradient",
                            gradient: {
                                shadeIntensity: 1,
                                opacityFrom: 0.3,
                                opacityTo: 0.4,
                                stops: [0, 90, 100]
                            }
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            curve: 'smooth',
                            width: 2
                        },
                        xaxis: {
                            categories: <?php echo json_encode($months); ?>,
                        },
                        tooltip: {
                            x: {
                                format: 'dd/MM/yy HH:mm'
                            },
                        }
                    }).render();
                });
            </script>
        </div>
    </div>
</div>




      


<?php

    // Query to count the occurrences of COD equal to 'y' and 'n' in the orders table
    $stmt = $conn->prepare("SELECT SUM(CASE WHEN COD = 'y' THEN 1 ELSE 0 END) AS codYCount, 
                                   SUM(CASE WHEN COD = 'n' THEN 1 ELSE 0 END) AS codNCount 
                            FROM orders");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Get the counts from the result
    $codYCount = $result['codYCount'];
    $codNCount = $result['codNCount'];

?>

<div class="col-lg-4">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">การชำระเงิน</h5>

            <!-- Bar Chart -->
            <canvas id="barChart" style="max-height: 500px;"></canvas>
            <script>
                document.addEventListener("DOMContentLoaded", () => {
          
                    var codYCount = <?php echo $codYCount; ?>;
                    var codNCount = <?php echo $codNCount; ?>;

                    new Chart(document.querySelector('#barChart'), {
                        type: 'bar',
                        data: {
                            labels: ['ชำระปลายทาง', 'โมบายแบงค์กิ้ง'],
                            datasets: [{
                                label: 'Bar Chart',
                                data: [codYCount, codNCount],
                                backgroundColor: [
                                    'rgba(75, 192, 192, 0.2)',
                                    'rgba(153, 102, 255, 0.2)'
                                ],
                                borderColor: [
                                    'rgb(75, 192, 192)',
                                    'rgb(153, 102, 255)'
                                ],
                                borderWidth: 2
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                });
            </script>
            <!-- End Bar Chart -->

        </div>
    </div>
</div>

<?php
require('dbConfig.php');


$sql = "SELECT od.productId, p.productName, COUNT(*) AS productCount 
        FROM orders_detail od 
        INNER JOIN product p ON od.productId = p.productId 
        GROUP BY od.productId 
        ORDER BY productCount DESC 
        LIMIT 5";
$stmt = $conn->prepare($sql);
$stmt->execute();
$productData = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Prepare data for the pie chart
$productLabels = [];
$productCounts = [];
foreach ($productData as $product) {
    $productLabels[] = $product['productName']; 
    $productCounts[] = $product['productCount'];
}
$productLabels = json_encode($productLabels);
$productCounts = json_encode($productCounts);
?>
<div class="col-lg-8">
    <div class="card">
        <div class="card-body">
            <div>
                <h5 class="card-title"><i class="bi bi-trophy-fill"></i>  สินค้าขายดี 5 อันดับ</h5>
            </div>
            <!-- Pie Chart -->
            <div id="pieChart" style="min-height: 400px;" class="echart"></div>

            <script>
                document.addEventListener("DOMContentLoaded", () => {
                    var productLabels = <?php echo $productLabels; ?>;
                    var productCounts = <?php echo $productCounts; ?>;

                    echarts.init(document.querySelector("#pieChart")).setOption({
                        title: {},
                        tooltip: {
                            trigger: 'item'
                        },
                        legend: {
                            orient: 'vertical',
                            left: 'right'
                        },
                        series: [{
                            name: 'Access From',
                            type: 'pie',
                            radius: '80%',
                            data: productLabels.map((label, index) => ({
                                value: productCounts[index],
                                name: label
                            })),
                            emphasis: {
                                itemStyle: {
                                    shadowBlur: 10,
                                    shadowOffsetX: 0,
                                    shadowColor: 'rgba(0, 0, 0, 0.5)'
                                }
                            }
                        }]
                    });
                });
            </script>
            <!-- End Pie Chart -->

        </div>
    </div>
</div>



        
      </div>
          </div>
        </div>

    

  </div>
</section>
    </main>

            



























  


  

  <!-- ======= Footer ======= -->
  <!-- <footer id="footer" class="footer">
 
  </footer>End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
  


</body>

</html>