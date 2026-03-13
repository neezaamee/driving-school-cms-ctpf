<?php session_start();
$pageTitle = "Active Students";
require_once('connection.php');
require_once('sessionSet.php');
require_once('Functions.php');
?>
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
<!--/ PHP Code: Token Entry -->
<!DOCTYPE html>
<html>
<!--Head-->
<?php include('Head.php') ?>
<!--/Head-->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-3.3.1/jszip-2.5.0/dt-1.10.21/af-2.3.5/b-1.6.3/b-colvis-1.6.3/b-flash-1.6.3/b-html5-1.6.3/b-print-1.6.3/cr-1.5.2/fc-3.3.1/fh-3.1.7/kt-2.5.2/r-2.2.5/rg-1.1.2/rr-1.2.7/sc-2.0.2/sp-1.1.1/sl-1.3.1/datatables.min.css" />
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.3.1/jszip-2.5.0/dt-1.10.21/af-2.3.5/b-1.6.3/b-colvis-1.6.3/b-flash-1.6.3/b-html5-1.6.3/b-print-1.6.3/cr-1.5.2/fc-3.3.1/fh-3.1.7/kt-2.5.2/r-2.2.5/rg-1.1.2/rr-1.2.7/sc-2.0.2/sp-1.1.1/sl-1.3.1/datatables.min.js"></script>
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
    $('#myTable2').DataTable({
      "processing": true,
      "serverSide": true,
      "ajax": {
        "url": "fetch_active_students.php",
        "type": "POST",
        "data": function(d) {
          d.PHPSESSID = "<?php echo session_id(); ?>";
        }
      },
      "columnDefs": [
        { "orderable": false, "targets": [16, 17] } // Photo and Action columns not orderable
      ],
      "responsive": true,
      "dom": 'Bfrtip',
      "buttons": [{
        extend: 'print',
        exportOptions: {
          stripHtml: false,
          columns: ':visible'
        }
      }]
    });

    // Handle delete modal URL
    $('#confirm-delete').on('show.bs.modal', function(e) {
      $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
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
      <?php
      $User = userByID($_SESSION['loginUserID']);
      $userSchoolID = $User->idschool;
      ?>
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Active Students</h1>
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
                  <h3 class="card-title"><?php echo "Active Students"; ?></h3>
                </div>
                <!-- /.card-header -->
                <!-- Questions Div -->
                <div class="card-body">
                  <div class="tab-content" id="custom-tabs-one-tabContent">
                    <div class="tab-pane fade active show" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="">
                      <div class="col-lg-12 col-md-12 col-sm-12">
                        <!-- /.card -->
                        <div class="card-body" style="overflow-x:auto;">
                          <table id="myTable2" class="display text-center" style="text-align: center;">
                            <thead class="text-center">
                              <tr>
                                <th width="05%">#</th>
                                <?php if (isAdmin()) { ?><th>School</th><?php } ?>
                                <th>Registration</th>
                                <th>Admission Date</th>
                                <th>Name</th>
                                <th>Gender</th>
                                <th>Guardian</th>
                                <th>DOB</th>
                                <th>CNIC</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Course</th>
                                <th>Discount</th>
                                <th>Fee Collected</th>
                                <th>Paid Date</th>
                                <th>Pick n Drop</th>
                                <th>Photo</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                               <?php
                               // Table body is now populated via AJAX (fetch_active_students.php)
                               ?>
                            </tbody>
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
                <!-- /.card-body -->
              </div>
              <!-- /.card-primary -->
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
    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-danger">
            <h4 class="modal-title"><i class="fas fa-exclamation-triangle"></i> Confirm Delete</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            Are you sure you want to delete this student admission record? This action cannot be undone.
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <a class="btn btn-danger btn-ok">Confirm Delete</a>
          </div>
        </div>
      </div>
    </div>
    <!--/validation-->
    <!--Footer Content-->
    <?php include 'footer.php'; ?>
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