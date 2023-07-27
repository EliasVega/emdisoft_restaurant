
<a href="{{ route('product.edit', $id) }}" class="btn btn-warning" data-toggle="tooltip"
data-placement="top" title="Editar"><i class="far fa-edit"></i></a>
@if ($status == 'active')
    <a href="{{ route('productStatus', $id) }}" class="btn btn-verde" data-toggle="tooltip"
    data-placement="top" title="Desactivar"><i class="fas fa-icons"></i></a>
@else
    <a href="{{ route('productStatus', $id) }}" class="btn btn-danger" data-toggle="tooltip"
    data-placement="top" title="Activar"><i class="fas fa-icons"></i></a>
@endif
<a href="{{ route('kardex.index') }}" class="btn btn-limon"><i class="fas fa-undo-alt mr-2"></i>Kardex</a>
