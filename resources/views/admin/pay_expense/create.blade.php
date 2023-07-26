@extends("layouts.admin")
@section('titulo')
{{ config('app.name', 'Ecounts') }}
@endsection
@section('content')
<div class="row">
    <div class="col-12 col-md-12">
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
            <form action="{{route('pay_expense.store')}}" method="POST">
                {{csrf_field()}}
                <div class="row m-1">
                    <div class="col-12 col-md-12">
                        @include('admin/pay_expense.form')
                    </div>
                    <div class="col-12 col-md-12">
                        @include('admin/pay_expense.form_pay')
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    @include('admin/pay_expense.script')
@endsection
