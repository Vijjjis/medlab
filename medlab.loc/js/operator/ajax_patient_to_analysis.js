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
            if(id_patient){
                $.ajax({
                        type: "POST",
                        url: "../../php/operator/ajax_patient_to_analysis.php",
                        data: { id_patient: id_patient },
                        cache: false,
                        success: function(responce){
                            $('.selectpicker_analysis').html(responce);
                            $('.selectpicker_analysis').selectpicker({title: 'Выберите анализы'}).selectpicker('render');
                            $('.selectpicker_analysis').prop('disabled', false); 
                            $('.selectpicker_analysis').selectpicker('refresh');
                            $('.order-button').prop('value', 'Выберите анализы');
                            $('.order-button').prop('disabled', true);
                        }
                });
            };
        });

        $('.selectpicker_analysis').change(function () {
            var array_NameMedtest = [];
            var array_IDMedtest = [];
            var sum=0;

            $('.selectpicker_analysis option:selected').each(function(){
                sum+=parseInt($(this).data('medtest_price'));
            })
            $('.selectpicker_analysis option:selected').each(function(i,item) {
                    array_IDMedtest.push($(item).data('medtest_id'));
                    array_NameMedtest.push($(item).data('medtest_name'));
            });

            var string_IDMedtest = array_IDMedtest.toString();
            var string_NameMedtest = array_NameMedtest.toString();

            if (sum !== 0) {
                $('.order-button').prop('disabled', false);
                $(".order-button").prop('value', 'Оформить заказ - ' + sum + ' руб.');

                //передаю данные в невидимые input
                $('.sum_price').prop('value', sum);
                $('.medtest_id').prop('value', string_IDMedtest);
                $('.medtest_name').prop('value', string_NameMedtest);
            }
            else {
               $('.order-button').prop('disabled', true);
               $('.order-button').prop('value', 'Выберите анализы');

               $('.sum_price').prop('value', '');
               $('.medtest_id').prop('value', '');
               $('.medtest_name').prop('value', ''); 
            }
        });

        $('.order-button').click(function() {
            var date = js_yyyy_mm_dd_hh_mm_ss (date);
            $('.order_date').prop('value', date);
        });
});