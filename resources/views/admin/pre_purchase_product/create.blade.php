@extends("layouts.admin")
@section('titulo')
{{ config('app.name', 'EmdisoftPro') }}
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
            {!!Form::open(array('url'=>'prePurchaseProduct', 'method'=>'POST', 'autocomplete'=>'off'))!!}
            {!!Form::token()!!}
            <div class="row m-1">
                <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                    @include('admin/pre_purchase_product.form_pre_purchase')
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                    @include('admin/pre_purchase_product.form_pay')
                </div>
            </div>
            {!!Form::close()!!}
        </div>
    </div>
</div>
@endsection
@section('scripts')
    @include('admin/pre_purchase_product.script')
    @include('admin/pre_purchase_product.script_pay')
@endsection
