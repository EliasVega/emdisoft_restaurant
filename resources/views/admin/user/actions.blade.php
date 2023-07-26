<a href="{{ route('user.edit', $id) }}"
    class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Editar"><i class="far fa-edit"></i>
</a>
<a href="{{ route('status', $id) }}"
    class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Desactivar"><i class="fas fa-user"></i>
</a>
<a href="{{ route('show_code', $id) }}"
    class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Autorizar"><i class="fas fa-key"></i>
</a>
