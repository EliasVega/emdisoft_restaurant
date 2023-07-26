@if($state != 'locked')
    <a class="btn bg-primary" href="{{ route('voucher_type.edit', $id) }}" title="Editar">
        <i class="fas fa-edit fa-fw"></i>
    </a>
    <a class="btn btn-danger" href="" data-target="#modal-delete-{{ $id }}" data-toggle="modal" title="Eliminar">
        <i class="fas fa-trash fa-fw"></i>
    </a>
    @include('admin.voucher_type.delete', ['id' => $id])
@else
    <h5><span class="badge badge-secondary">Bloqueado <i class="fas fa-lock fa-fw"></i></span></h5>
@endif
