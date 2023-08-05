<a href="{{ route('invoice.show', $id) }}" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Ver Venta" >
    <i class="far fa-eye"></i>
</a>
<a href="{{ route('invoicePdf', $id) }}" class="btn btn-red" target="_blank" data-toggle="tooltip" data-placement="top" title="Factura de venta pdf" >
    <i class="fas fa-file-pdf"></i>
</a>
<a href="{{ route('invoicePost', $id) }}" class="btn btn-dark" target="_blank" data-toggle="tooltip" data-placement="top" title="pdf Post" >
    <i class="fas fa-file-invoice-dollar"></i>
</a>
