<?php 
include "auth.php";
include "DB.php";
if($_SESSION['userrole'] !== 'Freelancer' )
{
	header("Location: register.php");
}
?>
<?php 
$user_profile_id = $_SESSION['id'];
?>


<?php 
	$client_id = "";
	$user_token = "";
	if(isset($_GET['client_id']))
	{
		if(isset($_GET['user_token']))
		{
			$client_id = $_GET['client_id'];
			$user_token = $_GET['user_token'];
		}
	}
	$query_update = "UPDATE invitations SET invitations.status = 'Accepted', invitations.user_accepted_date = CURRENT_TIMESTAMP WHERE user_token = '{$user_token}' AND client_profile = {$client_id}";
	$result_update = mysqli_query($connection,$query_update);
	if($result_update)
	{
		header("Location: user_accepted_invitation.php");
	}

	$query = "SELECT * FROM profilee WHERE profilee.profile_id = {$user_profile_id} ";
	$result = mysqli_query($connection,$query);
	while($row = mysqli_fetch_array($result))
	{
		$user_token_id = $row['user_token_id'];
	}

	
?>





<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Job Feed</title>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

	<link rel="stylesheet" href="style.css">

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
		<a class="navbar-brand" style="color: teal; font-weight: bold;" href="user_dasboard.php"><img src="images/.jpg" alt="" style="border-radius: 5px; margin-bottom: -10px;"> Find Work <br> <span style="font-size: 15px; margin-left: 50px;"></span> </a>
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
				<li class="nav-item dropdown">
					<a class="nav-link" href="user_dasboard.php" style="padding-top: 20px; color: white"> Back To Dashboard </a>
				</li>
				<li class="nav-item dropdown text-center">
					<a type="button" class="nav-link" style="color: white;">
						<?php echo $_SESSION['firstname'], "<br>"."( <span style='color: orange;'>". $_SESSION['userrole']."</span> )"; ?>
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
			<h1> Client Invites </h1>
		</div>
	</div>

	<div class="tab-content" id="myTabContent">
		<!------------------------------------------ my feed ----------------------------------------->
		<div class="tab-pane fade show active container" id="home" role="tabpanel" aria-labelledby="home-tab">
			<div class="row justify-content-md-center">




				<?php 
				$verify = false;
			$query = "SELECT * FROM invitations WHERE invitations.invitation = 'invited' AND invitations.status = 'Accepted' AND invitations.user_token = '{$user_token_id}' ";
				$result = mysqli_query($connection,$query);
				while($row = mysqli_fetch_array($result))
				{
					$verify = true;
					$client_id = $row['client_profile'];
					$client_status = $row['client_status'];
					$client_invited_date = $row['invite_date'];
					$your_accepted_date = $row['user_accepted_date'];
					$your_status = $row['status'];
					
					$query_verify = "SELECT * FROM client_profile WHERE client_profile.client_id = {$client_id} ";
					$result_query = mysqli_query($connection,$query_verify);
					while($row = mysqli_fetch_array($result_query))
					{
						$company_name = $row['client_company'];
						$client_email = $row['client_email'];
						$client_name = $row['client_name'];
				
				
				
				
				?>
				<div class="col-md-8">
					<div class="card">
						<div class="card-body">
							<h5 class="card-title"><b>Company Name :</b> <?php echo $company_name; ?></h5>
							<h6><b>Client Name : </b> <?php echo $client_name; ?> <p style="float: right;"><b>Invited On : </b><span class="text-uppercase"><?php echo $client_invited_date; ?></span></p>
							</h6>

							<p class="card-text">
								<b>Client Email :</b> <?php echo $client_email; ?>
							</p>
							<p><b>Your Status :</b> <?php echo $your_status; ?> <b>On</b> <?php echo $your_accepted_date; ?></p>
							<p><b>Client Status :</b> <?php echo $client_status; ?></p>

							<p><i class="fas fa-map-marker-alt"></i> India</p>

							<a href="index_2.php" class="btn btn-info" style="float:right; margin-top: -5%;"> Want to Chat </a>
						</div>
					</div>
				</div>

				<?php  }} if(!$verify) { ?>

				<div class="text-center" style="height: 100%; margin-top: 10px;">
					<img src="images/emp.png" alt="" style="height:110px;weight:110px;"><br><br>
					<h3>Its seems that none of the Client Invited you Yet! </h3>
					<h5> Want to Apply to a job <a href="find_work.php"> Check Here! </a></h5>
					<p> Client Invites Displays here. <strong>Note!</strong> Client Invites based on your Profile. <a href="view_profile.php">Update or View Profile</a></p>
				</div>
				<?php } ?>

			</div>

			<!-------------------------------------------- upto-here -------------------------------------------->
		</div>
		<!------------------------------------------ recommended ----------------------------------------->
		<div class="tab-pane fade container" id="profile" role="tabpanel" aria-labelledby="profile-tab">
			<div class="row justify-content-md-center mb-3">
				<div class="col-md-8">
					<div class="card-header bg-dark text-center">
						Recommended
					</div>
				</div>
			</div>
			<div class="row justify-content-md-center">
				<div class="col-md-8">
					<div class="card">

						<div class="card-body">
							<h5 class="card-title">Company's Name</h5>
							<p>Fixed Price - Expert - Est. Budget $500 - Posted 13 minutes ago</p>
							<p class="card-text">
								Lorem ipsum dolor sit amet consectetur adipisicing elit. Vel, magnam blanditiis.
								Repellendus vitae ipsum laudantium. Cum veritatis placeat ullam non rerum quaerat modi
								est nesciunt at, fugit quod! Rerum, perferendis.
							</p>
							<p>Proposals: Less than 5</p>
							<p><i class="fas fa-map-marker-alt"></i> India</p>
						</div>
					</div>
				</div>
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
