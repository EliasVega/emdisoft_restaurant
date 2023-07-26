@if (Auth::user()->role_id != 5 )
    <a href="{{ route('show_purchase', $id) }}"
        class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Compras"><i class="fas fa-cart-plus"></i>
    </a>
@endif





