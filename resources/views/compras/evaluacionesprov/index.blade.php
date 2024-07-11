@extends('./layouts/app')

@section('titulo', 'Evaluaciones de Proveedores')

@section('titulo-pagina', 'Evaluaciones de Proveedores')

@section('buscar')
    @livewire('busqueda-component', ['modulo' => 'usuario'])
@endsection

@section('button')
<div>
    <x-boton.boton-agregar link="{{route('evaluacionesprov.create')}}" title="Agregar evaluación de proveedor" />
</div>
<x-boton.boton-retroceder />
@endsection

@section('contenido')
    @livewire('compras.evaluaciones-prov-component')
@endsection

