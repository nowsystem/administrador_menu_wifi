document.addEventListener('DOMContentLoaded', () => {
    const carousel = document.getElementById('carousel');
    const items = Array.from(carousel.querySelectorAll('.carousel-item-tv'));
    const bannerElement = document.getElementById('dynamicContent');
    const pageName = carousel.dataset.pageName;
    
    let current = 0;
    let carouselInterval;

    // Sistema del Banner
    async function updateBanner() {
        try {
            const response = await fetch(`/tv/${pageName}/promo`);
            if (!response.ok) throw new Error(`HTTP ${response.status}`);
            
            const text = await response.text();
            const match = text.match(/^(\p{Emoji_Presentation}\uFE0F?|\p{Extended_Pictographic})\s*(.*)$/u);
            
            bannerElement.style.animation = 'none';
            void bannerElement.offsetWidth;
            
            if (match) {
                bannerElement.innerHTML = `
                    <span class="banner-emoji">${match[1].trim()}</span>
                    <span class="banner-text">${match[2].trim()}</span>
                `;
            } else {
                bannerElement.textContent = text.trim();
            }
            
            bannerElement.style.animation = 'marquee 15s linear infinite';

        } catch (error) {
            console.error('Error en updateBanner:', error);
            bannerElement.innerHTML = '<span class="banner-text">Promoción activa</span>';
        }
    }

    // Sistema del Carrusel
    function rotateCarousel() {
        items[current].classList.remove('active');
        current = (current + 1) % items.length;
        items[current].classList.add('active');
    }

    function initCarousel() {
        if(items.length > 0) {
            items[0].classList.add('active');
            carouselInterval = setInterval(rotateCarousel, 5000);
        }
    }

    // Verificación de cambios
    async function checkImageChanges() {
        try {
            const response = await fetch(`/tv/${pageName}/checksum`);
            if (!response.ok) throw new Error(`HTTP ${response.status}`);
            
            const data = await response.json();
            const lastChecksum = localStorage.getItem('tv4Checksum');
            
            if (lastChecksum && data.checksum !== lastChecksum) {
                localStorage.setItem('tv4Checksum', data.checksum);
                location.reload();
            }
            localStorage.setItem('tv4Checksum', data.checksum);
        } catch (error) {
            console.error('Error en checkImageChanges:', error);
        }
    }

    // Event Listeners
    document.addEventListener('visibilitychange', () => {
        if(document.hidden) {
            clearInterval(carouselInterval);
        } else {
            initCarousel();
        }
    });

    // Inicialización
    if (pageName) {
        initCarousel();
        setInterval(updateBanner, 10000);
        setInterval(checkImageChanges, 3000);
        updateBanner();
        checkImageChanges();
    }

    window.addEventListener('beforeunload', () => {
        clearInterval(carouselInterval);
    });
});