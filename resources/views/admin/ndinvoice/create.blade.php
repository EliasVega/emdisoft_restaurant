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
            <form action="{{route('ndinvoice.store')}}" method="POST">
                {{csrf_field()}}
                <div class="row m-1">
                    <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                        @include('admin/ndinvoice.form_ndinvoice')
                    </div>

                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                        @include('admin/ndinvoice.form_pay')
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    @include('admin/ndinvoice.script')
@endsection

