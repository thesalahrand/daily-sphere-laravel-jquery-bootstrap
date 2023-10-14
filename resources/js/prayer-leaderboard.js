document.addEventListener('DOMContentLoaded', function () {
  // enable all tooltips
  const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
  const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl, {
      'customClass': $(tooltipTriggerEl).closest('.leader-row').length ? 'success-rate-tooltip' : ''
    });
  });
  tooltipList.forEach(function(el) {
    $(el._element).closest('.leader-row').length && el.show();
  });
}, false);
