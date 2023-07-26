@if (Auth::user()->role_id != 5 )
    <a href="{{ route('show_prePurchase', $id) }}"
        class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Precompra"><i class="fas fa-cart-plus"></i>
    </a>
@endif





