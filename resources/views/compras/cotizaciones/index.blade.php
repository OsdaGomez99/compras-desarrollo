@extends('./layouts/app')

@section('titulo', 'Cotizaciones')

@section('titulo-pagina', 'Cotizaciones')

@section('buscar')
    @livewire('busqueda-component', ['modulo' => 'cot'])
@endsection

@section('button')
<div class="dropdown">
    <x-boton.boton-agregar-tipo title="Agregar cotización" />
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <a class="dropdown-item" href="{{route('cotizaciones.crear', 'BIENES')}}">Cot. de Bienes</a>
        <a class="dropdown-item" href="{{route('cotizaciones.crear', 'SERVICIOS')}}">Cot. de Servicios</a>
      </div>
</div>
    <x-boton.boton-retroceder />
@endsection

@section('contenido')
    @livewire('compras.cotizaciones.cotizaciones-component')
    @livewire('compras.cotizaciones.modal-proveedores-component')
@endsection
