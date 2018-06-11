$(document).ready(function() {

	function js_yyyy_mm_dd_hh_mm_ss (date) {
          now = new Date();
          year = "" + now.getFullYear();
          month = "" + (now.getMonth() + 1); if (month.length == 1) { month = "0" + month; }
          day = "" + now.getDate(); if (day.length == 1) { day = "0" + day; }
          hour = "" + now.getHours(); if (hour.length == 1) { hour = "0" + hour; }
          minute = "" + now.getMinutes(); if (minute.length == 1) { minute = "0" + minute; }
          second = "" + now.getSeconds(); if (second.length == 1) { second = "0" + second; }
          return date = year + "-" + month + "-" + day + " " + hour + ":" + minute + ":" + second;
    }

    $('.selectpicker_patient').change(function() {
        var id_patient = $(this).val();
        console.log(id_patient);
        if(id_patient){
            $.ajax({
                    type: "POST",
                    url: "../../php/laborant/ajax_add_specimen.php",
                    data: { id_patient: id_patient },
                    cache: false,
                    success: function(responce){
                        $('.selectpicker_order_id').html(responce);
                        $('.selectpicker_order_id').selectpicker({title: 'Выберите заказ'}).selectpicker('render');
                        $('.selectpicker_order_id').prop('disabled', false); 
                        $('.selectpicker_order_id').selectpicker('refresh');
                        $('.specimen-button').prop('value', 'Выберите заказ и анализы');
                        $('.specimen-button').prop('disabled', true);
                    }

            });
        };
    });

    $('.selectpicker_order_id').change(function() {
        var order_id = $(this).val();
        if(order_id){
            $.ajax({
                    type: "POST",
                    url: "../../php/laborant/ajax_add_specimen.php",
                    data: { order_id: order_id},
                    cache: false,
                    success: function(responce){
                        $('.selectpicker_medtest_of_specimen').html(responce);
                        $('.selectpicker_medtest_of_specimen').selectpicker({title: 'Выберите анализ'}).selectpicker('render');
                        $('.selectpicker_medtest_of_specimen').prop('disabled', false); 
                        $('.selectpicker_medtest_of_specimen').selectpicker('refresh');
                        $('.specimen-button').prop('value', 'Выберите анализы пробы');
                        $('.specimen-button').prop('disabled', true);
                    }
            });
        };
    });
    $('.selectpicker_medtest_of_specimen').change(function() {
        
        var array_typebio = [];
        $('.selectpicker_medtest_of_specimen option:selected').each(function(i,item) {
             array_typebio.push($(item).data('typebio'));
        });
        console.log(array_typebio);

        if (array_typebio.length > 1) {
            for (var i = 0; i < array_typebio.length; i++) {
                for (var j = i-1; j >= 0; j--) {
                    if (array_typebio[j] != array_typebio[i]) {
                        $('.specimen-button').prop('value', 'Выбранные анализы не могут относится к одной пробе!');
                        $('.specimen-button').prop('disabled', true); 
                    }
                    else {
                        $('.specimen-button').prop('value', 'Добавить пробу');
                        $('.specimen-button').prop('disabled', false);  
                    }
                }
            }
        }
        else if (array_typebio.length == 1) {
            $('.specimen-button').prop('value', 'Добавить пробу');
            $('.specimen-button').prop('disabled', false);  
        }
        else {
            $('.specimen-button').prop('value', 'Выберите анализы пробы');
            $('.specimen-button').prop('disabled', true);  
        }
    });

    $('.specimen-button').click(function() {
            var date = js_yyyy_mm_dd_hh_mm_ss(date);
            $('.specimen_date').prop('value', date);
            console.log(date);
    });

});