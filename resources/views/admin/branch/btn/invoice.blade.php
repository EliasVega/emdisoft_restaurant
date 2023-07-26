@if (Auth::user()->role_id != 4)
    <a href="{{ route('show_invoice', $id) }}"
        class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Ventas"><i class="fas fa-file-export"></i>
    </a>
@endif





