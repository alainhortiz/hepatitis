/*Declaraciones*/

/*$('#addOcupacion').select2({
    placeholder: "Seleccione la ocupación..",
    allowClear: true
});*/

$('#addAntecedentesPatologicos , #addMedicamentos').multiSelect();
$('#addGestante , #addTransfusion , #PPST , #HSH , #Trans').checkboxradio();


//Fin de declaraciones

// Boton buscar
$('#btnBuscar').on("click", function(){
    $('#containerResultado').css("display","block");
});

//funcion que reinicia todos los campos de la vista
function limpiarCampos()
{
    $(':input').val("");
    /*$('#addOcupacion').select2("");*/

    $('.ms-list .ms-elem-selectable').each(function(){
        $(this).css('display', 'list-item').removeClass('ms-selected');
    });

    $('.ms-list .ms-elem-selection').each(function(){
        $(this).css('display', 'none').addClass('ms-hover').removeClass('ms-selected');
    });
    $('.nombres').prop("disabled",false);
    $('#carnetIdentidad').prop("disabled",false);
    $('#btnLocalizar').prop("disabled",true);
    $('#btnAdicionar').prop("disabled",true);
    $(':checkbox').prop('checked',false);
    $('#addGestante , #addTransfusion ,#PPST , #HSH , #Trans').button('refresh');
    $('.gestante').addClass('hidden');
    $('.siGestante').addClass('hidden');
    $('#orientacionesSexuales').addClass('hidden');
    $('.ambos').addClass('hidden');
    $('.masculino').addClass('hidden');

    $('.f1-step').each(function () {
        $(this).removeClass('active');
        $(this).removeClass('activated');
    });
    //reiniciar el asistente
    $('.first').addClass('active');
    $('.f1 .btn-previous').each(function() {

        $(this).parents('fieldset').css('display', '');
    });
    $('.firstField').css('display', 'block');

    //vaciar las tablas
    $('#esquemasPrueba tbody').empty();
    $('#esquemasMedicamento tbody').empty();
    $('#tablaEvolucionesClinicas tbody').empty();
    $('#tablaCoinfeccionesPaciente tbody').empty();

    $("#causaFallecimiento").val('');
    $("#divCausaFallecimiento").addClass('hidden');
    $("#rowAddEvolucionClinica").removeClass('hidden');
    $("#rowCausaFallecimiento").addClass('hidden');
}


//Boton limpiar
$('#btnLimpiar').on("click", function(){
    $('#containerResultado').css("display","none");
    limpiarCampos();
});

$('#carnetIdentidad').on("keyup", function(){

    if($('#carnetIdentidad').val().trim().length != 0){
        $('.nombres').prop("disabled",true);
    }else{
        $('.nombres').prop("disabled",false);
    }
    if($('#carnetIdentidad').val().trim().length == 11){
        $('#btnLocalizar').prop("disabled",false);
        $('#btnAdicionar').prop("disabled",false);
    }else{
        $('#btnLocalizar').prop("disabled",true);
        $('#btnAdicionar').prop("disabled",true);
    }
});
$('.nombres').on("keyup", function(){

    if($(this).val().trim() != ''){
        $('#btnLocalizar').prop("disabled",false);
        $('#carnetIdentidad').prop("disabled",true);
    }else{
        $('#btnLocalizar').prop("disabled",true);
        $('#carnetIdentidad').prop("disabled",false);
    }
});


//select realacionados sin twig

$('#addTipoHepatitis').on('change', function () {

    if($(this).val() == 2){
        $('#estadio').removeClass('hidden');
        $('.estadioss').removeClass('opcional');
    }else{
        $('#estadio').addClass('hidden');
        $('.estadioss').addClass('opcional');
    }
});

$('#addFuentePesquisa').on('change', function () {

    if($(this).val() == 3){
        $('#motivo').removeClass('hidden');
        $('.pesquisa').removeClass('opcional');
    }else{
        $('#motivo').addClass('hidden');
        $('.pesquisa').addClass('opcional');
    }
});

$('#addFechaInicioTratamiento').on('change', function () {

    if($('#fechaFinalTratamiento').val() != ''){
        $('#final').removeClass('hidden');
        $('.fechaFinal').removeClass('opcional');
    }else{
        $('#final').addClass('hidden');
        $('.fechaFinal').addClass('opcional');
    }
});


$('#addSexo').on('change', function () {

    if($(this).val() == 'Femenino'){
        $('.gestante').removeClass('hidden');

    }else{
        $('#addGestante').prop('checked',false);
        $('#addGestante').button('refresh');
        $('.gestante').addClass('hidden');
        $('.siGestante').addClass('hidden');
    }
});
$('#addGestante').on('click', function () {
    if ($(this).prop('checked')){
        $('.siGestante').removeClass('hidden');
        $('.gestante').removeClass('opcional');
    }else {
        $('.siGestante').addClass('hidden');
        $('.gestante').addClass('opcional');
    }
});
$('#addSexo').on('change', function () {

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

