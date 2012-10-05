$(document).ready(function()
{
    var dynamicCheckboxData = {};
    var dynamicRadioData = {};
    var counter = 0;
    if (!generatedForm) {
        input = $('input[name="chk[]"]').clone();
        parent = $('input[name="chk[]"]');
        parent.after(input);
        parent = $('input[name="chk[]"]');
        parent.after(input);
        parent = $('input[name="chk[]"]');
        parent.after(input);
        $('input[name="chk[]"]').each(function()
        {
            dynamicCheckboxData[counter] = {'count': counter, 'value': counter};
            $(this).attr('id', 'dynamic_checkbox_' + counter);
            counter++;
            $(this).attr('value', counter);
            
        });
        dynamicCheckboxData = JSON.stringify(dynamicCheckboxData);
        $('[name=chk_jsonData]').attr('value', dynamicCheckboxData);
        input = $('input[name="rad[]"]').clone();
        parent = $('input[name="rad[]"]');
        input.attr('value', 2)
        parent.after(input);
        parent = $('input[name="rad[]"]');
        input.attr('value', 3)
        parent.after(input);
        parent = $('input[name="rad[]"]');
        input.attr('value', 4)
        parent.after(input);
        counter = 0;
        $('input[name="rad[]"]').each(function()
        {
            dynamicRadioData[counter] = {'count': counter, 'value': counter};
            $(this).attr('id', 'dynamic_radio_' + counter);
            counter++;
            $(this).attr('value', counter);
        });
        dynamicRadioData = JSON.stringify(dynamicRadioData);
        $('[name=rad_jsonData]').attr('value', dynamicRadioData);
        input = $('input[name="input[]"]').clone();
        parent = $('input[name="input[]"]');
        parent.after(input);
        parent = $('input[name="input[]"]');
        parent.after(input);
        parent = $('input[name="input[]"]');
        parent.after(input);
        counter = 0;
        $('input[name="input[]"]').each(function()
        {
            $(this).attr('id', 'dynamic_input_' + counter);
            counter++;
            $(this).attr('placeholder', 'Input nr ' + counter);
        });
    }
});