@extends('./layouts/app')

@section('titulo', 'Artículos')

@section('titulo-pagina', 'Artículos')

@section('buscar')
    @livewire('busqueda-component', ['modulo' => 'articulo'])
@endsection

@section('button')
<div>
    <x-boton.boton-agregar link="{{route('articulos.create')}}" title="Agregar artículo" />
</div>
    <x-boton.boton-retroceder />
@endsection

@section('contenido')
    @livewire('compras.articulos.articulos-component')
@endsection


