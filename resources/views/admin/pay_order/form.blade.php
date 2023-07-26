<div class="box-body row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="form-group">
            <a href="{{ route('pay_order.index') }}" class="btn btn-bluR btn-sm ml-3"><i class="fas fa-undo-alt mr-2"></i>Regresar</a>
            <a href="{{ route('branch.index') }}" class="btn btn-redeco btn-sm ml-3"><i class="fas fa-undo-alt mr-2"></i>Inicio</a>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-4 col-xs-12">
        <div class="form-group">
            <label class="form-control-label requerido" for="order">Pedido #</label>
            <input type="number" value="{{ $orders->id }}" id="order" name="order"
                class="form-control blanco" disabled pattern="[0-9]{0,15}">
        </div>
    </div>
    <div class="col-lg-4 col-md-8 col-sm-8 col-xs-12">
        <div class="form-group">
            <label class="form-control-label">Cliente</label>
            <input type="text" value="{{ $orders->customer->name }}" class="form-control" disabled pattern="[0-9]{0,15}">
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            <label class="form-control-label">Pendiente</label>
            <input type="number" id="pendient" value="{{ $orders->balance }}" class="form-control" disabled pattern="[0-9]{0,15}">
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            <label class="form-control-label">Fecha</label>
            <input type="text" value="{{ $orders->created_at }}" class="form-control" disabled pattern="[0-9]{0,15}">
        </div>
    </div>

</div>
