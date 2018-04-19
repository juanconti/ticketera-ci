<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>

<?=$head?>

	<body>
	<script type="text/javascript">
		const base_url = '<?=base_url()?>'
	</script>
			<?=$nav?>

			<div class="container-fluid main-container">
				<?=$contenido?>
			</div>
			
			<?=$footer?>

			<?=$scripts?>
			
	</body>

</html>
