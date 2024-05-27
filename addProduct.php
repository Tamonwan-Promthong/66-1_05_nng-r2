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


  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">
  <?php include 'sidebar.php'; ?>


  </aside><!-- End Sidebar-->

  <main id="main" class="main">
  <div class="pagetitle">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h1 >เพิ่มรายการสินค้าใหม่</h1>
        <div style="display: inline-block; float: right;">
         
<a href="#" class="modal-link" data-bs-toggle="modal" data-bs-target="#verticalycentered">เพิ่มหมวดหมู่สินค้า</a>
          <!--ปุ่มเพิ่มพนักงาน-->
          <div class="modal fade" id="verticalycentered" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">เพิ่มหมวดหมู่สินค้า</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="row g-3 p-3" action="addcategory.php" method="post">
                <div class="col-12">
                    <div class="mb-3">
                        <label for="inputEmail" class="form-label">ชื่อหมวดหมู่สินค้า</label>
                        <input type="text" class="form-control" name="categoryName" >
                    </div>
                
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary">เพิ่ม</button>
                </div>
            </form>
        </div>
    </div>
        </div>

        </div>
   
    </div><!-- End Page Title -->
    
    


    <section class="section">
      <div class="row">
      <div class="col-lg-12" >

<div class="card" style="margin-top: 20px;">
  <div class="card-body" >
    <h5 class="card-title">เพิ่มสินค้า</h5>
    

    <!-- Multi Columns Form -->
    <form class="row g-3" action="addProuct_db.php" method="post" enctype="multipart/form-data">
    <div class="col-md-6">
                  <label for="inputName5" class="form-label">รหัสสินค้า</label>
                  <input type="text" class="form-control" id="inputName5" name="productCode">
                </div>
                <div class="col-md-6">
                  <label for="inputName5" class="form-label">ชื่อสินค้า</label>
                  <input type="text" class="form-control" id="inputName5"  name="productName">
                </div>
                <div class="col-md-6">
                  <label for="inputName5" class="form-label">ราคาสินค้าที่ขาย</label>
                  <input type="text" class="form-control" id="inputName5" name="price">
                </div>
                <div class="col-6">
                  <label for="inputName5" class="form-label">จำนวนสต๊อคที่ต้องการเพิ่ม</label>
                  <input type="text" class="form-control" id="inputName5" name="stock">
                </div>
          
                <div class="col-md-6">
                  <label for="inputState" class="form-label">ประเภทของสินค้า</label>
                  <select id="inputState" class="form-select" name="categoryId">
                      <option selected>Choose...</option>
                      <?php
                      require_once 'dbConfig.php';
                      $stmt = $conn->query("SELECT * FROM category");

                      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                          echo '<option value="' . $row['categoryId'] . '">' . $row['categoryName'] . '</option>';
                      }
                      ?>
                  </select>
                  
                </div> 
                <div class="row mb-3">
                  <div class="col-sm-10">
                    <label for="inputNumber" class="col-sm-2 col-form-label">File Upload</label>
                    <input class="form-control" type="file" id="formFile" name="img">
                  </div>
                </div>   
        
                  <div style="text-align: right;"> <!-- Align container to the left -->
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
    </form><!-- End Multi Columns Form -->
    
  </div>
</div>



</div>
      </div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
   
  </footer><!-- End Footer -->

  

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