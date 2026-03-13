<?php session_start();
require_once('connection.php');
require_once('sessionSet.php');
require_once('Functions.php');

$userID = $_SESSION['loginUserID'];
$User = userByID($userID);
$userSchoolID = $User->idschool;

$message = "";
$messageType = "";

// Handle Update (POST)
if (isset($_POST['submit_update'])) {
    $expenseID = CleanData($_POST['expenseid']);
    $expenseType = CleanData($_POST['type']);
    $schoolID = CleanData($_POST['school']);
    $Date = CleanData($_POST['date']);
    $Amount = CleanData($_POST['amount']);
    $Description = CleanData($_POST['description']);

    $sql = "UPDATE expenses SET idschool=?, date=?, amount=?, description=?, idexpensetype=? WHERE id=?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "isisii", $schoolID, $Date, $Amount, $Description, $expenseType, $expenseID);
    
    if (mysqli_stmt_execute($stmt)) {
        $message = "Expense updated successfully!";
        $messageType = "success";
    } else {
        $message = "Error updating expense: " . mysqli_error($con);
        $messageType = "danger";
    }
    mysqli_stmt_close($stmt);
}

// Fetch Details (GET or after POST)
$expenseID = $_GET['expenseID'] ?? $_POST['expenseid'] ?? null;
if (!$expenseID) {
    header("Location: tableExpenses.php");
    exit();
}

$Expense = expenseByID($expenseID);
if (!$Expense) {
    echo "Expense not found.";
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <?php include('Head.php'); ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include('topNav.php'); ?>
        <?php include('sidebar.php'); ?>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2"><div class="col-sm-6"><h1 class="m-0 text-dark">Update Expense</h1></div></div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <?php if ($message): ?>
                        <div class="alert alert-<?php echo $messageType; ?>"><?php echo $message; ?></div>
                        <?php if ($messageType == 'success'): ?>
                            <script>setTimeout(function() { window.location.href = 'tableExpenses.php'; }, 1500);</script>
                        <?php endif; ?>
                    <?php endif; ?>

                    <div class="card card-primary">
                        <div class="card-header"><h3 class="card-title">Expense Details</h3></div>
                        <form role="form" method="post" action="updateExpense.php">
                            <input type="hidden" name="expenseid" value="<?php echo $expenseID; ?>">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>School</label>
                                    <select class="form-control" name="school" <?php echo !isAdmin() ? 'readonly' : ''; ?>>
                                        <?php
                                        $qSchools = isAdmin() ? "SELECT id, location FROM schools" : "SELECT id, location FROM schools WHERE id = $userSchoolID";
                                        $resSchools = mysqli_query($con, $qSchools);
                                        while ($s = mysqli_fetch_assoc($resSchools)) {
                                            $selected = ($s['id'] == $Expense->idschool) ? 'selected' : '';
                                            echo "<option value='{$s['id']}' $selected>{$s['location']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Date</label>
                                    <input type="date" class="form-control" name="date" value="<?php echo $Expense->date; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Expense Type</label>
                                    <select class="form-control" name="type" required>
                                        <?php
                                        $resTypes = mysqli_query($con, "SELECT id, type FROM expensetypes");
                                        while ($t = mysqli_fetch_assoc($resTypes)) {
                                            $selected = ($t['id'] == $Expense->idexpensetype) ? 'selected' : '';
                                            echo "<option value='{$t['id']}' $selected>{$t['type']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Amount</label>
                                    <input type="number" class="form-control" name="amount" value="<?php echo $Expense->amount; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" name="description" rows="3"><?php echo $Expense->description; ?></textarea>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" name="submit_update" class="btn btn-primary">Update Expense</button>
                                <a href="tableExpenses.php" class="btn btn-default">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
        <?php include('footer.php'); ?>
    </div>
    <?php include('footerPlugins.php'); ?>
</body>
</html>
