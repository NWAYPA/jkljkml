<?php
include "DB.php";
include "auth.php";
if($_SESSION['client_userrole'] !== 'Client' )
{
	header("Location: index.php");
}

$profile_id = $_SESSION['client_id'];
?>


<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Feeds</title>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="my-hires.css">

	<script src="https://kit.fontawesome.com/18dd5346aa.js" crossorigin="anonymous"></script>
	<style>
		body {
			min-height: 100%;
			background-image: -webkit-linear-gradient(65deg, rgb(0, 0, 0), rgba(45, 168, 168, 0.658));
		}

		.container {
			padding-top: 1%;
		}

		.top-header {
			border-radius: 11px 0 110px 0;
			padding: 0.5% 13%;
			margin-bottom: 1%;
		}

		.top-header a {
			color: white;
		}

		.content .card-header {
			border-radius: 0 0 150px 150px;
		}

		.card:hover {
			background-color: rgb(242, 247, 246);
		}

		.card-link {
			text-decoration: none;
			cursor: pointer;
		}

		.row {
			margin: 0;
		}
		ul.navbar-nav a:hover{
			color: wheat!important;
		}
		.badge:hover{
			color: wheat!important;
		}
	</style>
</head>

<body class="text-left">

	<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #292b2c;">
		<a class="navbar-brand" style="color: teal; font-weight: bold;" href="search_freelancer.php"><img src="images/.jpg" alt="" style="border-radius: 5px; margin-bottom: -15px;"> Search Freelancer<br>
			<span style="font-size: 15px; margin-left: 80px;"></span></a>

		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav ml-auto">
				<li class="nav-item dropdown">
					<a href="client-dashboard.php" class="nav-link" style="padding-top: 20px; color: white;">Back To Dashboard </a>
				</li>
				<li class="nav-item dropdown">
					<a href="client_invitations.php" class="nav-link" style="padding-top: 20px; color: white;"> Your Invites </a>
				</li>&nbsp;




				<ul class="navbar-nav mr-auto" style="">
					<li class="nav-item dropdown">
						<a class="nav-link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fas fa-bell" style="color: white; padding-top: 18px;"> 
								<?php 
							$count = "";	
							$query = "SELECT * FROM invitations WHERE client_status = 'Not_checked' AND status = 'Accepted' AND client_profile = {$profile_id} ";
							$query_update = mysqli_query($connection,$query);
							while(mysqli_fetch_array($query_update))
							{
								$count++;
							}
							if($count>0)
							{
							?>
					
								<span class="badge badge-success"> <?php echo $count; ?></span>
								<?php } ?>
							</i>
						</a>

						<div style="margin-left: -20px;" class="dropdown-menu" aria-labelledby="navbarDropdown">
							<p class="noti" style="text-align: center; ">Notifications <span class="badge badge-success"> <?php echo $count; ?></span></p>
							<div class="dropdown-divider"></div>
							<?php
							$query = "SELECT * FROM invitations WHERE client_status = 'Not_checked' AND status = 'Accepted' AND client_profile = {$profile_id} ";
							$query_update = mysqli_query($connection,$query);
							while($row = mysqli_fetch_array($query_update))
							{
								$date = $row['user_accepted_date'];
								$status = $row['status'];
								$client_status = $row['client_status'];
								$usertoken = $row['user_token'];
								$client_id = $row['client_profile'];
							
						
					
					?>
							<a class="dropdown-item" href="client_invitations.php?client_id=<?php echo $client_id.'&usertoken='.$usertoken; ?> ">
								<p><br><?php if($client_status == 'Not_checked'){echo "<b><span style='color: lightskyblue;'>$status</span></b>";}else{ echo $status; } ?><br><small>Accepted on: <?php echo $date; ?></small></p>
							</a>
							<div class="dropdown-divider"></div>
							<?php } ?>
						</div>
					</li>
				</ul>&nbsp;




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
	<form action="" method="post">
		<div class="row justify-content-md-center mb-3 content">
			<div class="col-md-8">
				<div class="card-header bg-dark text-center">
					Feeds
				</div>


				<div class="input-group my-3">

					<select class="custom-select" name="select1" id="" style="border-radius: 50px 0 0 50px;">
						<option value="<?php echo $select; ?>">Search in a particular category</option>
						
						<option value="Admin Support">Website and Application Development</option>
						<option value="Customer Service">Customer Service</option>
						<option value="Data Science and Analytics">Inspection of sites and applications</option>
						<option value="Design & Creative">Design & Creative</option>
						
						
						
						
						
						
						
					</select>
					<div class="input-group-append">
						<button type="submit" name="submit" class="btn btn-light" style="border-radius: 0 50px 50px 0;"><i class="fas fa-search"></i></button>
					</div>

				</div>

			</div>
		</div>
		<div class="row justify-content-md-center">
			<div class="col-md-8">
				<div class="card mb-1">
					<?php 	
					$invites = "";
					$select = "";
			if(isset($_POST['submit']))
			{
				$select = $_POST['select1'];
			}
			$query = "SELECT * FROM profilee, titletb, hourlytb WHERE profilee.profile_id = titletb.profile_id 
			AND hourlytb.profile_id = profilee.profile_id AND profilee.expertise = '{$select}' ";
			$result = mysqli_query($connection,$query);
				if(mysqli_num_rows($result) > 0)
				{
			while($row = mysqli_fetch_array($result))
			{
				$user_name = $row['firstname'];
				$expertise = $row['expertise'];
				$title = $row['title'];
				$description = $row['professional_overview'];
				$rate = $row['hourly_rate'];
				$skills = $row['skills'];
				$user_token = $row['user_token_id'];
				
					$query_check = "SELECT * FROM invitations WHERE invitation = 'invited' AND user_token = '{$user_token}' ";
					$result_check = mysqli_query($connection,$query_check);
					while($row = mysqli_fetch_array($result_check))
					{
						$invites = $row['invitation'];
					}
			
			
			
		?>

					<div class="card-body">

						<h5 class="card-title">Freelancer's Name: <?php echo $user_name; ?></h5>
						<h6>Expertise: <span class="font-weight-bold"><?php echo $expertise; ?></span></h6>
						<p> $<?php echo $rate; ?> / <span class="text-muted">hr</span></p>
						<p class="card-text">
							<span class="font-weight-bold">About:</span><br>
							<?php echo $description; ?>
						</p>
						<p><b>Skills: </b> <?php echo $skills; ?></p>

						<p class='text-right'><a href="client_invitations.php?invite=<?php echo $user_token.'&client_profile='.$profile_id;  ?>"><?php if($invites){ echo "<button class='btn btn-success' disabled> Invited Already </button>"; } 
							else { echo "<button class='btn btn-success' type='button'> Want to Invite </button>"; } ?></a></p>


					</div>
					<div class="card-footer"><i class="fas fa-map-marker-alt"></i> India </div>
					<hr style="border: 1px dashed black;">
					<?php  }} else { ?>

					<div class="text-center" style="height: 100%; margin-top: 10px;">
						<img src="images/emp.png" alt="" style="height:110px;weight:110px;"><br><br>
						<h3>Please Choose a Category First</h3>
						<h6>If nothing is displays after selecting a category then it might be the case there is till now no freealncer of that category</h6>
						<p>Your Selected Options Freelancer's Category Displays Here</p>
					</div>


					<?php } ?>

				</div>

				<!-- Demo cards: Remove this while doing backend on it -->
				<!-- Upto here -->
			</div>
		</div>

	</form>



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
