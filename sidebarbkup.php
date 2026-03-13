<?php
require_once('connection.php');
require_once('sessionSet.php');

$userName = $_SESSION['loginUsername'];
$userID = $_SESSION['loginUserID'];

$User = userByID($userID);
$userSchoolID = $User->idschool;
$staffID = $User->idstaff;
$Staff = staffByID($staffID);
$userFirstname = $Staff->firstname;
$userLastname = $Staff->lastname;
$userRank = $Staff->rank;
$userBelt = $Staff->belt;
$IDuserType = $User->idusertype;
$userTypes = userTypesByID($IDuserType);
$userType = $userTypes->name;
$userDetail = ucwords($userFirstname)." ".ucwords($userLastname)." ".strtoupper($userRank)."/".$userBelt;


?>
<?php
if(!isAdmin()){

?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link"> <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> <span class="brand-text font-weight-light"><?php echo $userType; ?> Login</span> </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image"> <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image"> </div>
            <div class="info">
                <a href="Profile.php" class="d-block">
                    <?php echo $userDetail; ?>
                </a>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <!--Add Candidate-->
                <li class="nav-item has-treeview">
                    <a href="addCandidate.php" class="nav-link active"> <i class="nav-icon far fa-plus-square"></i>
                        <p> Add Candidate </p>
                    </a>
                </li>
                <!--/Add Candidate-->
                <!--Take Test-->
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link"> <i class="nav-icon fas fa-chart-pie"></i>
                        <p> Take Test <i class="right fas fa-angle-left"></i> </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="tokenfortest.php" class="nav-link"> <i class="far fa-circle nav-icon"></i>
                                <p>Sign Test</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="tokenForRoadTest.php" class="nav-link"> <i class="far fa-circle nav-icon"></i>
                                <p>Road Test</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!--/ Take Test-->
                <!--Duplicate Token-->
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link"> <i class="nav-icon fas fa-tree"></i>
                        <p> Duplicate Token <i class="fas fa-angle-left right"></i> </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="duplicateFirstToken.php" class="nav-link"> <i class="far fa-circle nav-icon"></i>
                                <p>First Token</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="duplicateSignTestResultToken.php" class="nav-link"> <i class="far fa-circle nav-icon"></i>
                                <p>Sign Test Token</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link"> <i class="far fa-circle nav-icon"></i>
                                <p>Road Test Token</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!--/Duplicate Token-->
                <!--Print CNIC Data-->
                <li class="nav-item has-treeview">
                    <a href="cnicData.php" class="nav-link"> <i class="nav-icon fas fa-print"></i>
                        <p>Find Test Paper</p>
                    </a>
                </li>
                <!--/Print CNIC Data-->
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
<?php
}
else{
    ?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link"> <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> <span class="brand-text font-weight-light"><?php echo $userType; ?> Login</span> </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image"> <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image"> </div>
            <div class="info">
                <a href="Profile.php" class="d-block">
                    <?php echo $userDetail; ?>
                </a>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

                <!--Admission-->
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link"> <i class="nav-icon fas fa-file"></i>
                        <p> Admission <i class="right fas fa-angle-left"></i> </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="newAdmission.php" class="nav-link"> <i class="far fa-circle nav-icon"></i>
                                <p>New Admission</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="Questions.php" class="nav-link"> <i class="far fa-circle nav-icon"></i>
                                <p>Confirm Admission</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!--/ Admission-->


                <!--Expense-->
                <li class="nav-item has-treeview">
                    <a href="newExpense.php" class="nav-link"> <i class="nav-icon far fa-plus-square"></i>
                        <p> Add Expense </p>
                    </a>
                </li>
                <!--/Expense-->

                <!--Staff-->
                <li class="nav-item has-treeview">
                    <a href="Staff.php" class="nav-link"> <i class="nav-icon far fa-plus-square"></i>
                        <p> Staff </p>
                    </a>
                </li>
                <!--/Staff-->
                <!--Reports-->
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link"> <i class="nav-icon fas fa-chart-pie"></i>
                        <p> Reports <i class="right fas fa-angle-left"></i> </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Income
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview" style="display: none;">
                                <li class="nav-item">
                                    <a href="RPTincome2dates.php" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>From-To Dates</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="RPTincomeMonth.php" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>By Month</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="RPTincomeCategory.php" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Category</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="RPTincomeSchool.php" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>By School</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Expense
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview" style="display: none;">
                                <li class="nav-item">
                                    <a href="RPTexpense2dates.php" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>From-To Dates</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="RPTexpenseMonth.php" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>By Month</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="RPTexpenseCategory.php" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Category</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="RPTexpenseSchool.php" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>By School</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Student
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview" style="display: none;">
                                <li class="nav-item">
                                    <a href="RPTstudent2dates.php" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>From-To Dates</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="RPTstudentMonth.php" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>By Month</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="RPTstudentCategory.php" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Category</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="RPTstudentSchool.php" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>By School</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <!--/ Reports-->
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
<?php
}
?>
