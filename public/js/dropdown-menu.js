document.addEventListener('DOMContentLoaded', function() {
  const dropdownMenus = document.querySelectorAll('.dropdown-menu-container');

  dropdownMenus.forEach(container => {
    const trigger = container.querySelector('.dropdown-menu-trigger');
    const menu = container.querySelector('.dropdown-menu-content');

    if (!trigger || !menu) return;

    trigger.addEventListener('click', function(e) {
      e.stopPropagation();
      const isOpen = menu.classList.contains('open');
      
      document.querySelectorAll('.dropdown-menu-content.open').forEach(m => {
        if (m !== menu) {
          m.classList.remove('open');
        }
      });

      if (!isOpen) {
        menu.classList.add('open');
      } else {
        menu.classList.remove('open');
      }
    });

    menu.querySelectorAll('.dropdown-menu-item').forEach(item => {
      item.addEventListener('click', function(e) {
        if (this.classList.contains('danger')) {
          const confirmMessage = this.dataset.confirm || 'Êtes-vous sûr ?';
          if (!confirm(confirmMessage)) {
            e.preventDefault();
            return;
          }
        }
        menu.classList.remove('open');
      });
    });
  });

  document.addEventListener('click', function(e) {
    if (!e.target.closest('.dropdown-menu-container')) {
      document.querySelectorAll('.dropdown-menu-content.open').forEach(m => {
        m.classList.remove('open');
      });
    }
  });
});
