<?php session_start();
require_once('connection.php');
require_once('sessionSet.php');
require_once('Functions.php');

// AJAX Handler
if (isset($_GET['registration_number'])) {
    header('Content-Type: application/json');
    $registration_number = CleanData($_GET['registration_number']);
    
    if (!empty($registration_number)) {
        $stmt = $con->prepare("SELECT id, fullname, fathername, cnic FROM students WHERE cnic = ? ORDER BY id DESC LIMIT 1");
        $stmt->bind_param("s", $registration_number);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $student = $result->fetch_assoc();
            $idstudent = $student['id'];

            $stmt2 = $con->prepare("SELECT registration FROM admissions WHERE idstudent = ?");
            $stmt2->bind_param("i", $idstudent);
            $stmt2->execute();
            $result2 = $stmt2->get_result();

            if ($result2->num_rows > 0) {
                $studentDetails = $result2->fetch_assoc();
                $student = array_merge($student, $studentDetails);
                echo json_encode(['success' => true, 'data' => $student]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Admission details not found']);
            }
            $stmt2->close();
        } else {
            echo json_encode(['success' => false, 'message' => 'Student not found']);
        }
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid CNIC']);
    }
    exit();
}

if (isDEO()) {
    echo "<script>alert('You are not authorized to view this page'); window.location.href = 'index.php';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <?php include('Head.php'); ?>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-3.3.1/jszip-2.5.0/dt-1.10.21/af-2.3.5/b-1.6.3/b-colvis-1.6.3/b-flash-1.6.3/b-html5-1.6.3/b-print-1.6.3/cr-1.5.2/fc-3.3.1/fh-3.1.7/kt-2.5.2/r-2.2.5/rg-1.1.2/rr-1.2.7/sc-2.0.2/sp-1.1.1/sl-1.3.1/datatables.min.css" />
    <style>
        @media print {
            .no-print { display: none !important; }
            .print-only { display: block !important; }
            @page { size: landscape; margin: 10px; }
            body { font-size: 10px; }
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <div class="no-print">
            <?php include('topNav.php'); ?>
            <?php include('sidebar.php'); ?>
        </div>

        <div class="content-wrapper">
            <div class="content-header no-print">
                <div class="container-fluid">
                    <div class="row mb-2"><div class="col-sm-6"><h1 class="m-0 text-dark">License Test Sheet</h1></div></div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="card card-primary no-print">
                        <div class="card-header"><h3 class="card-title">Sheet Generator</h3></div>
                        <div class="card-body">
                            <div class="form-row align-items-end">
                                <div class="form-group col-md-4 mb-0">
                                    <label>Student CNIC</label>
                                    <input type="text" id="regNumber" class="form-control" placeholder="Enter Student CNIC" autofocus>
                                </div>
                                <div class="form-group col-md-4 mb-0">
                                    <button id="addStudentBtn" class="btn btn-primary">Add to Sheet</button>
                                    <button onclick="window.print()" class="btn btn-success">Print Sheet</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="testSheet" class="card card-outline card-info">
                        <div class="card-header"><h3 class="card-title">Daily License Test Sheet - <?php echo date('d-m-Y'); ?></h3></div>
                        <div class="card-body p-0">
                            <table id="studentTable" class="table table-bordered table-striped table-sm text-center">
                                <thead class="bg-dark">
                                    <tr>
                                        <th>Reg #</th>
                                        <th>Full Name</th>
                                        <th>Father/Guardian</th>
                                        <th>CNIC</th>
                                        <th>Photo</th>
                                        <th class="no-print">Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="no-print"><?php include('footer.php'); ?></div>
    </div>
    <?php include('footerPlugins.php'); ?>
    <script>
        $(document).ready(function() {
            $('#addStudentBtn').click(function() {
                var regNumber = $('#regNumber').val();
                if (regNumber) {
                    $.ajax({
                        url: 'licenseTestSheet.php',
                        method: 'GET',
                        data: { registration_number: regNumber },
                        success: function(response) {
                            if (response.success) {
                                var student = response.data;
                                var photoPath = 'StudentImages/' + student.cnic + '.JPG';
                                var newRow = `<tr>
                                    <td>${student.registration}</td>
                                    <td>${student.fullname}</td>
                                    <td>${student.fathername}</td>
                                    <td>${student.cnic}</td>
                                    <td><img src="${photoPath}" width="80" height="80" onerror="this.src='dist/img/avatar5.png'"></td>
                                    <td class="no-print"><button class="btn btn-danger btn-xs removeStudentBtn">Remove</button></td>
                                </tr>`;
                                $('#studentTable tbody').append(newRow);
                                $('#regNumber').val('').focus();
                            } else {
                                alert(response.message);
                            }
                        }
                    });
                }
            });

            $('#studentTable').on('click', '.removeStudentBtn', function() {
                $(this).closest('tr').remove();
            });

            $('#regNumber').keypress(function(e) {
                if(e.which == 13) $('#addStudentBtn').click();
            });
        });
    </script>
</body>
</html>
