/*Declaraciones*/

$('#editAntecedentesPatologicos , #editMedicamentos').multiSelect();
$('#editGestante , #editTransfusion , #PPST , #HSH , #Trans').checkboxradio();


$(function () {
    $("#tabs").tabs();
});

$(function () {
    $("#accordion").accordion({heightStyle: "content"});
});

$('#multi-antecedentes').multiSelect();

$('#multi-pruebas').multiSelect();



//Multiselect de Antecedentes Patologicos

$('.ms-list .ms-elem-selectable.misAntecedentes').each(function () {
    $(this).css('display', 'none');
    $(this).addClass('ms-hover');
    $(this).addClass('ms-selected');

});

$('.ms-list .ms-elem-selection.misAntecedentes').each(function () {
    $(this).addClass('ms-selected');
    $(this).css('display', 'block');
});

if($('#editTipoHepatitis').val() != 2){
    $('#estadio').addClass('hidden');
}

if($('#editFuentePesquisa').val() != 3){
    $('#motivo').addClass('hidden');
}

if($('#editEvolucionClinica').val() != 8){
    $('#fechaFallecido').addClass('hidden');
    $('#causa').addClass('hidden');
}


//Fin de declaraciones


//select realacionados sin twig

$('#editTipoHepatitis').on('change', function () {

    if($(this).val() == 2){
        $('#estadio').removeClass('hidden');
        $('.estadioss').removeClass('opcional');
    }else{
        $('#estadio').addClass('hidden');
        $('.estadioss').addClass('opcional');
    }
});

$('#editFuentePesquisa').on('change', function () {

    if($(this).val() == 3){
        $('#motivo').removeClass('hidden');
        $('.pesquisa').removeClass('opcional');
    }else{
        $('#motivo').addClass('hidden');
        $('.pesquisa').addClass('opcional');
    }
});
$('#editEvolucionClinica').on('change', function () {
    if($(this).val() == 8){
        $('#causa').removeClass('hidden');
        $('#fechaFallecido').removeClass('hidden');
        $('.fallecimiento').removeClass('opcional');
    }else{
        $('#causa').addClass('hidden');
        $('#fechaFallecido').addClass('hidden');
        $('.fallecimiento').addClass('opcional');
    }
});
$('#editSexo').on('change', function () {

    if($(this).val() == 'Femenino'){
        $('.gestante').removeClass('hidden');

    }else{
        $('#editGestante').prop('checked',false);
        $('#editGestante').button('refresh');
        $('.gestante').addClass('hidden');
        $('.siGestante').addClass('hidden');
    }
});
$('#editGestante').on('click', function () {
    if ($(this).prop('checked')){
        $('.siGestante').removeClass('hidden');
        $('.gestante').removeClass('opcional');
    }else {
        $('.siGestante').addClass('hidden');
        $('.gestante').addClass('opcional');
    }
});

$('#editSexo').on('change', function () {

    if($(this).val() != ''){
        $('#orientacionesSexuales').removeClass('hidden');
        $('.ambos').removeClass('hidden');
        if($(this).val() == 'Masculino'){
            $('.masculino').removeClass('hidden');
        }else {
            $('.masculino').addClass('hidden');
        }
    }else {
        $('#orientacionesSexuales').addClass('hidden');
    }
});

