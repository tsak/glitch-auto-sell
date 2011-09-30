$(document).ready(function () {
  // Calculate listing fee and commission on the fly
  $('#RulePrice').change(function() {
    $(this).val($(this).val().replace(/[^0-9]/g,''));
    var v = $(this).val();
    $('#commission').text(Math.round(v * .08));
    $('#listing-fee').text(Math.round((v * 0.015 < 3 ? 3 : v * .015)));
  }).change();

  // Calculate and display price per item
  $('#RulePrice,#RuleQuantity').change(function() {
    var price = $('#RulePrice').val();
    var quantity = $('#RuleQuantity').val();
    var ppi = Math.round(price/quantity*10)/10;
    $('#price-per-item').text(isNaN(ppi) ? '--' : ppi);
  }).change();

  // Confirm deletion
  $('a.delete').click(function() {
    return confirm('Do you really want to delete this rule and all auction history?');
  });

  // Make external links open in a new window or tab
  $("a[href^='http'][rel!='this-window']").attr('target','_blank');
});