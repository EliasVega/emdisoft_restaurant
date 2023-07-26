@extends("layouts.admin")
@section('titulo')
{{ config('app.name', 'Ecounts') }}
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="box-danger">
            <div class="box-header with-border">
                <h3 class="box-title mr-10">Editar Usuario: &nbsp;&nbsp;&nbsp;&nbsp;{{ $user->name }}</h3>
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
            {!!Form::model($user, ['method'=>'PATCH','route'=>['user.update', $user->id]])!!}
            {!!Form::token()!!}
            <form class="form-horizontal">
                <div class="card-body">
                    <div class="row">
                        <div class="row box-body">
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="branch_id">Sucursal</label>
                                    <select name="branch_id" class="form-control" id="branch_id">
                                        @foreach($branches as $bra)
                                        @if($bra->id == $user->branch_id)
                                        <option value="{{ $bra->id }}" selected>{{ $bra->name }}</option>
                                        @else
                                        <option value="{{ $bra->id }}">{{ $bra->name }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="name">Nombre</label>
                                    <input type="text" name="name"  class="form-control"
                                        value="{{ $user->name }}" placeholder="Nombre">
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="document_id">Tipo Identificacion</label>
                                    <select name="document_id" class="form-control" id="document_id">
                                        @foreach($documents as $doc)
                                        @if($doc->id == $user->document_id)
                                        <option value="{{ $doc->id }}" selected>{{ $doc->name }}</option>
                                        @else
                                        <option value="{{ $doc->id }}">{{ $doc->name }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="number">Numero de Identificacion</label>
                                    <input type="text" name="number" value="{{ $user->number }}" class="form-control"
                                        placeholder="Numero del Documento">
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="address">Direccion Residencia</label>
                                    <input type="text" name="address" value="{{ $user->address }}"
                                        class="form-control" placeholder="Direccion de residencia">
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="phone">Telefono</label>
                                    <input type="text" name="phone" value="{{ $user->phone }}"
                                        class="form-control" placeholder="Numero de Telefono">
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="email">E-Mail</label>
                                    <input id="email" type="email" value="{{ $user->email }}"
                                        class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                        name="email" value="" placeholder="Email" required>
                                    @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="password">Contraseña</label>
                                    <input id="password" type="password"
                                        class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                        name="password" placeholder="Password" required>
                                    @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="password-confirm" class="col-md-12 col-form-label">Confirmar
                                        Contraseña</label>
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" placeholder="Confirmar Password" required>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="position">Cargo</label>
                                    <input type="text" name="position" value="{{ $user->position }}" class="form-control"
                                        placeholder="Cargo">
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="role_id">Rol</label>
                                    <select name="role_id" class="form-control" id="role_id">
                                        @foreach($roles as $rol)
                                        @if($rol->id == $user->role_id)
                                        <option value="{{ $rol->id }}" selected>{{ $rol->role }}</option>
                                        @else
                                        <option value="{{ $rol->id }}">{{ $rol->role }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <div class="radio">
                                    <h4>Traslados</h4>

                                    <input type="radio" name="transfer" value="1" id="SI">
                                    <label for="transfer">Autorizado</label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="radio" name="transfer" value="0" id="NO">
                                    <label for="transfer">No Autorizado</label>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <button class="btn btn-primary" type="submit">Guardar</button>
                                    <a href="{{url('user')}}" class="btn btn-danger">Cancelar</a>
                                </div>
                            </div>
                        </div>
                    </div>
            </form>
            {!!Form::close()!!}
        </div>
    </div>
</div>
@endsection
