document.addEventListener('DOMContentLoaded', function () {
  // render months against year
  const yearInp = $('#year');
  const monthNameInp = $('#month_name');

  const yearFromUrl = location.href.split('/').slice(-2)[0];
  yearInp.val(yearFromUrl);

  const renderMonths = (e) => {
    const year = $(e?.target).val() || yearInp.val();
    const minMonthNo = yearInp.find(`[value="${year}"]`).attr('data-min-month-no');
    const maxMonthNo = yearInp.find(`[value="${year}"]`).attr('data-max-month-no');

    monthNameInp.html('<option value="">Select a Month</option>');

    for(let monthNo = Number(minMonthNo); monthNo <= Number(maxMonthNo); monthNo++) {
      const monthName = moment(monthNo, 'M').format('MMM');;
      monthNameInp.append(`<option value="${monthName}">${monthName}</option>`)
    }
  }

  renderMonths();
  yearInp.on('change', renderMonths);

  const monthNameFromUrl = location.href.split('/').slice(-1)[0];
  monthNameInp.val(monthNameFromUrl);

  // build URL
  const historyFilterForm = $('.history-filter-form');

  historyFilterForm.on('submit', (e) => {
    e.preventDefault();

    const year = yearInp.val();
    const monthName = monthNameInp.val();

    location.href = [...location.href.split('/').slice(0, -2), year, monthName].join('/');
  });

  // toggle charts based on prayer type
  const prayerTypeInps = $('[name="prayer_type_inp"]');
  const chartWrappers = $('.chart-wrapper');

  $.each(prayerTypeInps, (idx, prayerTypeInp) => {
    $(prayerTypeInp).on('change', (e) => {
      chartWrappers.addClass('d-none');
      $($(e.target).attr('data-target')).removeClass('d-none');
    });
  });
}, false);
