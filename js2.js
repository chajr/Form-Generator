SyntaxHighlighter.all();
$(document).ready(function()
{
    var activeNumber = 0;
    mail = $('.mail_amp').attr('href');
    mail2 = $('.mail_amp').html();
    mail = mail.replace(/{;amp;}/, '@');
    mail2 = mail2.replace(/{;amp;}/, '@');
    $('.mail_amp').attr('href', mail);
    $('.mail_amp').html(mail2);
    if (selectedExample) {
        $('#tabs').tabs({selected: 2});
        switch (selectedExample) {
            case'login_form':
                activeNumber = 1;
                break;
            case'register_form':
                activeNumber = 2;
                break;
        }
        $('#ex_accordion').accordion({
            active: activeNumber,
            autoHeight: false
        });
    } else {
        $('#tabs').tabs();
        $('#ex_accordion').accordion({
            autoHeight: false
        });
    }
    $('#doc_accordion').accordion({
        autoHeight: false
    });
    $('.button').click(function(){
        rel = $(this).attr('rel');
        parent = $(this).parent();
        child = parent.children('.' + rel);
        child.slideToggle('fast');
    });
    $('input[type="date"]').datepicker();
    $('#shipp_check').click(function(){
        $('#shipp_address').slideToggle('fast');
    });
});