<a href="{{ route('invoice.edit', $id) }}" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Editar">
    <i class="far fa-edit"></i>
</a>
<a href="{{ route('invoice.show', $id) }}" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Ver Venta" >
    <i class="far fa-eye"></i>
</a>
<a href="{{ route('show_invoice', $id) }}" class="btn btn-limon" data-toggle="tooltip" data-placement="top" title="Factura Electronica">
    <i class="fas fa-file-invoice-dollar"></i>
</a>
<a href="{{ route('show_pay_invoice', $id) }}" class="btn btn-ver" data-toggle="tooltip" data-placement="top" title="Agregar Abono" >
    <i class="fas fa-file-invoice-dollar"></i>
</a>
<a href="{{ route('show_pdf_invoice', $id) }}" class="btn btn-red" target="_blank" data-toggle="tooltip" data-placement="top" title="Factura de venta pdf" >
    <i class="fas fa-file-pdf"></i>
</a>
<a href="{{ route('post', $id) }}" class="btn btn-dark" target="_blank" data-toggle="tooltip" data-placement="top" title="pdf Post" >
    <i class="fas fa-file-invoice-dollar"></i>
</a>
