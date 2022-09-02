<?php
require_once('includes/load.php');
// Check if user is logged in
if($session->isUserLoggedIn(true)) { redirect('dashboard.php', false);}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>Inventário</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="assets/img/favicon.png">
	<!--===============================================================================================-->
	<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

	<link rel="stylesheet" type="text/css" href="assets/css/login.css">
	<!--===============================================================================================-->
</head>
<body>

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-65">				
				<form method="post" action="auth.php" class="login100-form">
					<div class="text-center">
						<img  width="70" src="assets/img/favicon.png" alt="Inventário">
					</div>
					<span class="login100-form-title p-b-65">
						Inventário
					</span>

					<?= display_msg($msg); ?>

					<div class="wrap-input100">
						<input class="input100" type="name" name="username" placeholder="Usuário" required>
						<span class="focus-input100-1"></span>
						<span class="focus-input100-2"></span>
					</div>

					<div class="wrap-input100">
						<input class="input100" type="password" name="password" placeholder="Senha" required>
						<span class="focus-input100-1"></span>
						<span class="focus-input100-2"></span>
					</div>

					<div class="container-login100-form-btn m-t-20">
						<button type="submit" class="login100-form-btn">
							Entrar
						</button>
					</div>					

				</form>
			</div>
		</div>
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

</body>
</html>