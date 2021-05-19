<!DOCTYPE>
<html>
<head>
<?php

?>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FORMULARIO ÚNICO DE TRAMITE (FUT)</title>
<style>
<style type="text/css">
		html, body, div, span, applet, object, iframe,
h1, h2, h3, h4, h5, h6, p, blockquote, pre,
a, abbr, acronym, address, big, cite, code,
del, dfn, em, img, ins, kbd, q, s, samp,
small, strike, strong, sub, sup, tt, var,
b, u, i, center,
dl, dt, dd, ol, ul, li,
fieldset, form, label, legend,
table, caption, tbody, tfoot, thead, tr, th, td,
article, aside, canvas, details, embed, 
figure, figcaption, footer, header, hgroup, 
menu, nav, output, ruby, section, summary,
time, mark, audio, video {
		margin: 0;
		padding: 0;
		border: 0;
		font-size: 100%;
		font: inherit;
		vertical-align: baseline;
	}
	
	.l-right{
		border-right:1px solid #000;
	}
	.l-left{
		border-left:1px solid #000;
	}
	.l-bottom{
		border-bottom:1px solid #000;
	}
	.l-border{
		border-top:1px solid #000;
		border-right:1px solid #000;
		border-left:1px solid #000;
		border-bottom:1px solid #000;
	}
	.l-top{
		border-top:1px solid #000;
	}
	.vtop{
		vertical-align:top;
	}
	.aright{
		text-align:right;
		padding-right:2px;
	}
	.aleft{
		text-align:left;
	}
	.normal{
		font-weight:normal;
	}
	.textleft{
		text-align:left;
		padding-left:2px;
	}
	.l-right{
		border-right:1px solid #000;
	}
	td.center{
		text-align:center;
		vertical-align: middle;
	}
	td.borde-down{
		border-bottom:1px solid #999;
		
	}
	td.border-left{
		border-left:1px solid #999;
	}
	td.borde-top{
		border-top:1px solid #999;
	}
	.textborder{
		border:1px solid #6CC0FF;
		
	}
	td.spaceleft{
		padding-left:5px;
	}
	table{
		font-size:13px;
		font-family:Arial, Helvetica;
	}
	table td{
		height: 30px;
    	vertical-align: middle;
	}
	.textborder{
		border:1px solid #6CC0FF;
		display:inline-block;
		
	}
	label{
		display:inline-block;
		margin-right:3px;
	}
 	tr.afr-tdsection{
		background:#cae4ff;
		font-weight:700;
	}
	#afr-rm{
		text-align:center;
		font-size:13px;
		font-family:Arial, Helvetica;
	}
	td.spacer{
		padding-right:24px;
		text-align:left;
	}
