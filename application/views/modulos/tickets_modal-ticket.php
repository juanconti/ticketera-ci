<!-- Modal de detalle de ticket previo -->
<div class="modal fade" id="modal_detalleTkPrevio" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h4>Detalle de Ticket Anterior</h4>
		</div>
		<div class="modal-body">
			<div class="detalle_tkPrevio">
				<div class="row">
					<div class="col-sm-6">
						<dl>
							<dt>ID</dt>
							<dd><?=$ticket['relacion']?></dd>
						</dl>
					</div>
					<div class="col-sm-6">
						<dl>
							<dt>Titulo</dt>
							<dd><span id="ticket_prev_titulo"></span></dd>
						</dl>
					</div>
					<div class="col-md-12">
						<label>Cuerpo</label>
						<textarea class="form-control" id="ticket_prev_cuerpo" style="resize:none;" disabled></textarea>
					</div>
				</div>
			</div>
		</div>
	</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->