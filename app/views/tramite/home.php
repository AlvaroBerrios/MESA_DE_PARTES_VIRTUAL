<!DOCTYPE>
<html>
<head>

<meta charset="UTF-8">
<!--
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />-->
  <meta name="viewport" content="width=device-width, initial-scale=1">
<title>MESA DE PARTES VIRTUAL</title>


		<script src="<?php echo site_resource('admin') ?>/js/jquery-2.1.4.min.js" type="text/javascript"></script>
        <script src="<?php echo site_resource('admin') ?>/js/custominputfile.min-es.js"></script>
        <script src="<?php echo site_resource('admin') ?>/js/jquery.validate.min.js"></script>
        <script src="<?php echo site_resource('admin') ?>/js/messages_es.js"></script> 
       
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?php echo site_resource('admin') ?>/js/css/custominputfile.min.css"  type="text/css" />
        <link rel="stylesheet" href="<?php echo site_resource('admin') ?>/css/style.css"  type="text/css" /> 

		<script src='https://www.google.com/recaptcha/api.js' async defer></script>
	
		<link rel="stylesheet" href= "https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"> 
    	<script src= "https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script> 
    	<script src= "https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"> </script> 
    	<!-- Nuevo  -->
	    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet"/>
	    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
	    <!--    -->

        <script>
            
         /**AP 15092020  Validacion de */
			Filevalidation = (a) => { 

        const fi = document.getElementById('requisito'+a); 
		
        // Check if any file is selected. 
        if (fi.files.length > 0) { 
            for ( i = 0; i <= fi.files.length - 1; i++) { 
  
                const fsize = fi.files.item(i).size; 
				const ftype= fi.files.item(i).type; 

                const ftmp_mane = fi.files.item(i).tmp_name;


                const file = Math.round((fsize / 1024)); 
                // The size of the file. 

				if (ftype === 'application/pdf') {
					if (file >= 8192) { 
                  /*  if (file >= 2048) { */
                      alert( "Archivo demasiado grande, seleccione un archivo de menos de 8 MB"); 
                      fi.value='';
		          	}else{
                        var input = fi;
                    var reader = new FileReader();
                    reader.readAsBinaryString(input.files[0]);
                    reader.onloadend = function(){
                        var count = reader.result.match(/\/Type[\s]*\/Page[^s]/g).length;
                     //   console.log('Number of Pages:',count );

						document.getElementById('size'+a).innerHTML = '| tamaño de archivo <b>'
                    + file + '</b> KB' + ' |  número de pagina(s) '+count; 

					$("#menu_item_id"+a).val(count); 
				

					var sum = 0;
					$("input[name='menu_item_id[]']").each( function() { 
						
  					   sum += +this.value;
						// alert(sum);
						 $("#txtfolio").val(sum);
						 $("#txtfolio_").val(sum);
					});
					

                   //  $("#txtfolio").val(count); 

                    }

                 }

                    


               }else{
					alert('Solo se permite subir archivos PDFs');
					fi.value='';
					
               }

                
				
            } 
        } 
    } 



             function soloNumeros(e)
				{
			
           var key = window.Event ? e.which : e.keyCode
           return ((key >= 48 && key <= 57) || (key==8))
			}
            
            
            function myFunction(){
                	$.ajax({
								url:"<?php echo site_url("tramite/consultadni")?>",
								data:{id:$("#txtdoc").val()},
								dataType:"json",
								type:"POST",
								success:function(data){
								    $("#txtnombre").val("");
								    $("#txtnombre").val(data.nombres);
								    $("#txtapepat").val("");
								    $("#txtapepat").val(data.apellido_paterno);
								    $("#txtapemat").val("");
								    $("#txtapemat").val(data.apellido_materno);
								}
					});
                
            }
            
			function myFunction2(){
                	$.ajax({
								url:"<?php echo site_url("tramite/consultaruc")?>",
								data:{id:$("#txtdoc").val()},
								dataType:"json",
								type:"POST",
								success:function(data){
								    $("#txtrazonsocial").val("");
								    $("#txtrazonsocial").val(data.razonsocial);
									$("#txtrazonsocialhid").val(data.razonsocial);
								}
					});
                
            }

            function getvalcboie(){
				var valuecbo = $("#txtie").find('option:selected').text();
				$("#txtie_val").val(valuecbo);
			}

		   /*genera requisito */
        /*nuevo*/
        function generaRequisito(idservicio) {

            //alert(idservicio);

            $("#ulfile li").remove();
            items_requisito = "";

            $.ajax({
                url: "<?php echo site_url("tramite/requisitos")?>",
                data: {id: idservicio},
                dataType: "json",
                type: "POST",
                success: function (data) {
                    var ctrl = 0;
                    $.each(data.requisitos, function (index, items) {
                        ctrl = ctrl + 1;
                        items_requisito = items_requisito + '<li><label>' + items.descripcion + ':</label><input type="file" onchange="Filevalidation(' + ctrl + ')"   name="afr-file[' + ctrl + ']" class="' + ((items.requerido === '1') ? 'required' : '') + '" id="requisito' + ctrl + '"> <span id="size' + ctrl + '"> </span> <input type="hidden" id="menu_item_id' + ctrl + '" value=""  name="menu_item_id[]"></li>';
                    })
                    $("#ulfile").append(items_requisito);
                    $('#solPedido').attr("disabled", false);
                }
            });
        }

            /* valida requisitos */
		   function validaRequisitos(cbo){

            switch(cbo) {
              case 1:
                /* NUEVO  */
              	var valuecbo2 = $("#cbservicio").find('option:selected').text();
              	$("#txtpedido_val").val(valuecbo2);
                var cbo = $("[name='cbservicio']").val();
                /*      */
                break;
              case 2:
				var cbo = $("[name='cbservicio_sub']").val();
                break;
			  case 3:
				var cbo = $("[name='cbservicio_sub2']").val();
                break;
              default:
                // code block
            } 

					$.ajax({
								url:"<?php echo site_url("tramite/getUltimoNivel")?>",
								data:{id:cbo},
								dataType:"json",
								type:"POST",
								success:function(data){
								
									var ctrl = 0;

									$.each(data.nivel,function(index, items){
										
                                         if(items.ultimoNivel==1){
											generaRequisito(cbo);
										 }
									})
									
									
								}
				     });


		   }
          
	

        </script>
        
        
        
        
		<script type="text/javascript">
				var cbo;
				var dependencia = [];
				
				
				 <?php
				foreach($solicitud as $item){
				?>
				      
					dependencia[<?php echo $item["id_tippedido"]?>] = "<?php echo $item["referencia"]?>";
				<?php
				}
				?>
				
				
 
				$(window).resize(function(){
					$('#afr-cmessage').css({
						   left: ($(window).width() - $('#afr-cmessage').outerWidth(true))/2,
						   top:  ($(window).height() - $('#afr-cmessage').outerHeight(true))/2
					  });
				});
				
				



				
				$(function(){
				
				
				
					$("#afr-btnclose").click(function(){
						$("#afr-cmessage").fadeOut(500,function(){
							$("#afr-overlay").fadeOut(700);
						});
						
						
						
					});
					$('#afr-cmessage').css({
						   left: ($(window).outerWidth() - $('#afr-cmessage').outerWidth(true))/2,
						   top:  ($(window).outerHeight() - $('#afr-cmessage').outerHeight(true))/2
					  });
					
					
					
					setTimeout(function(){

						$("#afr-msg").fadeOut(2000);
						},1800);
						
						
						var validar = $("#afr-frmfut").validate({
						errorElement:"span",
						errorClass:"afr-error",
						errorPlacement: function(error, element){},

						submitHandler:function(forms){

							$('.afr-btn').attr("disabled","disabled");
							forms.submit();
						}
						})



                     


						$('#level1_tramite').hide();
						$('#level2_tramite').hide();
     


                       /**Nivel 2*/

						$("#cbservicio_sub").change(function() {
						
							var idservicioNivel2 = $(this).val();
                                        $("#cbservicio_sub option:selected").each(function() {
								         $.post("index.php/tramite/getNivelPedidoLev2", {id2:idservicioNivel2, nivel:'2'
                                               }, function(data) {
                                                  if(data){
													$("#cbservicio_sub2").html(data);
									                  $("#level2_tramite").show();
												  }else{
													$('#level2_tramite').hide();
												  } 

                                           });
							

                              });

							  
                        })


						$("#cbservicio").change(function(){

							idservicio = $(this).val();
							/*********************************/
							$("#cbservicio option:selected").each(function() {

                                   $('#level2_tramite').hide();
                                    if(idservicio==21 || idservicio==22 ){
                                   	 $.post("index.php/tramite/getNivelPedido", {id: idservicio , nivel:'1'
                                   		 }, function(data) {
                                   			$("#cbservicio_sub").html(data);
                                   		   $("#level1_tramite").show();
                                   	  });
                                    }else{
                                   	$('#level1_tramite').hide();
                                    }
                                   
                            });
                                   
                           /*******************************************/

							$(".fundamentosBuzon").hide();
							switch(idservicio){
							    case "1" :$("#informacionAdicional").text("Indicar que es para abono de sus haberes");break;
							    case "2" :$("#informacionAdicional").text("Indicar el período qué desea que se emita (1973 a marzo 1998) y/o (abril 1998 a la actualidad). indicar las instituciones educativas en las que laboró, si son cesantes desde que fecha");break;
							    case "3" :$("#informacionAdicional").text("Indicar el uso de la cuenta ; para trámites personales o concurso público");break;
							    case "4" :$("#informacionAdicional").text("Indicar ugel de destino");break;
							    case "5" :$("#informacionAdicional").text("Para trámites personales, si es contratado o nombrado");break;
							    case "6" :$("#informacionAdicional").text("Indicar el número y el año de la emisión, si es resolución directoral o jefatural otros");break;
							    case "8" :$("#informacionAdicional").text("Indicar la institución educativa en la que labora");break;
							    case "9" :$("#informacionAdicional").text("Indicar el número de expediente a la cual se está haciendo el silencio administrativo");break;
								case "10" :
									$("#nro_cuenta").text("00000-282014");
									$("#informacionAdicional").text("Escriba aquí fundamento de pedido, Nombre Colegio, Distrito , Grados , Años , Sección (opcional), Especificar si I.E se encuentra activa o inactiva.");
								break;
								case "11" :$("#informacionAdicional").text("Indicar el tipo de retención");break;
								case "12" :$("#informacionAdicional").text("Indicar el mes y el año a reprogramar");break;
								case "13" :$("#informacionAdicional").text("Indicar consulta ");break;
								
								case "16" : $(".fundamentosBuzon").show();   $("#informacionAdicional").text("Detalle su consulta ,sea preciso y consiso.");
								             break;
								case "52" : $(".fundamentosBuzon").show();   $("#informacionAdicional").text("Especificar: causal (interés personal o unidad familiar ) y tipo (1,2 o 3)");
								 break;
								 case "51" : $(".fundamentosBuzon").show();   $("#informacionAdicional").text("");
								 break;
								case "21" : /*alert("goce");*/
								break;			 
								default:
								 $("#informacionAdicional").text("");
								break;
							}

							$("#afr-dependencia").text(dependencia[$(this).val()]);
							$("#txtdependencia").val(dependencia[$(this).val()]);
							$("#ulfile li").remove();
						
							items_requisito = "";
							

						//	combodinamico(idservicio);
						/********************Requisitos de tramite*/
							/*
							$.ajax({
								url:"<?php echo site_url("tramite/requisitos")?>",
								data:{id:idservicio},
								dataType:"json",
								type:"POST",
								success:function(data){
								
									var ctrl = 0;

									$.each(data.requisitos,function(index, items){
										ctrl = ctrl + 1;
										items_requisito = items_requisito + '<li><label>' + items.descripcion + ':</label><input type="file" onchange="Filevalidation('+ctrl+')"   name="afr-file[' + ctrl + ']" class="required" id="requisito' + ctrl + '"> <span id="size' + ctrl + '"> </span> <input type="hidden" id="menu_item_id'+ctrl+'" value=""  name="menu_item_id[]"></li>';
									
									})
									
									$("#ulfile").append(items_requisito);
									
								}
							});*/
                        /*********************************************************/

							
						});
				})
				
				function GeneraValidacion(){
					$('#requisito' + ctrl).rules('add', {
						required: true
						
					});
				}
				
				function countChar(val) {
              var len = val.value.length;
              if (len >= 250) {
                val.value = val.value.substring(0, 250);
              } else {
                $('#charNum').text(250 - len);
              }
               }; 
			
		$(function(){
		    
		     $("#cboTipoPersona").change(function(){
									
			                     	$("#cboTipoPersona option:selected").each(function() {
			                     		TipoPersona = $('#cboTipoPersona').val();
			                     		$.post("<?php echo(site_url("tramite/gettipodoc"))?>", {
			                     			TipoPersona : TipoPersona
			                     		}, function(data) {
			                     			$("#coTipoDocumento").html(data);
			                     		});
			                     	});
									
									
					var optionSelected = $("option:selected", this);
                     var valueSelected = this.value;
					 
					 if(valueSelected==1 /*|| valueSelected==3 */ || valueSelected=='' ){
						$("#txtdoc").prop("disabled",false);
						 $("#divRazon").css("display", "none");
						 $("#divNombres").css("display", "");

						 $("#txtapepat").addClass("required");
						 $("#txtnombre").addClass("required");
						 $("#divRazon").removeClass("required");

						 $("#txtnombreRazon").val("--");
						 $("#txtnombres").val("");
						 $("#txtapePaterno").val("");
						 $("#txtapeMaterno").val("");
						
						 $('#lblNroDoc').text("Número de Documento");
						 
						   
						$("#btnbsuquedadni").show();
						$("#btnbsuquedaruc").hide();
						  
						$("#txtdoc").attr('maxlength', 9);
						$("#txtdoc").val("");
						
						if(valueSelected==''){
							$("#coTipoDocumento").val(0);
						}else{
							$("#coTipoDocumento").val(2);
						}
					     
					 }else{
						 
						 $("#txtapepat").removeClass("required");
						 $("#txtnombre").removeClass("required");
						 $("#divRazon").addClass("required");

						  $("#btnbsuquedadni").hide();
						  $("#btnbsuquedaruc").show();

						 $("#txtdoc").attr('maxlength', 11);
						 $("#txtdoc").val("");
						 
						 if(valueSelected==4){
							
							 $('#nameEntidad').text("Nombre de Institución Educativa");
							 $('#lblNroDoc').text("Cod Local y/o Modular");
							  $("#txtnombreRazon").attr("placeholder", "Ingrese nombres de la Institución");
							 // $("#txtdoc").prop("disabled",true);

						 $("#txtapepat").removeClass("required");
						 $("#txtnombre").removeClass("required");
						 $("#divRazon").removeClass("required");

						}else{
							$("#txtdoc").prop("disabled",false);
							 $('#nameEntidad').text("Razón Social");
							 $('#lblNroDoc').text("Número de RUC");
							 $("#txtnombreRazon").attr("placeholder", "Ingrese nombre de la razón social");
							
						}
						 
						 
						 $("#divRazon").css("display", "");
						 $("#divNombres").css("display", "none");
						
						 $("#txtnombreRazon").val("");
						  $("#txtnombres").val("--");
						 $("#txtapePaterno").val("--");
						 $("#txtapeMaterno").val("--");
						 
						 $("#coTipoDocumento").val(3);
					 }	
									
									
			                   	
						}); 
		    
		})	
			
		/*                 NUEVO                 */
        $(document).ready(function () {
            $('.ie-select2').select2({
                ajax: {
                    url: '<?= site_url("tramite/institucion_educativa")?>',
                    type: 'post',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            searchTerm: params.term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    id: item.PersonaJuridicaId,
                                    text: item.Descripcion
                                }
                            })
                        };
                    },
                    cache: true
                },
                placeholder: 'SELECCIONAR IE',
                minimumInputLength: 3,
                language: {
                    inputTooShort: function () {
                        return 'Ingresa como mínimo 3 caracteres de la Institución Educativa...';
                    },
                    noResults: function () {
                        return 'No se encontraron resultados';
                    },
                    searching: function () {
                        return 'Buscando la institución Educativa..';
                    }
                }
            });
        });

        /*                                */

        /*                 NUEVO                 */
        $(document).ready(function () {
            $('.pedido-select2').select2({
                ajax: {
                    url: '<?= site_url("tramite/tipo_pedido")?>',
                    type: 'post',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            searchTerm: params.term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    id: item.id_tippedido,
                                    text: item.nombre
                                }
                            })
                        };
                    },
                    cache: true
                },
                placeholder: 'SELECCIONAR SOLICITUD',
                minimumInputLength: 3,
                language: {
                    inputTooShort: function () {
                        return 'Ingresa como mínimo 3 caracteres de la Solicitud...';
                    },
                    noResults: function () {
                        return 'No se encontraron resultados';
                    },
                    searching: function () {
                        return 'Buscando la solicitud..';
                    }
                }
            });
        });

        /*                                */

		</script>
		
		<style>
		.box {
		
		text-align:center;
vertical-align:middle; 
display:table-cell;
		
   position: relative;
 top: 50%;
  left: 10%;
  transform: translate(0%, 0%);
}

