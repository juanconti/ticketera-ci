<script type="text/javascript" src="<?=base_url('public/js/jquery-3.3.1.min.js');?>"></script>
<script type="text/javascript" src="<?=base_url('public/js/popper.min.js');?>"></script>
<script type="text/javascript" src="<?=base_url('public/js/bootstrap.min.js');?>"></script>
<script type="text/javascript" src="<?=base_url('public/js/helpers.js');?>"></script>

<?php
	if($scripts !== null):
		for($i=0;count($scripts)>$i;$i++):?>
	<script type="text/javascript"  src="<?=base_url('public/js/'.$scripts[$i]);?>"></script>
<?php
		endfor;
	endif;
?>