<?php session_start();
$pageTitle = "Multiple Admissions Management";
require_once('connection.php');
require_once('sessionSet.php');
require_once('Functions.php');

// Ensure we are using the merged database
mysqli_select_db($con, 'ds_ctpfsd_merged');

// Query to find students with more than 1 admission
$query = "SELECT s.id, s.fullname, s.cnic, s.phone, COUNT(a.id) as total_admissions 
          FROM students s
          JOIN admissions a ON s.id = a.idstudent
          GROUP BY s.id, s.fullname, s.cnic, s.phone
          HAVING COUNT(a.id) > 1
          ORDER BY total_admissions DESC";

$result = $con->query($query);
?>
<!DOCTYPE html>
<html>
<?php include('Head.php'); ?>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include('topNav.php') ?>
        <?php include('sidebar.php') ?>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">Students with Multiple Admissions</h1>
                            <p class="text-muted">These students were merged during the database consolidation and have historical records from both systems.</p>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Analysis Table (Total: <?php echo $result->num_rows; ?> Students)</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped" id="duplicateTable">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;"></th>
                                        <th>ID</th>
                                        <th>Full Name</th>
                                        <th>CNIC</th>
                                        <th>Phone</th>
                                        <th>Admissions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while($row = $result->fetch_assoc()): ?>
                                    <tr class="student-row" data-id="<?php echo $row['id']; ?>">
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-outline-primary toggle-details">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </td>
                                        <td><?php echo $row['id']; ?></td>
                                        <td><?php echo $row['fullname']; ?></td>
                                        <td><?php echo $row['cnic']; ?></td>
                                        <td><?php echo $row['phone']; ?></td>
                                        <td>
                                            <span class="badge badge-warning" style="font-size: 0.9rem;">
                                                <?php echo $row['total_admissions']; ?> Records
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="details-row d-none" id="details-<?php echo $row['id']; ?>">
                                        <td colspan="6" class="p-3 bg-light">
                                            <div class="admission-details-container text-center">
                                                <i class="fas fa-spinner fa-spin"></i> Loading admission history...
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <?php include('footer.php') ?>
    </div>

    <?php include('footerPlugins.php') ?>
    <script>
        $(document).ready(function() {
            var table = $('#duplicateTable').DataTable({
                "responsive": true,
                "autoWidth": false,
                "order": [[5, "desc"]]
            });

            $('.toggle-details').on('click', function() {
                var btn = $(this);
                var parentRow = btn.closest('tr');
                var studentId = parentRow.data('id');
                var detailsRow = $('#details-' + studentId);
                var container = detailsRow.find('.admission-details-container');

                if (detailsRow.hasClass('d-none')) {
                    // Expand
                    detailsRow.removeClass('d-none');
                    btn.html('<i class="fas fa-minus"></i>').removeClass('btn-outline-primary').addClass('btn-outline-danger');
                    
                    // Load data if not already loaded
                    if (container.find('table').length === 0) {
                        $.get('fetch_admissions.php', { student_id: studentId }, function(data) {
                            container.html(data);
                        });
                    }
                } else {
                    // Collapse
                    detailsRow.addClass('d-none');
                    btn.html('<i class="fas fa-plus"></i>').removeClass('btn-outline-danger').addClass('btn-outline-primary');
                }
            });
        });
    </script>
</body>
</html>
