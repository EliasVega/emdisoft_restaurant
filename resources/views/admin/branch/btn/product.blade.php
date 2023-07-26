@if (Auth::user()->role_id != 5 )
    <a href="{{ route('show_product', $id) }}"
        class="btn btn-limon" data-toggle="tooltip" data-placement="top" title="Productos esta Bodega"><i class="fas fa-box-open"></i>
    </a>
@endif





