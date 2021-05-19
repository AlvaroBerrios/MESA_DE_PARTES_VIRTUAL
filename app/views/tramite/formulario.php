<!DOCTYPE>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Boletas</title>
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
	table{
		width:100%;
		font-size:12px;
		font-family:Arial;
		font-style:italic;
	}
	table tr td{
		padding-left:2px;
	}
	table.lineheight tr td{
		padding-top:1px;
		padding-bottom:1px;
	}
		
		.wrapper{
			
			
		}
		.container{
			width:760px;
			font-size:12px;
			font-family:arial;
			
			margin:auto;
			
			
				
		}
		.boleta, .section{
			background:#999;
			text-align:center;
			font-size:14px;
			padding: 0px 0 0px 0;
			font-style:italic;
			font-weight:700;
		}
		.section{
			padding: 5px 0 5px 0;
			font-size:12px;
			
			
		}
		table tr.section2 td{
			padding-left:2px;
			padding-right:2px;
		}
		td.center{
			text-align:center;
			vertical-align: middle;
		}
		.bg{
			background:#999;
		}	
		.negrita{
			font-weight:700;
		}
		
		.textleft{
			text-align:left;
			padding-left:2px;
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
		.cabimg{
			margin:0px 0 5px 0;
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
		</style>
	</head>
	<body style="margin-top:0px">
    
    <?php 
	$ctrl = 1;
	$copies = 2;
	foreach($datos as $data){
		$remtotal = 0;
		$desctotal = 0; 
	
	$t=1;
	for($t=1;$t<=$copies;$t++){
	?>
		<div class="container">
        	<div class="cabimg">
        		<img src="<?php echo site_resource('admin') ?>/img/logo-ugel03-RRHH.jpg" alt="" title="">
            </div>
			<div>
				<span class="negrita"><b>RUC</b>:</span> 20331304736
			</div>
			<div class="wrapper">
				<table class="tb-list" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td colspan="3" class="boleta center bg l-border"><b>BOLETA DE PAGO</b></td>
						
					</tr>
					<tr height="10" >
						<td class="l-left" width="40" height="10" style=" vertical-align:middle"><b>MES</b>:</td>
						<td class="textleft" style=" vertical-align:middle"><?php echo strtoupper($mes) ?></td>
						<td class="l-right"></td>
					</tr>
					<tr height="20">
						<td colspan="3" class="center bg negrita l-border" ><b>DATOS DEL TRABAJADOR</b></td>
						
					</tr>
					<tr>
						<td colspan="3" class="l-left l-right">
                        	<table class="tb-list lineheight" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td class="negrita" width="170"><b>DNI</b></td>
                                    <td width="10">:</td>
                                    <td><?php echo $data["dni"]?></td>
                                </tr>
                                <tr>
                                    <td class="negrita"><b>APELLIDOS Y NOMBRES</b></td>
                                    <td>:</td>
                                    <td><?php echo $data["nombre"]?></td>
                                </tr>
                                <tr>
                                    <td class="negrita"><b>MODALIDAD CONTRATO</b></td>
                                    <td>:</td>
                                    <td><?php echo $data["modalidad"]?></td>
                                </tr>
                                <tr>
                                    <td class="negrita"><b>FECHA INGRESO</b></td>
                                    <td>:</td>
                                    <td><?php echo $data["fingreso"]?></td>
                                </tr>
                                <tr>
                                    <td class="negrita"><b>REG. PENS.</b></td>
                                    <td>:</td>
                                    <td  class="normal"><?php echo $data["pension"]?>
                                     <?php
										if($data["pension"] == "AFP"){
											echo($data["pensionnombre"]."&nbsp;&nbsp;&nbsp;"." <b>CUSSP</b>: ".$data["cussp"]);
											
										}
									?>
                                    
                                    </td>
                                </tr>
                                <tr>
                                    <td class="negrita"><b>AUTOGENERADO ESSALUD</b></td>
                                    <td>:</td>
                                    <td><?php echo $data["autoessalud"]?></td>
                                </tr>
                                <tr>
                                    <td class="negrita"><b>CARGO</b></td>
                                    <td>:</td>
                                    <td><?php echo $data["cargo"]?></td>
                                </tr>
                                <tr>
                                    <td class="negrita"><b>NUMERO CUENTA</b></td>
                                    <td>:</td>
                                    <td><?php echo $data["nrocuenta"]?></td>
                                </tr>
                                
                            </table>
                        
                        </td>
						
					</tr>
					
				</table>
                <table class="tb-list" border="0" cellpadding="0" cellspacing="0">
                	<tr>
                        <td class="center bg negrita l-top l-right l-left l-bottom" ><b>REMUNERACIONES</b></td>
                        
                        <td class="center bg negrita l-top l-bottom" ><b>DESCUENTOS</b></td>
                        <td class="center bg negrita l-top l-left l-right l-bottom" ><b>APORTACIONES DEL EMPLEADOR</b></td>
                    </tr>
                    <tr>
                        <td class="vtop l-left l-right">
                        	<table class="tb-list" border="0" cellpadding="0" cellspacing="0">
                            	<tr>
                                	<td width="65">D.L. 1057</td>
                                    <td>:</td>
                                    <td class="aright">S/. <?php echo number_format($data["dl"],2)?></td>
                                </tr>
								<?php if((float)$data["reintegro"]> 0 or (float)$data["reitegroxerror"]> 0 ){?>
                                <tr>
                                	<td>Reintegro</td>
                                    <td>:</td>
                                    <td class="aright">S/. <?php echo number_format($data["reintegro"] + $data["reitegroxerror"],2)?></td>
                                </tr>
								<?php } ?>
								<?php if((float)$data["aguinaldo"]> 0 ){?>
                                <tr>
                                	<td>Aguinaldo</td>
                                    <td>:</td>
                                    <td class="aright">S/. <?php echo number_format($data["aguinaldo"],2);
									
									
									
									?></td>
                                </tr>
								<?php } ?>
                                <?php if($data["vactrunca"]>0){?>
                                <tr>
                                	<td>Vac. Trunca</td>
                                    <td>:</td>
                                    <td class="aright">S/. <?php echo number_format($data["vactrunca"],2);
									
									
									
									?></td>
                                </tr>
                                <?php }?>
                            </table>
                        
                        </td>
						<?php $remtotal = $data["dl"] + $data["reintegro"] + $data["aguinaldo"]+$data["reitegroxerror"]+$data["vactrunca"];
						   $ctrl_pension = true;
						   if($data["pension"] == "ONP"){
								$ctrl_pension = false;
						   }
						   
					    ?>
                       
                        
                        <td class="vtop " >
                        	<table class="tb-list" border="0" cellpadding="0" cellspacing="0">
							<?php if($ctrl_pension){?>
                            	<tr>
                                	<td width="160">SPP - Aporte AFP</td>
                                    <td>:</td>
                                    <td class="aright">S/. <?php echo number_format($data["aporteafp"],2)?> 
                                   
                                    </td>
                                </tr>
                                <tr>
                                	<td>SPP - Prima Seguro AFP</td>
                                    <td>:</td>
                                    <td class="aright">S/. <?php echo number_format($data["seguroafp"],2)?></td>
                                </tr>
                                <tr>
                                	<td>SPP - Comisión AFP</td>
                                    <td>:</td>
                                    <td class="aright">S/. <?php echo number_format($data["comisionafp"],2)?></td>
                                </tr>
								<?php } else{?>
                                <tr>
                                	<td>ONP</td>
                                    <td>:</td>
                                    <td class="aright">S/. <?php echo number_format($data["onp"],2)?></td>
                                </tr>
								<?php }?>
                                <tr>
                                	<td>Faltas y Tardanzas</td>
                                    <td>:</td>
                                    <td class="aright">S/. <?php echo number_format($data["ft"],2)?></td>
                                </tr>
                                <tr>
                                	<td>Descuento de 4ta. Categoría</td>
                                    <td>:</td>
                                    <td class="aright">S/. <?php echo number_format($data["4tacategoria"],2)?></td>
                                </tr>
                                <tr>
                                	<td>Otros Descuentos</td>
                                    <td>:</td>
                                    <td class="aright">S/. <?php echo number_format($data["otrosdesc"],2);
									$desctotal = $data["aporteafp"]+$data["seguroafp"]+$data["comisionafp"]+$data["onp"]+$data["ft"]+$data["4tacategoria"]+$data["otrosdesc"];
									?></td>
                                </tr>
								
								<?php if($ctrl_pension == false){?>
                            	<tr>
                                	<td width="160"> </td>
                                    <td> </td>
									<td class="aright"><?php echo("&nbsp;")?></td>
                                </tr>
                                <tr>
                                	<td width="160"> </td>
                                    <td> </td>
									<td class="aright"><?php echo("&nbsp;")?></td>
                                </tr>
								<?php }?>
								
                            </table>
                        </td>
                        <td class="vtop l-left l-right" >
                        	<table class="tb-list" border="0" cellpadding="0" cellspacing="0">
                            	<tr>
                                	<td width="80">ESSALUD</td>
                                    <td>:</td>
                                    <td class="aright">S/. <?php echo number_format($data["essalud"],2)?></td>
                                </tr>
                                <tr>
                                	<td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                	<td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                               
                            </table>
                        </td>
                    </tr>
                    <tr>
                    	<td class="l-left l-top l-bottom l-right">
                        	<table class="tb-list" border="0" cellpadding="0" cellspacing="0">
                            	<tr>
                                	<td width="65" class="negrita center"><b>TOTAL</b></td>
                                    <td>:</td>
                                    <td class="aright">S/. <?php echo number_format($remtotal,2)?></td>
                                </tr>
                            </table>
                        </td>
                        <td class="  l-bottom l-top">
                        	<table class="tb-list" border="0" cellpadding="0" cellspacing="0">
                            	<tr>
                                	<td width="180" class="negrita center"><b>TOTAL</b></td>
                                    <td>:</td>
                                    <td class="aright">S/. <?php echo number_format($desctotal,2)?></td>
                                </tr>
                            </table>
                        </td>
                        <td class=" l-left l-bottom l-top negrita center bg l-right">
                        	<b>RESUMEN</b>
                        	
                        </td>
                    </tr>
                    <tr>
                    	<td>
                        	
                        </td>
                        <td class="">
                        	
                        </td>
                        <td class="l-left" style="padding:0">
                        	<table class="tb-list" border="0" cellpadding="0" cellspacing="0">
                            	<tr>
                                	<td width="" class="negrita l-bottom"><b>TOTAL REMUNERACIONES</b></td>
                                    <td class="l-bottom">:</td>
                                    <td class="aright l-right l-bottom">S/. <?php echo number_format($remtotal,2)?></td>
                                </tr>
                                <tr>
                                	<td width="" class="negrita l-bottom"><b>TOTAL DESCUENTOS</b></td>
                                    <td class="l-bottom">:</td>
                                    <td class="aright l-right l-bottom">S/. <?php echo number_format($desctotal,2)?></td>
                                </tr>
                                <tr>
                                	<td width="" class="negrita l-bottom"><b>REMUNERACION NETA</b></td>
                                    <td class="l-bottom">:</td>
                                    <td class="aright l-bottom l-right">S/. <?php echo number_format($data["totliquido"],2)?></td>
                                </tr>
                            </table>
                        	
                        </td>
                    </tr>
                </table>
				
			</div>
            <div style="width:100%; position:relative; padding-top:-60px">
            	<div style=" float:left; width:238px; position:absolute">
                	<img src="<?php echo site_resource('admin') ?>/img/sello.png" alt="" title="">
                </div>
            	<div style=" float:right;width:210px; left:200px;top:80px; padding-top:110px">
                <div style="border-top:#000 1px solid; text-align:center">
                	FIRMA DEL TRABAJADOR
                </div>
                </div>
            </div>
            
           
		</div>
        <?php
		if($t%2 != 0){ ?>
        <div style="border-bottom:2px dotted #000; height:2px; margin-top:8px">
        </div>
        <?php
		}
		?>
        <br />
        <?php
		}
		
		$ctrl++;
		}?>
		
		
	</body>
</html>
