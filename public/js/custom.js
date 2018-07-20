$(document).ready(function() {

    $('select[name="department"]').on('change', function(){
        var id = $(this).val();
        if(id) {
            $.ajax({
                url: '/request/service/get/'+id,
                type:"GET",
                dataType:"json",
                beforeSend: function(){
                    $('#loader').css("visibility", "visible");
                },

                success:function(data) {

                    $('select[name="service"]').empty();

                    $.each(data, function(key, value){

                        $('select[name="service"]').append('<option value="'+ key +'">' + value + '</option>');

                    });
                },
                complete: function(){
                    $('#loader').css("visibility", "hidden");
                }
            });
        } else {
            $('select[name="service"]').empty();
        }

    });

});