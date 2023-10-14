document.addEventListener('DOMContentLoaded', function () {
  const previewImgInps = $('.preview-img-inp');

  $.each(previewImgInps, function (idx, previewImgInp) {
    $(previewImgInp).on('change', function (e) {
      const fileReader = new FileReader();
      fileReader.onload = function (e) {
        const previewImg = $(previewImgInp).closest('.preview-img-wrapper').find('.preview-img');
        previewImg.attr('src', e.target.result);
      };
      fileReader.readAsDataURL(e.target.files[0]);
    });
  });
});
