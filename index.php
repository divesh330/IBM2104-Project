<!DOCTYPE html>
<?php session_start(); ?>
<?php $_SESSION['username'] = null ?>
	<html>
		<head>
		
			<meta charset="utf-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<meta name="viewport" content="width=device-width, initial-scale=1">
		
			<title>Main Login</title>

			<?php require_once('includes/helpers.php'); ?>
			
			<?php 
			  echo loadResources(array('css/nav.css', 'css/login.css', 'css/toastr.css'),
			  array('js/functions.js', 'js/jquery.min.js', 'js/toastr.js')) 
			?>
			
			<?php //check_session() ?>

		</head>
		
		<body>

		<!-- stayhi db connection  -->
		<?php //include './includes/stayhidb_conn.php'; ?>


		<!-- <form action="./controller/proc_signin.php" method="post"> -->

		<div class="wrapper">

			<!-- Sign In Form-->
			<div class="form">
				<h1>Login</h1>
				<form action="./signin.php" method="post">
					<div class="field-wrap">
						<label>
							Email Address<span class="req">*</span>
						</label>
						<input name="username" type="text" required autocomplete="off"/>
					</div>

					<div class="field-wrap">
						<label>
							Password<span class="req">*</span>
						</label>
						<input name="password" type="password" required autocomplete="off"/>
					</div>

					<br/>

					<button type="submit" class="button button-block">
						Login
					</button>

					<br/>
					<button type="submit" class="button button-block" id="register">
						Register
					</button>

				</form>
				<!-- End of Sign in form -->
			</div>
		</div>

		<!-- footer  -->
		<footer></footer>
		
		</body>
        <script>
            $('#register').click(function(e){
                e.preventDefault();
                window.location.replace("http://localhost/bus_system/register.php");
            })
        </script>
	</html>


