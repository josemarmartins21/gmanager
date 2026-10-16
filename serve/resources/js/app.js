import './bootstrap';

/**
 * MENU MOBILE / OFF-CANVAS DRAWER
 */
document.addEventListener('DOMContentLoaded', () => {
    const menuBtn = document.getElementById('menu');
    const menuIcon = document.getElementById('menu-icon');
    const sideBar = document.getElementById('side-bar');
    const backdrop = document.getElementById('menu-backdrop');
    const corpo = document.getElementById('corpo') || document.body;

    if (!menuBtn || !sideBar) return;

    let isOpen = false;
    let touchStartX = 0;
    let touchCurrentX = 0;

    function openMenu() {
        if (isOpen) return;
        isOpen = true;

        menuBtn.setAttribute('aria-expanded', 'true');
        menuBtn.setAttribute('aria-label', 'Fechar menu');
        sideBar.setAttribute('aria-hidden', 'false');

        // Transição do ícone (rotação + troca para fa-xmark)
        if (menuIcon) {
            menuIcon.classList.add('rotate-90', 'scale-75');
            setTimeout(() => {
                menuIcon.classList.remove('fa-bars');
                menuIcon.classList.add('fa-xmark');
                menuIcon.classList.remove('rotate-90', 'scale-75');
            }, 120);
        }

        // Exibir backdrop com fade-in
        if (backdrop) {
            backdrop.classList.remove('pointer-events-none', 'opacity-0');
            backdrop.classList.add('pointer-events-auto', 'opacity-100');
        }

        // Animação de entrada do drawer
        sideBar.classList.remove('-translate-x-full', 'invisible', 'pointer-events-none', 'opacity-0');
        sideBar.classList.add('translate-x-0', 'visible', 'pointer-events-auto', 'opacity-100');

        // Travar rolagem do fundo
        corpo.classList.add('overflow-hidden');
    }

    function closeMenu() {
        if (!isOpen) return;
        isOpen = false;

        menuBtn.setAttribute('aria-expanded', 'false');
        menuBtn.setAttribute('aria-label', 'Abrir menu');
        sideBar.setAttribute('aria-hidden', 'true');

        // Transição do ícone de volta para hambúrguer
        if (menuIcon) {
            menuIcon.classList.add('-rotate-90', 'scale-75');
            setTimeout(() => {
                menuIcon.classList.remove('fa-xmark');
                menuIcon.classList.add('fa-bars');
                menuIcon.classList.remove('-rotate-90', 'scale-75');
            }, 120);
        }

        // Ocultar backdrop com fade-out
        if (backdrop) {
            backdrop.classList.remove('pointer-events-auto', 'opacity-100');
            backdrop.classList.add('pointer-events-none', 'opacity-0');
        }

        // Animação de saída do drawer
        sideBar.classList.remove('translate-x-0');
        sideBar.classList.add('-translate-x-full');

        // Ocultar após o término da transição CSS (300ms)
        setTimeout(() => {
            if (!isOpen && window.innerWidth < 1024) {
                sideBar.classList.add('invisible', 'pointer-events-none', 'opacity-0');
            }
        }, 300);

        // Restaurar rolagem do corpo
        corpo.classList.remove('overflow-hidden');
    }

    function toggleMenu() {
        if (isOpen) {
            closeMenu();
        } else {
            openMenu();
        }
    }

    // Clique no botão do menu
    menuBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        toggleMenu();
    });

    // Clique no backdrop fecha o menu
    if (backdrop) {
        backdrop.addEventListener('click', closeMenu);
    }

    // Tecla Escape fecha o menu
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && isOpen) {
            closeMenu();
        }
    });

    // Fechar ao clicar em qualquer link de navegação no mobile
    const navLinks = sideBar.querySelectorAll('a.link-nav, #logout-btn button');
    navLinks.forEach((link) => {
        link.addEventListener('click', () => {
            if (window.innerWidth < 1024) {
                closeMenu();
            }
        });
    });

    // Suporte a gesto de swipe para a esquerda para fechar no celular
    sideBar.addEventListener('touchstart', (e) => {
        touchStartX = e.touches[0].clientX;
        touchCurrentX = touchStartX;
    }, { passive: true });

    sideBar.addEventListener('touchmove', (e) => {
        touchCurrentX = e.touches[0].clientX;
    }, { passive: true });

    sideBar.addEventListener('touchend', () => {
        if (isOpen && (touchStartX - touchCurrentX > 50)) {
            closeMenu();
        }
    });

    // Ajuste ao redimensionar a tela (breakpoint desktop 1024px)
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 1024) {
            if (isOpen) {
                closeMenu();
            }
            sideBar.classList.remove('-translate-x-full', 'invisible', 'pointer-events-none', 'opacity-0');
            corpo.classList.remove('overflow-hidden');
        } else if (!isOpen) {
            sideBar.classList.add('-translate-x-full', 'invisible', 'pointer-events-none', 'opacity-0');
        }
    });
});

