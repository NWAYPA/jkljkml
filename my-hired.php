<?php

include "auth.php";
include "DB.php";
include "functions.php";
if($_SESSION['client_userrole'] !== 'Client')
{
	header("Location: register.php");
}
$profile_id = $_SESSION['client_id'];

$hired_client_d_token = "";
$hired_user_d_token = "";
if(isset($_GET['hired_c_token']))
{
	if(isset($_GET['hired_u_token']))
		{
			$hired_client_d_token = base64_decode($_GET['hired_c_token']); 
			$hired_user_d_token = base64_decode($_GET['hired_u_token']);
		}
}
	$query_hired = "UPDATE users_applied_jobs SET hire_status = 'Hired', hired_date = CURRENT_TIMESTAMP WHERE users_applied_jobs.client_token = '{$hired_client_d_token}' 
	AND users_applied_jobs.user_token_id = '{$hired_user_d_token}' ";
	$result_hired = mysqli_query($connection,$query_hired);
	confirmQuery($result_hired);
?>


<!DOCTYPE html>
<html lang="en">

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="UTF-8">
	<title>Document</title>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

	<link rel="stylesheet" href="my-hires.css">
	<link rel="stylesheet" href="style.css">

	<script src="https://kit.fontawesome.com/18dd5346aa.js" crossorigin="anonymous"></script>
</head>

<style>
	.container {
		padding-top: 1%;
	}

	.top-header {
		border-radius: 110px 0 110px 0;
		padding: 0.5% 13%;
		margin-bottom: 1%;
	}

	.top-header a {
		color: white;
	}

	ul.navbar-nav a:hover {
		color: wheat !important;
	}

</style>

