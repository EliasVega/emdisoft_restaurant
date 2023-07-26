@extends("layouts.admin")
@section('titulo')
{{ config('app.name', 'Ecounts') }}
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="box-danger">
            <div class="box-header with-border">
                <h4 class="box-title">Agregar Datos Software</h4>
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
            <form action="{{route('software.store')}}" method="POST">
                {{csrf_field()}}
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    @include('admin/software.form')
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    @include('admin/software.form_save')
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
