$(document).ready(function() {
    var options = {
        type:'post',
        dataType:'json',
        success: function(resp){
            $('#add_name_default').empty().html(resp.html);
        },
        error: function(XMLHttpRequest, textStatus, errorThrown){
            console.log(XMLHttpRequest);
            console.log(textStatus);
            console.log(errorThrown);
        }
    };
    $('#add_name_default').ajaxForm(options);
});
function rsvp_captcha(){
    $('#captcha_image').attr('src',Dadiweb.baseUrl+'captcha?r='+new Date().getTime());
}