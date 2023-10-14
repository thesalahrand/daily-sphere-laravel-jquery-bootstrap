document.addEventListener('DOMContentLoaded', function () {
  const subMenuItems = $('.sidebar-menu > li:not(.sidebar-menu-title)');
  $.each(subMenuItems, (idx, subMenuItem) => {
    $(subMenuItem).on('click', (e) => {
      const subMenu = $(subMenuItem).find('ul');
      if (subMenu.css('max-height') != '0px') {
        subMenu.css('max-height', '0px').removeClass('my-1');
      } else {
        subMenu.css('max-height', subMenu.prop('scrollHeight') + 'px').addClass('my-1');
      }
    });
  });
});
