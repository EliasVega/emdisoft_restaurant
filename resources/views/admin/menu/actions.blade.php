
<a href="{{ route('menu.edit', $id) }}" class="btn btn-warning" data-toggle="tooltip"
data-placement="top" title="Editar"><i class="far fa-edit"></i></a>
<a href="{{ route('menu.show', $id) }}" class="btn btn-success" data-toggle="tooltip"
data-placement="top" title="Ver Menu">
    <i class="far fa-eye"></i></a>
@if ($status == 'active')
    <a href="{{ route('menuStatus', $id) }}" class="btn btn-verde" data-toggle="tooltip"
    data-placement="top" title="Desactivar"><i class="fas fa-icons"></i></a>
@else
    <a href="{{ route('menuStatus', $id) }}" class="btn btn-danger" data-toggle="tooltip"
    data-placement="top" title="Activar"><i class="fas fa-icons"></i></a>
@endif
