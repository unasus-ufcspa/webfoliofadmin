var inputs = document.querySelectorAll( '.selectArquivos' );
var files = false;
Array.prototype.forEach.call( inputs, function( input )
{
	var label	 = input.nextElementSibling,
		labelVal = label.innerHTML;

	input.addEventListener( 'change', function( e )
	{
		var fileName = '';
		if( this.files && this.files.length > 1 )
			fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
		else
			fileName = e.target.value.split( '\\' ).pop();
		if( fileName ){
			label.innerHTML = fileName;
      $('.buttonCarregar').prop('disabled', false);
		}else{
			label.innerHTML = labelVal;
    }
	});
});

  // function handleFileSelect(evt) {
  //   evt.stopPropagation();
  //   evt.preventDefault();
	//
  //   var dt = evt.dataTransfer; // FileList object.
	// 	var files = dt.files;
	// 	console.log(files);
	// 	console.log(files[0]);
  //   // files is a FileList of File objects. List some properties.
  //   var output = [];
  //   if(files.length>1){
  //     output.push(files.length+" arquivos selecionados");
  //   }else{
  //      output.push(escape(files[0].name));
  //   }
  //   document.getElementsByClassName('nomeArquivo')[0].innerHTML = output.join('');
	//
	// 	// e.preventDefault();
	//
	// 	  // var ajaxData = new FormData($form.get(0));
	// 		//
	// 	  // if (droppedFiles) {
	// 	  //   $.each( droppedFiles, function(i, file) {
	// 	  //     ajaxData.append( $input.attr('name'), file );
	// 	  //   });
	// 	  // }
	//
	// 	  $.ajax({
	// 	    url: '{{web_dir}}carregarTutoresArquivo',
	// 	    type: 'post',
	// 	    data: files,
	// 	    dataType: 'json',
	// 	    cache: false,
	// 	    contentType: false,
	// 	    processData: false,
	// 	    complete: function() {
	// 	      // $form.removeClass('is-uploading');
	// 	    },
	// 	    success: function(data) {
	// 	      // $form.addClass( data.success == true ? 'is-success' : 'is-error' );
	// 	      // if (!data.success) $errorMsg.text(data.error);
	// 	    },
	// 	    error: function() {
	// 	      // Log the error, show an alert, whatever works for you
	// 	    }
	// 	  });
	//
  //   $('.buttonCarregar').prop('disabled', false);
  //   $('.box').css( "background-color", "rgba(255, 255, 255, 0.0)");
  //   $('.box').css( "border", "dashed 3px rgba(255, 255, 255, 0.6)");
  // }


  function handleDragOver(evt) {
    $('.box').css( "background-color", "#9187c7");
    $('.box').css( "border", "dashed 3px rgb(255, 255, 255)");
    evt.stopPropagation();
    evt.preventDefault();
    evt.dataTransfer.dropEffect = 'copy'; // Explicitly show this is a copy.
  }

  function handleDragLeave(evt) {
    $('.box').css( "background-color", "rgba(255, 255, 255, 0.0)");
    $('.box').css( "border", "dashed 3px rgba(255, 255, 255, 0.6)");
    evt.stopPropagation();
    evt.preventDefault();
  }

  // Setup the dnd listeners.
  var dropZone = document.getElementsByClassName('boxInput')[0];
  dropZone.addEventListener('dragover', handleDragOver, false);
  dropZone.addEventListener('dragleave', handleDragLeave, false);
  dropZone.addEventListener('drop', handleFileSelect, false);

	// $(".box").on('submit', function(e) {
  //   // if ($form.hasClass('is-uploading')) return false;
	//
  //   // $form.addClass('is-uploading').removeClass('is-error');
	//
  //   e.preventDefault();
  //   var ajaxData = new FormData($(".box").get(0));
	//
  //   if (files) {
  //     $.each( files, function(i, file) {
  //       ajaxData.append( $input.attr('name'), file );
  //     });
  //   }
	//
  //   $.ajax({
  //     url: $(".box").attr('action'),
  //     type: $(".box").attr('method'),
  //     data: ajaxData,
  //     dataType: 'json',
  //     cache: false,
  //     contentType: false,
  //     processData: false,
  //     // complete: function() {
  //     //   $(".box").removeClass('is-uploading');
  //     // },
  //     success: function(data) {
  //       // $form.addClass( data.success == true ? 'is-success' : 'is-error' );
  //       // if (!data.success) $errorMsg.text(data.error);
  //       console.log("Sucesso");
  //     },
  //     error: function() {
  //       // Log the error, show an alert, whatever works for you
  //       console.log("Erro");
  //     }
  //   });
  // });
	// $(".box").on('submit', function(e) {
	//
	//
	//     e.preventDefault();
	//     var ajaxData = new FormData($(".box").get(0));
	//
	//     if (files) {
	//       $.each( files, function(i, file) {
	//         ajaxData.append( $input.attr('name'), file );
	//       });
	//     }
	//
	//     $.ajax({
	//       url: "{{web_dir}}carregarTutoresArquivo",
	//       type: $(".box").attr('method'),
	//       data: ajaxData,
	//       dataType: 'json',
	//       cache: false,
	//       contentType: false,
	//       processData: false,
	//
	//       success: function(data) {
	//         console.log("Sucesso");
	//       },
	//       error: function() {
	//         console.log("Erro");
	//       }
	//     });
	//   });
