<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ ucfirst($pageName) }} TV</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #000;
            color: #fff;
            overflow: hidden;
            margin: 0;
            padding: 10px 0;
            height: 100vh;
        }

        .carousel-container {
            display: flex;
            overflow-x: scroll;
            scroll-snap-type: x mandatory;
            scroll-behavior: smooth;
            height: calc(100vh - 20px);
            box-sizing: border-box;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .carousel-container::-webkit-scrollbar {
            display: none;
        }

        .carousel-item-tv {
            flex: 0 0 calc(100vw - 40px);
            width: calc(100vw - 40px);
            height: 100%;
            scroll-snap-align: center;
            margin: 0 20px;
            position: relative;
            transition: transform 0.3s ease;
        }

        .carousel-item-tv img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 30px;
            box-shadow: 0 0 30px rgba(255, 255, 255, 0.2);
        }

        .carousel-item-tv:not(:first-child) {
            margin-left: -20px;
        }

        .dynamic-banner {
            position: fixed;
            top: 20px;
            right: 30px;
            z-index: 1000;
            padding: 12px 25px;
            border-radius: 15px;
            background: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            animation: float 3s ease-in-out infinite;
        }

        .banner-text {
            font-family: 'Arial Black', sans-serif;
            font-size: 2rem;
            color: #fff;
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.5),
                         0 0 20px rgba(255, 0, 150, 0.5);
        }

        .banner-text .text-only {
            background: linear-gradient(45deg, #ff00ff, #00ffff);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }

        @media (max-width: 768px) {
            .dynamic-banner {
                top: 10px;
                right: 15px;
                padding: 8px 15px;
            }

            .banner-text {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>

    <!-- Banner animado -->
    <div class="dynamic-banner">
        <div class="banner-text" id="dynamicContent">Cargando...</div>
    </div>

    <div class="carousel-container" id="carousel">
        @forelse ($imagenes as $imagen)
            <div class="carousel-item-tv">
                <img src="data:image/jpeg;base64,{{ base64_encode($imagen) }}" alt="Imagen de {{ $pageName }}">
            </div>
        @empty
            <div class="carousel-item-tv">
                <h2 class="text-center text-white">No hay imágenes disponibles.</h2>
            </div>
        @endforelse
    </div>

    <script>
        function updateBanner() {
            const pageName = "{{ $pageName }}";

            fetch(`/tv/${pageName}/promo`)
                .then(response => response.text())
                .then(data => {
                    const container = document.getElementById('dynamicContent');
                    const match = data.match(/^(\p{Emoji_Presentation}|\p{Extended_Pictographic})\s*(.*)$/u);

                    if (match) {
                        const emoji = match[1];
                        const text = match[2];
                        container.innerHTML = `<span>${emoji}</span> <span class="text-only">${text}</span>`;
                    } else {
                        container.textContent = data;
                    }
                })
                .catch(error => {
                    console.error("Error al cargar promoción:", error);
                    document.getElementById('dynamicContent').textContent = "Sin promo";
                });
        }

        setInterval(updateBanner, 1000);
        updateBanner();

        const carousel = document.getElementById('carousel');
        const items = document.querySelectorAll('.carousel-item-tv');
        let currentIndex = 0;
        let scrollTimeout;

        function scrollToItem(index) {
            if (!items.length) return;

            const item = items[0];
            const style = getComputedStyle(item);
            const margin = parseInt(style.marginLeft) + parseInt(style.marginRight);
            const itemWidth = item.offsetWidth + margin;

            currentIndex = index % items.length;

            carousel.scrollTo({
                left: currentIndex * itemWidth,
                behavior: 'smooth'
            });
        }

        function startAutoScroll() {
            scrollTimeout = setInterval(() => {
                scrollToItem(currentIndex + 1);
            }, 6000);
        }

        startAutoScroll();

        carousel.addEventListener('mouseenter', () => clearInterval(scrollTimeout));
        carousel.addEventListener('mouseleave', startAutoScroll);

       
    let lastChecksum = null;

    function checkImageChanges() {
        const pageName = "{{ $pageName }}";
        fetch(`/tv/${pageName}/checksum`)
            .then(res => res.json())
            .then(data => {
                if (lastChecksum && data.checksum !== lastChecksum) {
                    location.reload(); // Reload si cambió algo
                }
                lastChecksum = data.checksum; // Guarda el actual
            })
            .catch(err => console.error('Error verificando cambios de imagen:', err));
    }

    // Ejecuta cada 5 segundos
    setInterval(checkImageChanges, 5000);
    checkImageChanges(); // Primer chequeo


    </script>

</body>
</html>
