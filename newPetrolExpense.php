<?php session_start();
$pageTitle = "Add Petrol Expense";
require_once('connection.php');
require_once('sessionSet.php');
require_once('Functions.php');

$userID = $_SESSION['loginUserID'];
$User = userByID($userID);
$userSchoolID = $User->idschool;
?>
<!DOCTYPE html>
<html>
<head>
    <?php include('Head.php'); ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include('topNav.php') ?>
        <?php include('sidebar.php') ?>
        
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6"><h1 class="m-0 text-dark">Add Petrol Expense</h1></div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-primary">
                                <div class="card-header"><h3 class="card-title">Petrol / Diesel Expense Form</h3></div>
                                <div class="card-body">
                                <?php
                                if (isset($_POST['submit_petrol'])) {
                                    // Logic from newPetrolExpenseRSP.php / addPetrolExpenseRSP.php
                                    $Date = CleanData($_POST['date']);
                                    $Type = CleanData($_POST['type']);
                                    $slipNo = CleanData($_POST['slipno']);
                                    $Quantity = CleanData($_POST['quantity']);
                                    $salePrice = CleanData($_POST['saleprice']);
                                    $Amount = CleanData($_POST['amount']);
                                    $Description = CleanData($_POST['description']);
                                    $schoolID = CleanData($_POST['schoolid']);

                                    // Calling the secured function in Functions.php
                                    if (newPetrolExpense($Type, $slipNo, $Quantity, $salePrice, $Amount, $Date, $Description, $schoolID, $userID)) {
                                        echo "<div class='alert alert-success'>Petrol expense added successfully.</div>";
                                    } else {
                                        echo "<div class='alert alert-danger'>Error adding petrol expense: " . mysqli_error($con) . "</div>";
                                    }
                                    echo "<script>setTimeout(function(){ window.location.href='newPetrolExpense.php'; }, 2000);</script>";

                                } else {
                                    ?>
                                    <form role="form" method="post" action="newPetrolExpense.php">
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label>Date</label>
                                                <input type="date" class="form-control" name="date" value="<?php echo date('Y-m-d'); ?>" required autofocus>
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
                                            <div class="form-group col-md-6">
                                                <label>Fuel Type</label>
                                                <select class="form-control" name="type" required>
                                                    <option value="Petrol">Petrol</option>
                                                    <option value="Diesel">Diesel</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Slip No</label>
                                                <input type="text" class="form-control" name="slipno" placeholder="Enter Slip #">
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label>Quantity (Liters)</label>
                                                <input type="number" step="0.01" class="form-control" name="quantity" id="fuel_qty" onkeyup="calcAmount()">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label>Sale Price (per Liter)</label>
                                                <input type="number" step="0.01" class="form-control" name="saleprice" id="fuel_price" onkeyup="calcAmount()">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label>Total Amount</label>
                                                <input type="number" step="0.01" class="form-control" name="amount" id="fuel_amount" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Description</label>
                                            <input type="text" class="form-control" name="description" placeholder="Optional details...">
                                        </div>

                                        <button type="submit" name="submit_petrol" class="btn btn-primary">Save Petrol Expense</button>
                                    </form>

                                    <script>
                                    function calcAmount() {
                                        var qty = document.getElementById('fuel_qty').value;
                                        var price = document.getElementById('fuel_price').value;
                                        if (qty && price) {
                                            document.getElementById('fuel_amount').value = (qty * price).toFixed(2);
                                        }
                                    }
                                    </script>
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