@extends('./layouts/app')

@section('titulo', ' - Roles')

@section('titulo-pagina', 'Roles')

@section('buscar')
    @livewire('busqueda-component', ['modulo' => 'rol'])
@endsection

@section('button')
    @livewire('segurity.roles.modal-roles-component')
    <x-boton.boton-retroceder />
@endsection

@section('contenido')
    @livewire('segurity.roles.roles-component')
@endsection
