<?php session_start();
$pageTitle = "Add New Candidate";
require_once('connection.php');
require_once('sessionSet.php');
require_once('Functions.php');
?>
<!DOCTYPE html>
<html>
<!--Head-->
<?php include('Head.php'); ?>
<!--/Head-->
<script>
    function showUser(str) {
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
    }

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
                            <h1 class="m-0 text-dark">Add New Candidate</h1>
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
                                    <h3 class="card-title">Add Candidate Basic Details</h3>
                                </div>
                                <!-- /.card-header -->
                                <!--fetch last token-->
                                <?php
                                                                
                                                                $todayDate= date("Y-m-d");
    
                                                                $fetchCandidateDataQ = "SELECT * FROM candidates ORDER BY id DESC LIMIT 1";
                                                                $fetchCandidateDataQR = mysqli_query($con,$fetchCandidateDataQ);
                                                                $fetchCandidateDataNum = mysqli_num_rows($fetchCandidateDataQR);
	
	                                                           if($fetchCandidateDataNum>0)
                                                                   {
                                                                      $candidateDataObject = mysqli_fetch_object($fetchCandidateDataQR);

                                                                        $lastToken = $candidateDataObject->token;
                                                                        $lastTokenDate = $candidateDataObject->entrydate;
                                                                        if($lastTokenDate == $todayDate){
                                                                            $Token=$lastToken+1;
                                                                        }
                                                                   else{
                                                                       $Token = 1;
                                                                   }
                                                                   
                                                               }else{
                                                                   $Token = 1;
                                                               } ?>
                                <!-- form start -->
                                <form role="form" method="post" action="printToken.php" id="addCandidateForm">
                                    <div class="card-body">
                                        <div class="form-row justify-content-between">
                                            <div class="form-group col-md-3">
                                                <label for="InputCNIC">Token</label>
                                                <input type="text" class="form-control" id="candidatetoken" name="candidatetoken" value="<?php echo $Token; ?>" readonly>
                                                <!--reset token button is working correctly but temporary hidden for user-->
                                                <!--<button id="tokenBtn" class="form-control btn btn-primary">Reset Token</button>-->
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label for="InputTicketCost">Commercial/Non-Commercial</label>
                                                <input type="text" class="form-control" id="candidateiscommercial" name="candidateiscommercial" readonly required> </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col">
                                                <label for="InputCNIC">CNIC</label>
                                                <input type="number" class="form-control" id="candidatecnic" placeholder="13 Digits without dash" name="candidatecnic" onkeyup="showUser(this.value);" autofocus> <small id="cnictext" class="text-muted" style="color: red !important">

                                                </small> </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="InputFullName">Full Name</label>
                                                <input type="text" class="form-control" id="candidatename" placeholder="Candidate Full Name" name="candidatename">
                                                <div class="invalid-feedback"> Please Enter Candidate Name </div>
                                                <div class="valid-feedback"> Looks good! </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="InputFullName">Father Name</label>
                                                <input type="text" class="form-control" id="candidatefathername" placeholder="Candidate Father Name" name="candidatefathername">
                                                <div class="invalid-feedback"> Please Enter Candidate's Father Name </div>
                                                <div class="valid-feedback"> Looks good! </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="InputPhone">Contact No</label>
                                                <input type="number" class="form-control" id="candidatephone" placeholder="Candidate Phone" name="candidatephone"> </div>
                                            <!--email field is temporary hidden-->
                                            <!--<div class="form-group col-md-4">
                                                <label for="InputPassword">Email</label>
                                                <input type="email" class="form-control" id="InputEmail" placeholder="Candidate Email" name="candidateemail">
                                                <div class="invalid-feedback"> Please enter a valid Email Address </div>
                                                <div class="valid-feedback"> Looks good! </div>
                                            </div>-->
                                        </div>
                                        <div class="form-row">
                                            <!--blood group field is hidden temporary-->
                                            <!--<div class="form-group col-md-6">
                                                <label for="InputBlood">Blood Group</label>
                                                <select class="form-control" id="InputBlood" name="candidatebloodgroup" required>
                                                    <option value="A+">A+</option>
                                                    <option value="AB+">AB+</option>
                                                    <option value="B+">B+</option>
                                                    <option value="O+">O+</option>
                                                    <option value="A-">A-</option>
                                                    <option value="AB-">AB-</option>
                                                    <option value="B-">B-</option>
                                                    <option value="O-">O-</option>
                                                </select>
                                                <div class="invalid-feedback"> Please choose blood group </div>
                                                <div class="valid-feedback"> Looks good! </div>
                                            </div>-->
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col">
                                                <label for="InputPassword">Address</label>
                                                <input type="text" class="form-control" id="candidateaddress" placeholder="Candidate Address" name="candidateaddress" required> </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-2">
                                                <label for="InputPassword">Learner Permit No.</label>
                                                <input type="text" class="form-control" id="candidatelpno" placeholder="Learner Permit Number" name="candidatelpno" required> <small id="passwordHelpBlock" class="text-muted">
                                                    Enter first Learner No here in case of renewal
                                                </small> </div>
                                            <div class="form-group col-md-2">
                                                <label for="InputPassword">Learner Permit Issue Date</label>
                                                <input type="date" class="form-control" id="candidatelpdate" placeholder="dd-mm-yyyy" name="candidatelpdate" max="today();" onchange="daysCalc(this.value);" required> <small id="lpdatehelpblock" class="text-muted" style="color: red !important">
                                                    Enter first Learner's issue date in case of renewal
                                                </small> </div>
                                            <div class="form-group col-md-2">
                                                <label for="InputPassword">License Category</label>
                                                <select class="form-control" id="licensecategory" name="licensecategory" onfocusout="checkCommercial();" onchange="checkCommercial();" onfocus="checkCommercial();" required>
                                                    <option value="M/Cycle">M/Cycle</option>
                                                    <option value="Car">Car</option>
                                                    <option value="M/Cycle+Car">M/Cycle+Car</option>
                                                    <option value="Tractor Agriculture">Tractor Agriculture</option>
                                                    <option value="M/Cycle+Car+Tractor Agriculture">M/Cycle+Car+Tractor Agriculture</option>
                                                    <option value="Tractor Commercial">Tractor Commercial</option>
                                                    <option value="LTV">LTV</option>
                                                    <option value="M/Cycle+LTV">M/Cycle+LTV</option>
                                                    <option value="M/Cycle+LTV+Tractor Commercial">M/Cycle+LTV+Tractor Commercial</option>
                                                    <option value="HTV">HTV</option>
                                                    <option value="HTV(Psv)">HTV(Psv)</option>
                                                    <option value="LTV(Psv)">LTV(Psv)</option>
                                                    <option value="Rikshaw">Rikshaw</option>
                                                    <option value="M/Cycle+Rikshaw">M/Cycle+Rikshaw</option>
                                                    <option value="Invalid Carriage">Invalid Carriage</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label for="InputPassword">Special Case</label>
                                                <select class="form-control" id="specialcase" name="specialcase" onchange="specialCase(); enableSubmit(this.value);" required>
                                                    <option value="Normal">Normal</option>
                                                    <option value="Renewal">Renewal</option>
                                                    <option value="LPC">LPC</option>
                                                    <option value="Absent">Absent</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-2" id="lpcbycheck" hidden>
                                                <label for="InputPassword">LPC By</label>
                                                <select class="form-control" id="lpcauthority" name="lpcauthority">
                                                    <option value="Normal"> -- select an option -- </option>
                                                    <option value="CTO">CTO</option>
                                                    <option value="DSP HQ">DSP HQ</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label for="InputTicketCost">Ticket Cost</label>
                                                <input type="text" class="form-control" id="candidateticketcost" placeholder="Tickets Cost" name="candidateticketcost" required> </div>
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
        $(document).ready(function() {
            $("#tokenBtn").click(function() {
                $("#InputToken").val("1");
            });
        });

    </script>
    <script>
        function checkCommercial() {
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

    </script>
    <script>
        function specialCase() {
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

    </script>
    <script>
        function daysCalc(date) {
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

        function enableSubmit(option) {
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
        }

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
