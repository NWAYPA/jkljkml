<?php
include "auth.php";
include "DB.php";
include "functions.php";
if($_SESSION['client_userrole'] !== 'Client' )
{
	header("Location: register.php");
}

?>
<?php

if(isset($_POST['submit']))
{
	$client_id = $_SESSION['client_id'];
	$firstname = $_SESSION['client_firstname'];
	$project_name = $_POST['project_name'];
	$company_name = $_POST['company_name'];
	$select = $_POST['select1'];
	$description = $_POST['job_description'];
	$details = $_POST['job_details'];
	$skills_required = $_POST['skills_required'];
	$job_vacancy = $_POST['job_vacancy'];
	$pay = $_POST['pay'];
	$length = 30;
	$token = bin2hex(openssl_random_pseudo_bytes($length));
	
	$experience = $_POST['experience'];
	$project_time = $_POST['project_time'];
	
	
	$query = "INSERT INTO client_job_posting(client_id, client_name, company_name, job_title, job_category, job_description, job_details, job_expertise_skills, job_vacanies, date, client_pay_like, client_req_experience, client_project_time, c_token) ";
	$query .= "VALUES({$client_id}, '{$firstname}', '{$company_name}', '{$project_name}',  '{$select}', '{$description}', '{$details}', '{$skills_required}', '{$job_vacancy}', CURRENT_TIMESTAMP, '{$pay}', '{$experience}', '{$project_time}', '{$token}' )";
	
	$result = mysqli_query($connection, $query);
	confirmQuery($result);
	
	header("Location: view_job_post.php");
}

?>



<!DOCTYPE html>
< lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Profile</title>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

	<link rel="stylesheet" href="style.css">
	<link rel="icon" type="image/png" href="images/.jpg">

	<script src="https://kit.fontawesome.com/18dd5346aa.js" crossorigin="anonymous"></script>
	<style>
		body {
			background-color: rgba(236, 231, 231, 0.897);
		}

		.container-tab {
			padding: 2% 2% 0.5%;
			border-radius: 0 0 50px 50px;
		}

		.card-header {
			background-color: rgb(30, 36, 43);
		}

		.card {
			box-shadow: 2px 2px 4px 4px grey;
		}

	</style>
</head>

