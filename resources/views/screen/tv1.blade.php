@php use Illuminate\Support\Facades\Storage; @endphp

@extends('layouts.layout')

@section('title', ucfirst($pageName) . ' P1')

@section('content')
    <div class="dynamic-banner">
        <div class="banner-text" id="dynamicContent">Cargando...</div>
    </div>

    <div class="carousel-container" id="carousel" data-page-name="{{ $pageName }}">
        @forelse ($imagenes as $imagen)
            <div class="carousel-item-tv">
                <img src="data:image/jpeg;base64,{{ $imagen }}" alt="Imagen de {{ $pageName }}">
            </div>
        @empty
            <div class="carousel-item-tv">
                <h2 class="text-center text-white">No hay imágenes disponibles.</h2>
            </div>
        @endforelse
    </div>
@endsection

@push('styles')
    @vite(['resources/css/screen/tv1.css'])
@endpush

@push('scripts')
    @vite(['resources/js/screen/tv1.js'])
@endpush
