@extends("layouts.admin")
@section('titulo')
{{ config('app.name', 'Ecounts') }}
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="box-danger">
            @if (count($errors)>0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <form action="{{route('purchase.store')}}" method="POST">
                {{csrf_field()}}
                <div class="row m-1">
                    <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                        @include('admin/purchase.form_purchase')
                    </div>

                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                        @include('admin/purchase.form_pay')
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--Inicio del modal cliente-->
@include('admin/purchase.supplier')
<!--Fin del modal-->
@endsection
@section('scripts')
    @include('admin/purchase.script')
    @include('admin/purchase.script_pay')
@endsection
