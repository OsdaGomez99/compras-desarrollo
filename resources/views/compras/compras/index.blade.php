@extends('./layouts/app')

@section('titulo', 'Compras')

@section('titulo-pagina', 'Compras')

@section('buscar')
    @livewire('busqueda-component', ['modulo' => 'compra'])
@endsection

@section('button')
<div class="dropdown">
    <x-boton.boton-agregar-tipo title="Agregar compra" />
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <a class="dropdown-item" href="{{route('compras.crear', 'BIENES')}}">Compra de Bienes</a>
        <a class="dropdown-item" href="{{route('compras.crear', 'SERVICIOS')}}">Compra de Servicios</a>
      </div>
</div>
    <x-boton.boton-retroceder />
@endsection

@section('contenido')
    @livewire('compras.compras.compras-component')
@endsection

