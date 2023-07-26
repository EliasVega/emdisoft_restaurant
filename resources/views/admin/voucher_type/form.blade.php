<div class="card-body">
    @include('includes.alerts.form_error')
    <div class="form-group">
        <label for="code">Código</label>
        <input type="text" id="code" name="code" value="{{ old('code', $voucherType->code ?? '') }}" class="form-control" placeholder="Código" required>
    </div>
    <div class="form-group">
        <label for="name">Nombre</label>
        <input type="text" id="name" name="name" value="{{ old('name', $voucherType->name ?? '') }}" class="form-control" placeholder="Nombre" required>
    </div>
    <div class="form-group">
        <label for="consecutive">Consecutivo</label>
        <input type="number" id="consecutive" name="consecutive" value="{{ old('consecutive', $voucherType->consecutive ?? '') }}" placeholder="Consecutivo" class="form-control" require>
    </div>
    <div class="form-group">
        <label for="state">Estado</label>
        <select name="state" id="state" class="form-control" required>
            <option {{ ($voucherType->state ?? '') == '' ? "selected" : "" }} disabled>Seleccionar estado</option>
            <option value="active" {{ old('state', $voucherType->state ?? '') == 'active' ? "selected" : "" }}>Activo</option>
            <option value="inactive" {{ old('state', $voucherType->state ?? '') == 'inactive' ? "selected" : "" }}>Inactivo</option>
        </select>
    </div>
    <div class="form-group">
        <button class="btn btn-primary" type="submit">Guardar</button>
        <a class="btn btn-danger" type="reset" href="{{ route('voucher_types.index') }}">Cancelar</a>
    </div>
</div>