.box select {
  background-color: #c3cdd280;
color: #1c516f;
padding: 4px;
width: 100%;
border: none;
font-size: 15px;/*
box-shadow: 0 5px 25px rgba(0, 0, 0, 0.2);*/
-webkit-appearance: button;
appearance: button;
outline: none;
}

.box::before {
  content: "\f13a";
  font-family: FontAwesome;
  position: absolute;
  top: 0;
  right:0;
  left:80%;
  width: 20%;
  height: 100%;
  text-align: center;
  font-size: 18px;
  line-height: 30px;
  color: rgba(255, 255, 255, 0.5);
  background-color: #c3c4c9;
  pointer-events: none;
}

.box:hover::before {
  color: rgba(255, 255, 255, 0.6);
   background-color: rgba(255, 255, 255, 0.2);
}

.box select option {
  padding: 30px;
}

.solPedido {
  background-color: #008CBA;
  border: none;
  color: white;
  padding: 15px 62px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  border-radius: 4px;
  transition-duration: 0.4s;
  margin-left: 365px;
}

.solPedido:hover {
 background-color: #4CAF50;
   box-shadow: 0 6px 8px 0 rgba(0,0,0,0.24), 0 17px 50px 0 rgba(0,0,0,0.19);
  color: white;
}

.solPedido:disabled {
     border: 1px solid #999999;
     background-color: #cccccc;
     color: #666666;
}

