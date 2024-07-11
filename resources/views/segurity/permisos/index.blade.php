@extends('./layouts/app')

@section('titulo', ' - Permisos')

@section('titulo-pagina', 'Permisos')

@section('buscar')
    @livewire('busqueda-component', ['modulo' => 'permisos'])
@endsection

@section('button')
    @livewire('segurity.permisos.modal-permisos-component')
    <x-boton.boton-retroceder />
@endsection

@section('contenido')
    @livewire('segurity.permisos.permisos-component')
@endsection