<body class="bg-light text-left">
	<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #292b2c;">
		<a class="navbar-brand" style="color: teal; font-weight: bold;" href="my-hired.php"><img src="images/.jpg" alt="" style="border-radius: 5px; margin-bottom: -15px;"> Freelancer You Hired <br> <span style="font-size: 15px; margin-left: 80px;"></span></a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav ml-auto">
				<li class="nav-item dropdown">
					<a href="client-dashboard.php" class="nav-link" style="padding-top: 20px; color: white;">Back To Dashboard </a>
				</li>

				<li class="nav-item dropdown">
					<a href="applied_freelancer.php" class="nav-link" style="padding-top: 20px; color: white;"> Hire a Freelancer </a>
				</li>

				<li class="nav-item dropdown">
					<a type="button" class="nav-link" style="color: white;">
						Login as <?php echo $_SESSION['client_firstname'], "<br>"."( <span style='color: orange;'>". $_SESSION['client_userrole']."</span> )"; ?>
					</a>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link" href="logout.php" style="padding-top: 20px; color: red;"> Logout </a>
				</li>
			</ul>
		</div>
	</nav>

	<div class="container">
		<div class="top-header bg-dark text-light text-center">
			<h1> Hired Freelancer </h1>
		</div>
	</div>

	<div class="container">
		<div class="jumbotron tab-content profile-tab" id="myTab1Content" style="background:white;">
			<div class="tab-pane fade show active" id="hires" role="tabpanel" aria-labelledby="home-tab">
				<?php
				$verify = false;
				$hired_client_token = "";
				$hired_user_token = "";
				$query = "SELECT users_applied_jobs.client_token, hired_date, users_applied_jobs.user_token_id, users_applied_jobs.hire_status, users_applied_jobs.user_name, users_applied_jobs.apply_date, 
				profilee.skills, regestration.user_email, e_leveltb.expertise_level, users_applied_jobs.applied_for, titletb.title, 
				employmenttb.employ_company ,employmenttb.employ_job_title FROM users_applied_jobs, client_job_posting , profilee, regestration, e_leveltb, titletb, employmenttb
				WHERE users_applied_jobs.client_token = client_job_posting.c_token AND client_job_posting.client_id = {$profile_id} AND profilee.user_token_id = users_applied_jobs.user_token_id
				AND regestration.user_id = users_applied_jobs.user_profile_id AND e_leveltb.profile_id = users_applied_jobs.user_profile_id AND users_applied_jobs.user_profile_id = titletb.profile_id 
				AND employmenttb.profile_id = users_applied_jobs.user_profile_id AND users_applied_jobs.hire_status = 'Hired' ";
				
				$result = mysqli_query($connection,$query);
				while($row = mysqli_fetch_array($result))
				{
					$verify = true;
					$username = $row['user_name'];
					$skills = $row['skills'];
					$email = $row['user_email'];
					$e_level = $row['expertise_level'];
					$userrole_position = $row['title'];
					$apply_for = $row['applied_for'];
					$past_company = $row['employ_company'];
					$past_job_title = $row['employ_job_title'];
					$apply_date = $row['apply_date'];
					$hired_status = $row['hire_status'];
					$client_token_hire = $row['client_token'];
					$user_token_hire = $row['user_token_id'];
					$hired_date = $row['hired_date'];
				
				
			?>
				<div id="content" class="" style="line-height: 2.0;">
					<h4>Apply for : <?php echo $apply_for; ?> <span style="float:right; font-size: 15px; ">Hired On : <?php echo $hired_date; ?></span></h4>
					<div class="row">
						<div class="col-sm-6"><span style="font-weight: bold;">Name :</span> <?php echo $username; ?> </div>
						<div class="col-sm-6"><span style="font-weight: bold;">Email :</span> <?php echo $email; ?></div>
						<div class="col-sm-6"><span style="font-weight: bold;">Skills :</span> <?php echo $skills; ?> </div>
						<div class="col-sm-6"><span style="font-weight: bold;">Level of Expertise :</span> <?php echo $e_level; ?></div>
					</div>
					<div class="row">
						<div class="col-sm-6"><span style="font-weight: bold;">Role or Position :</span> <?php echo $userrole_position; ?> </div>
					</div>
					<div class="row">
						<div class="col-sm-6"><span style="font-weight: bold;"> Past Experience :</span> <?php echo $past_job_title." at " . $past_company; ?></div>
					</div>
					<div class="row">
						<div class="col-sm-6"><span style="font-weight: bold;"> Apply On :</span> <?php echo $apply_date; ?></div>
					</div>
					<div class="row">
						<div class="col-sm-12"><a href="client_chat.php" class="btn btn-success" style="float: right; margin-top: -4%;" disabled> Chat </a> </div>
					</div>
				</div>
				<hr style="border:2px solid grey;shadow:2px 3px;">
				<br>

				<?php } if(!$verify) { ?>

				<div class="text-center" style="height: 100%; margin-top: 10px;">
					<img src="images/emp.png" alt="" style="height:110px;weight:110px;"><br><br>
					<h3>Its seems that you haven't Hired anyone Yet! </h3>
					<h5> Want to Hired a Freelancer <a href="applied_freelancer.php"> Check Here! </a> OR <a href="search_freelancer.php">Hire by Category</a> </h5>
					<p>Hired Freelancer Displays here.</p>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>

	<!-- footer -->
	<div class="footer text-center">
		<div class="footer-top row">
			<div class="col-lg-4">
				<h5><u><b>Help for you</b></u></h5>
				<h6><a type="button" data-toggle="modal" data-target="#contactModal">Contact Support</a></h6>
				<h6>FAQs</h6>
			</div>
			<div class="col-lg-4">
				<h5><u><b>Safety and Privacy</b></u></h5>
				<h6><a href="TERMS OF SERVICES.pdf" target="_blank">Terms of services</a></h6>
				<h6><a href="">Privacy Policy</a></h6>
				<h6>Safety Tips</h6>
			</div>
			<div class="col-lg-4">
				<h5><u><b>About</b></u></h5>
				<h6><a type="button" data-toggle="modal" data-target="#aboutModalScrollable">About us</a></h6>
				<h6><a type="button" data-toggle="modal" data-target="#careerModalLong">Careers</a></h6>
				<h6>Media</h6>
			</div>
		</div>
		<div class="footer-icons">
			<a href="https://www.facebook.com/profile.php?id=61555972914004" target="_blank"><i class="fab fa-facebook-f fa-2x"></i></a>
			<a href="https://www.linkedin.com" target="_blank"><i class="fab fa-linkedin fa-2x"></i></a>
			<a href="https://www.instagram.com/anodazscan?igsh=eDV4dXNrNXd1cDJu" target="_blank"><i class="fab fa-instagram fa-2x"></i></a>
		</div>
		<a href="">
			<h6>&copy; ANODAZ SCAN 2024</h6>
		</a>
	</div>
	<!-- footer end -->

	<!-- contact-modal -->
	<div style="text-align: left;" class="modal fade" id="contactModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Contact Support</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p>Anodaz Scan webtech solutions <br>
						Ring us at: <br>
						+213655882297 <br>
						+213674492676 <br>
						Ping us at: <br>
						email- contact@anodaz.io <br>
						Office Address <br>
						unversety tahri mouhamed bechar <br>
						</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<!-- terms of services model -->
	<div style="text-align: left;" class="modal fade" id="careerModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLongTitle">Careers</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p>
						<b>Service. society. Quality. (Your step towards safety)</b><br>
						Our goal is to develop and nurture the largest digital platform that can help you achieve your goals and ensure your safety. Join in with us. <br>
						<b>Our purpose comes first.</b><br>
						It still feels like the first day we think the independent economy is still in its early stages. We believe that our mission -- as early advocates -- is to do so as comprehensively as possible, to present all our goal of encouraging people to dream of living in their work.. <br>
						We're a platform. Everything we do stems from our desire to inspire people around the world to live their dream of working, developing their company and becoming independent.
						<b>Locations</b><br>

						---------- ------------ --------------- <br>
						Teams (Our Anodaz Scan Employees) <br>
						XXXXX <br>
						YYYYY <br>
						ZZZZZ <br>
					</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<!-- About us modal -->
	<div style="text-align: left;" class="modal fade" id="aboutModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-scrollable" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalScrollableTitle">About us</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p>
					A broker between programmers with the skills and ability to execute technical projects and clients looking for technical solutions for their business aimed at providing an enabling environment for interaction between the parties, ensuring the execution of projects at high quality and competitive prices. We ensure smooth and transparent communication between programmers and customers, and facilitate the search and recruitment process for the right programmers for each project. We also seek to provide a pleasant and lucrative experience for all our clients.
					</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>




	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="index.js"></script>
	<script lang="javascript" type="text/javascript">
		window.history.forward();

	</script>

	<script>
		$(document).ready(function() {
			$('[data-toggle="tooltip"]').tooltip();
		});

	</script>
</body>

</html>
