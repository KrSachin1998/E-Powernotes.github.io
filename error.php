<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<title>Page not found</title>

	<!-- Google font -->
	<link href="https://fonts.googleapis.com/css?family=Nunito:400,700" rel="stylesheet">

	<!-- Custom stlylesheet -->
	<link type="text/css" rel="stylesheet" href="css/style-error.css" />


</head>

<body>

	<div id="notfound">
		<div class="notfound">
			<div class="notfound-404"></div>
			<?php
				if(isset($_GET["np"])){
			?>

			<h2>Javascript disabled</h2>
			<p>Your browser does't support javascript or may be turned off. You have to enable it to use this website</p>					

				<?php }else{	?>

			<h1>404</h1>
			<h2>Oops! Page Not Be Found</h2>
			<p>Something went wrong our engineers are working on it, sorry for inconvenience</p>
			<a href="index.php">Back to homepage</a>
				<?php } ?>
		</div>
	</div>

</body>

</html>
