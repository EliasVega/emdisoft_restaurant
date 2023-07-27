<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('product') }}" class="brand-link elevation-4">
        <span class="logo-mini"><strong class="titulo-show">P</strong></span>
        <span class="brand-text font-weight-light"><strong>rins</strong> </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            @if (Auth::user()->role_id == 1)
               <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Administracion
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>
                                Localidades Entidades
                                <i class="right fas fa-angle-left"></i>
                            </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('department') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Departamentos</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('municipality') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Municipios</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('bank') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Bancos</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('card') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Tarjetas</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>
                                Dian
                                <i class="right fas fa-angle-left"></i>
                            </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('liability') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Responsabilidades</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('organization') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Organizacion</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('regime') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Regimen</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('discrepancy') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Discrepancias</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('tax') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Impuestos</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>
                                Tipos
                                <i class="right fas fa-angle-left"></i>
                            </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('indicator') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Indicadores</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('document') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>T/Documentos</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('type_document') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Tipo Doc. Dian</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('voucherType') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Tipos de Comprobante</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('generationType') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Tipos de Generacion</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('discrepancy') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Discrepancias</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('unit_measure') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Unidades de Medida</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('payment_form') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Forma Pagos</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('payment_method') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Medios Pagos</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('voucher_type') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Typo de Comprobantes</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
            @endif
            @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2)

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Empresa
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>
                                Compañias
                                <i class="right fas fa-angle-left"></i>
                            </p>
                            </a>
                            <ul class="nav nav-treeview">
                            @if (Auth::user()->role_id == 1)
                                <li class="nav-item">
                                    <a href="{{ url('company') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Empresas</p>
                                    </a>
                                </li>
                            @endif
                                <li class="nav-item">
                                    <a href="{{ url('branch') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Sucursales</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('resolution') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Resoluciones</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>
                                Usuarios
                                <i class="right fas fa-angle-left"></i>
                            </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('user') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Usuarios</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('roles') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Roles</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('verification_code') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Autorizaciones</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>
                                Terceros
                                <i class="right fas fa-angle-left"></i>
                            </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('supplier') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Proveedores</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('customer') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Clientes</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @if (Auth::user()->role_id == 1)
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>
                                Miscelanea
                                <i class="right fas fa-angle-left"></i>
                            </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="{{ url('percentage') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Porcentages</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('retention') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Retefuentes</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif
                    </ul>
                </li>
            @endif
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Operaciones
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>
                                Anticipos y pagos
                                <i class="right fas fa-angle-left"></i>
                            </p>
                            </a>
                            <ul class="nav nav-treeview">
                            @if (Auth::user()->role_id != 5)
                                <li class="nav-item">
                                    <a href="{{ url('payment') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Anticipo a Proveedores</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('pay_purchase') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Abonos a compras</p>
                                    </a>
                                </li>
                            @endif
                            @if (Auth::user()->role_id != 4)
                                <li class="nav-item">
                                    <a href="{{ url('advance') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Anticipo de clientes</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('pay_order') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Abonos Pedidos</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('pay_invoice') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Abonos Facturas</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('cash_out') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Salidas Efectivo</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('cash_in') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Entradas efectivo</p>
                                    </a>
                                </li>
                            @endif
                            </ul>
                        </li>
                        @if (Auth::user()->role_id != 5)
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>
                                Compras
                                <i class="right fas fa-angle-left"></i>
                            </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="{{ url('service') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Servicios</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('supplier') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Proveedores</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('purchase') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Compras</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('ncpurchase') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>NC Compra</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('ndpurchase') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>ND Compra</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('cash_receipt') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Recibos de caja</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('cash_box') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>caja</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif
                        @if (Auth::user()->role_id != 4)
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>
                                Ventas
                                <i class="right fas fa-angle-left"></i>
                            </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('customer') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Clientes</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ url('invoice') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Ventas</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('ncinvoice') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>NC Venta</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('ndinvoice') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>ND Venta</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ url('order') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Pedidos</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('sale_box') }}" class="nav-link">
                                        <i class="far -fa-dot-circle nav-icon"></i>
                                        <p>Caja</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('cash_receipt') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Recibos de caja</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif
                        @if (Auth::user()->role_id != 5)
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>
                                Inventario
                                <i class="right fas fa-angle-left"></i>
                            </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('category') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Categorias</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('product') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Materias Primas</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('menu') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Menu</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('transfer') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Traslados</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
