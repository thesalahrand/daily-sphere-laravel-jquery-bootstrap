document.addEventListener('DOMContentLoaded', function () {
  // historic date selection
  const historicDateInp = $('#historic_date_inp');

  historicDateInp.on('change', (e) => {
    location.href = `/trackers/prayer/daily/${$(e.target).val()}`;
  });

  // quick actions
  const quickActionsLinks = $('.quick-actions-dropdown ul li a');
  $.each(quickActionsLinks, (idx, quickActionsLink) => {
    $(quickActionsLink).on('click', (e) => {
      switch ($(quickActionsLink).text().trim()) {
        case 'Offered all fards with takbeer e tahrima':
          $('input[type="radio"][value="1"]').prop('checked', true);
          break;
        case 'Offered all fards in time':
          $('input[type="radio"][value="3"]').prop('checked', true);
          break;
        case 'Excuse all fards':
          $('input[type="radio"][value="6"]').prop('checked', true);
          break;
        case 'Offered all sunnat-e-muakkadahs in time':
          $('input[type="radio"][value="7"]').prop('checked', true);
          break;
        case 'Excuse all sunnat-e-muakkadahs':
          $('input[type="radio"][value="9"]').prop('checked', true);
          break;
      }
    });
  });
}, false);
