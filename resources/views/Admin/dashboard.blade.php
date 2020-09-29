@extends('admin.partials.app-dashboard')
@section('main-content')
<div class="row">
</div>
<!-- Modals -->
<div class="modal fade show" id="modal-new-product">
  <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header"></div>
        <div class="modal-body"></div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" style="float: left; float: left!important;" data-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-primary" data-dismiss="modal">Guardar</button>
        </div>
      </div>
  </div>
</div>
@endsection
