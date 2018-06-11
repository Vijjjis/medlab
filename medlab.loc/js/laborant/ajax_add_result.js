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

    $('.H1_Indicators').hide();
    $('.indicators').hide();
    $('.result-button').hide();

	$('.selectpicker_patient').change(function() {
        var id_patient = $(this).val();
        if(id_patient){
            $.ajax({
                    type: "POST",
                    url: "../../php/laborant/ajax_add_result.php",
                    data: { id_patient: id_patient },
                    cache: false,
                    success: function(responce){
                        $('.selectpicker_order_id').html(responce);
                        $('.selectpicker_order_id').selectpicker({title: 'Выберите заказ'}).selectpicker('render');
                        $('.selectpicker_order_id').prop('disabled', false); 
                        $('.selectpicker_order_id').selectpicker('refresh');

                        $('.H1_Indicators').hide();
                        $('.indicators').hide();
                        $('.result-button').hide();
                        /*$('.order-button').prop('value', 'Выберите анализы');
                        $('.order-button').prop('disabled', true);*/
                    }

            });
        };
    });

    $('.selectpicker_order_id').change(function() {
        var order_id = $(this).val();
        if(order_id){
            $.ajax({
                    type: "POST",
                    url: "../../php/laborant/ajax_add_result.php",
                    data: { order_id: order_id },
                    cache: false,
                    success: function(responce){
                        $('.selectpicker_medtest_of_specimen').html(responce);
                        $('.selectpicker_medtest_of_specimen').selectpicker({title: 'Выберите анализы пробы'}).selectpicker('render');
                        $('.selectpicker_medtest_of_specimen').prop('disabled', false); 
                        $('.selectpicker_medtest_of_specimen').selectpicker('refresh');

                        $('.H1_Indicators').hide();
                        $('.indicators').hide();
                        $('.result-button').hide();
                    }
            });
        };
    });

    $('.selectpicker_medtest_of_specimen').change(function() {

        var idSpecimen = $(this).find('option:selected').data('idspecimen');
        var idMedtest = $(this).val();

        $('.specimen').prop('value', idSpecimen);

        $.ajax({
                type: "POST",
                url: "../../php/laborant/ajax_add_result.php",
                data: { idSpecimen: idSpecimen, idMedtest: idMedtest },
                cache: false,
                success: function(responce){
                    $('.indicators').html(responce);
                    $('.H1_Indicators').show();
                    $('.indicators').show();
                    $('.result-button').show();
                    $('.selectpicker_norm').show();

                    // создание массива для id всех показателей анализа  
                    var arr_id_ind = [];
                    $('.form_ind').each(function(i,item) {
                        arr_id_ind.push($(item).data('id_ind'));
                    });
                    var str_id_ind = arr_id_ind.toString();
                    $('.arr_id_ind').prop('value', str_id_ind);
                },
                error: function(){ 
                    alert('error');
                }
        });
    });
    $('.result-button').click(function() {
            var date = js_yyyy_mm_dd_hh_mm_ss(date);
            $('.result_date').prop('value', date);
            console.log(date);
    });

});