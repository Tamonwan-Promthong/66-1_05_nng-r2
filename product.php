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
        <h1 style="margin: 0;">สินค้าของฉัน</h1>
              <a href="addProduct.php">
                  <button type="button" class="btn btn-primary" data-bs-target="#fullscreenModal" style="margin-top: 10px;">
                  เพิ่มรายการสินค้าใหม่
                  </button>
               </a>
    </div>
    </div><!-- End Page Title -->


    <section class="section">
    <div class="row">
      <div class="card">
      <div class="card-body">
      <h5 class="card-title"></h5>
          <!-- Multi Columns Form -->
          <form method="GET" action="" class="search-form row g-3">
              <div class="col-md-4">
                  <label for="inputName5" class="form-label">รหัสสินค้า</label>
                  <input type="text" name="productCode" class="form-control" placeholder="รหัสสินค้า">
              </div>
              <div class="col-md-4">
                  <label for="inputPrice" class="form-label">ราคา</label>
                  <input type="text" name="price" class="form-control" placeholder="ค้นหาตามราคา">
              </div>
              <div class="col-md-4">
                  <label for="inputCategory" class="form-label">หมวดหมู่สินค้า</label>
                  <select name="categoryName" class="form-control">
                      <option value="">เลือกหมวดหมู่สินค้า</option>
                      <?php
                      require_once 'dbConfig.php';
                      $categories = $conn->query("SELECT * FROM category");
                      foreach ($categories as $category) {
                          echo "<option value='" . $category['categoryName'] . "'>" . $category['categoryName'] . "</option>";
                      }
                      ?>
                  </select>
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
          
            <div class="card-body" style="margin-top: 20px;">
      
  <h5 style="display: inline-block;">สินค้าของฉัน</h5>
  <?php
require_once 'dbConfig.php';



    $stmt = $conn->prepare("SELECT COUNT(*) AS total_items FROM product");


    $stmt->execute();


    $row = $stmt->fetch(PDO::FETCH_ASSOC);

 
    if ($row) {
        $total_items = $row['total_items'];

       
        echo "<h3 class='mt-4'>$total_items รายการ</h3>";
    } else {

        echo "Error: No data found";
    }

?>
              
               <!-- Table with stripped rows -->
               <table class="table datatable">
                  <thead>
                      <tr>
                          <th>ลำดับ</th>
                          <th>รูปสินค้า</th>
                          <th>ชื่อสินค้า</th>
                          <th>รหัสสินค้า</th>
                          <th>ราคาสินค้า</th>
                          <th>จำนวนสินค้าในสต็อก</th>
                          <th>พร้อมขาย</th>
                          <th>หมวดหมู่สินค้า</th>
                          <th>action</th>
                     
                      </tr>
                  </thead>
                      <tbody>
                      <?php
                        require_once 'dbConfig.php';

                        $productCode = isset($_GET['productCode']) ? $_GET['productCode'] : '';
                        $price = isset($_GET['price']) ? $_GET['price'] : '';
                        $categoryName = isset($_GET['categoryName']) ? $_GET['categoryName'] : '';
                        $sql = "SELECT p.*, c.categoryName 
                        FROM product p 
                        JOIN category c ON p.categoryId = c.categoryId";
                        if (!empty($productCode)) {
                            $sql .= " AND p.productCode LIKE '%$productCode%'";
                        }

                        if (!empty($price)) {
                            $sql .= " AND p.price = $price";
                        }

                        if (!empty($categoryName)) {
                            $sql .= " AND c.categoryName LIKE '%$categoryName%'";
                        }

                        $stmt = $conn->query($sql);
                        $count = 1;

                        foreach ($stmt as $row) {
                            ?>
                            <tr>
                                <td><?php echo $count++; ?></td>
                                <td><img src="data:image/jpeg;base64,<?php echo base64_encode($row['img']); ?>" width="100" height="100"></td>
                                <td><?php echo $row['productName']; ?></td>
                                <td><?php echo $row['productCode']; ?></td>
                                <td><?php echo $row['price']; ?></td>     
                                <td><?php echo $row['stock']; ?></td>   
                                <td><?php echo $row['stockpoint']; ?></td>  
                                <td><?php echo $row['categoryName']; ?></td> <!-- Display category name --> 
                                <td>
                                <?php
                                // Display the roleId if it's set
                                if ($roleId == 1) {
                                    echo '<div>
                                              <a href="formEdit.php?id=' . $row['productId'] . '">แก้ไข</a>
                                          </div>
                                          <div>
                                              <a href="#" class="delete-product" data-id="' . $row['productId'] . '">ลบ</a>
                                          </div>';
                                }
                                else {
                                  // If roleId is not 1, display the links with grey text
                                  echo '<div>
                                         <span style="color: grey;">ลบ</span>
                                        </div>
                                        <div>
                                        <span style="color: grey;">แก้ไข</span>
                                        </div>';
                              }
                                ?>
                                     
                                 </td>
                               
                            </tr> 
                            <?php

                            // Check if stock is 0 and update statusId to 0
                            if ($row['stock'] == 0) {
                              $statusId = 4;
                          } elseif ($row['stock'] >= 100 || $row['stock'] >=10) {
                              $statusId = 5;
                          }  elseif ($row['stock'] <10) {
                              $statusId = 3;
                          }
                          
                          $productId = $row['productId'];
                          $updateSql = "UPDATE product SET statusId = :statusId WHERE productId = :productId";
                          $updateStmt = $conn->prepare($updateSql);
                          $updateStmt->bindParam(':statusId', $statusId);
                          $updateStmt->bindParam(':productId', $productId);
                          $updateStmt->execute();
                          
                        }
                        ?>

                      </tbody>
                </table>

              <!-- End Table with stripped rows -->

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
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Select all delete-product links
        const deleteLinks = document.querySelectorAll('.delete-product');

        // Add click event listener to each delete link
        deleteLinks.forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault(); // Prevent the default link behavior

                const productId = this.dataset.id; // Get the product ID from the data-id attribute

                // Display SweetAlert confirmation dialog
                Swal.fire({
                    title: 'ต้องการลบรายการใช่หรือไม่',
                    text: 'ถ้ากดแล้วไม่สามารถย้อนกลับได้',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // If user confirms, redirect to the deletion endpoint
                        window.location.href = 'delProduct_db.php?id=' + productId;
                    }
                });
            });
        });
    });
</script>


</body>

</html>