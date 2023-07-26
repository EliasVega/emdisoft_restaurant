@if (Auth::user()->role_id != 4)
    <a href="{{ route('show_sale_box', $id) }}"
    class="btn btn-verde" data-toggle="tooltip" data-placement="top" title="Caja"><i class="fas fa-cash-register"></i>
    </a>
@endif





