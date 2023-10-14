document.addEventListener('DOMContentLoaded', function () {
  const hamburgerMenuIcon = $('.hamburger-menu-icon');
  const sidebar = $('.sidebar');

  hamburgerMenuIcon.on('click', () => {
    sidebar.toggleClass('active');
  });
});
