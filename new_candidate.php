<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Driving Licence Test System (DLTS) CTP Faisalabad</title>
</head>

<?php  include('files/header.php'); include('connection.php'); ?>	

	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<?php  echo "Date : ".$todayDate; echo ".............Time : ".date("h:i:s"); ?>
		</div><!--/.row-->
				
		<div class="panel panel-default">
				<div class="panel-heading">New Candidate Entry (DLTS) CTP Faisalabad</div>
				<form action="datapost.php" method="post" role="form">
					<div class="panel-body">
						<div class="row">
							<div class="col-sm-4">
								<div class="form-group">
									<label>CNIC</label>
									<input name="cnic" class="form-control" maxlength='13' minlength='13'placeholder="CNIC" required>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form-group">
									<label>Learner Permit Number</label>
									<input name="lpno" class="form-control" placeholder="Learner Permit Number">
								</div>
							</div>
								<div class="col-sm-4">
								<div class="form-group">
									<label>Learner Permit Date</label>
									<input type="date" name="lpdt" class="form-control" required>
							
								</div>
							</div>
						</div>


						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label>Name</label>
									<input name="name" class="form-control" placeholder="Full Name">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label>Father/Husband Name </label>
									<input name="fh_name" class="form-control" placeholder="Father/Husband Full Name">
								</div>
							</div>
						</div>
					

						<div class="row">
							<div class="col-sm-8">
								<div class="form-group">
									<label>Address</label>
									<input name="addr" class="form-control" placeholder="Address">
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form-group">
									<label>City </label>
									<input name="city" class="form-control" placeholder="City">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-4">
								<div class="form-group">
									<label>Phone</label>
									<input name="phn" class="form-control" placeholder="Contact Number">
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form-group">
									<label>E-Mail</label>
									<input name="email" class="form-control" placeholder="E-Mail Address">
								</div>
							</div>
								<div class="col-sm-4">
								<div class="form-group">
									<label>Blood Group</label>
										<select name="bgrp" class="form-control" id="Blood" required>
										    <option value="">Select One</option>
										    <option value = "A+">A+</option>
										    <option value = "A-">A-</option>
										    <option value = "B+">B+</option>
										    <option value = "B-">B-</option>
										    <option value = "O+">O+</option>
										    <option value = "O-">O-</option>
										    <option value = "AB+">AB+</option>
										    <option value = "AB-">AB-</option>
									    </select>
								</div>
							</div>
							
						</div>

						<div class="row">
							<div class="col-sm-8">
								<div class="row">
									<div class="col-sm-12">
										<input type="checkbox" name="subject[]" value="M-Cycle">Moter Cycle  
										<input type="checkbox" name="subject[]" value="M-Car">Motor Car 
										<input type="checkbox" name="subject[]" value="LTV">LTV  
										<input type="checkbox" name="subject[]" value="HTV">HTV  
										<input type="checkbox" name="subject[]" value="LPSV">Light PSV  
										<input type="checkbox" name="subject[]" value="HPSV">Heavy PSV 
									</div>
								</div>

								<div class="row">
									<div class="col-sm-12">
										<input type="checkbox" name="subject[]" value="Rickshaw">Rickshaw 
										<input type="checkbox" name="subject[]" value="Tractor Agri">Tractor Agri 
										<input type="checkbox" name="subject[]" value="Tractor Comm">Tractor Comm 	
										<input type="checkbox" name="subject[]" value="Road Roller">Road Roller  
										<input type="checkbox" name="subject[]" value="Invlid Carriage">Invlid Carriage
									</div>									
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form-group">
									<label>Ticket Cost</label>
									<input type="text" name="cost_tkt" class="form-control" required>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6">
								<button type="submit" class="btn btn-primary">Submit Button</button>
								<button type="reset" class="btn btn-default">Reset Button</button>
							</div>
							<div class="col-sm-6">
								
							</div>
							
						</div>

						</div><!--Row-->
					</form>
				</div>
		</div>
	</div>	<!--/.main-->


<?php ?>