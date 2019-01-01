function createWord(value, session_id, xcsrf, callback) {
    var url = '/session/words/create';
    var data = {
        session_id: session_id,
        content: value,
        _token: xcsrf
    };

    $.post(url, data, function (response) {
        callback(response);
    }, 'json');
}

function updateWord(id, value, session_id, xcsrf, totalLetter) {
    var url = '/session/words/' + id;
    var data = {
        session_id: session_id,
        content: value,
        total_letter: totalLetter,
        _token: xcsrf
    };

    $.post(url, data, function (response) {
    }, 'json');
}

function createSentence(value, session_id, xcsrf, callback) {
    var url = '/session/sentences/create';
    var data = {
        session_id: session_id,
        content: value,
        _token: xcsrf
    };

    $.post(url, data, function (response) {
        callback(response);
    }, 'json');
}

function updateSentence(id, value, session_id, xcsrf) {
    var url = '/session/sentences/' + id;
    var data = {
        session_id: session_id,
        content: value,
        _token: xcsrf
    };

    $.post(url, data, function (response) {
    }, 'json');
}

function createParagraph(title, content, session_id, xcsrf, callback) {
    var url = '/session/paragraphs/create';
    var data = {
        session_id: session_id,
        title: title,
        content: content,
        _token: xcsrf
    };

    $.post(url, data, function (response) {
        callback(response);
    }, 'json');
}

function updateParagraph(id, title, content, session_id, xcsrf) {
    var url = '/session/paragraphs/' + id;
    var data = {
        session_id: session_id,
        title: title,
        content: content,
        _token: xcsrf
    };

    $.post(url, data, function (response) {
    }, 'json');
}

function updateEssay(title, content, session_id, xcsrf) {
    var url = '/session/essays';
    var data = {
        session_id: session_id,
        title: title,
        content: content,
        _token: xcsrf
    };

    $.post(url, data, function (response) {
    }, 'json');
}

function updateAssign(group_id, value, session_id, xcsrf) {
    var url = '/groups/ajax-add-session/' + session_id + '?unique=1';

    var data = {
        session_id: session_id,
        assign: value,
        _token: xcsrf
    };

    $.post(url, data, function (response) {
    }, 'json');
}

function updateTotalWordLetter() {
    var total = 0;
    $('.word-row .total').each(function () {
        total += parseInt($(this).html()) || 0;
    });

    $('#totalword').val(total);
    $('#totalword').trigger('change');
}

function updateTotalSentenceLetter() {
    var total = 0;
    $('.sentence-row .total').each(function () {
        total += parseInt($(this).html()) || 0;
    });

    $('#totalsentence').val(total);
    $('#totalsentence').trigger('change');
}

function updateTotalParagraphLetter() {
    var total = 0;
    $('.paragraph-row .total').each(function () {
        total += parseInt($(this).html()) || 0;
    });

    $('#totalparagraphs').val(total);
    $('#totalparagraphs').trigger('change');
}

function updateTotalEssayLetter() {
    var total = 0;
    $('.essay-row .total').each(function () {
        total += parseInt($(this).html()) || 0;
    });

    $('#totalessays').val(total);
    $('#totalessays').trigger('change');
}

function updateTotalWord() {
    var total = 0;
    $('.word-row').each(function () {
        if ($(this).data('id') > 0)
            total++;
    });

    $('#total-word').html(total);
}

function updateTotalSentence() {
    var total = 0;
    $('.sentence-row').each(function () {
        if ($(this).data('id') > 0)
            total++;
    });

    $('#total-sentence').html(total);
}

function updateTotalParagraph() {
    var total = 0;
    $('.paragraph-row').each(function () {
        if ($(this).data('id') > 0)
            total++;
    });

    $('#total-paragraph').html(total);
}