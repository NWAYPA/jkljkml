<?php ob_start();
include "auth.php"; 
include "DB.php";
include "functions.php";
if($_SESSION['client_userrole'] !== 'Client' )
{
	header("Location: register.php");
}

$profile_id = $_SESSION['client_id'];
$c_firstname = $_SESSION['client_firstname'];
$msg = "";
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Job Feed</title>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

	<link rel="stylesheet" href="style.css">
	<link rel="icon" type="image/png" href="images/.jpg">

	<script src="https://kit.fontawesome.com/18dd5346aa.js" crossorigin="anonymous"></script>

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

		.tab-content .card-header {
			border-radius: 50px;
		}

		.card:hover {
			background-color: rgb(242, 247, 246);
		}

	</style>
</head>

<body class="bg-light text-left">

	<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #292b2c;">
		<a class="navbar-brand" style="color: teal; font-weight: bold;" href="view_job_post.php"><img src="images/.jpg" alt="" style="border-radius: 5px; margin-bottom: -15px;"> Client Job Posts <br> <span style="font-size: 15px; margin-left: 70px;"></span> </a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<style>
				ul.navbar-nav a:hover {
					color: wheat !important;
				}

			</style>
			<ul class="navbar-nav ml-auto">
				<li class="nav-item dropdown trainings">
					<a href="client-dashboard.php" class="nav-link" style="padding-top: 20px; color: white;"> Back To Dashboard </a>
				</li>
				&nbsp;
				<li class="nav-item dropdown">
					<a type="button" class="nav-link" style="color: white;">
						<?php echo $_SESSION['client_firstname'], "<br>"."( <span style='color: orange;'>". $_SESSION['client_userrole']."</span> )"; ?>
					</a>
				</li>&nbsp;
				<li class="nav-item dropdown">
					<a class="nav-link" href="logout.php" style="padding-top: 20px; color: red;"> Logout </a>
				</li>

			</ul>
		</div>
	</nav>


	<div class="tab-content" id="myTabContent">
		<!------------------------------------------ my feed ----------------------------------------->
		<div class="tab-pane fade show active container" id="home" role="tabpanel" aria-labelledby="home-tab">
			<div class="row justify-content-md-center mb-3">
				<div class="col-md-8">
					<div class="card-header bg-dark text-center">
						Viewing Posted Jobs
					</div>
				</div>
			</div>
			<div class="row justify-content-md-center">

				<?php
$verify = false;
$job_title = "";
$query = "SELECT * FROM client_job_posting WHERE client_job_posting.client_id = {$profile_id} AND client_job_posting.client_name = '{$c_firstname}' ";
$result_job = mysqli_query($connection,$query);

while($row = mysqli_fetch_array($result_job))
{
	$verify = true;
	$job_title = $row['job_title'];
	$company_name = $row['company_name'];
	$job_description = $row['job_description'];
	$skills = $row['job_expertise_skills'];
	$job_vacancy = $row['job_vacanies'];
	$pay_like = $row['client_pay_like'];
	$date = $row['date'];
	
	$client_req_experience = $row['client_req_experience'];
	$token = $row['c_token'];

?>

				<div class="col-md-8">
					<div class="card">
						<div class="card-body">
							<h5 class="card-title"> <?php echo $company_name; ?></h5>
							<h6><?php echo $job_title; ?></h6>
							<p><?php echo $pay_like; ?> | <span class="text-uppercase"><?php echo $client_req_experience; ?></span> | Est. Budget $500 | <span class="text-secondary"><?php echo $date;  ?></span></p>
							<p class="card-text">
								<?php echo $job_description; ?>
							</p>
							<p><b>Skills Required:</b> <?php echo $skills; ?></p>
							<p>Proposals: <span class="text-uppercase"><?php echo $job_vacancy; ?></span></p>
							<p><i class="fas fa-map-marker-alt"></i> India</p>
							<span><a href="client_job_update.php?token=<?php echo $token; ?>" class="btn btn-primary"> Update </a></span>
							<span><a href="view_job_post.php?delete=<?php echo $token; ?>" class="btn btn-danger" style="float: right;"> Delete </a></span>

						</div>
					</div>
				</div>
				<?php } if(!$verify){ 
				?>



				<div class="text-center" style="height: 100%; margin-top: 10px;">
					<img src="images/emp.png" alt="" style="height:110px;weight:110px;"><br><br>
					<h3>Please Post a Job First! </h3>
					<p>Your Posted jobs will Displays here. <a href="post-a-job.php">Check Here to Post a job </a></p>
				</div>
				<?php } ?>


			</div>
		</div>

	</div>


	<?php
	
	if(isset($_GET['delete']))
	{
		$delete_token_id = $_GET['delete'];
		global $connection;
		
		$query = "DELETE FROM client_job_posting WHERE c_token = '{$delete_token_id}' AND client_id = {$profile_id} ";
		
		$delete_query = mysqli_query($connection,$query);
		confirmQuery($delete_query);
		
		header('Location: view_job_post.php');
	}
	?>


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
