$(document).ready(function() {
	$('.change').prop('disabled', true);
	var i_lastname = 0;
	var i_firstname = 0;
	var i_fathername = 0;
	var i_address = 0;
	var i_phone = 0;

	$('.btnln').click(function() {
		i_lastname++;
		if (i_lastname == 1) {
			$('.lastname').prop('disabled', false);

		}
		else if (i_lastname == 2) {
			i_lastname = 0;
			var lastname = $('.lastname').val();
			$.ajax({
                        type: "POST",
                        url: "../../php/patient/ajax_changePI.php",
                        data: { lastname: lastname },
                        cache: false,
                        success: function(responce){
                            $('.btnln').html(responce);
                        }
                });
			$('.lastname').prop('disabled', true);
		}
	});


	$('.btnfn').click(function() {
		i_firstname++;
		if (i_firstname == 1) {
			$('.firstname').prop('disabled', false);

		}
		else if (i_firstname == 2) {
			i_firstname = 0;
			var firstname = $('.firstname').val();
			$.ajax({
                        type: "POST",
                        url: "../../php/patient/ajax_changePI.php",
                        data: { firstname: firstname },
                        cache: false,
                        success: function(responce){
                            $('.btnfn').html(responce);
                        }
                });
			$('.firstname').prop('disabled', true);
		}
	});
	$('.btnftn').click(function() {
		i_fathername++;
		if (i_fathername == 1) {
			$('.fathername').prop('disabled', false);

		}
		else if (i_fathername == 2) {
			i_fathername = 0;
			var fathername = $('.fathername').val();
			$.ajax({
                        type: "POST",
                        url: "../../php/patient/ajax_changePI.php",
                        data: { fathername: fathername },
                        cache: false,
                        success: function(responce){
                            $('.btnftn').html(responce);
                        }
                });
			$('.fathername').prop('disabled', true);
		}
	});
	$('.btna').click(function() {
		i_address++;
		if (i_address == 1) {
			$('.address').prop('disabled', false);

		}
		else if (i_address == 2) {
			i_address = 0;
			var address = $('.address').val();
			$.ajax({
                        type: "POST",
                        url: "../../php/patient/ajax_changePI.php",
                        data: { address: address },
                        cache: false,
                        success: function(responce){
                            $('.btna').html(responce);
                        }
                });
			$('.address').prop('disabled', true);
		}
	});
	$('.btnp').click(function() {
		i_phone++;
		if (i_phone == 1) {
			$('.phone').prop('disabled', false);

		}
		else if (i_phone == 2) {
			var phone = $('.phone').val();
			$.ajax({
                        type: "POST",
                        url: "../../php/patient/ajax_changePI.php",
                        data: { phone: phone },
                        cache: false,
                        success: function(responce){
                            $('.btnp').html(responce);
                        }
                });
			i_phone = 0;
			$('.phone').prop('disabled', true);
		}
	});

});