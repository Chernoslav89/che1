<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/reset.css">
	<link rel="stylesheet" href="css/style.css">
	<script src="js/jquery-3.1.1.min.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>

</head>
<body>
<div class="wrapper">
	<header class="head">
		<div class="container">
			<div class="row">
				<nav class="col-sm-5 navigation">
					<menu class="headMain">
						<li><a class="" href="products.php">Main</a></li>
						<li><a class="" href="cabinet.php">Account</a></li>
					</menu>
				</nav>

				<div class="col-sm-3 support">
					<p><a href="#">

							<span class="glyphicon glyphicon-usd" aria-hidden="true"></span>
							Баланс: <?php echo "{price}";?> грн</a>
					</p>
				</div>
				<div class="col-sm-2 support">
					<p>
						<a href="#">
							<span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>

							<?php echo "{Count}";?> шт.
						</a>
					</p>
				</div>
				<div class="col-sm-2 support">
					<p>
						<a href="login.php">
							<span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>
							Вихід
						</a>
					</p>
				</div>
			</div>
		</div>
	</header>