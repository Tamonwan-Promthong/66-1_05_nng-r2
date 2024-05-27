<?php
session_start();
require('dbConfig.php');

if (!isset($_SESSION['loggedin'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!';
    header('location: login.php');
    exit; // Ensure to stop further execution after redirection
}

// Check if the session variable is set and not empty
if (!isset($_SESSION["strProductID"]) || empty($_SESSION["strProductID"])) {
    // Redirect to cart.php if $_SESSION["strProductID"] is not set or empty
    header("location: cart.php");
    exit; // Ensure to stop further execution after redirection
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

                    <div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
            <h5>รายการสินค้าที่เลือก</h5>
                    <form class="row g-3" action="saveCard1.php" method="post" enctype="multipart/form-data">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" >
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">ลำดับที่</th>
                                        <th scope="col">รูปสินค้า</th>
                                        <th scope="col">ชื่อสินค้า</th>
                                        <th scope="col">ราคา (บาท)</th>
                                        <th scope="col">จำนวนที่สั่งซื้อ</th>
                                        <th scope="col">จัดการ</th>
                                        <th scope="col">ราคารวม (บาท)</th>
                                        <th scope="col">ลบรายการสินค้า</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $total = 0;
                                    $Sumprice = 0;
                                    $m = 1;
                                    for ($i = 0; $i <= (int)$_SESSION["intLine"]; $i++) {
                                        if ($_SESSION["strProductID"][$i] != "") {
                                            $stmt = $conn->prepare("SELECT * FROM product WHERE productId = ?");
                                            $stmt->execute([$_SESSION["strProductID"][$i]]);
                                            $rowproduct = $stmt->fetch(PDO::FETCH_ASSOC);
                                            $price = $rowproduct['price'];
                                            $quantity = $_SESSION["strQty"][$i];
                                            $subtotal = $price * $quantity;
                                            $Sumprice += $subtotal;
                                            $_SESSION["Sumprice"] =  $Sumprice ;
                                    ?>
                                            <tr>
                                                <th scope="r0ow"><?= $m ?></th>
                                                <td><img src="data:image/jpeg;base64,<?php echo base64_encode($rowproduct['img']); ?>" class="img-thumbnail" style="width: 100px;"></td>
                                                <td><?= $rowproduct["productName"] ?></td>
                                                <td><?= number_format($price, 2) ?></td>
                                                <td><?= $quantity ?></td>
                                                <td>
                                                    <a href="order1.php?id=<?= $rowproduct["productId"] ?>" class="btn btn-outline-primary">+</a>
                                                    <?php if ($_SESSION["strQty"][$i] > 1) { ?>
                                                        <a href="order1_del.php?id=<?= $rowproduct["productId"] ?>" class="btn btn-outline-primary">-</a>
                                                    <?php } ?>
                                                </td>
                                                <td><?= number_format($subtotal, 2) ?></td>
                                                <td><a href="deleteCart1.php?Line=<?= $i ?>" class="btn btn-danger btn-sm">ลบ</a></td>
                                            </tr>
                                    <?php
                                            $m++;
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td colspan="5" class="text-end"><strong>ยอดรวมทั้งหมด (บาท)</strong></td>
                                        <td colspan="2"><strong><?= number_format($Sumprice, 2) ?></strong></td>
                                    </tr>
                                </tbody>
                            </table>
                         
                        </div>

                        <div class="text-end">
                                    <a href="buying.php" class="btn btn-secondary">เลือกสินค้า</a>
                                    <a href="clear.php" class="btn btn-danger">clearcart</a>
                                </div>
                        </div>

                        
            <div class="row">
                <div class="col-lg-12">
                  <div class="card">
                      <div class="card-body">

                      <h5 class="card-title">ข้อมูลที่อยู่จัดส่ง</h5>               
                            <div class="col-md-6">
                              <label for="inputName5" class="form-label">ชื่อ</label>
                              <input type="text" class="form-control" id="inputName5" name="nameCustomer">
                            </div>
                            <div class="col-md-6">
                              <label for="inputEmail5" class="form-label">เบอร์โทรศัพท์</label>
                              <input type="text" class="form-control" id="inputEmail5"  name="tell">
                            </div>
                            <div class="col-12">
                              <h1></h1>
                              <div class="form-floating">
                                <textarea class="form-control" placeholder="Address" id="floatingTextarea" style="height: 100px;" name="addrCustomer"></textarea>
                                <label for="floatingTextarea">ที่อยู่ลูกค้า</label>
                              </div>
                            </div>
                            <div class="col-6">
                              <label for="inputAddress5" class="form-label">e-mail</label>
                              <input type="text" class="form-control" id="inputAddres5s" name="e-mail">
                            </div>
                            <input type="hidden" name="total" value="<?php echo $SumTotal; ?>">
                            <div class="col-6">
                            <fieldset class="row mb-3">
                            <label for="inputAddress5" class="form-label">การชำระเงิน</label>
                                <div class="col-sm-10">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gridRadios" name ="COD" id="gridRadios1" value="option1" checked onchange="toggleFileUpload(false)">
                                        <label class="form-check-label" for="gridRadios1">
                                            ชำระเงินปลายทาง
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios2" value="option2" onchange="toggleFileUpload(true)">
                                        <label class="form-check-label" for="gridRadios2">
                                            โอนเงิน/แนบสลิปการโอนเงิน
                                        </label>
                                    </div>
                                </div>

                            </fieldset>
                            </div>
                          
             
                            <div class="col-sm-10" id="fileUploadSection" style="display:none;">
                                <label for="inputNumber" class="col-sm-2 col-form-label">File Upload</label>
                                <input class="form-control" type="file" id="formFile" name="slipimg">
                            </div>
                            <div class="col-md-6">
                                <label for="inputState" class="form-label">ขนส่ง</label>
                                <select id="inputState" class="form-select" name="messengerId">
                                    <option selected>Choose...</option>
                                    <?php
                                    require_once 'dbConfig.php';
                                    $stmt = $conn->query("SELECT * FROM messenger");

                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo '<option value="' . $row['messengerId'] . '">' . $row['messengerName'] . '</option>';
                                    }
                                    ?>
                    </select>
                            </div>                       
                            <div style="text-align: right;"> <!-- Align container to the left -->
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
                      </div>
                      
                  </div>
                  
                </div>
                
             </div>



                        

                        
                    </form>
                
          
        </div>
    </div>
                  
                    

                    
                    

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
  <script>
    function toggleFileUpload(show) {
        var fileUploadSection = document.getElementById("fileUploadSection");
        if (show) {
            fileUploadSection.style.display = "block";
        } else {
            fileUploadSection.style.display = "none";
        }
    }
</script>

</body>

</html> 