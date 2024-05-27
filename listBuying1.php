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

  </header><!-- End Header --><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">
  <?php include 'sidebar.php'; ?>

  </aside><!-- End Sidebar-->

  <main id="main" class="main">
    
  <section class="section">
  
          <div class="pagetitle">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h1 style="margin: 0;">รายการที่สร้างคำสั่งซื้อ</h1>
                        <?php
                // Check if the roleId is 1 or 2
                if ($roleId == 1 || $roleId == 2) {
            ?>
                <a href="buying.php">
                    <button type="button" class="btn btn-primary" data-bs-target="#fullscreenModal" style="margin-top: 10px;">
                        เพิ่มคำสั่งซื้อ
                    </button>
                </a>
            <?php
                }
            ?>
                    </div>
          </div><!-- End Page Title -->
                    <div class="row">
                      <div class="card">
                      <div class="card-body">
                      <h5 class="card-title"></h5>
                      <form method="GET" action="" class="search-form row g-3">
                      <div class="row">
                    <div class="col-md-4">
                        <label for="inputName5" class="form-label">รหัสคำสั่งซื้อ</label>
                        <input type="text" name="orderCode" class="form-control" placeholder="รหัสคำสั่งซื้อ">
                    </div>       
                    <div class="col-md-4">
                        <label for="inputStatus" class="form-label">สถานะ</label>
                        <select name="statusName" class="form-control">
                            <option value="">เลือกสถานะ</option>
                            <?php
                            require_once 'dbConfig.php';
                            $statuses = $conn->query("SELECT * FROM status");
                            foreach ($statuses as $status) {
                                echo "<option value='" . $status['statusName'] . "'>" . $status['statusName'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
            <div class="col-md-4">
                <label for="inputDate" class="form-label">Date</label>
                <input type="date" class="form-control"  name="timestamp">     
            </div>
        </div>


              <div class="col-md-12 text-end mt-3"> <!-- Add margin top for spacing -->
                  <button type="submit" class="btn btn-primary">search</button>
              </div>
          </form>
      </div>
      </div>
    </div>
      <div class="row">
        <div class="col-lg-12">
         <div class="card">
            <div class="card-body">
              <ul class="nav nav-tabs nav-tabs-bordered" id="borderedTab" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link active" id="allship-tab" data-bs-toggle="tab" data-bs-target="#bordered-allship" type="button" role="tab" aria-controls="allship" aria-selected="true">ทั้งหมด</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="success-tab" data-bs-toggle="tab" data-bs-target="#bordered-success" type="button" role="tab" aria-controls="success" aria-selected="false">รอเตรียมการจัดส่ง</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link " id="mustbeship-tab" data-bs-toggle="tab" data-bs-target="#bordered-mustbeship" type="button" role="tab" aria-controls="mustbeship" aria-selected="false">กำลังเตรียมการจัดส่ง</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="shipping-tab" data-bs-toggle="tab" data-bs-target="#bordered-shipping" type="button" role="tab" aria-controls="shipping" aria-selected="false">จัดส่งสำเร็จ</button>
              </li> 
             <li class="nav-item" role="presentation">
                <button class="nav-link" id="unsuccess-tab" data-bs-toggle="tab" data-bs-target="#bordered-unsuccess" type="button" role="tab" aria-controls="unsuccess" aria-selected="false">รายการยกเลิก</button>
              </li> 
            </ul>
            <main class="tab-content pt-2" id="borderedTabContent">
                 <div class="tab-pane fade show active" id="bordered-allship" role="tabpanel" aria-labelledby="allship-tab">                          
                      <div class="card recent-sales overflow-auto">
                        <div class="card-body">
                        <?php
                          require_once 'dbConfig.php';

                  
                          $stmt = $conn->prepare("SELECT COUNT(*) AS total_items FROM orders");

                          // Execute query
                          $stmt->execute();

                          // Fetch the result
                          $row = $stmt->fetch(PDO::FETCH_ASSOC);

                          // Check if the query was successful
                          if ($row) {
                              $total_items = $row['total_items'];
                              
                              // Display the count
                              echo "<h3 class='mt-4'>$total_items รายการ</h3>";
                          } else {
                              // Handle error if query fails
                              echo "Error: No data found";
                          }
                          ?>
                  
<form action="update2.php" method="post">
                        <table class="table ">
                              <thead>
                                  <tr>
                                    <th>    
                                        <span>คำสั่งซื้อ</span>
                                    </th>
                                      <th>สินค้า</th>
                                      <th>ชื่อผู้สั่งซื้อ</th>
                                      <th>สถานะคำสั่งซื้อ</th>
                                      <th>การชำระเงิน</th>
                                      <th>การจัดส่ง</th>
                                      <th>เลขพัสดุ</th>
                                      <th>Action</th>
                                  </tr>
                              </thead>
                        <tbody>
                          <?php
                         require_once 'dbConfig.php';

                         // Initialize orderId, statusName, and timestamp variables
                         $orderCode = isset($_GET['orderCode']) ? $_GET['orderCode'] : '';       
                         $statusName = isset($_GET['statusName']) ? $_GET['statusName'] : '';   
                         $timestamp = isset($_GET['timestamp']) ? $_GET['timestamp'] : '';
                         
                         // Prepare the SQL query with placeholders for conditions
                        $sql = "SELECT o.*, s.statusName, m.messengerName
        FROM orders o 
        JOIN status s ON o.statusId = s.statusId
        JOIN messenger m ON o.messengerId = m.messengerId";
                         // If orderId is not empty, add a condition to the query to filter by orderId
                         if (!empty($orderCode)) {
                             $sql .= " WHERE o.orderCode = :orderCode";
                         }
                         
                         // If statusName is not empty, add a condition to the query to filter by statusName
                         if (!empty($statusName)) {
                             $sql .= " AND s.statusName LIKE '%$statusName%'";
                         }
                         
                         // If timestamp is not empty, add a condition to the query to filter by timestamp
                         if (!empty($timestamp)) {
                             $sql .= " AND DATE(o.timestamp) = :timestamp"; // Assuming timestamp_column is your timestamp column name
                         }
                         
                         // Execute the prepared SQL query
                         $stmt = $conn->prepare($sql);
                         
                         // If orderCode is provided, bind the parameter and execute the query
                         if (!empty($orderCode)) {
                             $stmt->bindParam(':orderCode', $orderCode);
                         }
                         
                         // If timestamp is provided, bind the parameter and execute the query
                         if (!empty($timestamp)) {
                             $stmt->bindParam(':timestamp', $timestamp);
                         }
                         

                         
                         
                         $stmt->execute();

                          // Check if the query executed successfully
                          if ($stmt) {
                              foreach ($stmt as $row) {
                                  ?>
                                  <tr>
                                      <td>
                                      <div>
                                              <input type="checkbox" class="orderCheckbox" name="orderCheckbox[]" value="<?php echo $row['orderId']; ?>">
                                              <span><a href="viewOrder.php?id=<?php echo $row['orderId']; ?>"><?php echo $row['orderCode']; ?></a></span>

                                          </div>
                                          <div>
                                              <?php echo date("F j, Y, g:i a", strtotime($row['timestamp'])); ?>
                                          </div>
                                      </td>
                                      <td>
                                          <?php
                                          $stmt_inner = $conn->prepare("SELECT * FROM orders_detail WHERE orderId = :orderId");
                                          $stmt_inner->bindParam(':orderId', $row['orderId'], PDO::PARAM_INT);
                                          $stmt_inner->execute();
                                          while ($row_inner = $stmt_inner->fetch(PDO::FETCH_ASSOC)) {
                                              $stmt_product = $conn->prepare("SELECT * FROM product WHERE productId = :productId");
                                              $stmt_product->bindParam(':productId', $row_inner['productId'], PDO::PARAM_INT);
                                              $stmt_product->execute();
                                              $product = $stmt_product->fetch(PDO::FETCH_ASSOC);

                                              $width = 50;
                                              $height = 50;
                                              ?>
                                              <img src="data:image/jpeg;base64,<?php echo base64_encode($product['img']); ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>">
                                              <?php
                                          }
                                          ?>
                                      </td>
                                      <td><?php echo $row['nameCustomer']; ?></td>
                                      <td <?php if($row['statusId'] == 6) echo 'style="color: red;"'; ?>><?php echo $row['statusName']; ?></td>

                                      <td><?php echo $row['totalAmount']; ?> <span>฿</span>
                                      <div>
                                        <?php
                                        // Check if COD is 'y', then echo "ชำระเงินปลายทาง"
                                        if ($row['COD'] == 'y') {
                                            echo '<span style="color: orange;">ชำระเงินปลายทาง</span>';
                                        }
                                        if (!empty($row['slipimg'])) {
                                            // If payment is done, display "โอนชำระแล้ว" in green color
                                            echo '<span style="color: green;">โอนชำระแล้ว</span>';
                                        }
                                        ?>
                                    </div>                 
                                      </td>
                                      
                                      <td><?php echo $row['messengerName']; ?></td>
                                      <td>
                                      <?php echo $row['trackingNum']; ?>
                                      </td>
                                      <td> 
                                      <?php
                                    // Check if roleId is 1 or 2
                                    if ($roleId == 1 || $roleId == 2) {
                                          echo '
                                      <div>
                                        <a href="editBuying.php?id=' . $row['orderId'] . '">แก้ไขรายการ</a>
                                      </div>
                                      <div>
                                        <a href="cancleOrder.php?id=' . $row['orderId'] . '">ยกเลิกรายการ</a>
                                      </div>
                                      <div>
                                        <a href="returnandrefund.php?id=' . $row['orderId'] . '">การคืนเงิน</a>
                                      </div>
                                      <div>
                                        <a href="#" class="delete-link" data-id="' . $row['orderId'] . '">ลบ</a>
                                      </div>';
                                    }else{
                                        echo '<div>
                                                <a >viewOrder</a>
                                            </div>
                                            <div>
                                                <a >แก้ไขรายการ</a>
                                            </div>
                                            <div>
                                                <a >ยกเลิกรายการ</a>
                                            </div>
                                            <div>
                                                <a >การคืนเงิน</a>
                                            </div>
                                            <div>
                                                <a>ลบ</a>
                                            </div>';
                                    }
                                    ?>
   
            
    
</td>
                                  </tr>
                                  <?php
                              }
                          } 
                          ?>
                          </tbody>

                      </table>
                      <div style="text-align: right;">
                      <button type="submit" class="btn btn-primary" name="updateTracking">
                        Update Status
                          </button>
                              </div>
                     
</form>
                        </div>
                        
                      </div>
                </div>

                <div class="tab-pane fade" id="bordered-success" role="tabpanel" aria-labelledby="success-tab">
                  <div class="card">
                   
                  
                        <div class="card recent-sales overflow-auto">
                          <div class="card-body">
                          <?php
                              require_once 'dbConfig.php';

                              // Query to count the number of items with statusId = 7
                              $stmt = $conn->prepare("SELECT COUNT(*) AS total_items FROM orders WHERE statusId = ?");

                              // Bind parameter
                              $statusId_2 = 2;
                              $stmt->bindParam(1, $statusId_2);

                              // Execute query
                              $stmt->execute();

                              // Fetch the result
                              $row = $stmt->fetch(PDO::FETCH_ASSOC);

                              // Check if the query was successful
                              if ($row) {
                                  $total_items = $row['total_items'];
                                  
                                  // Display the count
                                  echo "<h3 class='mt-4'>$total_items รายการ</h3>";
                              } else {
                                  // Handle error if query fails
                                  echo "Error: No data found";
                              }
                              ?>
                    <form action="update.php" method="post">
    
                        <table class="table ">
                                    <thead>
                                  <tr>

                                  <th>
                <!-- Checkbox in the header -->
                                        <input type="checkbox" id="selectAll">
                                        <label for="selectAll">คำสั่งซื้อ</label>
                                    </th>

                                      <th>สินค้า</th>
                                      <th>ชื่อผู้สั่งซื้อ</th>
                                      <th>สถานะคำสั่งซื้อ</th>
                                      <th>การชำระเงิน</th>
                                      <th>การจัดส่ง</th>
                                      <th>Action</th>
                                  </tr>
                              </thead>

                                  <tbody>
                                      <?php
                                      $stmt = $conn->prepare("SELECT o.*, s.statusName, m.* 
                                      FROM orders o 
                                      INNER JOIN status s ON o.statusId = s.statusId 
                                      INNER JOIN messenger m ON o.messengerId = m.messengerId
                                      WHERE o.statusId = ?");
                                      $statusId = 2; // Set the desired statusId
                                      $stmt->bindParam(1, $statusId, PDO::PARAM_INT);
                                      $stmt->execute();

                                      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                      ?>
                                         <tr>
                                      <td>
                                          <div>
                                              <input type="checkbox" class="orderCheckbox" name="orderCheckbox[]" value="<?php echo $row['orderId']; ?>">
                                              <span><a href="viewOrder.php?id=<?php echo $row['orderId']; ?>"><?php echo $row['orderCode']; ?></a></span>

                                          </div>
                                          <div>
                                              <?php echo date("F j, Y, g:i a", strtotime($row['timestamp'])); ?>
                                          </div>
                                      </td>
                                      <td>
                                          <?php
                                          $stmt_inner = $conn->prepare("SELECT * FROM orders_detail WHERE orderId = :orderId");
                                          $stmt_inner->bindParam(':orderId', $row['orderId'], PDO::PARAM_INT);
                                          $stmt_inner->execute();
                                          while ($row_inner = $stmt_inner->fetch(PDO::FETCH_ASSOC)) {
                                              $stmt_product = $conn->prepare("SELECT * FROM product WHERE productId = :productId");
                                              $stmt_product->bindParam(':productId', $row_inner['productId'], PDO::PARAM_INT);
                                              $stmt_product->execute();
                                              $product = $stmt_product->fetch(PDO::FETCH_ASSOC);

                                              $width = 50;
                                              $height = 50;
                                              ?>
                                              <img src="data:image/jpeg;base64,<?php echo base64_encode($product['img']); ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>">
                                              <?php
                                          }
                                          ?>
                                      </td>
                                      <td><?php echo $row['nameCustomer']; ?></td>
                                      <td><?php echo $row['statusName']; ?></td> 
                                      <td><?php echo $row['totalAmount']; ?> <span>฿</span>
                                            <div>
                                        <?php
                                        // Check if COD is 'y', then echo "ชำระเงินปลายทาง"
                                        if ($row['COD'] == 'y') {
                                            echo '<span style="color: orange;">ชำระเงินปลายทาง</span>';
                                        }
                                        if (!empty($row['slipimg'])) {
                                            // If payment is done, display "โอนชำระแล้ว" in green color
                                            echo '<span style="color: green;">โอนชำระแล้ว</span>';
                                        }
                                        
                                        ?>
                                    </div>                     
                                      </td>
                                      <td><?php echo $row['messengerName']; ?></td>
                                      <td> 
                                      <?php
                                    // Check if roleId is 1 or 2
                                    if ($roleId == 1 || $roleId == 2) {
                                          echo '
                                        <a href="editBuying.php?id=' . $row['orderId'] . '">แก้ไขรายการ</a>
                                      </div>
                                      <div>
                                        <a href="cancleOrder.php?id=' . $row['orderId'] . '">ยกเลิกรายการ</a>
                                      </div>
                                      <div>
                                        <a href="returnandrefund.php?id=' . $row['orderId'] . '">การคืนเงิน</a>
                                      </div>
                                      <div>
                                        <a href="#" class="delete-link" data-id="' . $row['orderId'] . '">ลบ</a>
                                      </div>';
                                    }else{
                                        echo '<div>
                                                <a >viewOrder</a>
                                            </div>
                                            <div>
                                                <a >แก้ไขรายการ</a>
                                            </div>
                                            <div>
                                                <a >ยกเลิกรายการ</a>
                                            </div>
                                            <div>
                                                <a >การคืนเงิน</a>
                                            </div>
                                            <div>
                                                <a>ลบ</a>
                                            </div>';
                                    }
                                    ?>
                                  </tr>
                                      <?php
                                      }
                                      ?>
                                  </tbody>
                        </table>
                       
                          <div style="text-align: right;">
                          <button type="submit" class="btn btn-primary" name="updateStatusBtn">
                        Update Status
                          </button>
                              </div>
                          
                        
</form>
                              <!-- End Default Table Example -->
                          </div>
                        </div>
                 
                  </div>
                </div>

                
                <div class="tab-pane fade" id="bordered-mustbeship" role="tabpanel" aria-labelledby="mustbeship-tab">
                  <div class="card">
                             
                        <div class="card recent-sales overflow-auto">
                          <div class="card-body">
                          <?php
                              require_once 'dbConfig.php';

                              // Query to count the number of items with statusId = 7
                              $stmt = $conn->prepare("SELECT COUNT(*) AS total_items FROM orders WHERE statusId = ?");

                              // Bind parameter
                              $statusId_7 = 7;
                              $stmt->bindParam(1, $statusId_7);

                              // Execute query
                              $stmt->execute();

                              // Fetch the result
                              $row = $stmt->fetch(PDO::FETCH_ASSOC);

                              // Check if the query was successful
                              if ($row) {
                                  $total_items = $row['total_items'];
                                  
                                  // Display the count
                                  echo "<h3 class='mt-4'>$total_items รายการ</h3>";
                              } else {
                                  // Handle error if query fails
                                  echo "Error: No data found";
                              }
                              ?>
                        <form action="update_tracking.php" method="post">
                        <table class="table">
                                  <thead>
                                      <tr>
                                      <th>
                
                                        <input type="checkbox" id="selectAll1">
                                        <label for="selectAll">คำสั่งซื้อ</label>
                                    </th>
                                          <th>ผู้ซื้อ</th>
                                          <th>สินค้า</th>
                                          <th>สถานะคำสั่งซื้อ</th>
                                          <th>การจัดส่ง</th>
                                          <th>ราคา</th>
                                          <th>เลขพัสดุ</th>
                                      </tr>
                                  </thead>

                                  <tbody>
                                      <?php
                                      $stmt = $conn->prepare("SELECT o.*, s.statusName, m.* 
                                      FROM orders o 
                                      INNER JOIN status s ON o.statusId = s.statusId 
                                      INNER JOIN messenger m ON o.messengerId = m.messengerId
                                      WHERE o.statusId = ?");
                                      $statusId = 7; // Set the desired statusId
                                      $stmt->bindParam(1, $statusId, PDO::PARAM_INT);
                                      $stmt->execute();

                                      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                      ?>
                                          <tr>
                                              <td>
                                                  <div>
                                                      <input type="checkbox" class="orderCheckbox" name="orderCheckbox[]" value="<?php echo $row['orderId']; ?>">
                                                      <span><a href="viewOrder.php?id=<?php echo $row['orderId']; ?>"><?php echo $row['orderCode']; ?></a></span>

                                                  </div>
                                                  <div>
                                                      <?php echo date("F j, Y, g:i a", strtotime($row['timestamp'])); ?>
                                                  </div>
                                              </td>
                                              <td><?php echo $row['nameCustomer']; ?></td>
                                              <td>
                                                  <?php
                                                  $stmt_inner = $conn->prepare("SELECT * FROM orders_detail WHERE orderId = :orderId");
                                                  $stmt_inner->bindParam(':orderId', $row['orderId'], PDO::PARAM_INT);
                                                  $stmt_inner->execute();
                                                  while ($row_inner = $stmt_inner->fetch(PDO::FETCH_ASSOC)) {
                                                      $stmt_product = $conn->prepare("SELECT * FROM product WHERE productId = :productId");
                                                      $stmt_product->bindParam(':productId', $row_inner['productId'], PDO::PARAM_INT);
                                                      $stmt_product->execute();
                                                      $product = $stmt_product->fetch(PDO::FETCH_ASSOC);

                                                      $width = 50;
                                                      $height = 50;
                                                  ?>
                                                      <img src="data:image/jpeg;base64,<?php echo base64_encode($product['img']); ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>">
                                                  <?php
                                                  }
                                                  ?>
                                              </td>
                                              <td><?php echo $row['statusName']; ?></td> <!-- Show statusName instead of statusId -->
                                              <td><?php echo $row['messengerName']; ?></td>
                                              <td><?php echo $row['totalAmount']; ?> <span>฿</span></td>
                                              <td> 
                                                  <div class="col-md-6">
                                                      <input type="text" class="form-control" name="trackingNum[<?php echo $row['orderId']; ?>]" placeholder="Enter tracking number">
                                                  </div>
                                              </td>
                                          </tr>
                                      <?php
                                      }
                                      ?>
                                  </tbody>
                              </table>

                              <div style="text-align: right;">
                              <div>
                                                    <?php
                                                
                                                         echo '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEmployeeModal" style="float: right;">updateTracking</button>';
                                                    
                                                    ?>
                                                </div>
                                                <div class="modal fade" id="addEmployeeModal" tabindex="-1">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">ต้องการทำรายการ</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>        
                                                                <div class="modal-footer">
                                                                <button type="submit" class="btn btn-primary" id="updateTracking" name="updateTracking" style="margin-top: 10px;">Update Tracking</button>
                                                                </div>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                              </div>
                          </form>

                              <!-- End Default Table Example -->
                          </div>
                        </div>
                   
                  </div>
                </div>

                <div class="tab-pane fade" id="bordered-shipping" role="tabpanel" aria-labelledby="shipping-tab">
                  <div class="card">
                            
                        <div class="card recent-sales overflow-auto">
                          <div class="card-body">
                          <?php
                              require_once 'dbConfig.php';

                          
                              $stmt = $conn->prepare("SELECT COUNT(*) AS total_items FROM orders WHERE statusId = ?");

                              // Bind parameter
                              $statusId_8 = 8;
                              $stmt->bindParam(1, $statusId_8);

                              // Execute query
                              $stmt->execute();

                              // Fetch the result
                              $row = $stmt->fetch(PDO::FETCH_ASSOC);

                              // Check if the query was successful
                              if ($row) {
                                  $total_items = $row['total_items'];
                                  
                                  // Display the count
                                  echo "<h3 class='mt-4'>$total_items รายการ</h3>";
                              } else {
                                  // Handle error if query fails
                                  echo "Error: No data found";
                              }
                              ?>
                        <form action="update_tracking.php" method="post">
                        <table class="table">
                                  <thead>
                                      <tr>
                                      <th>
                                        <label for="selectAll">คำสั่งซื้อ</label>
                                    </th>
                                          <th>ผู้ซื้อ</th>
                                          <th>สินค้า</th>
                                          <th>สถานะคำสั่งซื้อ</th>
                                          <th>การจัดส่ง</th>
                                          <th>ราคา</th>
                                          <th>เลขพัสดุ</th>
                                      </tr>
                                  </thead>

                                  <tbody>
                                      <?php
                                      $stmt = $conn->prepare("SELECT o.*, s.statusName, m.* 
                                      FROM orders o 
                                      INNER JOIN status s ON o.statusId = s.statusId 
                                      INNER JOIN messenger m ON o.messengerId = m.messengerId
                                      WHERE o.statusId = ?");
                                      $statusId = 8; // Set the desired statusId
                                      $stmt->bindParam(1, $statusId, PDO::PARAM_INT);
                                      $stmt->execute();

                                      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                      ?>
                                          <tr>
                                              <td> 
                                                <div>
                                                <span><a href="viewOrder.php?id=<?php echo $row['orderId']; ?>"><?php echo $row['orderCode']; ?></a></span>

                                                  </div>
                                                 
                                                  <div>
                                                      <?php echo date("F j, Y, g:i a", strtotime($row['timestamp'])); ?>
                                                  </div>
                                              </td>
                                              <td><?php echo $row['nameCustomer']; ?></td>
                                              <td>
                                                  <?php
                                                  $stmt_inner = $conn->prepare("SELECT * FROM orders_detail WHERE orderId = :orderId");
                                                  $stmt_inner->bindParam(':orderId', $row['orderId'], PDO::PARAM_INT);
                                                  $stmt_inner->execute();
                                                  while ($row_inner = $stmt_inner->fetch(PDO::FETCH_ASSOC)) {
                                                      $stmt_product = $conn->prepare("SELECT * FROM product WHERE productId = :productId");
                                                      $stmt_product->bindParam(':productId', $row_inner['productId'], PDO::PARAM_INT);
                                                      $stmt_product->execute();
                                                      $product = $stmt_product->fetch(PDO::FETCH_ASSOC);

                                                      $width = 50;
                                                      $height = 50;
                                                  ?>
                                                      <img src="data:image/jpeg;base64,<?php echo base64_encode($product['img']); ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>">
                                                  <?php
                                                  }
                                                  ?>
                                              </td>
                                              <td><?php echo $row['statusName']; ?></td> <!-- Show statusName instead of statusId -->
                                              <td><?php echo $row['messengerName']; ?></td>
                                              <td><?php echo $row['totalAmount']; ?> <span>฿</span></td>
                                              <td> <?php echo $row['trackingNum']; ?></td>
                                          </tr>
                                      <?php
                                      }
                                      ?>
                                  </tbody>
                              </table>
                             
                          </form>

                              <!-- End Default Table Example -->
                          </div>
                        </div>
                    </div>
                
                </div>

                <div class="tab-pane fade" id="bordered-unsuccess" role="tabpanel" aria-labelledby="nsuccess-tab">
                  <div class="card">
                            
                        <div class="card recent-sales overflow-auto">
                          <div class="card-body">
                          <?php
                              require_once 'dbConfig.php';

                          
                              $stmt = $conn->prepare("SELECT COUNT(*) AS total_items FROM orders WHERE statusId = ?");

                              // Bind parameter
                              $statusId_6 = 6;
                              $stmt->bindParam(1, $statusId_6);

                              // Execute query
                              $stmt->execute();

                              // Fetch the result
                              $row = $stmt->fetch(PDO::FETCH_ASSOC);

                              // Check if the query was successful
                              if ($row) {
                                  $total_items = $row['total_items'];
                                  
                                  // Display the count
                                  echo "<h3 class='mt-4'>$total_items รายการ</h3>";
                              } else {
                                  // Handle error if query fails
                                  echo "Error: No data found";
                              }
                              ?>
                        <form action="update_tracking.php" method="post">
                        <table class="table">
                                  <thead>
                                      <tr>
                                      <th>
                                        <label for="selectAll">คำสั่งซื้อ</label>
                                    </th>
                                          <th>ผู้ซื้อ</th>
                                          <th>สินค้า</th>
                                          <th>สถานะคำสั่งซื้อ</th>
                                          <th>การจัดส่ง</th>
                                          <th>ราคา</th>
                                          <th>เลขพัสดุ</th>
                                      </tr>
                                  </thead>

                                  <tbody>
                                      <?php
                                      $stmt = $conn->prepare("SELECT o.*, s.statusName, m.*
                                      FROM orders o
                                      INNER JOIN status s ON o.statusId = s.statusId
                                      INNER JOIN messenger m ON o.messengerId = m.messengerId
                                      WHERE o.statusId = ?");
                                      $statusId = 6; // Set the desired statusId
                                      $stmt->bindParam(1, $statusId, PDO::PARAM_INT);
                                      $stmt->execute();

                                      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                      ?>
                                          <tr>
                                              <td>
                                                 
                                                  <div>
                                                  <span><a href="viewOrder.php?id=<?php echo $row['orderId']; ?>"><?php echo $row['orderCode']; ?></a></span>

                                                  </div>
                                              </td>
                                              <td><?php echo $row['nameCustomer']; ?></td>
                                              <td>
                                                  <?php
                                                  $stmt_inner = $conn->prepare("SELECT * FROM orders_detail WHERE orderId = :orderId");
                                                  $stmt_inner->bindParam(':orderId', $row['orderId'], PDO::PARAM_INT);
                                                  $stmt_inner->execute();
                                                  while ($row_inner = $stmt_inner->fetch(PDO::FETCH_ASSOC)) {
                                                      $stmt_product = $conn->prepare("SELECT * FROM product WHERE productId = :productId");
                                                      $stmt_product->bindParam(':productId', $row_inner['productId'], PDO::PARAM_INT);
                                                      $stmt_product->execute();
                                                      $product = $stmt_product->fetch(PDO::FETCH_ASSOC);

                                                      $width = 50;
                                                      $height = 50;
                                                  ?>
                                                      <img src="data:image/jpeg;base64,<?php echo base64_encode($product['img']); ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>">
                                                  <?php
                                                  }
                                                  ?>
                                              </td>
                                              <td <?php  echo 'style="color: red;"'; ?>><?php echo $row['statusName']; ?></td>
                                              <td><?php echo $row['messengerName']; ?></td>
                                              <td><?php echo $row['totalAmount']; ?> <span>฿</span></td>
                                              <td> <?php echo $row['trackingNum']; ?></td>
                                          </tr>
                                      <?php
                                      }
                                      ?>
                                  </tbody>
                              </table>
                             
                          </form>

                              <!-- End Default Table Example -->
                          </div>
                        </div>
                   
                  </div>
                </div>



         

              
            </main >
            </div> 
          </div> 
       
            
        </div>
      </div>
    </section>


    <section class="section">
   

      
      
      

      
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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
      
      
$(document).ready(function() {
    // Handle "Select All" checkbox
    $('#selectAll').click(function() {
        var $checkboxes = $(this).closest('.card-body').find('.orderCheckbox');
        $checkboxes.prop('checked', $(this).prop('checked'));
    });



    $('#selectAll1').click(function() {
        var $checkboxes = $(this).closest('.card-body').find('.orderCheckbox');
        $checkboxes.prop('checked', $(this).prop('checked'));
    });
 
      var deleteLinks = document.querySelectorAll('.delete-link');
    deleteLinks.forEach(function(link) {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            var orderId = this.getAttribute('data-id');
           
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                  
                    window.location.href = 'delOrderId.php?id=' + orderId;
                }
            });
        });
    });
    function confirmUpdateTracking() {
  
        Swal.fire({
            title: 'Are you sure?',
            text: 'Are you sure you want to update tracking?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'Cancel'
        }).then((result) => {
          
            if (result.isConfirmed) {
                document.getElementById("updateTrackingForm").submit(); // Submit the form
            }
        });
    }
});


  </script>




</body>

</html>