.solPedido span:after {
  content: '\00bb';
  position: absolute;
  opacity: 0;
  top: 0;
  right: -20px;
  transition: 0.5s;
}

select.form-control:not([size]):not([multiple]) {
    height: calc(1.7rem) !important; 
}

/*           NUEVO              */
        .select2-results__option {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji" !important;
            text-transform: uppercase !important;
            font-size: 12px !important;
        }
/*								*/

</style>
	
	</head>
<body> 



    <div id="afr-wrapper">
    	<div id="afr-overlay">
        	
        </div>

       

    	<div id="afr-toph">
            
            <div id="afr-menu">
                <div id="afr-date">
                	Lima, <?php echo datesmart(date("Y-m-d"),'{day} {month:name} {year}') ?>
                    
                </div>
               
            </div>
        </div>
        <div id="afr-cheader">
            <div id="afr-navmenu">
                <div id="afr-header">
                    
                    <div id="afr-logo">
                        <img style="width:450px;margin-right:300px" src="<?php echo site_resource('admin') ?>/img/logo-ugel03.jpg" >
                         <img style="width:180px;padding-left:10px ; margin-bottom:9px" src="<?php echo site_resource('admin') ?>/img/LOGO UGEL 03-01 (1).png" >
                      <!--  <div id="afr-rm">
                            RM N° 0445-2012-ED
                        </div>-->
                    </div>
                    
                      
                </div>
            </div>  
        </div>
        <div id="afr-bgcontaniner"> 
            <div id="afr-container">
            	<div id="afr-contform">
                <?php if(@$this->session->userdata("msg")!=""){ ?>
                	<div id="afr-msg" class="afr-msg <?php echo((@$this->session->userdata("error")==1)? "afr-msgerror":"")?>">
                    	
                    	<?php echo @$this->session->userdata("msg");
						  $this->session->sess_destroy();
							
		
						?>
                    </div>
                    <?php }?>
                	<form id="afr-frmfut" name="afr-frmfut" action="<?php echo(site_url("tramite/enviar"))?>" method="post" enctype="multipart/form-data">
                    	<input type="hidden" name="txtdependencia" id="txtdependencia">
                    
					 <!--    <table  style="width:100%; background-color: #f9cfcf;">
                           <tr>
                             <th>Descarga en formato digital  <a target="_blank" href="http://www.ugel03.gob.pe/web-ugel03/wp-content/uploads/2016/06/FUT.pdf"> FUT </a>  </th>
                            
                           </tr>
                         
                         </table> 
                        -->

                        <table id="afr-tblmain" border="0" cellpadding="0" cellspacing="0">
                        	<tr class="">
                            	<td style="color:white;background:#a6a6b9;"  class="borde-down">
                                  <b> MESA DE PARTES VIRTUAL</b></br>
                                	FORMULARIO ÚNICO DE TRAMITE (FUT) - RM N° 0445-2012-ED
									
                                </td>
								<!--
                                <td rowspan="4" class="borde-down border-left" style="width:200px; color:black" id="afr-tdcosto">
                                	<img src="<?php echo site_resource('admin') ?>/img/logo-bn.png" border="0" >
                                	<div>Banco de la Nación</div>
                                	<div>Cta. Cte. N°: <span id="nro_cuenta">0000-281905</span></div>
                                	<div>COSTO:</div><div id="afr-costo" style="font-weight:700;font-size:20px" >S/. <span>0.00</span></div>
                                    <div>
                                    	<select id="cbcosto" name="cbcosto" class="required">
                                        	<option value="">-- Seleccione --</option>
                                        </select>
                                    </div>
                                </td>-->
                            </tr>
                            <tr class="textleft afr-tdsection">
                                <td class="borde-down spaceleft">
                                	I.- Tramite: 
                                	<span>
                                        <div class="box"  style="background-color:white !important; width:650px;" > 		
											<input id="txtpedido_val" name="txtpedido_val" type="hidden" value="">
															<!--              NUEVO            -->
                                                            <select onchange='validaRequisitos(1)'
                                                                    class='form-control pedido-select2' id='cbservicio'
                                                                    name='cbservicio' required></select>
                                                            <!--						-->
										</div>
      								</span>  
                                	<!--
                                    <span>
                                    <div class="box"  style="background-color:white !important; width:650px;" >
                                    <select style="background-color:white !important" id="cbservicio" onchange="validaRequisitos(1)"  name="cbservicio" required>
                                    	<option value="">-- Seleccione solicitud --</option>
                                        <?php
										foreach($solicitud as $item){
										?>
                                    	<option value="<?php echo $item["id_tippedido"]?>"><?php echo $item["nombre"]?></option>
										
										<?php
										}
										?>
                                    </select>
                                    </div>  
                                    </span>
                                    -->
                                </td>
                            </tr>
							<tr id="level1_tramite" name="level1_tramite"   class="textleft afr-tdsection">
							<div style="padding-lef:260px"  >  </div>
                                <td class="borde-down spaceleft">
								   <h style="color:#0077b9" ><!--I.- Resumen de su pedido:-->I.- Tramite:</h> 
                                    <span>
                                    <div class="box"  style="background-color:white !important; width:650px;" >
                                    <select   style="background-color:white !important"  onchange="validaRequisitos(2)"   id="cbservicio_sub" name="cbservicio_sub" >
                                    	<option value=""></option>
                                     <!--   <?php
										foreach($solicitud as $item){
										?>
                                    	<option value="<?php echo $item["id_tippedido"]?>"><?php echo $item["nombre"]?></option>
										
										<?php
										}
										?>-->
                                    </select>
                                    </div>  
                                    </span>
                                </td>
                            </tr>
							<tr id="level2_tramite" name="level2_tramite"   class="textleft afr-tdsection">
							<div style="padding-lef:260px"  >  </div>
                                <td class="borde-down spaceleft">
								   <h style="color:#0077b9" ><!--I.- Resumen de su pedido:-->I.- Tramite:</h> 
                                    <span>
                                    <div class="box"  style="background-color:white !important; width:650px;" >
                                    <select   style="background-color:white !important" onchange="validaRequisitos(3)"  id="cbservicio_sub2" name="cbservicio_sub2" >
                                    	<option value=""></option>
                                    </select>
                                    </div>  
                                    </span>
                                </td>
                            </tr>


						


                            <tr style="display:none"  class="textleft">
                                <td class="borde-down">
                                	<textarea id="txtresumen" name="txtresumen" placeholder="Detalle su solicitud" class="afr-textarea required"  ></textarea>
                                	
                                </td>
                           </tr>
                           <tr  class="textleft afr-tdsection">
                                <td  class="borde-down spaceleft">
                                	II. Dependencia o autoridad a quien se dirige: <span id="afr-dependencia" style="font-weight:700">DIRECTOR UGEL 03</span>
                                </td>
                           </tr>
                           <tr class="textleft afr-tdsection">
                                <td class="borde-down spaceleft">
                                	III. Datos del solicitante:
                                </td>
                            	
                            </tr>
                            
                          <!--  
                            <tr class="textleft">
                            	<td class="spaceleft">
                                	Persona Natural:  	  
                            <span>
                                	<div class="box"  style="width:200px;margin-botton:20px" >
  <select>
    <option value="1">Persona Natural</option>
  <option value="2">Persona Juridica</option>
  </select>
