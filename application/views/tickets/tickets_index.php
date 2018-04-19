<link rel="stylesheet" href="<?=base_url('public/css/_tickets.css')?>">

<?php if(isset($error)):?>
	<div class="row">
		<div class="error">
			<div class="alert alert-danger alert-dismissible" role="alert">
				 <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<?=$error?>
			</div>
		</div>
	</div>
<?php endif?>

<?php if(isset($feedback)):?>
	<div class="row">
		<div class="feedback">
			<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<?=$feedback?>
			</div>
		</div>
	</div>
<?php endif?>

<div class="row">
	<div class="col-md-6">
		<h3>Tickets Pendientes</h3>
		<div class="tickets-pendientes">
		<?php if(!empty($tkPendUsuario)):?>

				<?php
				foreach ($tkPendUsuario as $ticket)
					$this->view('modulos/tickets_ticket-prev', $ticket);
				?>

				<div class="text-center">
					<a type="button" class="btn btn-link">Ver todos los tickets pendientes</a>
				</div>
		<?php else:?>
				<p>No tiene tickets Pendientes</p>
		<?php endif?>
		</div>
	</div>

	<div class="col-md-6">
		<h3>Tickets Pendientes de <?=$_SESSION['usuario']['sector']['descripcion']?></h3>
		<div class="tickets-recientes">
		<?php if(!empty($tkPendSector)):?>
				<?php
					foreach ($tkPendSector as $ticket)
						$this->view('modulos/tickets_ticket-prev', $ticket);
				?>
				<div class="text-center">
					<a type="button" class="btn btn-link">Ver todos los tickets pendientes de <?=$_SESSION['usuario']['sector']['descripcion']?></a>
				</div>
		<?php else:?>
				<p>No tiene tickets Pendientes de <?=$_SESSION['usuario']['sector']['descripcion']?></p>
		<?php endif?>
		</div>
	</div>
</div>
