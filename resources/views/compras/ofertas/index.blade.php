@extends('./layouts/app')

@section('titulo', 'Ofertas de Proveedores')

@section('titulo-pagina', 'Ofertas de Proveedores')

@section('buscar')
    @livewire('busqueda-component', ['modulo' => 'oferta'])
@endsection

@section('button')
    <x-boton.boton-retroceder />
@endsection

@section('contenido')
    @livewire('compras.ofertas.ofertas-component')
@endsection


