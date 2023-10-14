document.addEventListener('DOMContentLoaded', function () {
  // enable all tooltips
  const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
  tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
  });

  // show single toast
  const toastEl = $('.toast');
  if (toastEl.length) {
    const toast = new bootstrap.Toast(toastEl[0]);
    toast.show();
  }

  // disable shadows for page links
  $.each($('.page-link'), (idx, pageLink) => {
    $(pageLink).addClass('shadow-none');
  });
}, false);
