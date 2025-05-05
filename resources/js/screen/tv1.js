class CarruselTV {
    constructor() {
        this.carousel = document.getElementById('carousel');
        this.bannerElement = document.getElementById('dynamicContent');
        this.pageName = this.carousel.dataset.pageName;
        this.currentIndex = 0;
        this.scrollTimeout = null;
        this.bannerInterval = null;
        this.checkImageInterval = null;
        this.checkPageInterval = null;
        this.isPaused = false;
        this.lastChecksum = localStorage.getItem('lastChecksum') || null;
        this.lastPageChecksum = localStorage.getItem('lastPageChecksum') || null;

        this.init();
    }

    init() {
        this.setupEventListeners();
        this.startAutoScroll();
        this.startBannerUpdates();
        this.startImageCheck();
        this.startPageCheck();
        this.forceInitialPosition();
    }

    // ========== SISTEMA DE VERIFICACIÓN DE IMÁGENES ==========
    async checkImageChanges() {
        try {
            const response = await fetch(`/tv/${this.pageName}/checksum`);
            if (!response.ok) throw new Error(`HTTP ${response.status}`);

            const data = await response.json();

            if (this.lastChecksum && data.checksum !== this.lastChecksum) {
                localStorage.setItem('lastChecksum', data.checksum);
                location.reload();
            }

            this.lastChecksum = data.checksum;
        } catch (error) {
            console.error('Error en checkImageChanges:', error);
        }
    }

    startImageCheck() {
        this.checkImageInterval = setInterval(() => {
            this.checkImageChanges();
        }, 5000);
        this.checkImageChanges(); // verificación inicial
    }

    // ========== NUEVO: VERIFICACIÓN DE CAMBIO DE VISTA ==========
    async checkPageChange() {
        try {
            const response = await fetch(`/tv/${this.pageName}/page-checksum`);
            if (!response.ok) throw new Error(`HTTP ${response.status}`);

            const data = await response.json();

            if (this.lastPageChecksum && data.checksum !== this.lastPageChecksum) {
                localStorage.setItem('lastPageChecksum', data.checksum);
                location.reload();
            }

            this.lastPageChecksum = data.checksum;
        } catch (error) {
            console.error('Error en checkPageChange:', error);
        }
    }

    startPageCheck() {
        this.checkPageInterval = setInterval(() => {
            this.checkPageChange();
        }, 5000);
        this.checkPageChange(); // verificación inicial
    }

    // ========== SISTEMA DE BANNER ==========
    async updateBanner() {
        try {
            const response = await fetch(`/tv/${this.pageName}/promo`);
            if (!response.ok) throw new Error(`HTTP ${response.status}`);

            const text = await response.text();
            const match = text.match(/^(\p{Emoji_Presentation}|\p{Extended_Pictographic})\s*(.*)$/u);

            this.bannerElement.innerHTML = match ?
                `<span>${match[1]}</span><span class="text-only">${match[2]}</span>` :
                text;

        } catch (error) {
            console.error('Error en updateBanner:', error);
            this.bannerElement.textContent = "Promoción no disponible";
        }
    }

    startBannerUpdates() {
        this.bannerInterval = setInterval(() => {
            this.updateBanner();
        }, 1000);
        this.updateBanner(); // inicial
    }

    // ========== SISTEMA DE CARRUSEL ==========
    setupEventListeners() {
        this.carousel.addEventListener('mouseenter', () => this.pauseAutoScroll());
        this.carousel.addEventListener('touchstart', () => this.pauseAutoScroll());
        this.carousel.addEventListener('mouseleave', () => this.resumeAutoScroll());
        this.carousel.addEventListener('touchend', () => this.resumeAutoScroll());

        // Reiniciar checksum al interactuar
        this.carousel.addEventListener('click', () => {
            localStorage.removeItem('lastChecksum');
        });
    }

    calculateScrollPosition() {
        return this.currentIndex * window.innerWidth;
    }

    smoothScrollTo(position) {
        this.carousel.scrollTo({
            left: position,
            behavior: 'smooth',
            inline: 'start'
        });
    }

    scrollToNext() {
        if (this.isPaused || !this.carousel.children.length) return;

        this.currentIndex = (this.currentIndex + 1) % this.carousel.children.length;
        this.smoothScrollTo(this.calculateScrollPosition());
    }

    startAutoScroll() {
        this.scrollTimeout = setInterval(() => this.scrollToNext(), 6000);
    }

    pauseAutoScroll() {
        this.isPaused = true;
        clearInterval(this.scrollTimeout);
    }

    resumeAutoScroll() {
        this.isPaused = false;
        this.startAutoScroll();
    }

    forceInitialPosition() {
        this.smoothScrollTo(0);
        window.scrollTo(0, 0);
    }

    destroy() {
        clearInterval(this.scrollTimeout);
        clearInterval(this.bannerInterval);
        clearInterval(this.checkImageInterval);
        clearInterval(this.checkPageInterval);
        this.carousel.removeEventListener('click', this.handleClick);
    }
}

// Inicialización
document.addEventListener('DOMContentLoaded', () => {
    try {
        const carrusel = new CarruselTV();

        document.addEventListener('visibilitychange', () => {
            if (!document.hidden) {
                carrusel.updateBanner();
                carrusel.checkImageChanges();
                carrusel.checkPageChange();
            }
        });

        window.addEventListener('beforeunload', () => {
            carrusel.destroy();
        });

    } catch (error) {
        console.error('Error inicializando CarruselTV:', error);
        document.getElementById('dynamicContent').textContent = "Error inicializando sistema";
    }
});