</div>
                    </span>       
                    Tipo Documento:      
                     <span>
                                	<div class="box"  style="width:200px;margin-botton:20px" >
  <select>
    <option value="1">DNI</option>
  <option value="2">RUC</option>
  </select>
</div>
                    </span>   
                    <label>DNI N° y/o RUC:</label><input class="textborder required number" style="width:150px; height:24px" type="text" onkeypress="return soloNumeros(event);" maxlength="11"  name="txtdoc" id="txtdoc" >
                    
                         
                                </td>
                            </tr>
                            -->
                             <tr>
                            	<td colspan="2">
                                	
                                	<table id="" border="0" cellpadding="0" cellspacing="0">
                                    	<tr style="height:60px;">
                                        	<td style="width:325px;  " class="spaceleft">
                                            	    	Tipo Persona*:  	  
                            <span>
                                	<div class="box"  style="width:200px;margin-botton:20px" >
                                        <?php echo "<select class='form-control required' id='cboTipoPersona' name='cboTipoPersona' required='required'>";
                                          if (count($tipopersona)) {
											  echo "<option value=''>[--Seleccione--]</option>";
                                              foreach ($tipopersona as $list) {
                                                  echo "<option value='". $list['id'] . "'>" . $list['descripcion'] . "</option>";
                                              }
                                          }
                                          echo "</select>";
										?>
