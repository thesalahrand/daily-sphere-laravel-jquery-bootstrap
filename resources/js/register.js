document.addEventListener('DOMContentLoaded', function () {
  const genderInp = $('[name="gender"]');
  const pseudoNameInp = $('[name="pseudo_name_id"]');

  genderInp.on('change', (e) => {
    $.ajax({
      url: `/pseudo-names/available/?gender=${$(e.target).val()}`,
      method: 'GET',
      beforeSend: () => {
        pseudoNameInp.html('<option selected value="">--Choose an option--</option>');
      },
      success: (res) => {
        console.log(res);
        res.pseudo_names.forEach((item) => {
          pseudoNameInp.append(`<option value="${item.id}">${item.name}</option>`)
        });
      },
      error: (err) => {
        console.log(err.responseJSON.message);
      }
    })
  });
}, false);
