$(document).ready(function () {
  // Calculate listing fee and commission on the fly
  $('#RulePrice').change(function() {
    $(this).val($(this).val().replace(/[^0-9]/g,''));
    var v = $(this).val();
    $('#commission').text(Math.round(v * .08));
    $('#listing-fee').text(Math.round((v * 0.015 < 3 ? 3 : v * .015)));
  }).change();

  // Confirm deletion
  $('a.delete').click(function() {
    return confirm('Do you really want to delete this rule and all auction history?');
  });

  // Make external links open in a new window or tab
  $("a[href^='http']").attr('target','_blank');
});