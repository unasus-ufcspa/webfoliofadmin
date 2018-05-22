function getDate(){
  var today = new Date();
  var dd = today.getDate();
  var mm = today.getMonth()+1;

  var yyyy = today.getFullYear();
  if(dd<10){
      dd ='0'+dd;
  }
  if(mm<10){
      mm ='0'+mm;
  }
  var today = yyyy+'-'+mm+'-'+dd;
  return today;
}

$('#salvarEdicao').click(function() {
    var cod = $('.inputCod').val();
    var desc = $('.inputDescricao').val();

    if($('.inputDtInicio').val() == ''){
      var dtStart = getDate();
    }else{
      var dtStart = $('.inputDtInicio').val();
    }

    if($('.inputDtFim').val() == ''){
      var dtEnd = getDate();
    }else{
      var dtEnd = $('.inputDtFim').val();
    }

    if ($('#toggle').is(":checked")){
      var status = 'A'
    }else{
      var status = 'I'
    }

    $('#addClass_DsCode').val(cod);
    $('#addClass_DsDescription').val(desc);
    $('#addClass_StStatus').val(status);
    $('#addClass_DtStart').val(dtStart);
    $('#addClass_DtFinish').val(dtEnd);

    return true;
});
