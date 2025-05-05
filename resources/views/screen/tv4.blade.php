@php use Illuminate\Support\Facades\Storage; @endphp
@extends('layouts.layout')
@section('title', ucfirst($pageName).' P4')

@section('content')
  <div class="dynamic-banner">
    <div class="banner-text" id="dynamicContent">Cargando...</div>
  </div>

  <div class="media-wrapper">
    <div class="carousel-container" id="carousel" data-page-name="{{ $pageName }}">
      @forelse($imagenes as $imagen)
        <div class="carousel-item-tv {{ $loop->first ? 'active':'' }}">
          <img src="data:image/jpeg;base64,{{ $imagen }}" alt="">
        </div>
      @empty
        <div class="carousel-item-tv active">No hay imágenes.</div>
      @endforelse
    </div>
    <div class="video-section">
      @if($promoVideo = \DB::table('promos')->where('nombre',$pageName)->value('video'))
        <video class="video-frame" autoplay muted loop>
          <source src="{{ \Illuminate\Support\Facades\Storage::url($promoVideo) }}" type="video/mp4">
        </video>
      @else
        <div class="video-placeholder">Video no disponible</div>
      @endif
    </div>
  </div>
@endsection

@push('styles')
  @vite(['resources/css/screen/tv4.css'])
@endpush

@push('scripts')
  @vite(['resources/js/screen/tv4.js'])
@endpush
