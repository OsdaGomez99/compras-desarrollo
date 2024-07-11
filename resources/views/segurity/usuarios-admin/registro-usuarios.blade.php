@extends('./layouts/app')

@isset($id)
    @section('titulo', 'Edición de Usuario')
    @section('titulo-pagina', 'Edición de Usuarios')
@else
    @section('titulo', 'Registro Usuario')
    @section('titulo-pagina', 'Registro de Usuarios')
@endisset

@section('descripcion-pagina', '')

@section('contenido')
    @livewire('segurity.usuarios.usuarios-form-component', ['user' => $user ?? null])
@endsection