</div>
                    </span> 
                                            </td>
                                            <td style="width:325px; padding-left:10px;" class="spaceleft">
                                            	 Tipo Documento*:      
                     <span>
                                	<div class="box"  style="width:200px;margin-botton:20px" >
  
                                   <select class="form-control required" required="required"  id="coTipoDocumento" name="coTipoDocumento"  >
                                          <option value="0">[--Seleccione--]</option>
                                       </select>
</div>
                    </span> 
                                            </td>
                                            <td style="width:325px; padding-left:10px;" class="spaceleft">
                                            	 <label for="numDocide" id="lblNroDoc" name="lblNroDoc" class="control-label required">Número de Documento:<b class="campoRequerido" >*</b></label>
                                            	 <input class="textborder required number" style="width:120px; height:24px" value="" type="text" onkeypress="return soloNumeros(event);" maxlength="11"  name="txtdoc" id="txtdoc" >
                                             	 <button id="btnbsuquedadni"  name="btnbsuquedadni" onclick="myFunction()" style="background-color: #252371;color: white;height: 28px;display:none " ><i class="fa fa-search"></i></button>
												  <button id="btnbsuquedaruc"  name="btnbsuquedaruc" onclick="myFunction2()" style="background-color: #252371;color: white;height: 28px;display:none " ><i class="fa fa-search"></i></button>
											</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                           
                            <tr> 
                            	<td colspan="2">
                                	<div class="row" id="divNombres" name="divNombres">
                                	<table id="" border="0" cellpadding="0" cellspacing="0">
                                    	<tr style="height:60px;">
                                        	<td style="width:350px;  " class="spaceleft">
                                            	<label>Apellido Paterno*:</label><input class="textborder" style="width:213px; height:24px"  type="text" name="txtapepat" id="txtapepat">
                                            </td>
                                            <td style="width:350px; padding-left:10px;" class="spaceleft">
                                            	<label>Apellido Materno :</label><input class="textborder" value=" " style="width:213px; height:24px" type="text" name="txtapemat" id="txtapemat">
                                            </td>
                                            <td style="width:260px; padding-left:10px;" class="spaceleft">
                                            	<label>Nombres *:</label><input class="textborder"  type="text" value=" " style="width:180px; height:24px" name="txtnombre" id="txtnombre">
                                            </td>
                                        </tr>
                                    </table>
                                    </div>
                                    <div class="row" id="divRazon"  name="divRazon" style="display:none;">
                                        
                                        	<label style="padding-left:30px"> Razón Social*:</label><input  disabled  value=" " class="textborder" style="width:800px; height:24px" type="text" name="txtrazonsocial" id="txtrazonsocial">
                                    </div>
									<input  type="hidden"   value="" name="txtrazonsocialhid" id="txtrazonsocialhid">
                                    
                                </td>
                            </tr>
                             <!-- 
                             <tr class="textleft">
                            	<td class="spaceleft">
                                	Persona Jurídica:
                                </td>
                            </tr>
                            <tr class="textleft">
                            	<td colspan="2" class="spaceleft">
                                	<label>Razón Social*:</label><input class="textborder" style="width:833px; height:24px" type="text" name="txtrazonsocial" id="txtrazonsocial">
                                	
                                </td>
                            </tr>
                            
                           <tr class="textleft">
                            	<td class="spaceleft">
                                	Tipo de Documento:
                                </td>
                            </tr>-->
                            <tr>
                            	<td colspan="2">
                                	
                                	<table id="" border="0" cellpadding="0" cellspacing="0">
                               <tr style="height:60px;">
                                        <!-- 	<td style="width:272px;  " class="spaceleft">
                                            	<label>DNI N° y/o RUC:</label><input class="textborder required number" style="width:150px; height:24px" type="text" onkeypress="return soloNumeros(event);" maxlength="11"  name="txtdoc" id="txtdoc" >
                                            </td> -->
                                            <td colspan="2"  style="width:600px; padding-left:10px;" class="spaceleft">
                                            <!--	<label>IE:</label>
                                            	
                                            	<input class="textborder" style="width:213px; height:24px" type="text" name="txtie" id="txtie"> -->
                                            	<label>IE:</label>
                                            	<span> 
                                            	
                                            	 		<div class="box"  style="width:500px;vertical-align:center:middle" >
                                            	 		
														 <input id="txtie_val" name="txtie_val" type="hidden" value="">

