document.addEventListener('DOMContentLoaded', function () {
  const numInpDecBtns = $('.num-inp-dec-btn');
  const numInpIncBtns = $('.num-inp-inc-btn');

  $.each(numInpDecBtns, (idx, numInpDecBtn) => {
    $(numInpDecBtn).on('click', (e) => {
      const numInpCurVal = $(e.target).next().val();
      const minNumAllowed = $(e.target).next().attr('min') || Number.NEGATIVE_INFINITY;
      $(e.target).next().val(Math.max(numInpCurVal - 1, minNumAllowed));
    });
  });

  $.each(numInpIncBtns, (idx, numInpIncBtn) => {
    $(numInpIncBtn).on('click', (e) => {
      const numInpCurVal = $(e.target).prev().val();
      const maxNumAllowed = $(e.target).prev().attr('max') || Number.POSITIVE_INFINITY;
      $(e.target).prev().val(Math.min(Number(numInpCurVal) + 1, maxNumAllowed));
    });
  });
});
