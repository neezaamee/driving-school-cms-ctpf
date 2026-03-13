<?php
require_once('connection.php');
require_once('sessionSet.php');
require_once('Functions.php');
?>

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item"> <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a> </li>
        <li class="nav-item d-none d-sm-inline-block"> <a href="index.php" class="nav-link">Home</a> </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#"> <i class="fas fa-align-justify"></i> </a>
            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                <a href="Profile.php" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                Profile
                                <span class="float-right text-sm text-muted"><i class="fas fa-address-card"></i></span>
                            </h3>
                        </div>
                    </div>
                    <!-- Message End -->
                </a>
                <div class="dropdown-divider"></div>
                <a href="dbbackup.php" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                DB Backup
                                <span class="float-right text-sm text-muted"><i class="fas fa-address-card"></i></span>
                            </h3>
                        </div>
                    </div>
                    <!-- Message End -->
                </a>
                <div class="dropdown-divider"></div>
                <a href="Logout.php" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                Logout
                                <span class="float-right text-sm text-muted"><i class="fas fa-address-card"></i></span>
                            </h3>
                        </div>
                    </div>
                    <!-- Message End -->
                </a>
            </div>
        </li>
        <!--hide theme menu-->
        <!--li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"> <i class="fas fa-th-large"></i> </a>
        </li-->
    </ul>
</nav>
<!-- /.navbar -->
