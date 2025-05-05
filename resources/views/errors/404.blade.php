@extends('layouts.layout')

@section('title', 'Página no encontrada')

@section('content')
    <div style="padding: 100px 20px; color: #fff; text-align: center;">
        <h1 style="font-size: 80px; color: #3490dc;">404</h1>
        <p style="font-size: 24px;">La página que buscas no existe.</p>
        <a href="{{ url('/') }}" style="color: #3490dc; text-decoration: none; font-weight: bold; font-size: 18px;">
            Volver al inicio
        </a>
    </div>
@endsection
