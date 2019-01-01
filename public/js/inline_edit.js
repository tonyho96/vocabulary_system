/*
GUIDE:
define class .inline-edit-group to wrap all rows
define class .template to wrap all template (set display:none)
    define .inline-edit-template: full content row template
        each row must be wrapped by .inline-row class
        include .inline-edit class to toggle the edit mode
    define .new-row-template: empty row template
predefine the first row
That's it
*/

$('body').on('click', '.inline-row .inline-edit', function() {
    if ($(this).closest('.inline-row').hasClass('active')) {
        return;
    }

    if ($(this).find('input[type="text"]').length)
        return;

    var this_obj = $(this);
    var prev_obj = $(this).closest('.inline-row').prev('.inline-row');
    if (prev_obj.length && !prev_obj.data('value')) {
        return;
    }

    var value = $(this).closest('.inline-row').data('value') || '';
    if ($(this).hasClass('value2')) {
        value = $(this).closest('.inline-row').data('value2') || '';
    }

    $(this).closest('.inline-row').addClass('active');
    if ($(this).hasClass('text-area')) {
        $(this).html('<textarea rows="4" class="inline-edit-value">' + value + '</textarea>');
    }
    else
        $(this).html('<input class="inline-edit-value" type="text" value="'+ value +'">');

    setTimeout(function() {
        this_obj.find('.inline-edit-value').focus();
    }, 0);
    $(this).removeClass('hover');
});

$('body').on('blur', '.inline-edit-value', function(){
    var parent_object = $(this).closest('.inline-row');
    var value = $(this).val();
    var display_text = value;

    $(this).closest('.inline-edit').addClass('hover');
    if ($(this).closest('.inline-edit').hasClass('text-area'))
        display_text = '<pre>' + value + '</pre>';

    if ($(this).closest('.inline-edit').hasClass('value2')) {
        parent_object.data('value2', value);
        parent_object.find('.inline-edit.value2').html('<span>'+ display_text +'</span>');
    }
    else {
        parent_object.data('value', value);
        parent_object.find('.inline-edit.value1').html('<span>'+ display_text +'</span>');
    }
    parent_object.removeClass('active');

    if (value) {
        var next_object = parent_object.next('.inline-row');

        if (!next_object.length) {
            var template = parent_object.closest('.inline-edit-group').find('.new-row-template').html();
            parent_object.closest('.inline-edit-group').append(template);
            next_object = parent_object.next('.inline-row');
        }

        if (!next_object.data('value')) {
            var template = parent_object.closest('.inline-edit-group').find('.inline-edit-template').html();
            next_object.replaceWith(template);
        }
    }
});
