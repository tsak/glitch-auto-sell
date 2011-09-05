$(document).ready(function () {
  $('#RulePrice').change(function() {
    $(this).val($(this).val().replace(/[^0-9]/g,''));
    var v = $(this).val();
    $('#commission').text(Math.round(v * .08));
    $('#listing-fee').text(Math.round((v * 0.015 < 3 ? 3 : v * .015)));
  }).change();

  $('a.delete').click(function() {
    return confirm('Do you really want to delete this?');
  });
});