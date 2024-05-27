<ul class="sidebar-nav" id="sidebar-nav">

  <?php if ($roleId == 1 || $roleId == 2): ?>
  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
      <i class="ri-shopping-bag-3-line"></i><span>สินค้า</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li>
        <a href="product.php?roleId=<?php echo $roleId; ?>">
          <i class="bi bi-circle"></i><span>สินค้าของฉัน</span>
        </a>
      </li>
      <li>
        <a href="addProduct.php?roleId=<?php echo $roleId; ?>">
          <i class="bi bi-circle"></i><span>เพิ่มสินค้าใหม่</span>
        </a>
      </li>
    </ul>
  </li><!-- End Components Nav -->
  <?php endif; ?>

  <?php if ($roleId == 1 || $roleId == 2||  $roleId == 4): ?>
  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-journal-text"></i><span>คำสั่งซื้อและการจัดส่งสินค้า</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li>
        <a href="listBuying1.php?roleId=<?php echo $roleId; ?>">
          <i class="bi bi-circle"></i><span>คำสั่งซื้อของฉัน</span>
        </a>
      </li>
    </ul>
  </li><!-- End Forms Nav -->
  <?php endif; ?>

  <?php if ($roleId == 1 || $roleId == 2 ): ?>
  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
      <i class="ri-team-line"></i><span>พนักงาน</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="charts-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li>
        <a href="permission.php?roleId=<?php echo $roleId; ?>">
          <i class="bi bi-circle"></i><span>สิทธิ์การเข้าถึง</span>
        </a>
      </li>
    </ul>
  </li><!-- End Charts Nav -->
  <?php endif; ?>

  <?php if ($roleId == 1 || $roleId == 3): ?>
  <li class="nav-item">
    <a class="nav-link collapsed" href="index.php?roleId=<?php echo $roleId; ?>">
      <i class="ri-pie-chart-line"></i>
      <span>แดชบอร์ด</span>
    </a>
  </li><!-- End Contact Page Nav -->
  <?php endif; ?>

</ul>