<!-- <select onchange='getvalcboie()' class='form-control required' id='txtie' name='txtie' required='required'>   -->
<!--       <?php //echo "<select onchange='getvalcboie()' class='form-control ' id='txtie' name='txtie' >";
                                          //if (count($ie)) {
											 //echo "<option selected value='0'>[--Seleccione--]</option>";
                                              //foreach ($ie as $list) {
                                                  //echo "<option value='".trim($list['PersonaJuridicaId'])."'>" . $list['Descripcion'] . "</option>";
                                              //}
                                          //}
                                          //echo "</select>";
										?>   -->
															<!--              NUEVO            -->
                                                            <select onchange='getvalcboie()'
                                                                    class='form-control ie-select2' id='txtie'
                                                                    name='txtie'></select>
                                                            <!--						-->
</div>
      </span>                                       	
                                            	
                                            </td>
                                            <td style="width:325px; padding-left:10px;" class="spaceleft">
                                            	<label>Cargo Actual:</label><input class="textborder" type="text" style="width:213px; height:24px" name="txtcargo" id="txtcargo">
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr class="textleft afr-tdsection">
                            	<td class="spaceleft borde-down borde-top" colspan="2">
                                	IV. DIRECCIÓN:
                                </td>
                            </tr>
                            <tr>
                            	<td colspan="2">
                                	
                                	<table id="" border="0" cellpadding="0" cellspacing="0">
                                    	<tr>
                                        	<td class="spaceleft">TIPO DE VÍA*:</td>
                                            <td><label>Avenida:</label><input type="radio" name="rbtvia" value="1"></td>
                                            <td><label>Jirón:</label><input type="radio" name="rbtvia" value="2"></td>
                                            <td><label>Calle:</label><input type="radio" name="rbtvia" value="3"></td>
                                            <td><label>Pasaje:</label><input type="radio" name="rbtvia" value="4"></td>
                                            <td><label>Carretera:</label><input type="radio" name="rbtvia" value="5"></td>
                                            <td><label>Prolongación:</label><input type="radio" name="rbtvia" value="6"></td>
                                            <td><label for="rbtvia[]" class="afr-error" style="display:none;">Please choose one.</label></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr class="textleft">
                            	<td colspan="2" class="spaceleft">
                                	<label style="display:inline-block; width:90px;">Nombre de la vía*:</label><input class="textborder required" style="width:814px; height:24px" type="text" name="txtnomvia" id="txtnomvia" >
                                	
                                </td>
                            </tr>
                            <tr class="textleft">
                            	<td colspan="2" class="spaceleft">
                                	<label style="display:inline-block; width:90px;">Referencia*:</label><input class="textborder required" style="width:814px; height:24px" type="text" name="txtreferencia" id="txtreferencia" >
                                	
                                </td>
                            </tr>
                            <tr>
                            	<td colspan="2" class="spaceleft">
                                	
                                	<table id="" border="0" cellpadding="0" cellspacing="0">
                                    	<tr>
                                    	     <td>
                                            	<label>Código Modular:</label><input class="textborder" style="width: height:24px" type="text" name="txtmodula" id="txtmodula">
                                        	</td>
                                        	<td>
                                            	<label>Teléfonos*:</label><input class="textborder required" style="width: height:24px" onkeypress="return soloNumeros(event);" maxlength="11" type="text" name="txtphone" id="txtphone">
                                        	</td>
                                            <td>
                                            	<label>Correo Electronico*:</label><input class="textborder email" style="width: height:24px" type="text" name="txtemail" id="txtemail" required >
                                        	</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>

                          <tr  class="textleft afr-tdsection  fundamentosBuzon" style="display:none" >
                            	<td class="spaceleft borde-down " colspan="2">
                                	V. FUNDAMENTOS DEL PEDIDO:
                                </td>
								
                            </tr>
							<tr  class="textleft   fundamentosBuzon" style="display:none" >
                              <td style="text-align:left;"   class="fundamentosBuzon" style="display:none" colspan="2">
                                ¿ Que información proporcionar?	&nbsp;&nbsp;<span id="informacionAdicional"  name="informacionAdicional" class="informacionAdicional" ></span>
                                </td>
                            
                            </tr>
                             <tr class="textleft fundamentosBuzon" style="display:none">
                                <td class="borde-down" colspan="2">
                                	<textarea onkeyup="countChar(this)" id="txtfundpedido" name="txtfundpedido" placeholder="Escriba aquí fundamento de pedido." class="afr-textarea" style="height:60px" required ></textarea>
                                	<p  style="padding-top:5px;color:black;padding-left:750px">Cantidad maxima de caracteres <b id="charNum" style="color:#CB5656" >250</b></p>
                                </td>
                           </tr>
						   
						   
						   <span style="display:none" id="informacionAdicional2"  name="informacionAdicional2" class="informacionAdicional2" ></span>
                           <tr class="textleft afr-tdsection">
                            	<td class="spaceleft borde-down " colspan="2">
                                	VI. DOCUMENTOS QUE SE ADJUNTAN:
                                </td>
                            </tr>
                             <tr class="textleft">
                                <td class="" colspan="2">
                                	<ul id="ulfile">
                                    	<li>
                                        	<label>* Copia de DNI :</label>
                                        	<input type="file" name="afr-file[]" class="required requisito" id="file1" >
                                        </li>
                                    </ul>
                                </td>
                           </tr>
						   <tr class="textleft ">
						        <td>
                                            	<label> * Ingrese Número de Oficio y/o documento de solicitud:</label><input class="textborder" style="width:50px" onkeypress="return soloNumeros(event);" maxlength="4"  type="text" name="txtfoficio" id="txtfoficio">
                                </td>
                           </tr>
						   <tr class="textleft ">
						        <td>
                                            	<label> * Ingrese Número de Folio(s):</label><input disabled  class="textborder" style="width:50px" onkeypress="return soloNumeros(event);" maxlength="3"  type="text" name="txtfolio_" id="txtfolio_">
												<input  onkeypress="return soloNumeros(event);" maxlength="3"  type="hidden" name="txtfolio" id="txtfolio">
							    </td>
                           </tr>
                           <tr class="textleft ">
                                <td class="spaceleft" colspan="2">

                                	Declaro que los datos presentados en el presente formulario los realizo con caracter de declaración jurada.
                               
							    </td>
                           </tr>


						   <tr class="textleft afr-tdsection">
                            	<td style="background-color:white; color:black" class="spaceleft borde-down borde-top" colspan="2">
                                <!--
									DECLARO que los datos presentados en el presente formulario los realizo con carácter de DECLARACIÓN JURADA
                                 -->

									<label class="checkbox checkbox-outline-success">
                                    <input class="textleft " type="checkbox" id="condiciones" name="condiciones"     data-toggle="modal" data-target="#exampleModalLong" ><span>(*)Acepto Terminos y condiciones</span><span class="checkmark"></span>
                                    <input id="resultadocheck" name="resultadocheck" type="hidden" value="0">
                                <!--  Modal -->
                <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div  style="background-color:#c62c2c; color:white" class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Terminos y condiciones</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                            <p style="text-align:justify"> Al dar click en este casillero, usted está autorizando </p>
    <p style="text-align:justify"><b> Veracidad de la información declara por el administrado</b></p>

  <p style="text-align:justify"> Declaro expresamente que la información ingresa en la Plataforma para el proceso de contratación docente 2020 es verdadera y conforme con lo establecido en el artículo 49 del Texto Único Ordenado de la Ley N° 27444, Ley del Procedimiento Administrativo General, y en caso de resultar falsa la información que proporciono, me sujeto a los alcances de lo establecido en el artículo 411 del Código Penal, concordante con el artículo 33 del Texto Único Ordenado de la Ley N° 27444, Ley del Procedimiento Administrativo General; autorizando a efectuar la comprobación de la veracidad de la información declarada en la presente plataforma.</p>

