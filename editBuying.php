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
                        <h1>รายการคำสั่งซื้อ/แก้ไขที่อยู่ลูกค้า</h1>
                    </div>

    <section class="section">
                    <!-- <div class="row">
              <div class="col-lg-12">
                  <div class="card">
                      <div class="card-body">
                          <h5 class="card-title">สร้างคำสั่งซื้อ</h5>
                          <button type="button" class="btn btn-primary btn-lg btn-block" data-bs-toggle="modal" data-bs-target="#fullscreenModal">เลือกรายการสินค้า....                             
                          </button>
                      </div>
                  </div>
              </div>
          </div> -->

          <!-- Modal -->
          <!-- <div class="modal fade" id="fullscreenModal" tabindex="-1">
              <div class="modal-dialog modal-fullscreen">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title">เลือกสินค้า</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body" >
                          <table class="table datatable">
                              <thead>
                                  <tr>
                                  <th>ลำดับ</th>
                                  <th>รูปสินค้า</th>
                                  <th>ชื่อสินค้า</th>
                                  <th>รหัสสินค้า</th>
                                  <th>ราคาสินค้้า</th>
                                  <th>จำนวนสินค้าในสต๊อค</th>
                                  <th>ไซส์สินค้า</th>
                                  <th>หมวดหมู่สินค้า</th>
                                  <th>Add to Order</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <?php
                                  require_once 'dbConfig.php';
                                  $stmt = $conn->query("SELECT p.*, c.categoryName, s.sizeName 
                                                        FROM product p 
                                                        JOIN category c ON p.categoryId = c.categoryId 
                                                        JOIN size s ON p.sizeId = s.sizeId");
                                  $_counnt = 1;
                                  foreach ($stmt as $row) {
                                      ?>
                                      <tr>
                                          <td><?php echo $_counnt++; ?></td>
                                          <td><img src="data:image/jpeg;base64,<?php echo base64_encode($row['img']); ?>" width="100" height="100"></td>
                                          <td><?php echo $row['productName']; ?></td>
                                          <td><?php echo $row['productCode']; ?></td>
                                          <td><?php echo $row['price']; ?></td>
                                          <td><?php echo $row['stock']; ?></td>
                                          <td><?php echo $row['sizeName']; ?></td>
                                          <td><?php echo $row['categoryName']; ?></td>
                                          <td>
                                          <a href='editOrder_db.php?id=<?php echo $row['productId']; ?>&orderId=<?php echo isset($_GET['id']) ? $_GET['id'] : ""; ?>' class="btn btn-primary">order</a>
                                          </td>

                                      </tr>
                                  <?php
                                  }
                                  ?>
                              </tbody>
                          </table>
                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                          <button type="button" class="btn btn-primary">Save changes</button>
                      </div>
                  </div>
              </div>
          </div> -->
          <div class="col-lg-12">
                  <div class="card">
                      <div class="card-body">
                      <!-- <div style="text-align: right;">
                          <a href="clear.php"><button type="button" class="btn btn-primary"  data-bs-target="#fullscreenModal" style="margin-top: 10px;">
                             clear card
                          </button></a>
                      </div> -->
                      <div class="pagetitle">
                      <h5></h5>
                        <h5>รายการคำสั่งซื้อ/แก้ไขที่อยู่ลูกค้า</h5>
                        <?php
                                $SumTotal = 0;

                                // Fetch old order details from the database
                                if(isset($_GET['id'])) {
                                    $orderId = $_GET['id'];
                                    require_once 'dbConfig.php';
                                    $stmt = $conn->prepare("SELECT * FROM orders WHERE orderId = :orderId");
                                    $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
                                    $stmt->execute();
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {                                    
                                    ?>
                                    <h7>รายการที่<?php echo $row['orderCode']; ?></h7>
                        <?php
                                    }
                            }
                                ?>
                    </div>
                    
                        <div class="table-responsive " style="margin-top: 10px;">            
                        <table class="table table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    
                                    <th>รูปสินค้า</th>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $SumTotal = 0;

                                // Fetch old order details from the database
                                if(isset($_GET['id'])) {
                                    $orderId = $_GET['id'];
                                    require_once 'dbConfig.php';
                                    $stmt = $conn->prepare("SELECT * FROM orders_detail WHERE orderId = :orderId");
                                    $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
                                    $stmt->execute();

                                    if($stmt->rowCount() > 0) {
                                        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            // Fetch product details based on productId
                                            $productStmt = $conn->prepare("SELECT * FROM product WHERE productId = :productId");
                                            $productStmt->bindParam(':productId', $row['productId'], PDO::PARAM_INT);
                                            $productStmt->execute();

                                            if($productStmt->rowCount() > 0) {
                                                $productRow = $productStmt->fetch(PDO::FETCH_ASSOC);
                                                $Total = $row['qty'] * $productRow['price'];
                                                $SumTotal += $Total;
                                                ?>
                                                <tr>
                                                    
                                                    <td><img src="data:image/jpeg;base64,<?php echo base64_encode($productRow['img']); ?>" width="100" height="100"></td>
                                                    <td><?php echo $productRow['productName']; ?></td>
                                                    <td>$<?php echo number_format($productRow['price'], 2); ?></td>
                                                    <td><?php echo $row['qty']; ?></td>
                                                    <td>$<?php echo number_format($Total, 2); ?></td>
                                                   
                                                </tr>
                                                <?php
                                            } else {
                                                echo "<tr><td colspan='7'>Product not found for ID: " . $row['productId'] . "</td></tr>";
                                            }
                                        }
                                    } else {
                                        echo "<tr><td colspan='7'>No order details found for the provided order ID.</td></tr>";
                                    }
                                }
                                ?>
                            </tbody>
                              <tfoot>
                                  <tr>
                                      <td colspan="4" class="text-right"><strong>Total</strong></td>
                                      <td colspan="2">$<?php echo number_format($SumTotal, 2); ?></td>
                                      <td></td>
                                  </tr>
                              </tfoot>
                        </table>
                        </div>
                      </div>

                      <!-- <div class="card-body">
                        <div class="table-responsive " style="margin-top: 10px;">            
                        <table class="table table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Product ID</th>
                                    <th></th>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                       
                            <?php
