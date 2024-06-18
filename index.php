<?php 
session_start();
ob_start();
include "DB.php";
include "functions.php";
?>

<?php 
$error = "";
$db_username = "";
$db_password = "";
$db_user_role = "";
$db_admin_status = "";
$USERNAME = "";
$PASSWORD = "";
if(isset($_POST['signin']))
{
	$USERNAME = trim($_POST['username']);
	$PASSWORD = trim($_POST['password']);
	
	$username = mysqli_real_escape_string($connection,$USERNAME);
	$password = mysqli_real_escape_string($connection,$PASSWORD);
	
	$hashFormat = "$2y$10$";
	$salt = "iusesomecrazystrings22";
	
	$hashF_and_salt = $hashFormat . $salt;
	
	
	$password = crypt($password,$hashF_and_salt);
	
	$query = "SELECT * FROM regestration WHERE user_email = '{$username}' ";
	$result_query = mysqli_query($connection,$query);
	if(!$result_query)
	{
		die("Connection Failed!".mysqli_error($connection));
	}
	while($row = mysqli_fetch_assoc($result_query))
	{
		$db_id = $row['user_id'];
		$db_username = $row['user_email'];
		$db_lastname = $row['lastname'];
		$db_firstname = $row['firstname'];
		$db_password = $row['user_password'];
		$db_user_role = $row['user_role'];
		$db_email = $row['user_email'];
		$db_admin_status = $row['Admin_Status'];
	}
	if($db_username !== $USERNAME && $db_password !== $PASSWORD)
	{
//		$error = "Invalid Username or Password!";
		echo "<script>alert('Invalid Username or Password')</script>";
		
	}
	else if ($db_username == $username && $db_password == $password && $db_user_role == "Client" && $db_admin_status == 'Approved')
	{
		$_SESSION['client_email'] = $db_email;
		$_SESSION['client_firstname'] = $db_firstname;
		$_SESSION['client_userrole'] = $db_user_role;
		$_SESSION['client_id'] = $db_id;
                  $sub_query="
        INSERT INTO login_details 
        (user_id) 
        VALUES ('".$db_id."')
        ";
        $res2= mysqli_query($connection, $sub_query) or die();
        $_SESSION['user_id'] = $db_id;
		$_SESSION['userrole'] = $db_user_role;
        $_SESSION['username'] = $db_username ;
        $_SESSION['login_details_id']=$connection->insert_id;
		check_client_profile($_SESSION['client_id']);
	}
	else if ($db_username == $username && $db_password == $password && $db_user_role == "Freelancer" && $db_admin_status == 'Approved')
	{
		$_SESSION['id'] = $db_id;
		$_SESSION['userrole'] = $db_user_role;
		$_SESSION['firstname'] = $db_firstname;
		$_SESSION['lastname'] = $db_lastname;
		$_SESSION['email'] = $db_username;
		                $sub_query="
        INSERT INTO login_details 
        (user_id) 
        VALUES ('".$db_id."')
        ";
        $res2= mysqli_query($connection, $sub_query) or die();
        $_SESSION['user_id'] = $db_id;
		$_SESSION['userrole'] = $db_user_role;
        $_SESSION['username'] = $db_username ;
        $_SESSION['login_details_id']=$connection->insert_id;
		check_profile($_SESSION['id']);
	}
	else if ($db_username == $username && $db_password == $password && $db_user_role == "Admin" && $db_admin_status == 'Approved')
	{
		$_SESSION['id'] = $db_id;
		$_SESSION['userrole'] = $db_user_role;
		$_SESSION['firstname'] = $db_firstname;
		$_SESSION['lastname'] = $db_lastname;
        header('Location: Admin/admin_index.php');
		
	}
	
	
	else
	{
			echo "<script>alert('Invalid Username or Password or Status Not Approved')</script>";
	}
	
	$session_id = session_id();
	$_SESSION['auth'] = $session_id;
	
	

}

?>




<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Upwork</title>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

	<link rel="stylesheet" href="style.css">

	<script src="https://kit.fontawesome.com/18dd5346aa.js" crossorigin="anonymous"></script>



	<style>
		.dashed-box {
			margin: 10px;
			outline: dashed;
			outline-color: #C0C0C0;
			outline-offset: 10px;
			padding: 5px;
		}


		.card-img-top {
			border-radius: 15px;

			filter: grayscale(75%)
		}

		.choose {
			border-radius: 50%;
			height: 150px;
			width: 150px;
		}

		.bloglink {
			color: black;
		}

		.category-card .card .card-body font {
			text-align: center;
			align-items: center;
		}

		.category-card .card {

			border-radius: 15px;
			padding: 1%;
			background: white;

			-webkit-transition: 0.4s ease-out;
			transition: 0.4s ease-out;
			box-shadow: 0px 7px 10px rgba(0, 0, 0, 0.5);
		}

		.category-card .card:hover {
			-webkit-transform: translateY(20px);
			transform: translateY(20px);
		}

		.category-card .card:hover:before {
			opacity: 1;
		}

		.category-card .card:hover .info {
			opacity: 1;
			-webkit-transform: translateY(0px);
			transform: translateY(0px);
		}

		.category-card .card:before {
			content: "";
			position: absolute;
			top: 0;
			left: 0;
			display: block;
			width: 100%;
			height: 100%;
			border-radius: 15px;
			background: rgba(0, 0, 0, 0.6);
			z-index: 2;
			-webkit-transition: 0.5s;
			transition: 0.5s;
			opacity: 0;
		}

		.fa-info-circle {
			color: black;
			float: right;
			position: absolute;
			top: 25px;
			right: 25px;
			font-size: 1.2em;
			border-color: black transparent transparent transparent;
		}

	</style>

