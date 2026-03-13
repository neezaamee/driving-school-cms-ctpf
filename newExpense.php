<?php session_start();
$pageTitle = "Add New Expense";
require_once 'connection.php';
require_once 'sessionSet.php';
require_once 'Functions.php';

$userID = $_SESSION['loginUserID'];
$User = userByID($userID);
$userSchoolID = $User->idschool;
?>
<!DOCTYPE html>
<html>
<head>
    <?php include 'Head.php'; ?>
    <script>
      function toggleExpenseFields() {
        var category = document.getElementById("expensetype").value;
        var empName = document.getElementById("empCol");
        var vehicleCol = document.getElementById("vehicleCol");
        var petrolQuantityCol = document.getElementById("petrolQuantityCol");
        var amountCol = document.getElementById("amountCol");
        var descriptionCol = document.getElementById("descriptionCol");

        // RESET
        empName.style.display = "none";
        vehicleCol.style.display = "none";
        petrolQuantityCol.style.display = "none";

        if (category == "1") { // Petrol
          vehicleCol.style.display = "block";
          petrolQuantityCol.style.display = "block";
        } else if (category == "2" || category == "4") { // Maintenance or Repair
          vehicleCol.style.display = "block";
        } else if (category == "3") { // Salary
          empName.style.display = "block";
        }
      }

      function togglePaymentFields() {
        var paymentMethod = document.getElementById("paymentmethod").value;
        var checkNoCol = document.getElementById("checkNoCol");
        var checkIssueCol = document.getElementById("checkIssueCol");

        if (paymentMethod == "1") {
          checkNoCol.style.display = "none";
          checkIssueCol.style.display = "none";
        } else {
          checkNoCol.style.display = "block";
          checkIssueCol.style.display = "block";
        }
      }

      window.onload = function() {
        toggleExpenseFields();
        togglePaymentFields();
      };
    </script>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php include('topNav.php') ?>
    <?php include('sidebar.php') ?>
    
    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6"><h1 class="m-0 text-dark">Add New Expense</h1></div>
          </div>
        </div>
      </div>

      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card card-primary">
                <div class="card-header"><h3 class="card-title">Add New Expense</h3></div>
                <div class="card-body">
                <?php
                if (isset($_POST['submit_expense'])) {
                    // Logic from newExpenseRSP.php
                    $Date = CleanData($_POST['date']);
                    $idexpensetype = CleanData($_POST['expensetype']);
                    $idvehicle = isset($_POST['vehicleno']) ? CleanData($_POST['vehicleno']) : null;
                    $petrol_quantity = isset($_POST['petrolquantity']) ? CleanData($_POST['petrolquantity']) : null;
                    $idstaff = isset($_POST['empname']) ? CleanData($_POST['empname']) : null;
                    $amount = CleanData($_POST['amount']);
                    $description = CleanData($_POST['description']);
                    $payment_method = CleanData($_POST['paymentmethod']);
                    $check_no = isset($_POST['checkno']) ? CleanData($_POST['checkno']) : null;
                    $issue_to = isset($_POST['checkissueto']) ? CleanData($_POST['checkissueto']) : null;
                    $schoolID = CleanData($_POST['schoolid']);

                    $data = [
                        'idexpensetype' => $idexpensetype,
                        'amount' => $amount,
                        'description' => $description,
                        'payment_method' => $payment_method,
                        'idschool' => $schoolID,
                        'idusers' => $userID,
                        'date' => $Date,
                        'status' => 'active'
                    ];

                    if ($idvehicle) $data['idvehicle'] = $idvehicle;
                    if ($petrol_quantity) $data['petrol_quantity'] = $petrol_quantity;
                    if ($idstaff) $data['idstaff'] = $idstaff;
                    if ($check_no) $data['check_no'] = $check_no;
                    if ($issue_to) $data['issue_to'] = $issue_to;

                    if (insertData('expenses', $data)) {
                        echo "<div class='alert alert-success'>Expense added successfully.</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Error adding expense: " . mysqli_error($con) . "</div>";
                    }
                    echo "<script>setTimeout(function(){ window.location.href='newExpense.php'; }, 2000);</script>";

                } else {
                    ?>
                    <form role="form" method="post" action="newExpense.php">
                      <div class="form-row">
                        <div class="form-group col-md-3">
                          <label>Date</label>
                          <input type="date" class="form-control" name="date" value="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                        <?php if (isAdmin()) { ?>
                        <div class="form-group col-md-3">
                          <label>School</label>
                          <select class="form-control" name="schoolid">
                            <?php
                            $schools = mysqli_query($con, "SELECT * FROM schools WHERE id != 1");
                            while($s = mysqli_fetch_array($schools)) {
                                echo "<option value='{$s['id']}'>{$s['location']}</option>";
                            }
                            ?>
                          </select>
                        </div>
                        <?php } else { ?>
                        <input type="hidden" name="schoolid" value="<?php echo $userSchoolID; ?>">
                        <?php } ?>
                      </div>

                      <div class="form-row">
                        <div class="form-group col-md-12">
                          <label>Expense Type</label>
                          <select class="form-control" id="expensetype" name="expensetype" onchange="toggleExpenseFields();" required>
                            <?php echo expenseTypeList(); ?>
                          </select>
                        </div>
                      </div>

                      <div class="form-row">
                        <div class="form-group col-md-6" id="empCol">
                          <label>Employee Name</label>
                          <select class="form-control" name="empname">
                             <option value="">Select Employee</option>
                             <?php echo staffList(null, "WHERE idtypestaff != 1 AND idschool = '$userSchoolID'"); ?>
                          </select>
                        </div>
                        <div class="form-group col-md-6" id="vehicleCol">
                          <label>Vehicle No</label>
                          <select class="form-control" name="vehicleno">
                             <option value="">Select Vehicle</option>
                             <?php echo vehicleList(null, "WHERE status = 1 AND idschool = '$userSchoolID'"); ?>
                          </select>
                        </div>
                        <div class="form-group col-md-6" id="petrolQuantityCol">
                          <label>Petrol Quantity (Liters)</label>
                          <input type="number" step="0.01" class="form-control" name="petrolquantity">
                        </div>
                      </div>

                      <div class="form-group">
                        <label>Amount</label>
                        <input type="number" class="form-control" name="amount" required>
                      </div>

                      <div class="form-group">
                        <label>Description</label>
                        <input type="text" class="form-control" name="description">
                      </div>

                      <div class="form-row">
                        <div class="form-group col-md-4">
                          <label>Payment Method</label>
                          <select class="form-control" id="paymentmethod" name="paymentmethod" onchange="togglePaymentFields();">
                            <option value="1">Cash</option>
                            <option value="2">Cheque</option>
                          </select>
                        </div>
                        <div class="form-group col-md-4" id="checkNoCol">
                          <label>Cheque #</label>
                          <input type="text" class="form-control" name="checkno">
                        </div>
                        <div class="form-group col-md-4" id="checkIssueCol">
                          <label>Cheque Issued To</label>
                          <input type="text" class="form-control" name="checkissueto">
                        </div>
                      </div>

                      <button type="submit" name="submit_expense" class="btn btn-primary">Submit Expense</button>
                    </form>
                    <?php
                }
                ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    <?php include('footer.php') ?>
  </div>
  <?php include('footerPlugins.php') ?>
</body>
</html>