$SumTotalT = 0; // Initialize $SumTotalT here to avoid undefined variable warning

if (!isset($_SESSION["strProductID"]) || !is_array($_SESSION["strProductID"])) {
    echo '<tr><td colspan="6" class="text-center">Cart is empty.</td></tr>';
} else {
    foreach ($_SESSION["strProductID"] as $key => $productId) {
        if (!empty($productId)) {
            $stmt = $conn->prepare("SELECT * FROM product WHERE productId = :productId");
            $stmt->bindParam(':productId', $productId);
            $stmt->execute();
            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            $Total = $_SESSION["strQty"][$key] * $product["price"];
            $SumTotalT += $Total;
            ?>
            
            <tr>
                <td><?php echo $productId; ?></td>
                <td><img src="data:image/jpeg;base64,<?php echo base64_encode($product['img']); ?>" width="100" height="100"></td>
                <td><?php echo $product["productName"]; ?></td>
                <td>$<?php echo number_format($product["price"], 2); ?></td>
                <td><?php echo $_SESSION["strQty"][$key]; ?></td>
                <td>$<?php echo number_format($Total, 2); ?></td>
                <td>
                   <a href="delOrderItemedit.php?Line=<?php echo $key; ?>&orderId=<?php echo $orderId; ?>" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>

                </td>
            </tr>
      
            <?php
        }
    }
        $stmt = $conn->prepare("SELECT * FROM orders WHERE orderId = :orderId");
                        $stmt->bindParam(':orderId', $orderId);
                        $stmt->execute();
                        $order = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch the order details
                        $SumTotal +=$order["totalAmount"];
                        // echo  $SumTotal;
                       
}


?>

                                </tbody>
                              <tfoot>
                                  <tr>
                                      <td colspan="4" class="text-right"><strong>Total</strong></td>
                                      <td colspan="2">$<?php echo number_format($SumTotalT, 2); ?></td>
                                      <td></td>
                                  </tr>
                              </tfoot>
                        </table>
                        </div>
                      </div> -->
                  </div>
          </div>       
            <div class="row">
                <div class="col-lg-12">
                  <div class="card">
                      <div class="card-body">
                        <h5 class="card-title">ข้อมูลที่อยู่จัดส่ง</h5>  
                        <?php
                            if(isset($_GET['id'])){
                                // Fetch product details from the database based on the product ID
                                $stmt = $conn->prepare("SELECT * FROM orders WHERE orderId = :orderId");
                                $stmt->bindParam(':orderId', $_GET['id']);
                                $stmt->execute();
                                $orders = $stmt->fetch(PDO::FETCH_ASSOC);

                                // Fetch slipimg from the database
                               
                        ?>
                                <form class="row g-3" action="editOrderCustomer.php" method="post" enctype="multipart/form-data">
                                    <div class="col-md-6">
                                        <label for="inputName5" class="form-label">ชื่อ</label>
                                        <input type="text" class="form-control" id="inputName5" name="nameCustomer" value="<?php echo $orders['nameCustomer']; ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputEmail5" class="form-label">เบอร์โทรศัพท์</label>
                                        <input type="text" class="form-control" id="inputEmail5"  name="tel" value="<?php echo $orders['tel']; ?>">
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <textarea class="form-control" placeholder="Address" id="floatingTextarea" style="height: 100px;" name="addrCustomer"><?php echo $orders['addrCustomer']; ?></textarea>
                                            <label for="floatingTextarea">ที่อยู่ลูกค้า</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label for="inputAddress5" class="form-label">e-mail</label>
                                        <input type="text" class="form-control" id="inputAddres5s" name="e-mail"  value="<?php echo $orders['email']; ?>">
                                    </div>
                                    <input type="hidden" name="total" value="<?php echo $SumTotal; ?>">
                                    <div class="col-sm-10">
                                                          <label for="inputNumber" class="col-sm-2 col-form-label">File Upload</label>
                                                          <input class="form-control" type="file" id="formFile" name="slipimg">
                                                          <?php
                                $stmt = $conn->prepare("SELECT slipimg FROM orders WHERE orderId = :orderId");
                                $stmt->bindParam(':orderId', $_GET['id']);
                                $stmt->execute();
                                $img = $stmt->fetch(PDO::FETCH_ASSOC);
                                    // Display slipimg
                                    if ($img) {
                                        echo '<img src="data:image/jpeg;base64,' . base64_encode($img['slipimg']) . '" style="max-width: 200px; max-height: 200px;" />';

                                    }
                                    ?>  
                                                        </div>
                        
                                    <input  type="hidden"  name="orderId" value="<?php echo $orders['orderId']; ?>">
                                    <div class="text-right"> <!-- Align container to the left -->
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