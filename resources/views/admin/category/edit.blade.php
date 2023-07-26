@extends("layouts.admin")
@section('titulo')
    {{ config('app.name', 'Ecounts') }}
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">Editar categoria:&nbsp;&nbsp;&nbsp;&nbsp;  {{ $category->name }}</h3>
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
            {!!Form::model($category, ['method'=>'PATCH','route'=>['category.update', $category->id]])!!}
            {!!Form::token()!!}
                <div class="box-body row">
                    <div class="col-lg-4 col-md-8 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="name">category</label>
                            <input type="text" name="name" class="form-control" value="{{ $category->name }}">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="iva">IVA</label>
                            <input type="number" name="iva" class="form-control" value="{{ $category->iva }}">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="utility">Utilidad</label>
                            <input type="number" name="utility" class="form-control" value="{{ $category->utility }}">
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="description">Descripcion de la category</label>
                            <input type="text" name="description" class="form-control" value="{{ $category->description }}">
                        </div>
                    </div>


                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <button class="btn btn-primary btn-md" type="submit"><i class="fa fa-pencil-alt"></i>&nbsp; Actualizar</button>
                            <a href="{{ url('category') }}" class="btn btn-danger"><i class="fa fa-window-close"></i>&nbsp; Cancelar</a>
                        </div>
                    </div>
                </div>
            {!!Form::close()!!}
        </div>
    </div>
</div>
@endsection
