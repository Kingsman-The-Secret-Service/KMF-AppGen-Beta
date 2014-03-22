$(document).ready(function(){
    $("form").validate({
            errorElement: "p",
            errorPlacement: function(error, element) {
                 error.appendTo(element.parents('div.input-prepend').next('span'));
                 error.addClass('text-error').prepend("<i class=\"icon-exclamation-sign icon-large\"></i> ");
            },
            success: function(label) {
                label.removeClass('text-error').html("<i class=\"icon-ok icon-large icon-green\"></i>");
            }
        });
        
    $('[data-datepicker]').each(function() {
    
        var options = { dateFormat: "yy-mm-dd"};   
        var additionalOptions = $(this).data("datepicker");
        jQuery.extend(options, additionalOptions);
        $(this).datepicker(options);
    });
});