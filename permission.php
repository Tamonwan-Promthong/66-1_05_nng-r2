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
  <div>
  <div>
    <h1 style="display: inline-block;">สิทธิ์การเข้าถึง</h1>
    <?php
    // Assuming $roleId is already defined
    if ($roleId == 1 ) {
        // If role ID is 1 or 2, show the button
        echo '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEmployeeModal" style="float: right;">เพิ่มพนักงาน</button>';
    }
    ?>
</div>

    <!-- Modal for adding employee -->
    <div class="modal fade" id="addEmployeeModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">เพิ่มพนักงาน</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="row g-3 p-3" action="savepermission.php" method="post">
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="inputEmail" class="form-label">อีเมล</label>
                            <input type="email" class="form-control" name="email" id="inputEmail">
                        </div>
                        <div class="mb-3">
                            <label for="inputTel" class="form-label">เบอร์โทรศัพท์</label>
                            <input type="text" class="form-control" name="telEmp" id="inputTel">
                        </div>
                        <div class="mb-3">
                            <label for="inputName" class="form-label">ชื่อ</label>
                            <input type="text" class="form-control" name="employeeName" id="inputName">
                        </div>
                        <div class="mb-3">
                            <label for="inputRole" class="form-label">บทบาท</label>
                            <div class="row">
                            <?php
                            require_once 'dbConfig.php';
                            $stmt = $conn->query("SELECT * FROM role");
                            if ($stmt->rowCount() > 0) {
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo '<div class="col-6 mb-2">';
                                    echo '<div class="form-check">';
                                    echo '<input class="form-check-input" type="checkbox" name="roles[]" value="' . $row["roleId"] . '" id="role_' . $row["roleId"] . '">';
                                    echo '<label class="form-check-label" for="role_' . $row["roleId"] . '">' . $row["roleName"] . '</label>';
                                    echo '</div>';
                                    echo '</div>';
                                }
                            } else {
                                echo '<div class="col-12">No roles found.</div>';
                            }
                            ?>
                        </div>
                        </div>
                        <div class="mb-3">
                            <label for="inputUsername" class="form-label">กำหนด Username ให้พนักงาน</label>
                            <input type="text" class="form-control" name="username" id="inputUsername">
                        </div>
                        <div class="mb-3">
                            <label for="inputPassword" class="form-label">กำหนด password ให้พนักงาน</label>
                            <input type="text" class="form-control" name="password" id="inputPassword">
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

   
      <div class="row">
        <!-- Left side columns -->
        <div class="col-lg-12">  
            <ul class="nav nav-tabs nav-tabs-bordered" id="borderedTab" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link active" id="emplyee-tab" data-bs-toggle="tab" data-bs-target="#bordered-employee" type="button" role="tab" aria-controls="employee" aria-selected="true">พนักงาน</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="role-tab" data-bs-toggle="tab" data-bs-target="#bordered-role" type="button" role="tab" aria-controls="role" aria-selected="false">บทบาท</button>
              </li>
            </ul>
            <main class="tab-content pt-2" id="borderedTabContent">
              <!-- tAB โชว์คน-->
              <div class="tab-pane fade show active" id="bordered-employee" role="tabpanel" aria-labelledby="emplyee-tab">
                <div class="col-12">
                  <div class="card recent-sales overflow-auto" >
                    <div class="card-body" >
                      <form class="row g-3 p-3">
                      <div class="col-md-3">
        <select name="role" id="role" class="form-select">
            <option value="" selected>เลือกบทบาท</option>
            <?php
            // Fetch roles from the database
            $stmt_roles = $conn->prepare("SELECT * FROM role");
            $stmt_roles->execute();
            while ($row_role = $stmt_roles->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='" . $row_role['roleId'] . "'>" . $row_role['roleName'] . "</option>";
            }
            ?>
        </select>
    </div>
    
    <div class="col-md-3">
        <input type="text" name="employeeCode" class="form-control" placeholder="รหัสพนักงาน">
    </div>

    <div class="col-md-3">                         
        <button type="submit" class="btn btn-primary">ค้นหา</button>
    </div>             
                      </form><!-- End Multi Columns Form -->
                    </div>                                   
                  </div>
                </div>
                <div class="col-12">
                  <div class="card recent-sales overflow-auto" >
                    <div class="card-body" >
                    <table class="table datatable">
                  <thead>
                      <tr>
                          <th>รหัสพนักงาน</th>
                          <th>ชื่อพนักงาน</th>
                          <th>หน้าที่พนักงาน</th>
                          <th>action</th>
                      </tr>
                  </thead>
                      <tbody>
                      <?php
                        require_once 'dbConfig.php';

                        $whereClause = ""; // Initialize where clause

                        // Check if role filter is applied
                        if(isset($_GET['role']) && $_GET['role'] != "") {
                            $roleId = $_GET['role'];
                            // Include employees who have the selected role
                            $whereClause .= " AND e.employeeId IN (SELECT employeeId FROM employee_role WHERE roleId = $roleId)";
                        }

                        // Check if employee code filter is applied
                        if(isset($_GET['employeeCode']) && $_GET['employeeCode'] != "") {
                            $employeeCode = $_GET['employeeCode'];
                            // Include employees with the specified employee code
                            $whereClause .= " AND e.employeeCode = '$employeeCode'";
                        }

                        // Fetch employees with applied filters
                        $stmt = $conn->prepare("SELECT e.*, GROUP_CONCAT(r.roleName) AS roleNames
                                                FROM employee e 
                                                LEFT JOIN employee_role er ON e.employeeId = er.employeeId 
                                                LEFT JOIN role r ON er.roleId = r.roleId
                                                WHERE 1 $whereClause
                                                GROUP BY e.employeeId");
                        $stmt->execute();

                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            ?>       
                          <tr>
                              <td><?php echo $row['employeeCode']; ?></td>
                              <td><?php echo $row['employeeName']; ?></td>
                              <td><?php echo $row['roleNames']; ?></td>
                              <td> 
                                  <?php
                                  // Display the roleId if it's set
                                  if ($roleId == 1) {
                                
                                      // If roleId is 1, allow editing and deleting
                                      echo '<div>
                                                <a href="#" onclick="confirmDelete(' . $row['employeeId'] . ');">ลบ</a>
                                          </div>
                                          <div>
                                              <a href=\'editPermission.php?employeeId=' . $row['employeeId'] . '\'>แก้ไข</a>
                                          </div>';
                                        } else {
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
                        }
                        ?>
                      </tbody>
                </table>
                    </div>                                   
                  </div>
                </div>
                  



              </div>
              <!-- tAB บทบาท-->
              <div class="tab-pane fade" id="bordered-role" role="tabpanel" aria-labelledby="role-tab">

                <div class="card">
                  <div class="card-body">
                    
      
                    <!-- Default Table -->
                    
                    <table class="table">
                      <thead>
                        <tr>
      
                          <th scope="col" class="col-lg-2">ชื่อบทบาท</th>
                          <th scope="col" class="col-lg-4">คำอธิบาย</th>
                          <th scope="col" class="col-lg-4">สิทธิ์อนุญาต</th>
                          
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td scope="row">ผู้จัดการร้านค้า</td>
                          <td>ผู้จัดการร้านค้าสามารถดำเนินงานได้ทั้งหมด สามารถแก้ไข ดูโมดูลใดก็ได้ เช่น ผลิตภัณฑ์ คำสั่งซื้อ การเงิน และการจัดส่ง</td>
                          <td>ผลิตภัณฑ์(ดูและแก้ไข),จัดการสต็อก(ดูและแก้ไข),เพิ่มสินค้าใหม่(ดูและแก้ไข),คำสั่งซื้อ(ดูและแก้ไข),สร้างคำสั่งซื้อ,คำขอยกเลิก(ดูและแก้ไข),การจัดส่ง(ดูและแก้ไข),พนักงาน(ดูและแก้ไข),จัดการสิทธิ์พนักงาน(แก้ไข),แดชบอร์ด(ดู)</td>
                         
                          
                        </tr>
                        <tr>
                          <td scope="row">ตัวแทนบริการลูกค้า</td>
                          <td>ผู้เชี่ยวชาญด้านการบริการลูกค้า สามารถดูและแก้ไขคำสั่งซื้อได้ รวมถึงการตอบข้อซักถามของลูกค้า</td>
                          <td>ผลิตภัณฑ์(ดู),คำสั่งซื้อ(ดูและแก้ไข),คำขอยกเลิก(ดูและแก้ไข),การจัดส่ง(ดู),จัดการสต็อก(ดู)</td>
                          
                          
                        </tr>
                        <tr>
                          <td scope="row">ผู้เชี่ยวชาญด้านการเงิน</td>
                          <td>ผู้เชี่ยวชาญด้านการเงินส่วนใหญ่สามารถเข้าถึงโมดูลทางการเงินและสามารถดำเนินการทางการเงินต่างๆได้ เช่น การดูรายละเอียดบิลและการส่งออกบิล</td>
                          <td>แดชบอร์ด(ดู),คำสั่งซื้อ(ดู)</td>
                          
                          
                        </tr>
                        

                        <tr>
                          <td scope="row">ผู้จัดส่งสินค้า</td>
                          <td>ผู้จัดส่งสินค้าสามารถเข้าถึงโมดูลการจัดส่งได้ รวมถึงการสั่งพิมพ์ใบปะหน้าพัสดุ จัดการเตรียมพัสดุเพื่อส่งให้ขนส่งนำส่งพัสดุถึงลูกค้า</td>
                          <td>คำสั่งซื้อ(ดู),การจัดส่ง(ดูและแก้ไข),ฉลากการจัดส่ง(ดูและแก้ไข),การส่งคืน(ดูและแก้ไข),คำขอยกเลิก(ดู)</td>
                          
                          
                        </tr>
                      </tbody>
                    </table>
                    <!-- End Default Table Example -->
                  </div>
                </div>
              </div> 
             </main >
        </div > 
        
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
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  <script>
  function confirmDelete(employeeId) {
    Swal.fire({
      title: 'ต้องการลบใช่ไหม',
      text: "ถ้าลบแล้วไม่สามารถกุคืนได้",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes'
    }).then((result) => {
      if (result.isConfirmed) {
        // If confirmed, redirect to the delete script
        window.location.href = 'delPermission.php?employeeId=' + employeeId;
      }
    });
  }
</script>



</body>

</html>