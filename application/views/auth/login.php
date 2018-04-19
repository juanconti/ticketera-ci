<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<head>
	<title>Login</title>
	<link rel="stylesheet" href="<?=base_url('public/css/_login.css')?>">
	<link rel="stylesheet" href="<?=base_url('public/css/bootstrap.min.css')?>">
</head>

<body>

	<div class="container-fluid">
	<?php if(isset($error)):?>
	<div class="row">
	<div class="col-lg-4 offset-lg-4 col-md-12 alert-error-msj">
		<div class="alert alert-danger" role="alert">
			<?=$error?>
		</div>
	</div>
	</div>
	<?php endif?>
	<div class="row align-items-center h-100">
		<div class="col-lg-4 offset-lg-4 col-md-10 offset-md-1">
			<div class="login-container">
				<div class="login-header">
						<h3>Log In</h3>
						<hr>
				</div>
				<form name="login" method="POST" action="<?=base_url('auth/login_post')?>" class="form-horizontal">
					<div class="row login-form">
						<div class="col-lg-12 form-group input-username">
							<label for="username">Usuario</label>
							<input type="text" name="username" class="form-control" placeholder="Usuario" required autofocus>
						</div>
						<div class="col-lg-12 form-group input-password">
							<label for="password">Contraseña</label>
							<input type="password" name="password" class="form-control" placeholder="Contraseña" required>
						</div>
						<div class="col-lg-12 btn-submit">
								<button class="btn btn-outline-primary btn-lg btn-block" type="submit">Ingresar</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	</div>

</body>