<p style="text-align:justify"><b> Autorización para la notificación al correo electrónico</b> </p>

<p style="text-align:justify">AUTORIZO de forma expresa y conforme a lo dispuesto por el artículo N° 20 del Texto único Ordenando de la Ley N° 27444 – Ley del Procedimiento Administrativo General, aprobado mediante el DECRETO SUPREMO Nº 004-2019-JUS y modificado mediante el Decreto Legislativo N° 1497, a la UNIDAD DE GESTION EDUCATIVA LOCAL 03 – UGEL 03, que me notifique el/los acto(s) administrativo(s), comunicados o documentación adicional que se emitan a consecuencia del proceso de contratación docente 2020 al correo electrónico consignado en presente plataforma; así mismo acuerdo que el  acto administrativo, los comunicados o la documentación adicional pueda estar contenida en un archivo adjunto o un enlace web a través del cual se descargará y/o otros mecanismo que garanticen su notificación.</p>

<p style="text-align:justify">Tengo conocimiento que las notificaciones dirigidas a la dirección de mi correo electrónico señalada en la presente Plataforma se entiende válidamente efectuadas cuando la UGEL 03 reciba la respuesta de recepción de la dirección electrónica antes señalada; a través del acuse de recibo, el mismo que dejará constancia del acto de notificación; en concordancia a lo establecido por el artículo 20 del mencionado Texto Único Ordenado, surtiendo efectos el día siguiente que conste haber sido recibido en mi bandeja de entrada, conforme a lo previsto en el numeral 2 del artículo 25 del citado Texto Único Ordenado.</p>

