@if (Auth::user()->role_id != 4)

    <a href="{{ route('show_order', $id) }}"
        class="btn btn-lila" data-toggle="tooltip" data-placement="top" title="Pedidos"><i class="far fa-file-alt"></i>
    </a>
@endif





