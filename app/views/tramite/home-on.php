<!DOCTYPE>
<html>
<head>

<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FORMULARIO ÚNICO DE TRAMITE (FUT)</title>
		<script src="<?php echo site_resource('admin') ?>/js/jquery-2.1.4.min.js" type="text/javascript"></script>
        <script src="<?php echo site_resource('admin') ?>/js/custominputfile.min-es.js"></script>
        <script src="<?php echo site_resource('admin') ?>/js/jquery.validate.min.js"></script>
        <script src="<?php echo site_resource('admin') ?>/js/messages_es.js"></script> 
        
		<link rel="stylesheet" href="<?php echo site_resource('admin') ?>/js/css/custominputfile.min.css"  type="text/css" />
        <link rel="stylesheet" href="<?php echo site_resource('admin') ?>/css/style.css"  type="text/css" /> 
        
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
							
						},
						rules: {
							 'via[]':{ required:true },
							 'afr-file[]' :{ required:true }
							}
						})
						$("#cbservicio").change(function(){
							idservicio = $(this).val();
							switch(idservicio){
								case "9" :
									/*alert("AFR Soft");return false;*/
								break;
							}
							$("#afr-dependencia").text(dependencia[$(this).val()]);
							$("#txtdependencia").val(dependencia[$(this).val()]);
							$("#ulfile li").remove();
							$("#afr-message table tr").remove();
							$("#cbcosto option").remove();
							
							items_requisito = "";
							
							$.ajax({
								url:"<?php echo site_url("tramite/requisitos")?>",
								data:{id:$(this).val()},
								dataType:"json",
								type:"POST",
								success:function(data){
									var ctrl = 0;
									$.each(data.requisitos,function(index, items){
										ctrl = ctrl + 1;
										items_requisito = items_requisito + '<li><label>' + items.descripcion + ':</label><input type="file" name="afr-file[' + ctrl + ']" class="required" id="requisito' + ctrl + '"></li>';
																				
										
									})
									if(data.costo.length > 0){
										if(idservicio == 2){
											var tr = "";
											var opt = '<option value="">-- Seleccione --</option>';
											$.each(data.costo,function(index, items){
												tr = tr + '<tr><td style="width:140px;">' + items.observacion + '</td><td style="width:80px;">S/. ' + items.costo + '</td></tr>'
												opt = opt + '<option value="' + items.costo + '">' + items.observacion + '   ---  ' + 'S/.' + items.costo + '</option>';
											})
											$("#cbcosto").append(opt);
											$("#afr-message table").append(tr);
											$("#cbcosto").show();
											$("#afr-overlay").fadeIn(500,function(){
												$("#afr-cmessage").fadeIn(700);
											});
											$("#ulfile").append(items_requisito);
											$("#afr-costo span").text("0.00");
											return false;
										}
										$("#cbcosto").hide();
										$.each(data.costo,function(index, items){
											$("#afr-costo span").text(items.costo);
										})
									}
									else{
										$("#cbcosto").hide();
										$("#afr-costo span").text("0.00");
									}
									
									//alert(data.requisitos[0].id_requisito);
									$("#ulfile").append(items_requisito);
								}
							});
							$("#cbcosto").change(function(){
								$("#afr-costo span").text($(this).val());
							});
							/*$.post("<?php echo site_url("tramite/requisitos")?>",{id:$(this).val()},function(data){
								alert(data.requisito);
								$("#ulfile").append(data);
							});*/
						});
				})
			
		</script>
	
	</head>
