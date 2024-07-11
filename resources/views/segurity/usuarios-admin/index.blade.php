@extends('./layouts/app')

@section('titulo', 'Usuarios')

@section('titulo-pagina', 'Usuarios')

@section('buscar')
    @livewire('busqueda-component', ['modulo' => 'usuario'])
@endsection

@section('button')
    @livewire('segurity.usuarios.modal-usuarios-admin-component')
    <x-boton.boton-retroceder />
@endsection

@section('contenido')
    @livewire('segurity.usuarios.usuarios-admin-component')
@endsection


