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
<style>
    .card-body {
        margin-top: 20px; /* Adjust the value as needed */
    }
</style>

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
                        <h1 style="margin: 0;">สร้างคำสั่งซื้อ</h1>
              
                <a href="listBuying1.php">
                    <button type="button" class="btn btn-danger" data-bs-target="#fullscreenModal" style="margin-top: 10px;">
                        ยกเลิก
                    </button>
                </a>
            
                    </div>
          </div><!-- End Page Title -->

    <section class="section">
    <div class="col-lg-12"> <!-- Adjust the card width -->
        <div class="card shadow">
            <div class="card-body">
                <h5 class="card-title">ค้นหาสินค้า</h5>
                <form method="GET" action="" class="search-form row g-3">
    <div class="col-md-4">
        <label for="inputName5" class="form-label">รหัสสินค้า</label>
        <input type="text" name="productCode" class="form-control" placeholder="รหัสสินค้า">
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
</div>

    <div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
            <div class="container text-center">
    <div class="row">
    <?php
require_once 'dbConfig.php';

// Initialize search variables
$searchProductName = isset($_GET['productCode']) ? $_GET['productCode'] : '';

$searchCategoryName = isset($_GET['categoryName']) ? $_GET['categoryName'] : '';

// Build the SQL query
$sql = "SELECT p.*, c.categoryName
        FROM product p 
        JOIN category c ON p.categoryId = c.categoryId
        WHERE p.statusId = 5";

// Add search conditions if provided
if (!empty($searchProductName)) {
    $sql .= " AND p.productCode LIKE '%$searchProductName%'";
}


if (!empty($searchCategoryName)) {
    $sql .= " AND c.categoryName LIKE '%$searchCategoryName%'";
}

// Execute the SQL query
$stmt = $conn->query($sql);
?>  
   <table class="table datatable">
    <thead>
        <tr>
            <th>ลำดับ</th>
            <th>รูปสินค้า</th>
            <th>ชื่อสินค้า</th>
            <th>รหัสสินค้า</th>
            <th>ราคาสินค้า</th>
            <th>จำนวนสินค้าในสต๊อก</th>
            <th>พร้อมขาย</th>
            <th>หมวดหมู่สินค้า</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
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
                <td><?php echo $row['categoryName']; ?></td>
                <td>
                    <?php
                    // Display the action buttons based on the roleId
                    if ($roleId == 1 || $roleId == 2) {
                        echo '<a href="order1.php?id=' . $row['productId'] . '" class="btn btn-primary">Order</a>';
                        
                    } else {
                        echo '<a class="btn btn-primary">Order</a>';
                        
                    }
                    ?>
                </td>
            </tr>
        <?php
            // Update statusId based on stock
            if ($row['stock'] == 0) {
                $statusId = 4;
            } elseif ($row['stock'] >= 100 || $row['stock'] >= 10) {
                $statusId = 5;
            } elseif ($row['stock'] < 10) {
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

      
    </div>
</div>
            </div>
        </div>
    </div>
</div>

          </section>

      </main>

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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>


</body>

</html> 