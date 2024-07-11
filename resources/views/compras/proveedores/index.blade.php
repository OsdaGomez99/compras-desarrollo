@extends('./layouts/app')

@section('titulo', 'Proveedores')

@section('titulo-pagina', 'Proveedores')

@section('buscar')
    @livewire('busqueda-component', ['modulo' => 'proveedor'])
@endsection

@section('button')
<div>
    <x-boton.boton-agregar link="{{route('proveedores.create')}}" title="Agregar proveedor" />
</div>
<x-boton.boton-retroceder />
@endsection

@section('contenido')
    @livewire('compras.proveedores.proveedores-component')
@endsection


