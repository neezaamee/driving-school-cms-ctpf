<?php session_start();
$pageTitle = "Dashboard";
require_once('connection.php');
require_once('sessionSet.php');
include('Functions.php');

$months = [];
$enrollmentData = [];
$incomeData = [];
for ($i = 6; $i >= 0; $i--) {
    $d = date('Y-m-01', strtotime("-$i months"));
    $m = date('n', strtotime($d));
    $y = date('Y', strtotime($d));
    $months[] = strtoupper(date('M', strtotime($d)));
    $enrollmentData[] = totalAdmissions(null, $m, $y);
    $incomeData[] = totalIncome($con, null, $m, $y);
}
?>
<!DOCTYPE html>
<html>
<!--Head-->
<?php include_once 'Head.php'; ?>
<style>
  .total {
    font-size: x-large;
  }
</style>
<!--/Head-->
<!--Body-->

<body class="hold-transition sidebar-mini layout-fixed" onload="myFunction()">
  <div class="wrapper">
    <!-- Navbar -->
    <?php include('topNav.php') ?>
    <!-- /.navbar -->
    <!-- Main Sidebar Container -->
    <?php include('sidebar.php') ?>
    <!--/ Main Sidebar Container-->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header ( Page header ) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Dashboard</h1>
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
          <div class="row">
            <div class="col-lg-4 col-12">
              <div class="small-box bg-warning elevation-2">
                <div class="inner text-white">
                  <h3><?= totalAdmissions(null, date('m'), date('Y')) ?: '0' ?></h3>
                  <p>Enrollments (<?= date('F Y') ?>)</p>
                </div>
                <div class="icon"><i class="fas fa-users"></i></div>
                <a href="reportEnrolled.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-lg-4 col-12">
              <div class="small-box bg-success elevation-2">
                <div class="inner">
                  <h3><?= totalIncome($con, null, date('m'), date('Y')) ?: '0' ?></h3>
                  <p>Income (<?= date('F Y') ?>)</p>
                </div>
                <div class="icon"><i class="fas fa-coins"></i></div>
                <a href="RPTincomeMonth.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-lg-4 col-12">
              <div class="small-box bg-info elevation-2">
                <div class="inner">
                  <h3><?= totalExpenses($con, null, date('m'), date('Y')) ?: '0' ?></h3>
                  <p>Expenses (<?= date('F Y') ?>)</p>
                </div>
                <div class="icon"><i class="fas fa-wallet"></i></div>
                <a href="RPTexpenseMonth.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
          </div>

          <div class="row mb-4">
            <div class="col-12">
              <div class="card elevation-2">
                <div class="card-header bg-dark"><h3 class="card-title">Quick Actions</h3></div>
                <div class="card-body py-3">
                  <div class="row text-center">
                    <div class="col-6 col-md-3 mb-2 mb-md-0">
                      <a href="newEnroll.php" class="btn btn-outline-primary btn-block p-3">
                        <i class="fas fa-user-plus fa-2x mb-2 d-block"></i> New Enrollment
                      </a>
                    </div>
                    <div class="col-6 col-md-3 mb-2 mb-md-0">
                      <a href="newAdmission.php" class="btn btn-outline-success btn-block p-3">
                        <i class="fas fa-file-signature fa-2x mb-2 d-block"></i> New Registration
                      </a>
                    </div>
                    <div class="col-6 col-md-3">
                      <a href="viewVoucher.php" class="btn btn-outline-warning btn-block p-3">
                        <i class="fas fa-file-invoice-dollar fa-2x mb-2 d-block"></i> Duplicate Voucher
                      </a>
                    </div>
                    <div class="col-6 col-md-3">
                      <a href="duplicateRegistrationForm.php" class="btn btn-outline-info btn-block p-3">
                        <i class="fas fa-copy fa-2x mb-2 d-block"></i> Duplicate Form
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Small boxes ( Stat box ) -->
          <div class="row">
            <!-- Analytics Chart -->
            <div class="col-lg-8 col-12">
              <div class="card elevation-2">
                <div class="card-header border-0">
                  <div class="d-flex justify-content-between">
                    <h3 class="card-title font-weight-bold">Analytics Overview</h3>
                    <a href="RPTincomeMonth.php" class="text-primary">View Detailed Reports</a>
                  </div>
                </div>
                <div class="card-body">
                  <div class="d-flex">
                    <p class="d-flex flex-column">
                      <span class="text-bold text-lg">Income vs Enrollments</span>
                      <span>Last 7 Months Performance</span>
                    </p>
                  </div>
                  <div class="position-relative mb-4">
                    <canvas id="enrollment-chart" height="300"></canvas>
                  </div>
                  <div class="d-flex flex-row justify-content-end">
                    <span class="mr-2">
                      <i class="fas fa-square text-primary"></i> Enrollments
                    </span>
                    <span>
                      <i class="fas fa-square text-success"></i> Income
                    </span>
                  </div>
                </div>
              </div>

              <!-- Recent Admissions Table -->
              <div class="card elevation-2">
                <div class="card-header border-transparent">
                  <h3 class="card-title font-weight-bold">Recent Admissions</h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body p-0">
                  <div class="table-responsive">
                    <table class="table m-0 table-hover table-striped">
                      <thead class="bg-light">
                        <tr>
                          <th>Registration</th>
                          <th>Student Name</th>
                          <th>Course</th>
                          <th>Status</th>
                          <th>Date</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $sqlRecent = "SELECT a.registration, s.fullname, c.coursename, a.status, a.admission_date
                                     FROM admissions a
                                     JOIN students s ON a.idstudent = s.id
                                     JOIN courses c ON a.idcourse = c.id
                                     ORDER BY a.id DESC LIMIT 7";
                        $resRecent = mysqli_query($con, $sqlRecent);
                        while ($rowRec = mysqli_fetch_assoc($resRecent)) {
                          $statusBadge = $rowRec['status'] == 0 ? '<span class="badge badge-primary">Active</span>' : '<span class="badge badge-success">Passed</span>';
                          echo "<tr>
                                  <td><a href='duplicateRegistrationForm.php?registration=" . $rowRec['registration'] . "'>" . $rowRec['registration'] . "</a></td>
                                  <td>" . strtoupper($rowRec['fullname']) . "</td>
                                  <td>" . $rowRec['coursename'] . "</td>
                                  <td>" . $statusBadge . "</td>
                                  <td>" . date('d-m-Y', strtotime($rowRec['admission_date'])) . "</td>
                                </tr>";
                        }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="card-footer clearfix text-center">
                  <a href="activeStudents.php" class="btn btn-sm btn-info">View All Students</a>
                </div>
              </div>
            </div>

            <!-- Right Column: Original Cards Improved -->
            <div class="col-lg-4 col-12">
              <!-- Enrollment Card -->
              <div class="card card-warning elevation-2">
                <div class="card-header">
                  <h3 class="card-title font-weight-bold">Enrollments</h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                  </div>
                </div>
                <div class="card-body p-0">
                  <table class="table table-hover mb-0">
                    <tr class="bg-light"><th>Total</th><th class="text-right"><span class="badge badge-dark"><?= totalAdmissions(); ?></span></th></tr>
                    <tr><td>Active Students</td><td class="text-right"><?= totalAdmissions(0) ?></td></tr>
                    <tr><td>Passed Out</td><td class="text-right"><?= totalAdmissions(1) ?></td></tr>
                    <tr><td>Current Month</td><td class="text-right"><?= totalAdmissions(null, date('m'), date('Y')); ?></td></tr>
                    <tr><td>Current Year</td><td class="text-right"><?= totalAdmissions(null, null, date('Y')); ?></td></tr>
                  </table>
                </div>
                <div class="card-footer text-center"><a href="reportEnrolled.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a></div>
              </div>

              <!-- Income Card -->
              <div class="card card-success elevation-2">
                <div class="card-header">
                  <h3 class="card-title font-weight-bold">Income</h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                  </div>
                </div>
                <div class="card-body p-0">
                  <table class="table table-hover mb-0">
                    <tr class="bg-light"><th>Total</th><th class="text-right"><span class="badge badge-dark"><?= number_format(totalIncome($con) ?? 0); ?></span></th></tr>
                    <?php
                    $QR = mysqli_query($con, "SELECT * FROM studentcategories");
                    while ($Row = mysqli_fetch_assoc($QR)) {
                      echo "<tr><td>" . $Row['name'] . "</td><td class='text-right'>" . number_format(totalIncome($con, $Row['id']) ?? 0) . "</td></tr>";
                    }
                    ?>
                    <tr><td>Current Month</td><td class="text-right"><?= number_format(totalIncome($con, null, date('m'), date('Y')) ?? 0); ?></td></tr>
                  </table>
                </div>
                <div class="card-footer text-center"><a href="RPTincomeMonth.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a></div>
              </div>

              <!-- Expenses Card -->
              <div class="card card-info elevation-2">
                <div class="card-header">
                  <h3 class="card-title font-weight-bold">Expenses</h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                  </div>
                </div>
                <div class="card-body p-0">
                  <table class="table table-hover mb-0">
                    <tr class="bg-light"><th>Total</th><th class="text-right"><span class="badge badge-dark"><?= number_format(totalExpenses($con) ?? 0); ?></span></th></tr>
                    <?php
                    $QR = mysqli_query($con, "SELECT * FROM expensetypes WHERE status = 1");
                    while ($Row = mysqli_fetch_assoc($QR)) {
                      echo "<tr><td>" . $Row['type'] . "</td><td class='text-right'>" . number_format(totalExpenses($con, $Row['id']) ?? 0) . "</td></tr>";
                    }
                    ?>
                    <tr><td>Current Month</td><td class="text-right"><?= number_format(totalExpenses($con, null, date('m'), date('Y')) ?? 0); ?></td></tr>
                  </table>
                </div>
                <div class="card-footer text-center"><a href="RPTexpenseMonth.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a></div>
              </div>
            </div>
          </div>
          <!-- /.end row small box -->

          <?php if (isAdmin()): ?>
            <div class="row mt-4 mb-4">
              <div class="col-12">
                <div class="card elevation-2">
                  <div class="card-header bg-dark">
                    <h3 class="card-title font-weight-bold"><i class="fas fa-chart-line mr-2"></i>Branch Performance Overview</h3>
                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                      </button>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table m-0 table-hover table-striped">
                        <thead class="bg-light">
                          <tr class="text-center">
                            <th class="text-left">School Branch</th>
                            <th>Total Enrollments</th>
                            <th>Passed Out</th>
                            <th>Monthly Income</th>
                            <th>Monthly Expenses</th>
                            <th>Net Performance (MTD)</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $sqlSchools = "SELECT * FROM schools WHERE status = 1";
                          $resSchools = mysqli_query($con, $sqlSchools);
                          while ($school = mysqli_fetch_assoc($resSchools)) {
                            $schoolID = $school['id'];
                            $enrolls = totalAdmissions(null, null, null, $schoolID) ?? 0;
                            $passed = totalAdmissions(1, null, null, $schoolID) ?? 0;
                            $income = totalIncome($con, null, date('m'), date('Y'), $schoolID) ?? 0;
                            $expense = totalExpenses($con, null, date('m'), date('Y'), $schoolID) ?? 0;
                            $net = $income - $expense;
                            $netClass = $net >= 0 ? 'text-success' : 'text-danger';

                            echo "<tr>
                                    <td class='font-weight-bold'><i class='fas fa-school mr-2 text-muted'></i> " . $school['location'] . " (" . $school['schoolcode'] . ")</td>
                                    <td class='text-center'><span class='badge badge-primary px-3'>" . $enrolls . "</span></td>
                                    <td class='text-center'><span class='badge badge-success px-3'>" . $passed . "</span></td>
                                    <td class='text-center text-bold'>Rs. " . number_format($income) . "</td>
                                    <td class='text-center text-bold'>Rs. " . number_format($expense) . "</td>
                                    <td class='text-center font-weight-bold " . $netClass . "'>Rs. " . number_format($net) . "</td>
                                  </tr>";
                          }
                          ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php endif; ?>
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
  <!-- Custom Script to Initialize the Bar Chart -->
  <script>
    $(function() {
      'use strict'
      var ticksStyle = {
        fontColor: '#495057',
        fontStyle: 'bold'
      }
      var mode = 'index'
      var intersect = true
      var $salesChart = $('#enrollment-chart')
      var salesChart = new Chart($salesChart, {
        type: 'bar',
        data: {
          labels: <?php echo json_encode($months); ?>,
          datasets: [{
            label: 'Enrollments',
            backgroundColor: '#007bff',
            borderColor: '#007bff',
            data: <?php echo json_encode($enrollmentData); ?>,
            yAxisID: 'y-axis-enroll'
          }, {
            label: 'Income',
            backgroundColor: '#28a745',
            borderColor: '#28a745',
            data: <?php echo json_encode($incomeData); ?>,
            yAxisID: 'y-axis-income'
          }]
        },
        options: {
          maintainAspectRatio: false,
          tooltips: {
            mode: mode,
            intersect: intersect
          },
          hover: {
            mode: mode,
            intersect: intersect
          },
          legend: {
            display: true
          },
          scales: {
            yAxes: [{
              id: 'y-axis-enroll',
              type: 'linear',
              position: 'left',
              gridLines: {
                display: true,
                lineWidth: '2px',
                color: 'rgba(0, 0, 0, .1)'
              },
              ticks: $.extend({
                beginAtZero: true,
                fontColor: '#007bff'
              }, ticksStyle)
            }, {
              id: 'y-axis-income',
              type: 'linear',
              position: 'right',
              gridLines: {
                display: false
              },
              ticks: $.extend({
                beginAtZero: true,
                fontColor: '#28a745',
                callback: function(value) {
                  return 'Rs.' + (value >= 1000 ? (value / 1000) + 'k' : value);
                }
              }, ticksStyle)
            }],
            xAxes: [{
              display: true,
              gridLines: {
                display: false
              },
              ticks: ticksStyle
            }]
          }
        }
      })
    })
  </script>
  <?php include 'footerPlugins.php' ?>
</body>
<!--/Body-->

</html>