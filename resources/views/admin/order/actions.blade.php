
@if ($status == 'pendiente')
    <a href="{{ route('order.edit', $id) }}" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Editar">
        <i class="far fa-edit"></i>
    </a>
    <a href="{{ route('show_invoicy', $id) }}" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Facturar Pedido"><i class="fas fa-receipt"></i>
    </a>
@endif
<a href="{{ route('order.show', $id) }}" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Ver Pedido" >
        <i class="far fa-eye"></i>
</a>
<a href="{{ route('orderPdf', $id) }}" class="btn btn-red" target="blanck" data-toggle="tooltip" data-placement="top" title="pdf Pedido" >
    <i class="fas fa-file-pdf"></i>
</a>
<a href="{{ route('orderPost', $id) }}" class="btn btn-blank" target="blanck" data-toggle="tooltip" data-placement="top" title="post Pedido" >
    <i class="fas fa-receipt"></i>
</a>
@if ($status == 'pendiente')
    <a href="{{ route('eliminar', $id) }}" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar Pedido" >
        <i class="fas fa-trash"></i>
    </a>
@endif

