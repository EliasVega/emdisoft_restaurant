@extends("layouts.admin")
@section('titulo')
{{ config('app.name', 'Ecounts') }}
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="box-danger">
            <div class="box-header with-border">
                <h4 class="box-title">Agregar Nota Credito Compra {{ $purchase->document }}</h4>
            </div>
            @if (count($errors)>0)
                <div class="alert alert-danger">
                    <ul>
                         @foreach ($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{route('ncpurchase.store')}}" method="POST">
                {{csrf_field()}}
                <div class="row m-1">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        @include('admin/ncpurchase.form_ncpurchase')
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    @include('admin/ncpurchase.script')
@endsection

