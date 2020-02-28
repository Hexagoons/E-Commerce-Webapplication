document.addEventListener('DOMContentLoaded', function() {
    var elems;

    elems = document.querySelectorAll('.sidenav');
    M.Sidenav.init(elems, {});

    elems = document.querySelectorAll('input[data-length]');
    M.CharacterCounter.init(elems, {});

    elems = document.querySelectorAll('select');
    M.FormSelect.init(elems, {});

    elems = document.querySelectorAll('.chips');

    if(elems.length > 0) {
        M.Chips.init(elems, {
            placeholder: "attribuut:waarde",
            secondaryPlaceholder: "+attribuut:waarde",
            onChipAdd: chips2Input,
            data: input2Chips()
        });
    }
});

function chips2Input() {
    var instance = M.Chips.getInstance(document.getElementById('specChips'));
    var input    = document.getElementById('specs');
    input.value  = '';

    for(var i = 0; i < instance.chipsData.length; i++){
        if(input.value === '') {
            input.value = instance.chipsData[i].tag;
        } else {
            input.value += '|' + instance.chipsData[i].tag;
        }
    }
}

function input2Chips() {
    var input    = document.getElementById('specs');
    var values   = input.value.split('|');
        values    = (values[0] === "") ? [] : values;
    var chipData = '';

    for (var i = 0; i < values.length; i++) {
        chipData += '{tag: "' + values[i] + '"},';
    }

    return eval('[' + chipData + ']');
}