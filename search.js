; (function ($) {
    $(document).ready(function () {
        // $("#search-form").submit(function () {
        //     var data = {
        //         action: 'snowreports_shortcode1',
        //     }
        //     $.ajax({
        //         url: search_url,
        //         data: data,
        //         succsss: function(response){
        //             console.log(response);
        //             console.log("one");
        //         }
        //     });
        //     return false;
        // })

        $("#search-form").on("submit", function(){

            var data = {
                action: "snowreports_shortcode",
                a_name: $(this).find("#a_name").val(),
                categories: $(this).find("#categories").val(),
                practiceareas: $(this).find("#practiceareas").val(),
            }

            $.ajax({
                url: search_url,
                data: data,
                beforeSend: function(){
                    $(".search-element button").html("Search");
                    $(".search-element button").html('loading...');
                },
                success: function(response){
                    $(".search-element button").html("Search");
                    $("#ourresult").html(response);
                }
            });


            return false;
        });


        
    });


    

})(jQuery);
