@extends("layouts.admin")
@section('titulo')
    {{ config('app.name', 'Ecounts') }}
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">Editar producto:  {{ $rawMaterial->name }}</h3>
                </div>
                @if (count($errors)>0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
    {!!Form::model($rawMaterial, ['method'=>'PATCH','route'=>['rawMaterial.update', $rawMaterial->id]])!!}
    {!!Form::token()!!}
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            @include('admin/raw_material.form')
        </div>
    {!!Form::close()!!}
@endsection
