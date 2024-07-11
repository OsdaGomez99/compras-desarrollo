@extends('./layouts/app')

@section('titulo', 'Requisiciones')

@section('titulo-pagina', 'Requisiciones')

@section('buscar')
    @livewire('busqueda-component', ['modulo' => 'req'])
@endsection

@section('button')
<div class="dropdown">
    <x-boton.boton-agregar-tipo title="Agregar requisición" />
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="{{route('requisiciones.crear', 'BIENES')}}">Req. de Bienes</a>
            <a class="dropdown-item" href="{{route('requisiciones.crear', 'SERVICIOS')}}">Req. de Servicios</a>
      </div>
</div>
    <x-boton.boton-retroceder />
@endsection

@section('contenido')
    @livewire('compras.requisiciones.requisiciones-component')
@endsection


