<?php session_start();
require_once('connection.php');
require_once('sessionSet.php');
require_once('Functions.php');
?>
<?php
if (isset($_POST['submit'])) {
  //$Month = CleanData($_POST['month']);
  //$Month1 = date("F", mktime(0, 0, 0, $Month, 10));
  $firstDate = CleanData($_POST['firstdate']);
  $secondDate = CleanData($_POST['seconddate']);
} ?>
<!-- Only Admin Can View This Page-->
<?php
if (isDEO()) {
?>
  <script>
    setTimeout(function() {
      alert("you are not authorized to view this page");
      window.location.href = 'index.php';
    });
  </script>
<?php
}
?>
<!-- Only Admin Can View This Page-->
<!--/ PHP Code: Token Entery -->
<!DOCTYPE html>
<html>
<!--Head-->
<?php include('Head.php') ?>
<!--/Head-->

<head>
  <title>Student Report</title>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" />
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css" />
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
  <style>
    @media print {
      * {
        text-align: center;
      }

      img {
        display: block;
      }

      @page {
        size: landscape;
      }
    }
  </style>

</head>
<script>
  $(document).ready(function() {
    $('#myTable').DataTable({
      responsive: true, // Updated to the latest syntax
      dom: 'Bfrtip',
      buttons: [{
        extend: 'print',
        exportOptions: {
          stripHtml: false,
          columns: ':visible'
        }
        // Uncomment and customize if needed
        // customize: function(win) {
        //     $(win.document.body)
        //         .css('font-size', '10pt')
        //         .prepend(
        //             '<img src="http://datatables.net/media/images/logo-fade.png" style="position:absolute; top:0; left:0;" />'
        //         );
        //     $(win.document.body).find('table')
        //         .addClass('compact')
        //         .css('font-size', 'inherit');
        // }
      }]
    });
  });
  $(document).ready(function() {
    $('#myTable2').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: 'fetch_data.php', // Update this to the path of your server-side script
        type: 'POST',
        data: function(d) {
          // Send additional data if needed
          d.firstDate = '<?php echo $totalRecords; ?>';
          d.secondDate = '<?php echo $totalRecords; ?>';
        }
      },
      responsive: true,
      dom: 'Bfrtip',
      buttons: [{
        extend: 'print',
        exportOptions: {
          stripHtml: false,
          columns: ':visible'
        }
      }]
    });
  });
</script>

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
              <h1 class="m-0 text-dark">Student Report</h1>
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
            <div class="col-12">
              <!-- general form elements -->
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title"><?php echo "Student Report"; ?></h3>
                </div>
                <!-- /.card-header -->
                <!-- Questions Div -->
                <div class="card-body">
                  <div class="tab-content" id="custom-tabs-one-tabContent">
                    <div class="tab-pane fade active show" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="View All Questions">
                      <div class="col-lg-12 col-md-12 col-sm-12">
                        <!-- /.card-body -->
                        <!-- /.card -->
                        <div class="card-body" style="overflow-x:auto;">
                          <table id="myTable2" class="display" style="text-align: center;" class="text-center">
                            <thead class="text-center">
                              <tr>
                                <th>Serial</th>
                                <th>Student</th>
                              </tr>
                            </thead>

                            <tfoot>

                            </tfoot>
                          </table>
                        </div>
                        <!-- /.card-body -->
                      </div>
                    </div>
                    <!--/tab-pane-->
                  </div>
                  <!--/tab-content-->
                </div>
                <!-- /.card -->
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
    <!--custome validation-->
    <!--/validation-->
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
  <?php include 'footerPlugins.php'; ?>
</body>
<!--/Body-->

</html>