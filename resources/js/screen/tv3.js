document.addEventListener('DOMContentLoaded', () => {
    const carousel = document.getElementById('carousel');
    const items = Array.from(carousel.querySelectorAll('.carousel-item-tv'));
    const bannerElement = document.getElementById('dynamicContent');
    const pageName = carousel.dataset.pageName;
    
    let current = 0;
    let animationInterval;

    // =====================
    // 🏷️ SISTEMA DEL BANNER
    // =====================
    async function updateBanner() {
        try {
            const response = await fetch(`/tv/${pageName}/promo`);
            if (!response.ok) throw new Error(`HTTP ${response.status}`);
            
            const text = await response.text();
            const match = text.match(/^(\p{Emoji_Presentation}|\p{Extended_Pictographic})\s*(.*)$/u);
            
            bannerElement.innerHTML = match ?
                `<span class="banner-emoji">${match[1]}</span><span class="banner-text">${match[2]}</span>` :
                text;

            bannerElement.style.animation = 'none';
            void bannerElement.offsetWidth;
            bannerElement.style.animation = 'bannerGlow 2s ease-in-out infinite alternate';

        } catch (error) {
            console.error('Error en updateBanner:', error);
            bannerElement.innerHTML = '<span class="banner-text">Promoción activa</span>';
        }
    }

    // =====================
    // 🎠 SISTEMA DE CARRUSEL
    // =====================
    function animateTransition() {
        items.forEach((item, index) => {
            item.classList.remove('active', 'prev');
            
            if(index === current) {
                setTimeout(() => {
                    item.style.animation = 'smoothEntrance 1.2s ease-out forwards';
                    item.classList.add('active');
                }, index * 200);
            }
            else if(index === (current - 1 + items.length) % items.length) {
                item.classList.add('prev');
            }
        });

        current = (current + 1) % items.length;
    }

    function initializeAnimation() {
        if(items.length > 1) {
            items[0].classList.add('active');
            setTimeout(() => animateTransition(), 3000);
            animationInterval = setInterval(animateTransition, 7000);
        }
    }

    // =====================
    // 🔄 VERIFICACIÓN DE CAMBIOS (IMÁGENES)
    // =====================
    async function checkImageChanges() {
        try {
            const response = await fetch(`/tv/${pageName}/checksum`);
            if (!response.ok) throw new Error(`HTTP ${response.status}`);
            
            const data = await response.json();
            const lastChecksum = localStorage.getItem('lastChecksum');
            
            if (lastChecksum && data.checksum !== lastChecksum) {
                localStorage.setItem('lastChecksum', data.checksum);
                location.reload();
            }
            localStorage.setItem('lastChecksum', data.checksum);
        } catch (error) {
            console.error('Error en checkImageChanges:', error);
        }
    }

    // =====================
    // 🔄 VERIFICACIÓN DE CAMBIOS (PÁGINA)
    // =====================
    async function checkPageChange() {
        try {
            const response = await fetch(`/tv/${pageName}/page-checksum`);
            if (!response.ok) throw new Error(`HTTP ${response.status}`);
            
            const data = await response.json();
            const lastPageChecksum = localStorage.getItem('lastPageChecksum');
            
            if (lastPageChecksum && data.checksum !== lastPageChecksum) {
                localStorage.setItem('lastPageChecksum', data.checksum);
                location.reload();
            }
            localStorage.setItem('lastPageChecksum', data.checksum);
        } catch (error) {
            console.error('Error en checkPageChange:', error);
        }
    }

    // =====================
    // ⚙️ CONFIGURACIÓN INICIAL
    // =====================
    items.forEach(item => {
        item.addEventListener('animationend', () => {
            item.style.animation = '';
        });
    });

    document.addEventListener('visibilitychange', () => {
        if(document.hidden) {
            clearInterval(animationInterval);
        } else {
            initializeAnimation();
        }
    });

    if (pageName) {
        initializeAnimation();
        setInterval(updateBanner, 10000);
        setInterval(checkImageChanges, 2000);
        setInterval(checkPageChange, 5000);
        updateBanner();
        checkImageChanges();
        checkPageChange();
    }

    window.addEventListener('beforeunload', () => {
        clearInterval(animationInterval);
    });
});