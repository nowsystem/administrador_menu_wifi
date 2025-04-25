<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 fw-bold text-dark mb-0"> <!-- Mejor usar mb-0 -->
                {{ __('Dashboard') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-5 bg-light">
        <div class="container">
            <div class="card border-0 shadow rounded-4"> <!-- rounded-4 necesita Bootstrap 5.3+ -->
                <div class="card-body p-5 text-center"> <!-- py-5 -> p-5 para padding completo -->
                    <h4 class="mb-4">Bienvenido al panel de administración</h4>
                    <p class="mb-5 text-muted">Gestiona las imágenes del menú u otras funciones administrativas.</p>

                    <div class="d-grid gap-3 d-md-flex justify-content-md-center"> <!-- Mejor responsive -->
                        <a href="{{ route('menu.editar') }}" class="btn btn-primary btn-lg px-4">
                            <i class="bi bi-images me-2"></i> Editar Imágenes
                        </a>
                        <a href="#" class="btn btn-success btn-lg px-4">
                            <i class="bi bi-plus-circle me-2"></i> Agregar promo
                        </a>
                        <a href="#" class="btn btn-info btn-lg px-4 text-white">
                            <i class="bi bi-bar-chart-line me-2"></i> DB (Usuarios Business)
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>