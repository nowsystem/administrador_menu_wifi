<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">{{ __('Seleccionar Diseño de Pantalla') }}</h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                
                <!-- Mostrar mensaje de éxito si existe -->
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('tv.guardar') }}" method="POST">
                    @csrf
                    <input type="hidden" name="vista" id="selectedDesign">

                    <!-- Contenedor de Imágenes - 2 columnas -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6"> <!-- Responsive -->
                        @foreach([1, 2, 3, 4] as $num)
                            <div class="text-center">
                                <img 
                                    src="{{ asset("images/tv$num.jpg") }}" 
                                    alt="Diseño {{ $num }}" 
                                    class="mx-auto w-full h-64 object-cover rounded-lg cursor-pointer border-4 border-gray-300"
                                    data-design="{{ $num }}"
                                    onclick="selectDesign(this, {{ $num }})"
                                >
                            </div>
                        @endforeach
                    </div>

                    <!-- Botón Centrado -->
                    <div class="text-center">
                        <button type="submit" class="bg-red-600 text-white px-8 py-3 rounded-lg hover:bg-red-700">
                            GUARDAR DISEÑO
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function selectDesign(img, num) {
            // Resetear bordes
            document.querySelectorAll('img[data-design]').forEach(i => {
                i.style.borderColor = '#d1d5db'; // Gris
            });
            // Borde rojo al seleccionado
            img.style.borderColor = '#ff0000';
            // Actualizar valor
            document.getElementById('selectedDesign').value = num;
        }
    </script>
</x-app-layout>
