@extends('./layouts/app')

@isset($id)
    @section('titulo', 'Edición de Cotización ('. $tipo .')')
    @section('titulo-pagina', 'Edición de Cotización ('. $tipo .')')
@else
    @section('titulo', 'Registro de Cotización ('. $tipo .')')
    @section('titulo-pagina', 'Registro de Cotización ('. $tipo .')')
@endisset

@section('descripcion-pagina', '')

@section('button')
<a href="{{route('cotizaciones.index')}}" class="inline ml-2 btn bg-white btn-round btn-round flaticon-back" title= "Retroceder">
    </a>
@endsection

@section('contenido')
    @livewire('compras.cotizaciones.cotizaciones-form-component', ['id' => $id ?? null, 'tipo' => $tipo ?? null])
@endsection
