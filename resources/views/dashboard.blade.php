<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 fw-bold text-dark mb-0">
                {{ __('Panel Administrativo') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-5 bg-light">
        <div class="container">
            <div class="card border-0 shadow rounded-4">
                <div class="card-body p-5 text-center">
                    <h4 class="mb-4">Bienvenido</h4>
                    <p class="mb-5 text-muted">Gestiona las imágenes del menú y otras funciones de interés.</p>

                    <div class="d-grid gap-3 d-md-flex justify-content-md-center">
                        <a href="{{ route('menu.editar') }}" class="btn btn-primary btn-lg px-4">
                            <i class="bi bi-images me-2"></i> Imagenes Menú
                        </a>
                        <a href="{{ route('promos.editar') }}" class="btn btn-success btn-lg px-4">
                            <i class="bi bi-plus-circle me-2"></i> Agregar Promo
                        </a>
                        <a href="{{ route('consulta.metricas') }}" class="btn btn-info btn-lg px-4 text-white">
                            <i class="bi bi-bar-chart-line me-2"></i> DB (Solo Usuarios Business)
                        </a>

                        @if($canvaLink)
                            <a href="{{ $canvaLink }}" target="_blank" class="btn btn-outline-secondary btn-lg px-4">
                                <i class="bi bi-pencil-square me-2"></i> Editar en Canva
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