<body>

	<style>
		ul.navbar-nav a:hover {
			color: wheat !important;
		}

	</style>
	<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #292b2c;">
		<a class="navbar-brand" style="color: teal; font-weight: bold;" href="#"><img src="images/.jpg" alt="" style="border-radius: 5px; margin-bottom: -15px;"> Post A Job <br> <span style="font-size: 15px; margin-left: 40px;"></span></a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav ml-auto">
				<li class="nav-item dropdown">
					<a href="client-dashboard.php" class="nav-link" style="padding-top: 20px; color: white;">Back To Dashboard </a>
				</li>
				<li class="nav-item dropdown">
					<a href="view_job_post.php" class="nav-link" style="padding-top: 20px; color: white;"> View Posted Jobs </a>
				</li>

				<li class="nav-item dropdown">
					<a type="button" class="nav-link" style="color: white;">
						<?php echo $_SESSION['client_firstname'], "<br>"."( <span style='color: orange;'>". $_SESSION['client_userrole']."</span> )"; ?>
					</a>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link" href="logout.php" style="padding-top: 20px; color: red;"> Logout </a>
				</li>
			</ul>
		</div>
	</nav>

	<!-- side navigation or off-canvas Menu -->
	<form action="" method="post" enctype="multipart/form-data">
		<div class="container-tab bg-light">
			<ul id="myTab" class="nav nav-tabs justify-content-center">
				<li class="nav-item">
					<a class="nav-link active" id="expertise-tab" data-toggle="tab" href="#Title" role="tab" aria-controls="expertise" aria-selected="true">Title</a>
				</li>
				<li class="nav-item">
					<a id="1a" href="#Description" class="nav-link" data-toggle="tab" role="tab" aria-controls="expertise-level" aria-selected="true">Description</a>
				</li>
				<li class="nav-item">
					<a id="2a" href="#Details" class="nav-link" data-toggle="tab" role="tab" aria-controls="education" aria-selected="true">Details</a>
				</li>
				<li class="nav-item">
					<a id="3a" href="#Expertize" class="nav-link" data-toggle="tab" role="tab" aria-controls="employment" aria-selected="true">Expertise</a>
				</li>
				<li class="nav-item">
					<a id="4a" href="#Visibility" class="nav-link" data-toggle="tab" role="tab" aria-controls="languages" aria-selected="true">Visibility</a>
				</li>
			</ul>
		</div>
		<div class="alert alert-danger" style="width: 50%; margin-left: 25%; margin-bottom: -20px;">
			<strong> Note! </strong> You Have to Fill all Text
		</div>
		<div class="heading row justify-content-md-center">
			<div class="col-md-5 bg-dark">
				<h1>Job Specification</h1>
			</div>
		</div>
		<div class="tab-content row justify-content-md-center" id="myTabContent">


			<!-- 1 -->
			<div class="tab-pane fade show active col-md-6" id="Title" role="tabpanel" aria-labelledby="expertise-tab">
				<div class="card" style="text-align: left;">
					<div class="card-header">
						1 of 5
					</div>
					<div class="card-body">
						<h5 class="card-title">Title</h5>
						<p class="card-text"><b>Enter the name of your job post.</b></p>
						<input type="text" class="form-control" placeholder="Enter name here" name="project_name" required>
						<p class="card-text"><b>Name of the Company</b></p>
						<input type="text" class="form-control" placeholder="Enter Comapny name" name="company_name" required>
						<br>
						<p class="card-text"><select class="custom-select" name="select1" id="" required>
								<option value="Admin Support">Website and Application Development</option>
						<option value="Customer Service">Customer Service</option>
						<option value="Data Science and Analytics">Inspection of sites and applications</option>
						<option value="Design & Creative">Design & Creative</option>
							</select></p>
						<div style="text-align: right; padding-top: 3%;">
							<a id="1" href="#Description" data-toggle="tab" role="tab" aria-controls="expertise-level" aria-selected="true" class="btn btn-primary">Next</a>
						</div>
					</div>
				</div>
			</div>

			<!-- 2 -->
			<div class="tab-pane fade col-md-6" id="Description" role="tabpanel" aria-labelledby="expertise-level-tab">
				<div class="card" style="text-align: left;">
					<div class="card-header">
						2 of 5
					</div>
					<div class="card-body">
						<h5 class="card-title">Description</h5>
						<p class="card-text"><b>A good description includes:</b></p>
						<ul>
							<li> What the deliverable is</li>
							<li>Type of freelancer or agency you're looking for</li>
							<li>Anything unique about the project, team, or your company</li>
						</ul>
						<textarea name="job_description" id="" cols="30" rows="5" class="form-control" required></textarea>
						<div style="text-align: right; padding-top: 3%;">
							<a id="2" class="btn btn-primary" href="#Details" data-toggle="tab" role="tab" aria-controls="education" aria-selected="true">Next</a>
						</div>
					</div>
				</div>
			</div>


			<!-- 3 -->
			<div class="tab-pane fade col-md-6" id="Details" role="tabpanel" aria-labelledby="education-tab">
				<div class="card" style="text-align: left;">
					<div class="card-header">
						3 of 5
					</div>
					<div class="card-body">
						<h5 class="card-title">Details</h5>
						<p class="card-text">
							<b>What type of project do you have?</b>
							<select name="job_details" id="" class="form-control" required>
								<option value="">Select the type of project</option>
								<option value="One-time">One-time Project</option>
								<option value="On-going">On-going Project</option>
								<option value="Complex">Complex Project</option>
							</select>
						</p>
						<div style="text-align: right; padding-top: 3%;">
							<a id="3" href="#Expertize" data-toggle="tab" role="tab" aria-controls="employment" aria-selected="true" class="btn btn-primary">Next</a>
						</div>
					</div>
				</div>
			</div>


			<!-- 4 -->
			<div class="tab-pane fade col-md-6" id="Expertize" role="tabpanel" aria-labelledby="employment-tab">
				<div class="card" style="text-align: left;">
					<div class="card-header">
						4 of 5
					</div>
					<div class="card-body">
						<h5 class="card-title">Expertise</h5>
						<p class="card-text"><b>What skills and expertise are most important to you?</b></p>
						<textarea name="skills_required" id="" cols="30" rows="5" class="form-control" required></textarea>
						<div style="text-align: right; padding-top: 3%;">
							<a id="4" href="#Visibility" data-toggle="tab" role="tab" aria-controls="languages" aria-selected="true" class="btn btn-primary">Next</a>
						</div>
					</div>
				</div>
			</div>



			<!-- 5 -->
			<div class="tab-pane fade col-md-6" id="Visibility" role="tabpanel" aria-labelledby="languages-tab">
				<div class="card" style="text-align: left;">
					<div class="card-header">
						5 of 5
					</div>
					<div class="card-body">
						<p><b>How many people do you need for this job?</b></p>
						<select name="job_vacancy" id="" class="form-control" required>
							<option value=''>Select</option>
							<option value="One">Only One Freelancer</option>
							<option value="More">More Than One Freelancer</option>
						</select>
						</p>
						<div style="text-align: right; padding-top: 3%;">
							<button class="btn btn-success" type="submit" name="submit"> Submit and Review </button>
						</div>
					</div>
				</div>
			</div>

		</div>

	</form>


	<br>
	<br>
	<br>
	<br>
	<br>


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


	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="create-your-profile.js"></script>
</body>

</html>
