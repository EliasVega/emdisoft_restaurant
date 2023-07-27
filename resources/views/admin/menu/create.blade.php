@extends("layouts.admin")
@section('titulo')
    {{ config('app.name', 'Ecounts') }}
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">Nuevo Producto</h3>
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
            {!!Form::open(array('url'=>'menu', 'method'=>'POST', 'autocomplete'=>'off', 'files' => 'true'))!!}
            {!!Form::token()!!}
                @if ($indicator->restaurant == 'off')
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        @include('admin/menu.form')
                    </div>
                @else
                    <div class="row">
                        <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                            @include('admin/menu.form')
                        </div>
                        <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                            @include('admin/menu.form_product')
                        </div>
                    </div>
                @endif
            {!!Form::close()!!}
        </div>
    </div>
</div>
@endsection
@section('scripts')
    @include('admin/menu.script')
@endsection
