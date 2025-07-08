@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Bienvenidos!</h1>
@stop

@section('content')
 
      <div class="section-body">
    <div class="row">
        {{-- Usuarios --}}
        <div class="col-md-4 col-xl-4">
            <div class="card bg-c-blue order-card">
                <div class="card-block">
                    <h5>Usuarios</h5>
                    @php use App\Models\User; $cant_usuarios = User::count(); @endphp
                    <h2 class="text-right"><i class="fa fa-users f-left"></i><span>{{ $cant_usuarios }}</span></h2>
                    <p class="m-b-0 text-right"><a href="/usuarios" class="text-white">Ver más</a></p>
                </div>
            </div>
        </div>

        {{-- Roles --}}
        <div class="col-md-4 col-xl-4">
            <div class="card bg-c-green order-card">
                <div class="card-block">
                    <h5>Roles</h5>
                    @php use Spatie\Permission\Models\Role; $cant_roles = Role::count(); @endphp
                    <h2 class="text-right"><i class="fa fa-user-lock f-left"></i><span>{{ $cant_roles }}</span></h2>
                    <p class="m-b-0 text-right"><a href="/roles" class="text-white">Ver más</a></p>
                </div>
            </div>
        </div>

        {{-- Clientes --}}
        <div class="col-md-4 col-xl-4">
            <div class="card bg-c-yellow order-card">
                <div class="card-block">
                    <h5>Clientes</h5>
                    @php use App\Models\Cliente; $cant_clientes = Cliente::count(); @endphp
                    <h2 class="text-right"><i class="fa fa-address-book f-left"></i><span>{{ $cant_clientes }}</span></h2>
                    <p class="m-b-0 text-right"><a href="/clientes" class="text-white">Ver más</a></p>
                </div>
            </div>
        </div>

        {{-- Facturas --}}
        <div class="col-md-4 col-xl-4">
            <div class="card bg-c-red order-card">
                <div class="card-block">
                    <h5>Facturas</h5>
                    @php use App\Models\Factura; $cant_facturas = Factura::count(); @endphp
                    <h2 class="text-right"><i class="fa fa-file-invoice-dollar f-left"></i><span>{{ $cant_facturas }}</span></h2>
                    <p class="m-b-0 text-right"><a href="/facturas" class="text-white">Ver más</a></p>
                </div>
            </div>
        </div>

        {{-- Pagos --}}
        <div class="col-md-4 col-xl-4">
            <div class="card bg-c-brown order-card">
                <div class="card-block">
                    <h5>Pagos</h5>
                    @php use App\Models\Pago; $cant_pagos = Pago::count(); @endphp
                    <h2 class="text-right"><i class="fa fa-money-bill-wave f-left"></i><span>{{ $cant_pagos }}</span></h2>
                    <p class="m-b-0 text-right"><a href="/pagos" class="text-white">Ver más</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

 
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
   <link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
   @stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop