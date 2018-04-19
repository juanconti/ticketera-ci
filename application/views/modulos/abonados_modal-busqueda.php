<!-- Modal de busqueda de abonados -->
<div class="modal fade" id="modal_detalleAbonado" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
		<div class="modal-body">
			<div class="detalle_abonado">
				<div class="row">
					<div class="col-sm-6">
						<dl>
						  <dt>ID</dt><dd id="detalle_abonado_id">PlaceHolder</dd>
						</dl>
					</div>
					<div class="col-sm-6">
						<dl>
						  <dt>Descripcion</dt><dd id="detalle_abonado_descripcion">PlaceHolder</dd>
						</dl>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<dl>
						  <dt>Telefono</dt><dd id="detalle_abonado_telefono">PlaceHolder</dd>
						</dl>
					</div>
					<div class="col-sm-6">
						<dl>
						  <dt>E-Mail</dt><dd id="detalle_abonado_email">PlaceHolder</dd>
						</dl>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<dl>
						  <dt>CUIT</dt><dd id="detalle_abonado_cuit">PlaceHolder</dd>
						</dl>
					</div>
					<div class="col-sm-6">
						<dl>
						  <dt>Razon Social</dt><dd id="detalle_abonado_razonsocial">PlaceHolder</dd>
						</dl>
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="button" class="btn btn-primary btn_selecciona_abonado" style="display: none">Seleccionar</button>
		</div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript" src="<?=base_url('/public/js/_busquedaAbonados.js')?>"></script>