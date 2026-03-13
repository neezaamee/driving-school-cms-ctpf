<?php session_start();
require_once('connection.php');
require_once('sessionSet.php');
include('Functions.php');
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
            <div class="col-12 col-sm-4 col-md-4">
              <div class="info-box bg-light">
                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text h3"><?= ' Enrollments ' . date('F Y') ?></span>
                  <span class="info-box-number h3">
                    <?= totalAdmissions(null, date('m'), date('Y')) ?>
                    <small></small>
                  </span>
                </div>

              </div>
            </div>
            <!-- end col -->
            <div class="col-12 col-sm-4 col-md-4">
              <div class="info-box bg-light mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-solid fa-coins"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text h3"><?= ' Income ' . date('F Y') ?></span>
                  <span class="info-box-number h3"><?= totalIncome($con, null, date('m'), date('Y')) ?></span>
                </div>

              </div>

            </div>
            <!-- end col -->
            <div class="col-12 col-sm-4 col-md-4">
              <div class="info-box bg-light mb-3">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-coins"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text h3"><?= ' Expenses ' . date('F Y') ?></span>
                  <span class="info-box-number h3"><?= totalExpenses($con, null, date('m'), date('Y')) ?></span>
                </div>

              </div>

            </div>
            <!-- end col -->
          </div>
          <!-- end row info box -->
          <!-- Small boxes ( Stat box ) -->
          <div class="row">
            <div class="col-lg-4 col-sm-12">
              <div class="card bg-warning collapsed-card">
                <div class="card-header">
                  <h3 class="card-title"><span class="h2">Enrollments</span></h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-plus"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body p-0">
                  <!-- small box -->
                  <div class="table-responsive">
                    <table class="table table-hover m-0">
                      <thead>
                        <tr class="bg-dark h4">
                          <th>Total</th>
                          <th>
                            <span class="badge badge-warning p-2 w-100">
                              <?= totalAdmissions(); ?>
                            </span>
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr class="h5">
                          <th>Active</td>
                          <td><span class="badge badge-dark p-2 w-100"><?= totalAdmissions(0) ?></span></td>
                        </tr>
                        <tr class="h5">
                          <th>Passed Out</td>
                          <td><span class="badge badge-dark p-2 w-100"><?= totalAdmissions(1) ?></span></td>
                        </tr>
                        <tr class="h5">
                          <th>Current Month</td>
                          <td><span class="badge badge-dark p-2 w-100"><?= totalAdmissions(1, 07, 2024); ?></span></td>
                        </tr>
                        <tr class="h5">
                          <th>Current Year</td>
                          <td><span class="badge badge-dark p-2 w-100"><?= totalAdmissions(1, null, 2024); ?></span></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="card-footer text-center clearfix">
                  <a href="reportEnrolled.php" class="btn">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>

            </div>
            <div class="col-lg-4 col-sm-12">
              <div class="card bg-success collapsed-card">
                <div class="card-header">
                  <h3 class="card-title"><span class="h2">Income</span></h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-plus"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body p-0">
                  <!-- small box -->
                  <div class="table-responsive">
                    <table class="table table-hover m-0">
                      <thead>
                        <tr class="bg-dark h4">
                          <th>Total</th>
                          <th>
                            <div class="badge badge-success p-2 w-100"><?= totalIncome($con); ?></div>
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $Q = "SELECT * FROM studentcategories";
                        $QR = mysqli_query($con, $Q);
                        while ($Row = mysqli_fetch_assoc($QR)) {
                          echo "<tr class='h5'><th>" . $Row['name'] . "</th><td><span class='badge badge-dark p-2 w-100'>" . totalIncome($con, $Row['id']) . "</td></tr>";
                        }
                        ?>
                        <tr class="h5">
                          <th>Current Month</td>
                          <td><span class="badge badge-dark p-2 w-100"><?= totalIncome($con, null, 07, 2024); ?></span></td>
                        </tr>
                        <tr class="h5">
                          <th>Current Year</td>
                          <td><span class="badge badge-dark p-2 w-100"><?= totalIncome($con, null, null, 2024); ?></span></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="card-footer text-center clearfix"> <!-- <i class="ion ion-person-add"></i> -->
                  <a href="reportEnrolled.php" class="btn">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>

            </div>
            <div class="col-lg-4 col-sm-12">
              <div class="card bg-info collapsed-card">
                <div class="card-header">
                  <h3 class="card-title"><span class="h2">Expenses</span></h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-plus"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body p-0">
                  <!-- small box -->
                  <div class="table-responsive">
                    <table class="table table-hover m-0">
                      <thead>
                        <tr class="bg-dark h4">
                          <th>Total</th>
                          <th>
                            <span class="badge badge-info p-2 w-100"><?= totalExpenses($con); ?></span>
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $Q = "SELECT * FROM expensetypes WHERE status = 1";
                        $QR = mysqli_query($con, $Q);
                        while ($Row = mysqli_fetch_assoc($QR)) {
                          echo "<tr class='h5'><th>" . $Row['type'] . "</th><td><span class='badge badge-dark p-2 w-100'>" . totalExpenses($con, $Row['id']) . "</td></tr>";
                        }

                        ?>
                        <tr class="h5">
                          <th>Current Month</td>
                          <td><span class="badge badge-dark p-2 w-100"><?= totalExpenses($con, null, 07, 2024); ?></span></td>
                        </tr>
                        <tr class="h5">
                          <th>Current Year</td>
                          <td><span class="badge badge-dark p-2 w-100"><?= totalExpenses($con, null, null, 2024); ?></span></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="card-footer text-center clearfix">
                    <!-- <i class="ion ion-person-add"></i> -->
                    <a href="reportEnrolled.php" class="btn">More info <i class="fas fa-arrow-circle-right"></i></a>
                  </div>
                </div>
              </div>

            </div>
          </div>
          <!-- /.end row small box -->

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
          labels: ['JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'],
          datasets: [{
            backgroundColor: '#007bff',
            borderColor: '#007bff',
            data: [1000, 2000, 3000, 2500, 2700, 2500, 3000]
          }, {
            backgroundColor: '#ced4da',
            borderColor: '#ced4da',
            data: [700, 1700, 2700, 2000, 1800, 1500, 2000]
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
            display: false
          },
          scales: {
            yAxes: [{
              gridLines: {
                display: true,
                lineWidth: '4px',
                color: 'rgba(0, 0, 0, .2)',
                zeroLineColor: 'transparent'
              },
              ticks: $.extend({
                beginAtZero: true,
                callback: function(value) {
                  if (value >= 1000) {
                    value /= 1000
                    value += 'k'
                  }
                  return '$' + value
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