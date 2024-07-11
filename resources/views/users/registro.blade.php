@extends('./layouts/app')

@section('titulo', ' - Registro Usuario')

@section('titulo-pagina', 'Registro de Usuarios')

@section('descripcion-pagina', '')

@section('contenido')
    @include('auth.register')
@endsection