</style>
</head>
<body>    
    <div id="afr-wrapper">
    	
        <div id="afr-bgcontaniner" style=" background:none"> 
            <div id="afr-container">
            	<div id="afr-contform">
                	<img src="<?php echo site_resource('admin') ?>/img/logo-ugel03.jpg" >
                    <div id="afr-rm">
                        <b>RM N° 0445-2012-ED</b>
                    </div>
                	<form id="afr-frmfut" name="afr-frmfut" action="<?php echo(site_url("tramite/enviar"))?>" method="post" enctype="multipart/form-data">
                    	
                        <table id="afr-tblmain" border="0" cellpadding="0" cellspacing="0" class="l-border center">
                        	<tr class="">
                            	<td class="borde-down center" style="font-size:15px">
                                	<b>FORMULARIO ÚNICO DE TRAMITE (FUT)</b>
                                </td>
                             <!--   <td rowspan="6" class="borde-down l-left" style="width:200px">
                                	
                                </td>-->
                            </tr>
                            <tr class="textleft afr-tdsection">
                                <td class="borde-down spaceleft" style="">
                                	<b>I.- RESUMEN DE SU PEDIDO:</b><span style="display:inline-block; margin-left:8px"> &nbsp; <?php echo @$servicio ?></span>
                                </td>
                            </tr>
                            <tr class="textleft">
                                <td class="borde-down spaceleft vtop" style=" min-height:55px;vertical-align:top">
                                	<?php echo @$resumen?>
                                	
                                </td>
                           </tr>
                           <tr class="textleft">
                                <td class="borde-down spaceleft">
                                	<b>II. DEPENDENCIA O AUTORIDAD A QUIEN SE DIRIGE:</b> <span style="font-weight:700; font-size:14px"><?php echo $dependencia ?></span>
                                </td>
                           </tr>
                           <tr class="textleft afr-tdsection">
                                <td class="borde-down spaceleft">
                                	<b>III. DATOS DEL SOLICITANTE:</b>
                                </td>
                            	
                            </tr>
                            <tr class="textleft">
                            	<td class="spaceleft">
                                	<b>Persona Natural:</b>
                                </td>
                            </tr>
                            <tr>
                            	<td colspan="2">
                                	
                                	<table id="" border="0" cellpadding="0" cellspacing="0">
                                    	<tr style="height:60px;">
                                        	<td style="width:325px;  " class="spaceleft">
                                            	<label>Apellido Paterno:</label><input type="text" class="textborder" style="width:150px;height:24px" value="<?php echo @$apepat?>">
                                            </td>
                                            <td style="width:325px; padding-left:10px;" class="spaceleft">
                                            	<label>Apellido Materno:</label><input class="textborder" style="width:150px; height:24px" type="text" name="txtapemat" id="txtapemat" value="<?php echo @$apemat?>">
                                            </td>
                                            <td style="width:325px; padding-left:10px;" class="spaceleft">
                                            	<label>Nombres:</label><input class="textborder" type="text" style="width:150px; height:24px" name="txtnombre" id="txtnombre" value="<?php echo @$nombre?>">
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                             <tr class="textleft">
                            	<td class="spaceleft">
                                	 <b>Persona Jurídica:</b>
                                </td>
                            </tr>
                            <tr class="textleft">
                            	<td colspan="2" class="spaceleft">
                                	<label>Razón Social:</label><input class="textborder" style="width:833px; height:24px" type="text" name="txtrazonsocial" id="txtrazonsocial" value="<?php echo @$razonsocial?>">
                                	
                                </td>
                            </tr>
                            <tr class="textleft">
                            	<td class="spaceleft">
                                	<b>Tipo de Documento:</b>
                                </td>
                            </tr>
                            <tr>
                            	<td colspan="2">
                                	
                                	<table id="" border="0" cellpadding="0" cellspacing="0">
                                    	<tr style="height:60px;">
                                        	<td style="width:272px;  " class="spaceleft">
                                            	<label>DNI N° y/o RUC:</label><input class="textborder" style="width:100px; height:24px" type="text" name="txtdoc" id="txtdoc" value="<?php echo @$doc?>">
                                            </td>
                                            <td style="width:325px; padding-left:10px;" class="spaceleft">
                                            	<label>IE:</label><input class="textborder" style="width:213px; height:24px" type="text" name="txtie" id="txtie"  value="<?php echo @$ie?>">
                                            </td>
                                            <td style="width:325px; padding-left:10px;" class="spaceleft">
                                            	<label>Cargo Actual:</label><input class="textborder" type="text" style="width:213px; height:24px" name="txtcargo" id="txtcargo" value="<?php echo @$cargo?>">
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr class="textleft afr-tdsection">
                            	<td class="spaceleft borde-down borde-top" colspan="2">
                                	<b>IV. DIRECCIÓN:</b>
                                </td>
                            </tr>
                            <tr>
                            	<td colspan="2">
                                	
                                	<table id="" border="0" cellpadding="0" cellspacing="2">
                                    	<tr>
                                        	<td class="spaceleft" style="padding-right:8px"><b>TIPO DE VÍA:</b></td>
                                            <td><label>Avenida: </label></td>
                                            <td class="spacer" >
                                            	<input type="radio" <?php echo (($via==1)? 'checked="checked"': '')?>  >
                                            	                                          
                                            </td>
                                            
                                            <td><label>Jirón:</label></td>
                                            <td class="spacer"><input type="radio" <?php echo (($via==2)? 'checked="checked"': '')?>  ></td>
                                            <td><label>Calle:</label></td>
                                            <td class="spacer"><input type="radio" <?php echo (($via==3)? 'checked="checked"': '')?>  ></td>
                                            <td><label>Pasaje:</label></td>
                                            <td class="spacer"><input type="radio" <?php echo (($via==4)? 'checked="checked"': '')?>  ></td>
                                            <td><label>Carretera:</label></td>
                                            <td class="spacer"><input type="radio" <?php echo (($via==5)? 'checked="checked"': '')?>  ></td>
                                            <td><label>Prolongación:</label></td>
                                            <td><input type="radio" <?php echo (($via==6)? 'checked="checked"': '')?>  ></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr class="textleft">
                            	<td colspan="2" class="spaceleft">
                                	<label style="display:inline-block; width:90px;">Nombre de la vía:</label><input class="textborder" style="width:814px; height:24px" type="text" name="txtnomvia" id="txtnomvia" value="<?php echo @$nombvia?>">
                                	
                                </td>
                            </tr>
                            <tr class="textleft">
                            	<td colspan="2" class="spaceleft">
                                	<label style="display:inline-block; width:90px;">Referencia:</label><input class="textborder" style="width:814px; height:24px" type="text" name="txtreferencia" id="txtreferencia" value="<?php echo @$referencia?>">
                                	
                                </td>
                            </tr>
                            <tr>
                            	<td colspan="2" class="spaceleft">
                                	
                                	<table id="" border="0" cellpadding="0" cellspacing="0">
                                    	<tr>
                                        	<td>
                                            	<label>Teléfonos:</label><input class="textborder" style="width:200px; height:24px" type="text" name="txtphone" id="txtphone" value="<?php echo @$telefono?>">
                                        	</td>
                                            <td>
                                            	<label>Código Modular:</label><input class="textborder" style="width:200px; height:24px" type="text" name="txtmodula" id="txtmodula" value="<?php echo @$modular?>">
                                        	</td>
                                            <td>
                                            	<label>Correo:</label><input class="textborder" style="width:200px; height:24px" type="text" name="txtemail" id="txtemail" value="<?php echo @$email?>">
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

						 <?php if($fundamento){?>
                           <tr class="textleft afr-tdsection">
                            	<td class="spaceleft borde-down " colspan="2">
                                	<b>V. FUNDAMENTOS DEL PEDIDO:</b>
                                </td>
                            </tr>
                             <tr class="textleft">
                                <td class="" colspan="2" style="text-align:justify; padding:0 8px; height:140px; vertical-align:top">
                                	<div><?php echo @$fundamento ?></div>
                                	
                                </td>
                           </tr>
						 <?php }?>
                       <!--     <tr class="textleft ">
                                <td class="spaceleft" colspan="2">
                                	Declaro que los datos presentados en el presente formulario los realizo con caracter de declaración jurada.
                                </td>
                           </tr>-->
                           <?php /*?><tr class="textleft afr-tdsection">
                            	<td class="spaceleft borde-down " colspan="2">
                                	VI. DOCUMENTOS QUE SE ADJUNTAN:
                                </td>
                            </tr>
                             <tr class="textleft">
                                <td class="" colspan="2">
                                	<ul id="ulfile">
                                    	<li>
                                        	<input type="file" name="afr-file[]" >
                                        </li>
                                        <li>
                                        	<input type="file" name="afr-file[]" >
                                        </li>
                                        <li>
                                        	<input type="file" name="afr-file[]" >
                                        </li>
                                    </ul>
                                	
                                	
                                </td>
                               
                           </tr><?php */?>
                        </table>
                                               
                    </form>
                </div>
				
            </div>
        </div>
		<div style="clear:both"></div>
        
    </div>
</body>
</html>