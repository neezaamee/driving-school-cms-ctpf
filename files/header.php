<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>RSTS - Admin</title>

<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/styles.css" rel="stylesheet">

<!--Icons-->
<script src="js/lumino.glyphs.js"></script>

</head>

<body>
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#"><span>RSTS</span>Admin</a>
				<ul class="user-menu">
					<li class="dropdown pull-right">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> User <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="#"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Profile</a></li>
							<li><a href="#"><svg class="glyph stroked gear"><use xlink:href="#stroked-gear"></use></svg> Settings</a></li>
							<li><a href="#"><svg class="glyph stroked cancel"><use xlink:href="#stroked-cancel"></use></svg> Logout</a></li>
						</ul>
					</li>
				</ul>
			</div>
							
		</div><!-- /.container-fluid -->
	</nav>
		
	<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
		<ul class="nav menu">
			<li class="active"><a href="index.php"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Dashboard</a></li>

			<li><a href="new_candidate.php"><svg class="glyph stroked pencil"><use xlink:href="#stroked-pencil"></use></svg> New Candidate</a></li>

			<li><a href="signstest.php"><svg class="glyph stroked app-window"><use xlink:href="#stroked-app-window"></use></svg> Road Sign Test</a></li>
			
			<li><a href="rdtest.php"><svg class="glyph stroked table"><use xlink:href="#stroked-table"></use></svg> Road Test</a></li>

			<li><a href="duplicate.php"><svg class="glyph stroked line-graph"><use xlink:href="#stroked-line-graph"></use></svg> Duplicate Token</a></li>

			<li><a href="report.php"><svg class="glyph stroked line-graph"><use xlink:href="#stroked-line-graph"></use></svg> Reports</a></li>

			<li><a href="export.php"><svg class="glyph stroked line-graph"><use xlink:href="#stroked-line-graph"></use></svg> Export Data</a></li>

			<li><a href="#"><svg class="glyph stroked line-graph"><use xlink:href="#stroked-line-graph"></use></svg> Close Work</a></li>
			
	</div><!--/.sidebar-->

	<?php
				//Date Variable Global
				date_default_timezone_set("Asia/Karachi");
				$todayDate = date("d-m-Y");
	?>
	