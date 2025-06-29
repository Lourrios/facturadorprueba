@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Bienvenidos!</h1>
@stop

@section('content')

            
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">                          
                                <div class="row">
                                    <div class="col-md-4 col-xl-4">
                                    
                                    <div class="card bg-c-blue order-card">
                                            <div class="card-block">
                                            <h5>Usuarios</h5>                                               
                                                @php
                                                 use App\Models\User;
                                                $cant_usuarios = User::count();                                                
                                                @endphp
                                                <h2 class="text-right"><i class="fa fa-users f-left"></i><span>{{$cant_usuarios}}</span></h2>
                                                <p class="m-b-0 text-right"><a href="/usuarios" class="text-black">Ver más</a></p>
                                            </div>                                            
                                        </div>                                    
                                    </div>
                                    
                                    <div class="col-md-4 col-xl-4">
                                        <div class="card bg-c-green order-card">
                                            <div class="card-block">
                                            <h5>Roles</h5>                                               
                                                @php
                                                use Spatie\Permission\Models\Role;
                                                 $cant_roles = Role::count();                                                
                                                @endphp
                                                <h2 class="text-right"><i class="fa fa-user-lock f-left"></i><span>{{$cant_roles}}</span></h2>
                                                <p class="m-b-0 text-right"><a href="/roles" class="text-black">Ver más</a></p>
                                            </div>
                                        </div>
                                    </div>                                                                
                                    
                                               
                        </div>
                    </div>
                </div>
            </div>
        </div>
 
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
   <link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop