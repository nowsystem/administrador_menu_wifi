document.addEventListener('DOMContentLoaded', () => {
    const carousel = document.getElementById('carousel');
    const items = Array.from(carousel.querySelectorAll('.carousel-item-tv'));
    const bannerElement = document.getElementById('dynamicContent');
    const pageName = carousel.dataset.pageName;
    
    let current = 0;
    let animationInterval;
    let bannerUpdateInterval;

    // =====================
    // 🏷️ SISTEMA DEL BANNER MEJORADO
    // =====================
    async function updateBanner() {
        try {
            const response = await fetch(`/tv/${pageName}/promo`);
            if (!response.ok) throw new Error(`HTTP ${response.status}`);
            
            const text = await response.text();
            // Expresión regular mejorada para emojis
            const match = text.match(/^(\p{Emoji_Presentation}\uFE0F?|\p{Extended_Pictographic})\s*(.*)$/u);
            
            // Resetear animación correctamente
            bannerElement.style.animation = 'none';
            void bannerElement.offsetWidth; // Forzar reflow
            
            // Actualizar contenido con sanitización básica
            if (match) {
                bannerElement.innerHTML = `
                    <span class="banner-emoji">${sanitizeHTML(match[1])}</span>
                    <span class="banner-text">${sanitizeHTML(match[2])}</span>
                `;
            } else {
                bannerElement.textContent = sanitizeHTML(text);
            }
            
            // Restaurar animación correcta (marquee en lugar de bannerGlow)
            bannerElement.style.animation = 'marquee 15s linear infinite';

        } catch (error) {
            console.error('Error en updateBanner:', error);
            bannerElement.innerHTML = '<span class="banner-text">Promoción activa</span>';
            bannerElement.style.animation = 'marquee 15s linear infinite';
        }
    }

    // Función básica de sanitización
    function sanitizeHTML(str) {
        return str.replace(/</g, '&lt;').replace(/>/g, '&gt;');
    }

    // =====================
    // 🎠 SISTEMA DE CARRUSEL OPTIMIZADO
    // =====================
    function animateTransition() {
        items.forEach((item, index) => {
            item.classList.remove('active', 'prev');
            
            if(index === current) {
                requestAnimationFrame(() => {
                    item.style.animation = 'smoothEntrance 1.2s ease-out forwards';
                    item.classList.add('active');
                });
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
    // 🔄 VERIFICACIÓN DE CAMBIOS (MEJORADO)
    // =====================
    async function checkChanges(endpoint, storageKey) {
        try {
            const response = await fetch(`/tv/${pageName}/${endpoint}`);
            if (!response.ok) throw new Error(`HTTP ${response.status}`);
            
            const data = await response.json();
            const lastChecksum = localStorage.getItem(storageKey);
            
            if (lastChecksum && data.checksum !== lastChecksum) {
                localStorage.setItem(storageKey, data.checksum);
                location.reload();
            }
            localStorage.setItem(storageKey, data.checksum);
        } catch (error) {
            console.error(`Error en verificación de ${endpoint}:`, error);
        }
    }

    // =====================
    // ⚙️ CONFIGURACIÓN INICIAL OPTIMIZADA
    // =====================
    function setupEventListeners() {
        items.forEach(item => {
            item.addEventListener('animationend', () => {
                item.style.animation = '';
            });
        });

        document.addEventListener('visibilitychange', () => {
            if(document.hidden) {
                clearInterval(animationInterval);
                clearInterval(bannerUpdateInterval);
            } else {
                initializeAnimation();
                bannerUpdateInterval = setInterval(updateBanner, 10000);
            }
        });
    }

    // Inicialización completa
    if (pageName) {
        setupEventListeners();
        initializeAnimation();
        
        // Configurar intervalos
        bannerUpdateInterval = setInterval(updateBanner, 10000);
        setInterval(() => checkChanges('checksum', 'lastChecksum'), 2000);
        setInterval(() => checkChanges('page-checksum', 'lastPageChecksum'), 5000);
        
        // Carga inicial
        updateBanner();
        checkChanges('checksum', 'lastChecksum');
        checkChanges('page-checksum', 'lastPageChecksum');

        // Limpieza
        window.addEventListener('beforeunload', () => {
            clearInterval(animationInterval);
            clearInterval(bannerUpdateInterval);
        });
    }
});