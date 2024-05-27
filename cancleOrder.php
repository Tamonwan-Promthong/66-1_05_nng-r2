<?php
session_start();
require('dbConfig.php');
if (!isset($_SESSION['loggedin'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!';
    header('location: login.php');
  }
  

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

  <img src="assets/img/Tu.png" alt="" style="width: 150px; height: 40px;">
    <!-- <span class="d-none d-lg-block">Ecommerce</span> -->
  </a>
  <i class="bi bi-list toggle-sidebar-btn"></i>
</div><!-- End Logo -->
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

</header><!-- End Header --><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">
  <?php include 'sidebar.php'; ?>


  </aside><!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h1 style="margin: 0;"></h1>
    </div><!-- End Page Title -->

    <section class="section">
    <div class="pagetitle">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h1 style="margin: 0;">ยกเลิกคำสั่งซื้อ</h1>
                              <!-- <a href="buying.php">
                                  <button type="button" class="btn btn-primary" data-bs-target="#fullscreenModal" style="margin-top: 10px;">
                                  เพิ่มคำสั่งซื้อ
                                  </button>
                              </a> -->
                    </div>
          </div><!-- End Page Title -->
          <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
            <h5 class="card-title">รายละเอียดคำสั่งซื้อ</h5>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">หมายเลขคำสั่งซื้อ&nbsp;<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?></label>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">รายการคำสั่งซื้อ</label>
           
            </div>
            <div class="card-body">
            
                <table class="table ">
                        <thead>
                            <tr>
                                <th></th>
                                <th> </th>
                                <th></th>
                                <th></th>
                                <th></th>
                            
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // viewOrder.php

                            // Check if orderId is set in URL parameters
                            if(isset($_GET['id'])) {
                                // Get the orderId from URL
                                $orderId = $_GET['id'];

                                
                                require_once 'dbConfig.php';

                                // Fetch order details from the database based on orderId
                                $stmt = $conn->prepare("SELECT * FROM orders_detail WHERE orderId = :orderId");
                                $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
                                $stmt->execute();
                                
                                // Check if any rows are returned
                                if($stmt->rowCount() > 0) {
                                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                        <tr>
                                            
                                            <?php
                                            
                                            $productStmt = $conn->prepare("SELECT * FROM product WHERE productId = :productId");
                                            $productStmt->bindParam(':productId', $row['productId'], PDO::PARAM_INT);
                                            $productStmt->execute();
                                            
                                            
                                            if($productStmt->rowCount() > 0) {
                                                $productRow = $productStmt->fetch(PDO::FETCH_ASSOC);
                                                ?>
                                                <td><img src="data:image/jpeg;base64,<?php echo base64_encode($productRow['img']); ?>" width="100" height="100"></td>
                                                <td><?php echo $productRow['productName']; ?></td>
                                                <td><?php echo $productRow['productCode']; ?></td>
                                                <td>x<?php echo $row['qty']; ?></td>
                                                <td><?php echo $productRow['price']; ?></td>
                                            
                                                <?php
                                            } else {
                                            
                                                echo "<td colspan='3'>Product not found for ID: " . $row['productId'] . "</td>";
                                            }
                                            ?>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                
                                    echo "<tr><td colspan='4'>No order details found for the provided order ID.</td></tr>";
                                }
                            } else {
                                // orderId is not set in URL parameters
                                echo "<tr><td colspan='4'>Order ID is not provided in the URL.</td></tr>";
                            }
                            ?>
                        </tbody>
                        <tfoot>
                        <?php
                                if(isset($_GET['id'])) {
                                    // Fetch the total amount for the specified order ID
                                    $stmt = $conn->prepare("SELECT total_amount FROM orders_detail WHERE orderId = :orderId");
                                    $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
                                    $stmt->execute();
                                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                ?>
                                <tfoot>
                                    <tr>
                                        <td colspan="4" class="text-right"><strong>Total</strong></td>
                                        <td colspan="2">$<?php echo $row['total_amount']; ?></td>
                                    </tr>
                                </tfoot>
                                <?php
                                }
                                ?>
                        </tfoot>
                </table>

            </div>
            <div class="row mb-3">
                <?php
                        // Check if order ID is set in the URL
                        if(isset($_GET['id'])) {
                            // Get the orderId from URL
                            $orderId = $_GET['id'];
                            
                            $stmt = $conn->prepare("SELECT * FROM orders WHERE orderId = :orderId");
                            $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
                            $stmt->execute();
                    
                            $row = $stmt->fetch(PDO::FETCH_ASSOC);
                            ?>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">การชำระเงิน</label>
                                <?php
                                if ($row['COD'] == 'y') {
                                    echo "ชำระเงินปลายทาง";
                                }
                                if (!empty($row['slipimg'])) {
                                    echo "โอนชำระแล้ว";
                                }
                                ?>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">ชื่อลูกค้า</label>
                                <?php
                                echo $row['nameCustomer']; 
                                ?>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">เบอร์โทรลูกค้า</label>
                                <?php
                                echo $row['tel']; 
                                ?>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">ที่ออยู่ลูกค้า</label>
                                <?php
                                echo $row['addrCustomer']; 
                                ?>
                            </div>
                            <?php
                        }
                        ?>
                    </div>

            </div>
          </div>
        </div>    
      </div>

      <div class="row">
        <div class="col-lg-12">

        <form action="cancleOrder_db.php" method="POST">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">รายละเอียดการยกเลิกสินค้า</h5>   

            <div class="col-md-6">
                <label for="inputState" class="form-label">เหตุผลในการยกเลิก</label>
                <select id="inputState" class="form-select" name="cancleId">
                    <option selected>Choose...</option>
                    <?php
                    require_once 'dbConfig.php';
                    $stmt = $conn->query("SELECT * FROM cancle");

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo '<option value="' . $row['cancleId'] . '">' . $row['cancleName'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-6">
                <label for="inputState" class="form-label">หมายเหตุ</label>
                <div class="form-floating">
                    <textarea class="form-control" placeholder="Address" id="floatingTextarea" style="height: 100px;" name="cancleDetail"></textarea>
                    <label for="floatingTextarea">หมายเหตุ</label>
                </div>
            </div> <?php
                            // viewOrder.php

                            // Check if orderId is set in URL parameters
                            if(isset($_GET['id'])) {
                                // Get the orderId from URL
                                $orderId = $_GET['id'];
                            }?>
            <input type="hidden" name="orderId" value="<?php echo  $orderId; ?>">
            <div style="text-align: right;">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
   
        </div>    
    
        
    </div>

</form>

      

      
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
  </footer><!-- End Footer -->

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