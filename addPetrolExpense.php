<?php session_start();
require_once('connection.php');
require_once('sessionSet.php');
require_once('Functions.php');
?>
<!DOCTYPE html>
<html>
<!--Head-->
<?php include('Head.php'); ?>
<!--/Head-->
<?php
    $userName = $_SESSION['loginUsername'];
$userID = $_SESSION['loginUserID'];

$User = userByID($userID);
$userSchoolID = $User->idschool;    

$School = schoolByID($userSchoolID);
$schoolName = $School->location;
    
    
    ?>
<script>
    /*function showUser(str) {
        if (str == "") {
            document.getElementById("cnictext").innerHTML = "";
            return;
        } else {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("cnictext").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET", "userFailed.php?q=" + str, true);
            xmlhttp.send();
        }
    }*/

</script>
<!--Body-->

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <?php include('topNav.php') ?>
        <!-- /.navbar -->
        <!-- Main Sidebar Container -->
        <?php include ('sidebar.php')?>
        <!--/ Main Sidebar Container-->
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">New Expense</h1>
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
                                    <h3 class="card-title">Expense Form</h3>
                                </div>
                                <!-- /.card-header -->
                                <!--fetch last token-->
                                <?php
                                                                
                                    $todayDate= date("Y-m-d");
                                                               
                                ?>
                                <!-- form start -->
                                <form role="form" method="post" action="addPetrolExpenseRSP.php" id="newAdmissionForm">
                                    <div class="card-body">
                                        <div class="form-row justify-content-between">
                                            <div class="form-group col-md-2">
                                                <label for="date">Date</label>
                                                <input type="date" class="form-control" id="date" name="date" placeholder="current date" autofocus>
                                                <!--input type="text" class="form-control" id="date" name="date" placeholder="current date" value="<?php //echo $todayDate; ?>"-->
                                            </div>
                                        </div>
                                        <?php
                                        if(isAdmin()){
                                            ?>
                                        <div class="form-row">
                                            <div class="form-group col">
                                                <label for="InputRole">School</label>
                                                <select class="form-control" id="school" name="schoolid">
                                                    <?php
                                                    $Q2 = "SELECT * FROM schools WHERE id != 1";
                                                    $QR2 = mysqli_query($con,$Q2);
                                                     while($data = mysqli_fetch_array($QR2))
                                                        {
                                                            echo "<option value='". $data['id'] ."'>" .$data['location'] ."</option>";
                                                        }	
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <?php
                                        }
                                        else{
                                            ?>
                                        <input type="text" class="form-control" id="serialid" name="schoolid" value="<?php echo $userSchoolID; ?>" hidden>
                                        <?php
                                            
                                        }
                                        ?>
                                        <div class="form-row">
                                            <div class="form-group col">
                                                <label for="type">Type</label>
                                                <select class="form-control" id="type" name="type" required>
                                                    <option value="Petrol">Petrol</option>
                                                    <option value="Diesel">Diesel</option>                                                    
                                                </select>
                                                <div class="invalid-feedback"> Please choose correct value </div>
                                                <div class="valid-feedback"> Looks good! </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col">
                                                <label for="amount">Slip No</label>
                                                <input type="number" class="form-control" id="slipno" placeholder="Slip No" name="slipno">
                                                <small id="cnictext" class="text-muted" style="color: red !important">

                                                </small>
                                            </div>
                                        </div>                                        
                                        <div class="form-row">
                                            <div class="form-group col">
                                                <label for="amount">Quantity</label>
                                                <input type="number" class="form-control" id="quantity" placeholder="Quantity" name="quantity">
                                                <small id="cnictext" class="text-muted" style="color: red !important">

                                                </small>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col">
                                                <label for="amount">Sale Price</label>
                                                <input type="number" class="form-control" id="saleprice" placeholder="Sale Price" name="saleprice">
                                                <small id="cnictext" class="text-muted" style="color: red !important">

                                                </small>
                                            </div>
                                        </div>
                                        
                                        <div class="form-row">
                                            <div class="form-group col">
                                                <label for="amount">Amount</label>
                                                <input type="number" class="form-control" id="amount" placeholder="Expense Amount" name="amount" onkeyup="showUser(this.value);" autofocus>
                                                <small id="cnictext" class="text-muted" style="color: red !important">

                                                </small>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col">
                                                <label for="Description">Description</label>
                                                <input type="text" class="form-control" id="description" placeholder="Expense Description" name="description">
                                                <div class="invalid-feedback"> Please Enter Candidate Name </div>
                                                <div class="valid-feedback"> Looks good! </div>
                                            </div>

                                        </div>

                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <button type="submit" id="submit" class="btn btn-primary" name="submit">Submit</button>
                                    </div>
                                    <!--/.card-footer-->
                                </form>
                                <!-- form ends -->
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
        <?php include ('footer.php')?>
        <!--/Footer Content-->
        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    <?php include ('footerPlugins.php')?>
    <script>
        /* $(document).ready(function() {
            $("#tokenBtn").click(function() {
                $("#InputToken").val("1");
            });
        });*/

    </script>
    <script>
        /*function checkCommercial() {
            var text;
            var category = document.getElementById("licensecategory").value;
            switch (category) {
                case "M/Cycle":
                    text = 'non commercial';
                    break;
                case "Car":
                    text = 'non commercial';
                    break;
                case "M/Cycle+Car":
                    text = 'non commercial';
                    break;
                case "Tractor Agriculture":
                    text = 'non commercial';
                    break;
                case "M/Cycle+Car+Tractor Agriculture":
                    text = 'non commercial';
                    break;
                case "Tractor Commercial":
                    text = 'commercial';
                    break;
                case "LTV":
                    text = 'commercial';
                    break;
                case "M/Cycle+LTV":
                    text = 'commercial';
                    break;
                case "M/Cycle+LTV+Tractor Commercial":
                    text = 'commercial';
                    break;
                case "HTV":
                    text = 'commercial';
                    break;
                case "HTV(Psv)":
                    text = 'commercial';
                    break;
                case "LTV(Psv)":
                    text = 'commercial';
                    break;
                case "Rikshaw":
                    text = 'commercial';
                    break;
                case "M/Cycle+Rikshaw":
                    text = 'commercial';
                    break;
                case "Invalid Carriage":
                    text = 'non commercial';
                    break;
                default:
                    text = "I have never heard of that fruit...";
            }
            document.getElementById("candidateiscommercial").value = text;
        }
*/

    </script>
    <script>
        /*   function specialCase() {
            var specialcase = document.getElementById("specialcase").value;
            var lpcby = document.getElementById("lpcbycheck");
            switch (specialcase) {
                case "Normal":
                    lpcby.hidden = true;
                    break;
                case "Renewal":
                    lpcby.hidden = true;
                    break;
                case "LPC":
                    lpcby.hidden = false;
                    break;
                case "Absent":
                    lpcby.hidden = true;
                    break;
                default:
                    text = "I have never heard of that fruit...";
            }
        }
*/

    </script>
    <script>
        /*   function daysCalc(date) {
            var lpDate = date;
            var date2 = new Date();
            var btn = document.getElementById('submit');
            var txt = document.getElementById('lpdatehelpblock');

            var LearnerIssueDate = Date.parse(lpDate);
            var todayDate = Date.parse(date2);

            var timeDiff = todayDate - LearnerIssueDate;
            var Today = new Date();
            Today.setMonth(Today.getMonth() - 6);

            var daysDiff = Math.floor(timeDiff / (1000 * 60 * 60 * 24));
            if (daysDiff > 42 && LearnerIssueDate > Today) {
                txt.innerHTML = "OK";
                btn.disabled = false;
            } else if (LearnerIssueDate < Today) {
                txt.innerHTML = "Learner Expired";
                btn.disabled = true;
            } else {
                txt.innerHTML = "Select 42 Days Old Date";
                btn.disabled = true;
                console.log(todayDate - 1);
            }
        }
*/
        /* function enableSubmit(option) {
 var btn = document.getElementById('submit');
 var option1 = option;
 switch (option1) {
 case "Normal":
 btn.disabled = true;
 break;
 case "Renewal":
 btn.disabled = false;
 break;
 case "LPC":
 btn.disabled = false;
 break;
 case "Absent":
 btn.disabled = false;
 break;
 default:
 text = "I have never heard of that fruit...";
 }
 }*/

    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#addCandidateForm").validate({
                rules: {
                    candidatecnic: {
                        required: true,
                        number: true,
                        minlength: 13,
                        maxlength: 13
                    },
                    candidatename: {
                        required: true,
                        lettersonly: true,
                        minlength: 3,
                        maxlength: 100
                    },
                    candidatefathername: {
                        required: true,
                        lettersonly: true,
                        minlength: 3,
                        maxlength: 100
                    },
                    candidatephone: {
                        required: true,
                        number: true,
                        minlength: 11,
                        maxlength: 11
                    },
                    candidateaddress: {
                        required: true,
                        minlength: 3,
                        maxlength: 150
                    },
                    candidatelpno: {
                        required: true,
                        number: true,
                        minlength: 3,
                        maxlength: 10
                    },
                    candidatelpdate: {
                        required: true
                    },
                    candidateticketcost: {
                        required: true,
                        minlength: 1,
                        maxlength: 4
                    }
                },
                messages: {
                    fbtype: {},
                    fbsubject: {},
                    fbname: {
                        maxlength: "Maximum Length for Name is 100 Characters.",
                        minlength: "Minimum Length for Name is 3 Characters."
                    },
                    fbcnic: {
                        maxlength: "Maximum Length for Contact is 11 starting with 0.   ",
                        minlength: "Minimum Length for Contact is 10 starting with 0.   "
                    },
                    fbcontact: {},
                    fbemail: {},
                    fbaddress: {},
                    fborganization: {},
                    fbto: {},
                    fbtext: {}
                }
            });
        });

    </script>
    <script>
        $.validator.addMethod("lettersonly", function(value, element) {
            return this.optional(element) || /^[a-z\s]+$/i.test(value);
        }, "Letters only please");

    </script>
</body>
<!--/Body-->

</html>