</head>

<body style="background-color:#E8E8E8">

	<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #292b2c;">
		<a class="navbar-brand" style="color: teal; font-weight: bold;" href="#"><img src="images/Black and White Modern Monochrome Initial A Technology Logo.jpg" alt="" style="border-radius: 5px;"> Anodaz Scan</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav ml-auto">

				<li class="nav-item dropdown">
					<a href="#" class="nav-link" style=" color: white;">Solutions</a>
				</li>
				<li class="nav-item dropdown trainings">
					<a href="register.php" class="nav-link" style=" color: white;">Post a job</a>
				</li>
				<li class="nav-item dropdown">
					<a href="register.php" class="nav-link" style=" color: white;">Register</a>
				</li>
				<li class="nav-item dropdown">
					<a type="button" class="nav-link" data-toggle="modal" data-target="#exampleModal" style="color: yellow;">
						Login >
					</a>
				</li>
			</ul>
		</div>
	</nav>


	<!-- Login modal -->
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Login</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form action="index.php" method="post">
					<div class="modal-body">
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Username" name="username" required><a href="#" onclick="return false" data-toggle="tooltip" title="Username is your Email Id which you provided at the time of registeration"><i class="fas fa-info-circle"></i></a>
						</div>
						<div class="form-group">
							<input type="password" class="form-control" placeholder="Password" name="password" required>

						</div>
						<div style="text-align: right;">
							<a href="forgot.php?forgot=<?php echo uniqid(true); ?>">Forget password?</a>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" name="signin" class="btn btn-info">Login</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- Login modal end -->

	<div class="welcome-title">
		<h1>Your first step towards safety &#8482;</h1>
		<h1 class="green">ANODAZ SCAN</h1>
		<h6>Anodaz Scan connects developers, professional programmers and agencies with companies and people looking for specialized talent.
		</h6>
		<h6>Find top Specialists on Anodaz Scan  —
			the Best freelancing website.</h6>
		<br>
		<a data-qa="cta" class="cta-group__btn btn btn-primary mb-0 mr-10" href="register.php" track-event="click">
			Get Started
		</a>
	</div>

	<!-- <hr class="green"> -->

	<div class="container-fluid body-section" style="padding-top: 4%;">
		<h1 style="color: teal; text-shadow: 1px 1px 2px grey; line-height: 2;">Find quality talents	</h1>



		<div class="category-container row">
			<div class="category-card col-sm-3">
				<a class="bloglink" href="blogtemplate.html">
					<div class="card">
						<img src="images/Design&Creative.png" class="card-img-top" alt="...">
						<div class="card-body">
						<a href="register.php">
							<font size="+1">Design <br> & Creative</font>
						</div>
					</div>
				</a>
			</div>
			<div class="category-card col-sm-3">
				<a class="bloglink" href="blogtemplate.html">
					<div class="card">
						<img src="images/DataScience&Analytics.png" class="card-img-top" alt="...">
						<div class="card-body">
						<a href="register.php">
							<font size="+1">Inspection of sites and applications</font>
						</div>
					</div>
				</a>
			</div>
			<div class="category-card col-sm-3">
				<a class="bloglink" href="blogtemplate.html">
					<div class="card">
						<img src="images/CustomerService.png" class="card-img-top" alt="...">
						<div class="card-body">
						<a href="register.php">
							<font size="+1">Customer <br>Service</font>
						</div>
					</div>
				</a>
			</div>
			<div class="category-card col-sm-3">
				<a class="bloglink" href="blogtemplate.html">
					<div class="card"> 
						<img src="images/Admin Support.png" class="card-img-top" alt="...">
						<div class="card-body">
						<a href="register.php">
							<font size="+1">Website and Application Development</font>
						</div>
					</div>
				</a>
			</div>
		</div>
	</div>

	<!--Hire Scope-->
	<div class="hire-scope" style="background-color:#FFFFFF; padding:4% 0% 4% 0%;">
		<div class="container">
				</div>
			<section class="client_section "> 
      <div class="container"> 
        <div class="heading_container heading_center"> 
          <h2> 
            feed-back 
          </h2> 
        </div> 
      </div> 
      <div id="customCarousel2" class="carousel slide" data-ride="carousel"> 
        <div class="carousel-inner"> 
          <div class="carousel-item active"> 
            <div class="container"> 
              <div class="row"> 
                <div class="col-md-10 mx-auto"> 
                  <div class="box"> 
                    <div class="img-box"> 
                      <img src="images/client.jpg" alt=""> 
                    </div> 
                    <div class="detail-box"> 
                      <div class="client_info"> 
                        <div class="client_name"> 
                          <h5> 
                            mouhamed-bd 
                          </h5> 
                          <h6> 
                            Customer 
                          </h6> 
                        </div> 
                        <i class="fa fa-quote-left" aria-hidden="true"></i> 
                      </div> 
                      <p> 
					  "The speed and efficiency of work was one of the highlights I admired in dealing with this platform. I was able to find skilled programmers quickly, and the project was completed on time and within the budget. "
                      </p> 
                    </div> 
                  </div> 
                </div> 
              </div> 
            </div> 
          </div> 
          <div class="carousel-item"> 
            <div class="container"> 
              <div class="row"> 
                <div class="col-md-10 mx-auto"> 
                  <div class="box"> 
                    <div class="img-box"> 
                      <img src="images/client.jpg" alt=""> 
                    </div> 
                    <div class="detail-box"> 
                      <div class="client_info"> 
                        <div class="client_name"> 
                          <h5> 
                           khawla-gar
                          </h5> 
                          <h6> 
                            Customer 
                          </h6> 
                        </div> 
                        <i class="fa fa-quote-left" aria-hidden="true"></i> 
                      </div> 
                      <p> 
					  "My experience with them was excellent from start to finish. The support team was very cooperative, and the programmer who worked on my project was an expert in his field. I strongly recommend the use of their services. "
                      </p> 
                    </div> 
                  </div> 
                </div> 
              </div> 
            </div> 
          </div> 
        </div> 
        <ol class="carousel-indicators"> 
          <li data-target="#customCarousel2" data-slide-to="0" class="active"></li> 
          <li data-target="#customCarousel2" data-slide-to="1"></li> 
          <li data-target="#customCarousel2" data-slide-to="2"></li> 
        </ol> 
      </div> 
    </section>
						
				</div>
			</div>
		</div>
	</div>
	<br>
	<!--hire scope end-->

	<!--WE Provide -->
	<div class="hire-scope" style=" padding:4% 0% 4% 0%;">
		<div class="container">
			<h3 style="color: teal; text-shadow: 1px 1px 2px grey; line-height: 2;">We Provide</h3>
			<div class="row">
				<div class="col-sm-4">
					<img class="choose" src="img/experience.png">
					<div class="fc">
						<font size="+1">Access to Expertise </font>
					</div>
				</div>
				<div class="col-sm-4">
					<img class="choose" src="img/save-time.png">
					<div class="fc">
						<font size="+1">Efficiency and Time-Saving</font>
					</div>
				</div>
				<div class="col-sm-4">
					<img class="choose" src="img/flexibility.png">
					<div class="fc">
						<font size="+1">Flexibility and Scalability</font>
					</div>
				</div>

				<div class="col-sm-4">
					<img class="choose" src="img/problem-solving.png" style="margin-top: 5%;">
					<div class="fc">
						<font size="+1">Problem Resolution and Support</font>
					</div>
				</div>
				<div class="col-sm-4">
					<img class="choose" src="img/innovative-idea.png" style="margin-top: 5%;">
					<div class="fc">
						<font size="+1">Innovation and Development</font>
					</div>
				</div>
				<div class="col-sm-4">
					<img class="choose" src="img/quality (2).png" style="margin-top: 5%;">
					<div class="fc">
						<font size="+1" class="fc">Quality Assurance</font>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--we provide end-->



	<!--why choose us-->
	<div class="chooseus" style="background-color:#FFFFFF;  padding:4% 0% 4% 0%;;">
		<div class="container">
			<h3 style="color: teal; text-shadow: 1px 1px 2px grey; line-height: 2;">Why Choose Us</h3>
			<div class="row">
				<div class="col-sm-2">
					<img class="choose" src="img/call.png">
					<div class="fc">
						<font size="+2">Continuous Support </font>
					</div>
				</div>
				<div class="col-sm-2">
					<img class="choose" src="img/easy-use.png">
					<div class="fc">
						<font size="+2">Ease of Use</font>
					</div>
				</div>
				<div class="col-sm-2">
					<img class="choose" src="img/deadline.png">
					<div class="fc">
						<font size="+2">Speedy Execution</font>
					</div>
				</div>
				<div class="col-sm-2">
					<img class="choose" src="img/data-variety.png">
					<div class="fc">
						<font size="+2">Flexibility and Variety</font>
					</div>
				</div>
				<div class="col-sm-2">
					<img class="choose" src="img/handshake.png">
					<div class="fc">
						<font size="+2">Long-Term Partnership</font>
					</div>
				</div>
				<div class="col-sm-2">
					<img class="choose" src="img/solution.png">
					<div class="fc">
						<font size="+2" class="fc">Cost-Effective Solutions</font>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!--why choose us end-->


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
