<a href="{{ route('expense.edit', $id) }}" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Editar" >
    <i class="far fa-edit"></i>
</a>
<a href="{{ route('expense.show', $id) }}" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Ver Gasto" >
    <i class="far fa-eye"></i>
</a>
<a href="{{ route('show_pdf_expense', $id) }}"class="btn btn-ver" target="_blank" data-toggle="tooltip" data-placement="top" title="Gasto pdf">
    <i class="fas fa-file-pdf"></i>
</a>
<a href="{{ route('post_expense', $id) }}" class="btn btn-ver" target="_blank" data-toggle="tooltip" data-placement="top" title="pdf Post" >
    <i class="fas fa-receipt"></i>
</a>
