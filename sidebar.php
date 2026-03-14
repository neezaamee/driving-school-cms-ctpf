<?php
require_once('connection.php');
require_once('sessionSet.php');

$userID = $_SESSION['loginUserID'];
$userName = $_SESSION['loginUsername'];

$User = userByID(getUserID());
$userSchoolID = $User->idschool;
$School = schoolByID($userSchoolID);
$schoolName = $School->location;
$City = cityByID($School->idcity);
$cityName = $City->name;
$Staff = staffByID($User->idstaff);
$TypeStaff = typeStaffByID($Staff->idtypestaff);
$staffTypeStaff =  $TypeStaff->name;
$userFirstname = $Staff->fullname;
$userDetail = ucwords($userFirstname) . "<br /><span style='font-size: 0.8em'>" . $staffTypeStaff . "</span>";

// Active page helper
$currentPage = basename($_SERVER['PHP_SELF']);
function isPageActive($page) {
    global $currentPage;
    return ($currentPage == $page) ? 'active' : '';
}
function isTreeOpen($pages) {
    global $currentPage;
    return in_array($currentPage, $pages) ? 'menu-open' : '';
}
function isTreeActive($pages) {
    global $currentPage;
    return in_array($currentPage, $pages) ? 'active' : '';
}
?>

<aside class="main-sidebar sidebar-light-primary elevation-4">
  <div class="brand-link bg-primary text-center py-3">
    <i class="fas fa-car-side fa-2x mb-2 d-block"></i>
    <span class="brand-text font-weight-bold">
      <?= isAdmin() ? "Super Admin" : "$schoolName $cityName"; ?>
    </span>
  </div>

  <div class="sidebar">
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image"><i class="fas fa-user-circle fa-2x text-primary"></i></div>
      <div class="info">
        <a href="Profile.php" class="d-block font-weight-bold"><?= $userDetail; ?></a>
      </div>
    </div>

    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
        
        <li class="nav-item">
          <a href="index.php" class="nav-link <?= isPageActive('index.php'); ?>">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <?php $deskOps = ['newEnroll.php', 'viewVoucher.php', 'newAdmission.php', 'activeStudents.php', 'addPhoto.php']; ?>
        <li class="nav-item has-treeview <?= isTreeOpen($deskOps); ?>">
          <a href="#" class="nav-link <?= isTreeActive($deskOps); ?>">
            <i class="nav-icon fas fa-desktop text-info"></i>
            <p>Desk Operations <i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="newEnroll.php" class="nav-link <?= isPageActive('newEnroll.php'); ?>">
                <i class="fas fa-user-plus nav-icon"></i><p>New Enrollment</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="viewVoucher.php" class="nav-link <?= isPageActive('viewVoucher.php'); ?>">
                <i class="fas fa-file-invoice-dollar nav-icon text-warning"></i><p>Duplicate Voucher</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="newAdmission.php" class="nav-link <?= isPageActive('newAdmission.php'); ?>">
                <i class="fas fa-file-signature nav-icon"></i><p>New Registration</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="activeStudents.php" class="nav-link <?= isPageActive('activeStudents.php'); ?>">
                <i class="fas fa-users nav-icon"></i><p>Active Students</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="addPhoto.php" class="nav-link <?= isPageActive('addPhoto.php'); ?>">
                <i class="fas fa-camera nav-icon"></i><p>Add Student Photo</p>
              </a>
            </li>
          </ul>
        </li>

        <?php $expenses = ['newExpense.php', 'newPetrolExpense.php']; ?>
        <li class="nav-item has-treeview <?= isTreeOpen($expenses); ?>">
          <a href="#" class="nav-link <?= isTreeActive($expenses); ?>">
            <i class="nav-icon fas fa-wallet text-danger"></i>
            <p>Expenses <i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="newExpense.php" class="nav-link <?= isPageActive('newExpense.php'); ?>">
                <i class="fas fa-minus-circle nav-icon"></i><p>Add General Expense</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="newPetrolExpense.php" class="nav-link <?= isPageActive('newPetrolExpense.php'); ?>">
                <i class="fas fa-gas-pump nav-icon"></i><p>Add Petrol Expense</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-header">ANALYTICS</li>
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-chart-bar text-success"></i>
            <p>Income Reports <i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="RPTincome2dates.php" class="nav-link"><i class="far fa-circle nav-icon"></i><p>By Dates</p></a>
            </li>
            <li class="nav-item">
              <a href="RPTincomeMonth.php" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Monthly</p></a>
            </li>
            <?php if (isAdmin()) { ?>
            <li class="nav-item">
              <a href="RPTincomeSchool.php" class="nav-link"><i class="far fa-circle nav-icon"></i><p>By School</p></a>
            </li>
            <?php } ?>
          </ul>
        </li>

        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-file-invoice-dollar text-warning"></i>
            <p>Expense Reports <i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="RPTexpense2dates.php" class="nav-link"><i class="far fa-circle nav-icon"></i><p>By Dates</p></a>
            </li>
            <li class="nav-item">
              <a href="RPTexpenseMonth.php" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Monthly</p></a>
            </li>
            <?php if (isAdmin()) { ?>
            <li class="nav-item">
              <a href="RPTexpenseSchool.php" class="nav-link"><i class="far fa-circle nav-icon"></i><p>By School</p></a>
            </li>
            <?php } ?>
          </ul>
        </li>

        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-user-graduate text-primary"></i>
            <p>Student Reports <i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="RPTstudent2dates.php" class="nav-link"><i class="far fa-circle nav-icon"></i><p>By Dates</p></a>
            </li>
            <li class="nav-item">
              <a href="RPTstudentMonth.php" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Monthly</p></a>
            </li>
          </ul>
        </li>

        <?php $utilities = ['tableStudentsAjax.php', 'editStudent.php', 'duplicateRegistrationForm.php', 'printCertificate.php', 'licenseTestSheet.php']; ?>
        <li class="nav-item has-treeview <?= isTreeOpen($utilities); ?>">
          <a href="#" class="nav-link <?= isTreeActive($utilities); ?>">
            <i class="nav-icon fas fa-tools text-secondary"></i>
            <p>Utilities <i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="tableStudentsAjax.php" class="nav-link <?= isPageActive('tableStudentsAjax.php'); ?>">
                <i class="fas fa-table nav-icon"></i><p>Student Directory</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="editStudent.php" class="nav-link <?= isPageActive('editStudent.php'); ?>">
                <i class="fas fa-user-edit nav-icon"></i><p>Modify Student</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="duplicateRegistrationForm.php" class="nav-link <?= isPageActive('duplicateRegistrationForm.php'); ?>">
                <i class="fas fa-copy nav-icon"></i><p>Duplicate Form</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="printCertificate.php" class="nav-link <?= isPageActive('printCertificate.php'); ?>">
                <i class="fas fa-certificate nav-icon"></i><p>Print Certificate</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="licenseTestSheet.php" class="nav-link <?= isPageActive('licenseTestSheet.php'); ?>">
                <i class="fas fa-clipboard-list nav-icon"></i><p>License Test Sheet</p>
              </a>
            </li>
          </ul>
        </li>

        <?php if (!isDEO()) { ?>
        <?php $admin = ['Staff.php', 'viewUsers.php', 'addStaff.php', 'auditLogs.php']; ?>
        <li class="nav-item has-treeview <?= isTreeOpen($admin); ?>">
          <a href="#" class="nav-link <?= isTreeActive($admin); ?>">
            <i class="nav-icon fas fa-user-shield text-dark"></i>
            <p>Administration <i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="Staff.php" class="nav-link <?= isPageActive('Staff.php'); ?>">
                <i class="fas fa-user-tie nav-icon"></i><p>Staff Management</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="viewUsers.php" class="nav-link <?= isPageActive('viewUsers.php'); ?>">
                <i class="fas fa-users-cog nav-icon"></i><p>View Users</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="addStaff.php" class="nav-link <?= isPageActive('addStaff.php'); ?>">
                <i class="fas fa-user-plus nav-icon"></i><p>Add New Staff</p>
              </a>
            </li>
            <?php if (isAdmin()) { ?>
            <li class="nav-item">
              <a href="auditLogs.php" class="nav-link <?= isPageActive('auditLogs.php'); ?>">
                <i class="fas fa-clipboard-check nav-icon text-warning"></i><p>Audit Logs</p>
              </a>
            </li>
            <?php } ?>
          </ul>
        </li>
        <?php } ?>

        <li class="nav-item mt-4 pt-4 border-top">
          <a href="Logout.php" class="nav-link text-danger bg-light">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p class="font-weight-bold">Logout System</p>
          </a>
        </li>

      </ul>
    </nav>
  </div>
</aside>
