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
      <h1>เพิ่มสินค้า</h1>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">เพิ่มสินค้า</h5>

              <?php
              require_once 'dbConfig.php';
              if(isset($_GET['id'])){
                  // Fetch product details from the database based on the product ID
                  $stmt = $conn->prepare("SELECT * FROM product WHERE productId = :productId");
                  $stmt->bindParam(':productId', $_GET['id']);
                  $stmt->execute();
                  $product = $stmt->fetch(PDO::FETCH_ASSOC);
              ?>
            <form class="row g-3" action="updateProduct_db.php" method="post" enctype="multipart/form-data">               
                <div class="col-md-6">
                    <label for="inputName5" class="form-label">รหัสสินค้า</label>
                    <input type="text" class="form-control" id="inputName5" name="productCode" value="<?php echo $product['productCode']; ?>">
                </div>
                <div class="col-md-6">
                    <label for="inputEmail5" class="form-label">ชื่อสินค้า</label>
                    <input type="text" class="form-control" id="inputEmail5"  name="productName" value="<?php echo $product['productName']; ?>">
                </div>
                <div class="col-md-6">
                    <label for="inputPassword5" class="form-label">ราคาสินค้าที่ขาย</label>
                    <input type="text" class="form-control" id="inputPassword5" name="price" value="<?php echo $product['price']; ?>">
                </div>
                <div class="col-6">
                    <label for="inputAddress5" class="form-label">จำนวนสต๊อคที่ต้องการเพิ่ม</label>
                    <input type="text" class="form-control" id="inputAddres5s" name="stock" value="<?php echo $product['stock']; ?>">
                </div>
                <div class="col-md-6">
                  <label for="inputState" class="form-label">ไซส์สินค้า</label>
                  <select id="inputState" class="form-select" name="sizeId">
                      <?php
                      $stmt = $conn->query("SELECT * FROM size");
                      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                          $selected = ($row['sizeId'] == $product['sizeId']) ? 'selected' : '';
                          echo '<option value="' . $row['sizeId'] . '" ' . $selected . '>' . $row['sizeName'] . '</option>';
                      }
                      ?>
                  </select>
              </div>
              <div class="col-md-6">
                  <label for="inputState" class="form-label">ประเภทของสินค้า</label>
                  <select id="inputState" class="form-select" name="categoryId">
                      <?php
                      $stmt = $conn->query("SELECT * FROM category");
                      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                          $selected = ($row['categoryId'] == $product['categoryId']) ? 'selected' : '';
                          echo '<option value="' . $row['categoryId'] . '" ' . $selected . '>' . $row['categoryName'] . '</option>';
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
                <?php
                    
                    $productId = $_GET['id']; 
                
                    $stmt = $conn->prepare("SELECT img FROM product WHERE productId = :productId");
                    $stmt->bindParam(':productId', $productId);
                    $stmt->execute();
                    
                    $img = $stmt->fetch(PDO::FETCH_ASSOC); 
                        echo '<img src="data:image/jpeg;base64,'.base64_encode($img['img']).'"" style="max-width: 200px; max-height: 200px;" />';
                   
                ?>
                 <input type="hidden" name="productId" value="<?php echo $product['productId']; ?>">
                <div style="text-align: right;">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
            </form><!-- End Multi Columns Form -->
            <?php
              }
            ?>

            </div>
          </div>

        </div>

     
      </div>
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