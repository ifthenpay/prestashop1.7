$(document).ready(function()
{
  $("#ifthenpay_mbway_mobilephone").keydown(function (e) {
    // Allow: backspace, delete, tab, escape, enter and .
    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110]) !== -1 ||
        // Allow: Ctrl+A, Command+A
        (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
        // Allow: home, end, left, right, down, up
        (e.keyCode >= 35 && e.keyCode <= 40)) {
            // let it happen, don't do anything
            return;
    }
    // Ensure that it is a number and stop the keypress
    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
        e.preventDefault();
    }

    if ($(this).val().length > 8) {
      e.preventDefault();
    }
  });

  function checkIfFilled(event)
  {
    if ($("#ifthenpay_mbway_mobilephone").val().trim() === '' || $("#ifthenpay_mbway_mobilephone").val().length !== 9){
      $('#ifthenpay_mbway_mobilephone_error').text('Tem de introduzir o número de telemóvel associado a uma conta MBWay para poder finalizar a encomenda');
      event.preventDefault();
      event.stopPropagation();
      return false;
    }
  }

  $('#payment-confirmation button').click(function (event) {
    if ($('input[name=payment-option]:checked').data("moduleName") === 'ifthenpay_mbway') {
      return checkIfFilled(event);
    }
  });
	
  $('#payment-confirmation').click(function (event) {
	  if ($('input[name=payment-option]:checked').data("moduleName") === 'ifthenpay_mbway')
	  {
		 return checkIfFilled(event)
	  } 
  });
  
});