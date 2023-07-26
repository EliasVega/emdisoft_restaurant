<div class="box-body row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="form-group">
            <a href="{{ route('pay_purchase.index') }}" class="btn btn-bluR btn-sm ml-3"><i class="fas fa-undo-alt mr-2"></i>Regresar</a>
            <a href="{{ route('branch.index') }}" class="btn btn-redeco btn-sm ml-3"><i class="fas fa-undo-alt mr-2"></i>Inicio</a>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-4 col-xs-12">
        <div class="form-group">
            <label class="form-control-label" for="purchase_id">Compra #</label>
            <input type="number" name="purchase_id" value="{{ $purchase->id }}" id="purchase_id"
                class="form-control blanco" pattern="[0-9]{0,15}" readonly>
        </div>
    </div>
    <div class="col-lg-4 col-md-8 col-sm-8 col-xs-12">
        <div class="form-group">
            <label class="form-control-label" for="supplier_id">Proveedor</label>
            <input type="text" name="supplier_id" value="{{ $purchase->supplier->name }}" class="form-control" id="suplier_id" disabled pattern="[0-9]{0,15}">
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            <label class="form-control-label">Pendiente</label>
            <input type="number" id="pendient" value="{{ $purchase->balance }}" class="form-control" disabled pattern="[0-9]{0,15}">
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            <label class="form-control-label">Fecha</label>
            <input type="text" value="{{ $purchase->created_at }}" class="form-control" disabled pattern="[0-9]{0,15}">
        </div>
    </div>
</div>
