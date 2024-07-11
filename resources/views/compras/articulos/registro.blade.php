@extends('./layouts/app')

@section('titulo', ' Nuevo Artículo')

@section('titulo-pagina', 'Nuevo Artículo')

@isset($id)
    @section('titulo', 'Edición de Artículo')
    @section('titulo-pagina', 'Edición de Artículo')
@else
    @section('titulo', 'Registro de Artículo')
    @section('titulo-pagina', 'Registro de Artículo')
@endisset

@section('button')
    <a href="{{route('articulos.index')}}" class="inline ml-2 btn bg-white btn-round btn-round flaticon-back" title= "Retroceder">
    </a>
@endsection

@section('contenido')
    @livewire('compras.articulos.articulos-form-component', ['id' => $id ?? null])
@endsection
