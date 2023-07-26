@extends("layouts.admin")
@section('titulo')
    {{ config('app.name', 'Ecounts') }}
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-condensed table-hover">
                <thead>
                    <tr class="bg-success">
                        <th>Id</th>
                        <th>Departamento</th>
                        <th>Municipio</th>
                        <th>comresa</th>
                        <th>NIT</th>
                        <th>dv</th>
                        <th>Logo</th>
                        @if (Auth::user()->role_id == 1)
                        <th>Ingresar</th>
                        <th>Editar</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($companies as $com)
                        <tr>
                            <td>{{ $com->id }}</td>
                            <td>{{ $com->department->name }}</td>
                            <td>{{ $com->municipality->name }}</td>
                            <td>{{ $com->name }}</td>
                            <td>{{ $com->nit }}</td>
                            <td>{{ $com->dv }}</td>
                            <td>
                                <img src="{{ $com->logo }}" alt="{{ $com->name }}" style="height:60px; width:80px;" class="img-thumbnail">
                            </td>
                            @if (Auth::user()->role_id == 1)
                            <td>
                                <a href="{{ route('company.show', $com->id) }}" class="btn btn-info btn-sm"> <i class="fa fa-indent"></i> Ingresar </a>
                            </td>
                            <td>
                                <a href="{{ route('company.edit', $com->id) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> Editar</a>
                            </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="section-body">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 col-xl-4">
                            <div class="card bg-c-green order-card">
                                <div class="card-blok">
                                    <h5>Sucursales</h5>
                                    @php
                                        use App\Models\Branch;
                                        $cant_branchs = Branch::count();
                                    @endphp
                                    <h2 class="text-right"><i class="fa fa-users f-left"></i><span>{{ $cant_branchs }}</span></h2>
                                        <p class="m-b-0 text-right"><a href="branch" class="text-white">Ver mas</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-xl-4">
                            <div class="card bg-c-blue order-card">
                                <div class="card-blok">
                                    <h5>Compras hoy</h5>
                                    @php
                                        use App\Models\Purchase;
                                        $purchases = Purchase::whereDay('created_at', '=', date('d'))->sum('total_pay');
                                    @endphp
                                    <h2 class="text-right"><i class="fa fa-users f-left"></i><span>${{ number_format($purchases,2) }}</span></h2>
                                        <p class="m-b-0 text-right"><a href="branch" class="text-white">Ver mas</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-xl-4">
                            <div class="card bg-c-blue2 order-card">
                                <div class="card-blok">
                                    <h5>Ventas hoy</h5>
                                    @php
                                        use App\Models\Invoice;
                                        $invoices = Invoice::whereDay('created_at', '=', date('d'))->sum('total_pay');
                                    @endphp
                                    <h2 class="text-right"><i class="fa fa-users f-left"></i><span>${{ number_format($invoices,2) }}</span></h2>
                                        <p class="m-b-0 text-right"><a href="branch" class="text-white">Ver mas</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-xl-4">
                            <div class="card bg-c-lemon order-card">
                                <div class="card-blok">
                                    <h5>Usuarios</h5>
                                    @php
                                        use App\Models\User;
                                        $users = User::count();
                                    @endphp
                                    <h2 class="text-right"><i class="fa fa-users f-left"></i><span>${{ $users }}</span></h2>
                                        <p class="m-b-0 text-right"><a href="user" class="text-white">Ver mas</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-xl-4">
                            <div class="card bg-c-gray order-card">
                                <div class="card-blok">
                                    <h5>Autorizaciones</h5>
                                    @php
                                        use App\Models\Verification_code;
                                        $permisos = Verification_code::count();
                                    @endphp
                                    <h2 class="text-right"><i class="fa fa-users f-left"></i><span>{{ $permisos }}</span></h2>
                                        <p class="m-b-0 text-right"><a href="verification_code" class="text-white">Ver mas</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-xl-4">
                            <div class="card bg-c-orange order-card">
                                <div class="card-blok">
                                    <h5>Inventarios</h5>
                                    @php
                                        use App\Models\Product;
                                        $products = Product::count();
                                    @endphp
                                    <h2 class="text-right"><i class="fa fa-users f-left"></i><span>{{ $products }}</span></h2>
                                        <p class="m-b-0 text-right"><a href="product" class="text-white">Ver mas</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

