
  function editarAdministrador(id){
    //     ToDo: Perguntar se vai salvar as edições
    $(".editarAdmin").each(function(){
       if($(this).attr('id') == id){
           var $formulario = $("#formEditAdmin");
          $('#closeEditar').click(function(){
             closeEditar(id);
          });
           $(this).append( $formulario );
           $formulario.css("display", "block");
           $(this).show();
       }else{
         closeEditar($(this).attr('id'));
       }
    });
  }

  function closeEditar(id){
    $(".editarAdmin").each(function(){
       if($(this).attr('id') == id){
           $(this).hide();
       }
    });
  }

  //FUNÇÕES DA BUSCA
      var fazerBusca = function(){
        $(".editarAdmin").each(function(){
            $(this).hide();
        });
        $(".divAddAdmin").hide();
        var txt = $('#inputPesquisa').val();
        $('.nomeTutor').each(function(){
           if($(this).text().toUpperCase().indexOf(txt.toUpperCase()) == -1){
               $(this).closest('.itemUsuario').hide();
           }
        });
        var itens = document.getElementsByClassName("itemUsuario");
        var flagItens= true;
        for(var i=0; i<itens.length; i++){
          if(itens[i].style.display!="none"){
            flagItens=false;
          }
        }
        if(flagItens){
          document.getElementById("naoEncontrado").style.visibility="visible";
        }else{
          document.getElementById("naoEncontrado").style.visibility="hidden";
        }
      };

      var limparBusca = function(){
        $('.nomeTutor').each(function(){
           $(this).closest('.itemUsuario').show();
        });
      };

      $("#inputPesquisa").keydown(function(e) {
          limparBusca();
          fazerBusca();
      });

      $('#iconLupa').click(function(){
        if($('#inputPesquisa').val()!=""){
          limparBusca();
          fazerBusca();
        }else{
          limparBusca();
          document.getElementById("naoEncontrado").style.visibility="hidden";
        }
      });

  //ADD ADMIN
      function addAdmin(){
        $(".divAddAdmin").show();
      }
      function closeAddAdmin(){
        $(".divAddAdmin").hide();
      }