<body>    
    <div id="afr-wrapper">
    	<div id="afr-overlay">
        	
        </div>
        <div id="afr-cmessage">
        	<div id="afr-bodymsg">
            	<a href="javascript:void(0)" id="afr-btnclose">X</a>
        		<div id="afr-headmsg">Escala de Pagos</div>
                <div id="afr-message">
                	<table>
                    	
                        
                    </table>
                </div>
            </div>
        
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
                        <img src="<?php echo site_resource('admin') ?>/img/logo-ugel03.jpg" >
                        <div id="afr-rm">
                            RM N° 0445-2012-ED
                        </div>
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
                        <table id="afr-tblmain" border="0" cellpadding="0" cellspacing="0">
                        	<tr class="">
                            	<td class="borde-down">
                                	FORMULARIO ÚNICO DE TRAMITE (FUT)
                                </td>
                                <td rowspan="6" class="borde-down border-left" style="width:200px" id="afr-costo">
                                	<img src="<?php echo site_resource('admin') ?>/img/logo-bn.png" border="0" >
                                	<div>Banco de la Nación</div>
                                	<div>Cta. Cte. N°: 0000-281905</div>
                                	<div>COSTO:</div><div id="afr-costo" style="font-weight:700;font-size:20px" >S/. <span>0.00</span></div>
                                    <div>
                                    	<select id="cbcosto" name="cbcosto" class="required">
                                        	<option value="">-- Seleccione --</option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr class="textleft afr-tdsection">
                                <td class="borde-down spaceleft">
                                	I.- Resumen de su pedido:
                                    <span>
                                    <select id="cbservicio" name="cbservicio" required>
                                    	<option value="">-- Seleccione solicitud --</option>
                                        <?php
										foreach($solicitud as $item){
										?>
                                    	<option value="<?php echo $item["id_tippedido"]?>"><?php echo $item["nombre"]?></option>
										
										<?php
										}
										?>
                                    </select>
                                    </span>
                                </td>
                            </tr>
                            <tr class="textleft">
                                <td class="borde-down">
                                	<textarea id="txtresumen" name="txtresumen" placeholder="Detalle su solicitud" class="afr-textarea required"  ></textarea>
                                	
                                </td>
                           </tr>
                           <tr class="textleft">
                                <td class="borde-down spaceleft">
                                	II. Dependecia o autoridad a quien se dirige: <span id="afr-dependencia" style="font-weight:700">DIRECTOR UGEL 03</span>
                                </td>
                           </tr>
                           <tr class="textleft afr-tdsection">
                                <td class="borde-down spaceleft">
                                	III. Datos del solicitante:
                                </td>
                            	
                            </tr>
                            <tr class="textleft">
                            	<td class="spaceleft">
                                	Persona Natural:
                                </td>
                            </tr>
                            <tr>
                            	<td colspan="2">
                                	
                                	<table id="" border="0" cellpadding="0" cellspacing="0">
                                    	<tr style="height:60px;">
                                        	<td style="width:325px;  " class="spaceleft">
                                            	<label>Apellido Paterno:</label><input class="textborder" style="width:213px; height:24px" type="text" name="txtapepat" id="txtapepat">
                                            </td>
                                            <td style="width:325px; padding-left:10px;" class="spaceleft">
                                            	<label>Apellido Materno:</label><input class="textborder" style="width:213px; height:24px" type="text" name="txtapemat" id="txtapemat">
                                            </td>
                                            <td style="width:325px; padding-left:10px;" class="spaceleft">
                                            	<label>Nombres:</label><input class="textborder" type="text" style="width:213px; height:24px" name="txtnombre" id="txtnombre">
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                             <tr class="textleft">
                            	<td class="spaceleft">
                                	Persona Jurídica:
                                </td>
                            </tr>
                            <tr class="textleft">
                            	<td colspan="2" class="spaceleft">
                                	<label>Razón Social:</label><input class="textborder" style="width:833px; height:24px" type="text" name="txtrazonsocial" id="txtrazonsocial">
                                	
                                </td>
                            </tr>
                            <tr class="textleft">
                            	<td class="spaceleft">
                                	Tipo de Documento:
                                </td>
                            </tr>
                            <tr>
                            	<td colspan="2">
                                	
                                	<table id="" border="0" cellpadding="0" cellspacing="0">
                                    	<tr style="height:60px;">
                                        	<td style="width:272px;  " class="spaceleft">
                                            	<label>DNI N° y/o RUC:</label><input class="textborder required number" style="width:150px; height:24px" type="text" name="txtdoc" id="txtdoc" >
                                            </td>
                                            <td style="width:325px; padding-left:10px;" class="spaceleft">
                                            	<label>IE:</label><input class="textborder" style="width:213px; height:24px" type="text" name="txtie" id="txtie">
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
                                        	<td class="spaceleft">TIPO DE VÍA:</td>
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
                                	<label style="display:inline-block; width:90px;">Nombre de la vía:</label><input class="textborder required" style="width:814px; height:24px" type="text" name="txtnomvia" id="txtnomvia" >
                                	
                                </td>
                            </tr>
                            <tr class="textleft">
                            	<td colspan="2" class="spaceleft">
                                	<label style="display:inline-block; width:90px;">Referencia:</label><input class="textborder required" style="width:814px; height:24px" type="text" name="txtreferencia" id="txtreferencia" >
                                	
                                </td>
                            </tr>
                            <tr>
                            	<td colspan="2" class="spaceleft">
                                	
                                	<table id="" border="0" cellpadding="0" cellspacing="0">
                                    	<tr>
                                        	<td>
                                            	<label>Teléfonos:</label><input class="textborder" style="width: height:24px" type="text" name="txtphone" id="txtphone">
                                        	</td>
                                            <td>
                                            	<label>Código Modular:</label><input class="textborder" style="width: height:24px" type="text" name="txtmodula" id="txtmodula">
                                        	</td>
                                            <td>
                                            	<label>Correo:</label><input class="textborder email" style="width: height:24px" type="text" name="txtemail" id="txtemail" required >
                                        	</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr class="textleft afr-tdsection">
                            	<td class="spaceleft borde-down borde-top" colspan="2">
                                	DECLARO que los datos presentados en el presente formulario los realizo con carácter de DECLARACIÓN JURADA
                                </td>
                            </tr>
                            <tr class="textleft afr-tdsection">
                            	<td class="spaceleft borde-down " colspan="2">
                                	V. FUNDAMENTOS DEL PEDIDO:
                                </td>
                            </tr>
                             <tr class="textleft">
                                <td class="borde-down" colspan="2">
                                	<textarea id="txtfundpedido" name="txtfundpedido" placeholder="Escriba aquí fundamento de pedido." class="afr-textarea" style="height:80px" required ></textarea>
                                	
                                </td>
                           </tr>
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
                                <td class="spaceleft" colspan="2">
                                	Declaro que los datos presentados en el presente formulario los realizo con caracter de declaración jurada.
                                </td>
                           </tr>
                        </table>
                        <div style="text-align:right">
                        	<div id="afr-important">
                            	<b>Importante:</b> Antes de enviar el formulario, asegurese que su correo este digitado correctamente y sea válido.
                            </div>
                        	<input type="submit" value="Enviar" class="afr-btn"  >
                        </div>
                        
                    </form>
                </div>
				
            </div>
        </div>
		<div style="clear:both"></div>
        <div id="afr-footer">
            <div id="afr-ctextfooter">
                <div id="afr-textf">
                    <ul>
                        <li class="fcontact">4273210 / 4262627 /  4261562</li>
                        <li class="ftime">Atención de 8:30am a 1:00pm y de 2:00pm a 4:00pm</li>
                        <li class="fhome">UGEL 03 - Jr. Andahuaylas 563, Cercado de Lima </li>
                    </ul>
                </div>
                <div id="afr-copy">
                    UGEL 03 | <?Php echo date("Y");?> &copy; Todos los derechos reservados
                </div>
            </div>
    	</div>
    </div>
	
	
</body>
</html>