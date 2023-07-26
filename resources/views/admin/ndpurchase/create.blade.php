@extends("layouts.admin")
@section('titulo')
{{ config('app.name', 'Ecounts') }}
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="box-danger">
            <div class="box-header with-border">
                <h5 class="box-title">Agregar Nota Debito
                    <a href="{{ route('invoice.index') }}" class="btn btn-bluR btn-sm ml-3"><i class="fas fa-undo-alt mr-2"></i>Regresar</a>
                    <a href="{{ route('branch.index') }}" class="btn btn-redeco btn-sm ml-3"><i class="fas fa-undo-alt mr-2"></i>Inicio</a>
                </h5>
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
            <form action="{{route('ndpurchase.store')}}" method="POST">
                {{csrf_field()}}
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="nd">
                    @include('admin/ndpurchase.form_nd')
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@include('admin/ndpurchase.script')
@endsection
