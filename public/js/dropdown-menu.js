document.addEventListener('DOMContentLoaded', function () {
    const MENU_WIDTH = 192; // 12rem × 16px
    const GAP = 4;

    function closeAll(except) {
        document.querySelectorAll('.dropdown-menu-content.open').forEach(function (m) {
            if (m !== except) m.classList.remove('open');
        });
    }

    function positionMenu(trigger, menu) {
        // Déplace le menu dans <body> pour échapper aux transform/overflow parents
        if (menu.parentNode !== document.body) {
            document.body.appendChild(menu);
        }

        const rect = trigger.getBoundingClientRect();
        const vw = window.innerWidth;
        const vh = window.innerHeight;

        // Aligne le bord droit du menu avec celui du bouton
        let left = rect.right - MENU_WIDTH;
        if (left < 8) left = 8;
        if (left + MENU_WIDTH > vw - 8) left = vw - MENU_WIDTH - 8;

        // Ouvre vers le haut si pas assez de place en bas
        const menuH = menu.offsetHeight || 160;
        let top = (rect.bottom + GAP + menuH > vh - 8)
            ? rect.top - GAP - menuH
            : rect.bottom + GAP;

        menu.style.left = left + 'px';
        menu.style.top  = top  + 'px';
    }

    document.querySelectorAll('.dropdown-menu-container').forEach(function (container) {
        const trigger = container.querySelector('.dropdown-menu-trigger');
        const menu    = container.querySelector('.dropdown-menu-content');
        if (!trigger || !menu) return;

        trigger.addEventListener('click', function (e) {
            e.stopPropagation();
            const isOpen = menu.classList.contains('open');
            closeAll(menu);
            if (!isOpen) {
                positionMenu(trigger, menu);
                menu.classList.add('open');
            } else {
                menu.classList.remove('open');
            }
        });

        // Confirmation avant suppression
        menu.querySelectorAll('.dropdown-menu-item').forEach(function (item) {
            item.addEventListener('click', function (e) {
                if (this.classList.contains('danger')) {
                    const msg = this.dataset.confirm || 'Êtes-vous sûr ?';
                    if (!confirm(msg)) {
                        e.preventDefault();
                        return;
                    }
                }
                menu.classList.remove('open');
            });
        });
    });

    // Ferme sur clic extérieur, scroll ou resize
    document.addEventListener('click', function () { closeAll(); });
    document.addEventListener('scroll', function () { closeAll(); }, true);
    window.addEventListener('resize', function () { closeAll(); });
});
