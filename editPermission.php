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

  <title>E-commerce</title>
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

  <link rel="stylesheet" type="text/css" href="js/dropzone/dropzone.min.css" />
<script type="text/javascript" src="js/dropzone/dropzone.min.js"></script>
  

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
            
            $sql = "SELECT name FROM user_account WHERE username = :username";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':username', $_SESSION['username']); 
            $stmt->execute();

            $name = $stmt->fetchColumn();

            
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
        <div>
          <h1 style="display: inline-block;">แก้ไขพนักงาน</h1>
          
   
   
      <div class="row">
        <!-- Left side columns -->
    
            <main class="tab-content pt-2" id="borderedTabContent">
              <!-- tAB โชว์คน-->
                <div class="col-12">
                  <div class="card recent-sales overflow-auto" >
                    <div class="card-body" >
                    <?php
                        require_once 'dbConfig.php';
                        if(isset($_GET['employeeId'])){
                            $employeeId =$_GET['employeeId'];
                            // Fetch product details from the database based on the product ID
                            $stmt = $conn->prepare("SELECT * FROM employee WHERE employeeId = :employeeId");
                            $stmt->bindParam(':employeeId', $_GET['employeeId']);
                            $stmt->execute();
                            $employee = $stmt->fetch(PDO::FETCH_ASSOC);
                        ?>
                  <form class="row g-3" action="editPermission_db.php" method="post">
    <input type="hidden" name="employeeId" value="<?php echo isset($_GET['employeeId']) ? $_GET['employeeId'] : ''; ?>">
                        <div class="modal-body">
                        <div class="row mb-3">
                                <label  class="col-sm-2 col-form-label">รหัสพนักงาน</label>
                                <div class="col-sm-10">
                                <label  class="col-sm-2 col-form-label"><?php echo $employee['employeeCode']; ?></label>
                                </div>
                        </div>
                        <div class="row mb-3">
                                <label  class="col-sm-2 col-form-label">เบอร์โทรศัพท์</label>
                                <div class="col-sm-6">
                                <input type="text" class="form-control" name="telEmP" value="<?php echo $employee['telEmp']; ?>">
                                </div>
                        </div>
                            <div class="row mb-3">
                                <label for="inputEmail" class="col-sm-2 col-form-label">อีเมล</label>
                                <div class="col-sm-6">
                                    <input type="email" class="form-control" name="email" value="<?php echo $employee['email']; ?>">
                                </div>
                            </div>
                            <!-- Other form fields -->
                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-2 col-form-label">ชื่อ</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="employeeName" value="<?php echo $employee['employeeName']; ?>">
                                </div>
                            </div>
                            <div class="modal-body">
        <!-- Existing roles -->
                          <div class="row mb-3">
                              <label class="col-sm-2 col-form-label">บทบาทที่ใช้งานอยู่</label>
                              <div class="col-sm-6">
                                  <?php
                                  require_once 'dbConfig.php';
                                  if (isset($_GET['employeeId'])) {
                                      $employeeId = $_GET['employeeId'];

                                      // Fetch roles assigned to the employee from the database
                                      $stmt = $conn->prepare("SELECT er.roleId, r.roleName 
                                                              FROM employee_role er
                                                              INNER JOIN role r ON er.roleId = r.roleId
                                                              WHERE er.employeeId = :employeeId");
                                      $stmt->bindParam(':employeeId', $employeeId);
                                      $stmt->execute();

                                      if ($stmt->rowCount() > 0) {
                                          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                              echo '<div>';
                                              echo '<span>' . $row["roleName"] . '</span>';
                                              echo '<span><a href="delroleidinpms.php?employeeId=' . $employeeId . '&roleId=' . $row["roleId"] . '">ลบ</a></span>';
                                              echo '</div>';
                                          }
                                      } else {
                                          echo "No roles found.";
                                      }
                                  }
                                  ?>
                              </div>
                          </div>
                    <div class="row mb-3">
                        <label for="inputText" class="col-sm-2 col-form-label">บทบาทใหม่</label>
                        <div class="col-sm-6">
                            <!-- PHP code to generate checkboxes for new roles -->
                            <?php
                            require_once 'dbConfig.php';
                            $stmt = $conn->query("SELECT * FROM role");
                            if ($stmt->rowCount() > 0) {
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo '<div class="col-sm-10">';
                                    echo '<input type="checkbox" name="roles[]" value="' . $row["roleId"] . '">';
                                    echo '<span>' . $row["roleName"] . '</span>';
                                    echo '</div>';
                                }
                            } else {
                                echo "No roles found.";
                            }
                            ?>
                        </div>
                    </div>

                    <!-- Submit buttons -->
                    <div style="text-align: right;">
                        <button type="submit" class="btn btn-primary">ยืนยัน</button>
                        <button type="reset" class="btn btn-secondary">ยกเลิก</button>
                    </div>
                </div>
                       
                     
                    </form>



                        <?php
                        }
                        ?>

                    </div>                                   
                  </div>
               
              
                  



              </div>
      
             </main >
        </div > 
      
 

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

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>


</body>

</html>