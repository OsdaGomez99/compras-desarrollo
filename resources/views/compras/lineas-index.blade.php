@extends('./layouts/app')

@section('titulo', 'Líneas')

@section('titulo-pagina', 'Líneas')

@section('buscar')
    @livewire('busqueda-component', ['modulo' => 'linea'])
@endsection

@section('button')
    @livewire('compras.lineas.lineas-form-component')
    <x-boton.boton-retroceder />
@endsection

@section('contenido')
    @livewire('compras.lineas.lineas-component')
@endsection