<p style="text-align:justify">
En atención a la presente autorización me comprometo con las siguientes obligaciones:
1.	Señalar una dirección de correo electrónica válida, a la cual tenga acceso y que se mantenga activa durante el proceso de contratación docente 2020.
2.	Asegurar que la capacidad del buzón de la dirección de correo electrónico permita recibir los documentos a notificar.
3.	Revisar continuamente la cuenta de correo electrónico, incluyendo la bandeja de spam o el buzón de correo no deseado.</p>

<p style="text-align:justify">El no tomar conocimiento oportuno de las notificaciones remitidas por la UNIDAD DE GESTION EDUCATIVA LOCAL 03 – UGEL 03, debido al incumplimiento de las presentes obligaciones, constituye exclusiva responsabilidad de mi persona. </p>

<p style="text-align:justify">DECRETO LEGISLATIVO Nº 1497: DECRETO LEGISLATIVO QUE ESTABLECE MEDIDAS PARA PROMOVER Y FACILITAR CONDICIONES REGULATORIAS QUE CONTRIBUYAN A REDUCIR EL IMPACTO EN LA ECONOMÍA PERUANA POR LA EMERGENCIA SANITARIA PRODUCIDA POR EL COVID- 19
Artículo 3.- Incorporación de párrafo en el artículo 20 de la Ley Nº 27444, Ley del Procedimiento Administrativo General
Incorpórase un último párrafo en el artículo 20 de la Ley Nº 27444, Ley del Procedimiento Administrativo General, cuyo texto queda redactado de la manera siguiente:
“Artículo 20.- Modalidades de notificación
(…)</p>
<p style="text-align:justify">El consentimiento expreso a que se refiere el quinto párrafo del numeral 20.4 de la presente Ley puede ser otorgado por vía electrónica.”</p>

<p style="text-align:justify"><b>Autorización para el tratamiento de los datos personal del administrado</b></p>

<p style="text-align:justify">En atención a los dispuesto por la Ley N° 29733, Ley de Protección de Datos Personales y su Reglamento aprobado por Decreto Supremo N° 003-2013-JUS, AUTORIZO a la UNIDAD DE GESTION EDUCATIVA LOCAL 03 – UGEL 03 al tratamiento de mis datos personales, así como cualquier otra información ingresada en la plataforma para el proceso de contratación docente 2020.</p>



                          </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
                              
                                </label>



							   
							    </td>
                            </tr>
                        </table>
                        <div style="text-align:right">
                           <!--
                            <div id="ap-important">
                              <b> Acceso a instructivo:</b>  <a style=" z-index: 9999;" href="https://www.youtube.com/watch?v=liiPbifXBNk">Enlace</a> 
                            </div>-->
                            <div id="ap-important">
                               <b style="color:black" > Acceso al video instructivo Mesa de partes virtual :</b>  <a target="_blank" style=" z-index: 9999;" href="https://www.youtube.com/watch?v=liiPbifXBNk">Haga clic al Enlace</a> <br>
                               <b style="color:black" >Sobre el horario de recepción de documentos (RD Nº 03920-2020-UGEL03 – Artículo 4)</b><br>
                                <ul>
                                 <li>- La presentación de documentos en la mesa de partes virtual podrá realizarse sin restricción de horario.</li>
                                 <li>- Sin embargo, la recepción se efectuará de acuerdo con el horario de la atención de la UGEL 03 (lunes a viernes de 8:00 a.m. a 4:45 p.m.)</li>
                                 <li>- Pasado este horario, la documentación podrá ser presentada, pero se dará por recibida a partir del día hábil siguiente.</li>
                                </ul>
                                <b style="color:black" >Sobre problemas técnicos</b><br>
                                <p>Si tuviese inconvenientes para ingresar su solicitud, puede escribir al correo electrónico ayudampv@ugel03.gob.pe para recibir mayor orientación.</p>
                            </div>
                        	<div id="afr-important">
                            	<b>Importante:</b> Antes de enviar el formulario, asegurese que su correo este digitado correctamente y sea válido. <br>
                            	No registrar correos con extension <b>yahoo</b>, tenemos incovenientes por el momento.(*)Obligatorio
                            	
                            </div>

                              <div style="text-align:center !important;"  class="col-md-offset-2 col-md-4">
						        <div class="g-recaptcha" data-sitekey="6LeElakZAAAAABshRg5ekULJC3t8q1PY5f3UKEw_">
						        
						          
						      </div>
						
						      	<input disabled class="solPedido" id= "solPedido" style="vertical-align:middle" type="submit" value="Enviar Solicitud" class="afr-btn"  >
						      

						   </div>
                          
                            
                        
                        </div>
                        
                    </form>
                  
                </div>
				</br></br></br>
            </div>
        </div>

	

		<div style="clear:both"></div>
        <div id="afr-footer">
            <div id="afr-ctextfooter">
                <div id="afr-textf">
                    <ul>
                        <li class="fcontact">(01) 6155800 Anexo: 13018 Informes</li>
                        <li class="ftime">Atención de 8:30am a 1:00pm y de 2:00pm a 4:00pm</li>
                        <li class="fhome">UGEL 03 -Av. Iquitos 918, La Victoria </li>
                    </ul>
                </div>
                <div id="afr-copy">
                    UGEL 03 | Equipo de Tecnologia de la Información <?Php echo date("Y");?> &copy; Todos los derechos reservados
                </div>
            </div>
    	</div>
    </div>
	
	
</body>
</html>