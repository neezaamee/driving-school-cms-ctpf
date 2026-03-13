<?php session_start();
$pageTitle = "Staff Management";
require_once('connection.php');
require_once('sessionSet.php');
include('Functions.php');


?>

<!DOCTYPE html>
<html>
<!--Head-->
<?php include_once('Head.php'); ?>
<!--/Head-->
<!--Body-->

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <!-- Navbar -->
    <?php include('topNav.php') ?>
    <!-- /.navbar -->
    <!-- Main Sidebar Container -->
    <?php include('sidebar.php') ?>
    <!--/ Main Sidebar Container-->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Staff Management</h1>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <!-- Small boxes (Stat box) -->
          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
              <div class="card">
                <div class="card-body">
                  <table id="usersTable" class="table text-center table-bordered table-striped">
                    <?php
                    $userName = $_SESSION['loginUsername'];
                    $userID = $_SESSION['loginUserID'];

                    $User = userByID($userID);
                    $userSchoolID = $User->idschool;
                    ?>
                    <thead>
                      <tr>
                        <th>No.</th>
                        <th>School Name</th>
                        <th>Full Name</th>
                        <th>Rank</th>
                        <th>Belt</th>
                        <th>Designation</th>
                        <th>Date Added</th>
                        <th colspan="3">Actions</th>

                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $Serial = 0;

                      // Optimized JOIN query to fetch all staff data in one go
                      $sql = "SELECT 
                                s.*, 
                                sc.schoolcode, sc.location as schoolLocation, 
                                c.shortcode as cityShortcode,
                                ts.name as designation,
                                (SELECT COUNT(*) FROM users u WHERE u.idstaff = s.id) as userExists
                              FROM staff s
                              INNER JOIN schools sc ON s.idschool = sc.id
                              INNER JOIN cities c ON sc.idcity = c.id
                              INNER JOIN typestaff ts ON s.idtypestaff = ts.id";

                      if (!isAdmin()) {
                        $sql .= " WHERE s.idschool = ? AND s.idtypestaff NOT IN ('1', '10')";
                        $stmt = mysqli_prepare($con, $sql);
                        mysqli_stmt_bind_param($stmt, "i", $userSchoolID);
                      } else {
                        $stmt = mysqli_prepare($con, $sql);
                      }

                      mysqli_stmt_execute($stmt);
                      $Result = mysqli_stmt_get_result($stmt);

                      while ($Row = mysqli_fetch_assoc($Result)) {
                        $Serial++;
                        $staffID = $Row['id'];
                        $isUserCreated = (int)$Row['userExists'] > 0;
                        ?>
                        <tr>
                          <td><?php echo $Serial; ?></td>
                          <td><span class="badge badge-secondary"><?php echo $Row['schoolcode'] . '-' . $Row['cityShortcode']; ?></span><br><small><?php echo $Row['schoolLocation']; ?></small></td>
                          <td class="text-left"><strong><?php echo strtoupper($Row['fullname']); ?></strong></td>
                          <td><?php echo $Row['rank'] ?: '-'; ?></td>
                          <td><?php echo $Row['belt'] ?: '-'; ?></td>
                          <td><span class="badge badge-info"><?php echo $Row['designation']; ?></span></td>
                          <td><?php echo date('d-M-Y', strtotime($Row['added'])); ?></td>
                          <td>
                            <div class="btn-group">
                              <a class="btn btn-primary btn-sm" href="editStaff.php?staffID=<?php echo $staffID; ?>" title="Edit Staff">
                                <i class="fas fa-edit"></i>
                              </a>
                              <button class="btn btn-danger btn-sm ml-1" data-href="deleteStaff.php?staffID=<?php echo $staffID; ?>" data-toggle="modal" data-target="#confirm-delete" title="Delete Staff">
                                <i class="fas fa-trash"></i>
                              </button>
                            </div>
                          </td>
                          <td>
                            <?php if ($isUserCreated): ?>
                              <span class="badge badge-success"><i class="fas fa-check-circle"></i> User Exists</span>
                            <?php elseif (in_array($Row['idtypestaff'], ['10', '2', '11'])): ?>
                              <?php if (isAdmin()): ?>
                                <a class="btn btn-outline-success btn-xs" href="createInchargeUser.php?staffID=<?php echo $staffID; ?>">
                                  <i class="fas fa-user-shield"></i> Create Incharge
                                </a>
                              <?php endif; ?>
                              <a class="btn btn-outline-info btn-xs" href="createDEOuser.php?staffID=<?php echo $staffID; ?>">
                                <i class="fas fa-user-plus"></i> Create DEO
                              </a>
                            <?php else: ?>
                              <span class="badge badge-light text-muted">N/A</span>
                            <?php endif; ?>
                          </td>
                        </tr>
                        <?php
                      }
                      mysqli_stmt_close($stmt);
                      ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>No.</th>
                        <th>School Name</th>
                        <th>Full Name</th>
                        <th>Rank</th>
                        <th>Belt</th>
                        <th>Designation</th>
                        <th>Date Added</th>
                        <th colspan="3">Actions</th>

                      </tr>
                    </tfoot>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <!--Footer Content-->
    <?php include('footer.php') ?>
    <!--/Footer Content-->
    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->
  <!--Model for Delete User-->
  <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header"> CTP Faisalabad </div>
        <div class="modal-body"> want to delete ? </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button> <a class="btn btn-danger btn-ok">Delete</a>
        </div>
      </div>
    </div>
  </div>
  <!--/ Model for Delete User-->

  <?php include('footerPlugins.php') ?>
  <!-- DataTables -->
  <script src="plugins/datatables/jquery.dataTables.js"></script>
  <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
  <script>
    $(function() {
      $('#usersTable').DataTable({
        "paging": true,
        "searching": true,
      });
    });
  </script>
  <script>
    $('#confirm-delete').on('show.bs.modal', function(e) {
      $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    });
  </script>
</body>
<!--/Body


</html>
