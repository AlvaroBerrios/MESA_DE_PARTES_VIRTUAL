<!DOCTYPE>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Mesa de Partes Virtual | Ugel03 </title>
    <link href="<?php echo site_resource('mdp')?>/css/style.css" rel="stylesheet" />
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo site_resource('mdp')?>/images/logo-full.png">
    <script src="<?php echo site_resource('mdp')?>/js/plugins/jquery-3.3.1.min.js"></script>
    <script src="<?php echo site_resource('mdp')?>/js/jquery.validate.min.js"></script>
</head>
        
    <script type="text/javascript">
        
        function countChar(val) {
              var len = val.value.length;
              if (len >= 250) {
                val.value = val.value.substring(0, 250);
              } else {
                $('#charNum').text(250 - len);
              }
        }; 

        function soloNumeros(e)
        {
           var key = window.Event ? e.which : e.keyCode
           return ((key >= 48 && key <= 57) || (key==8))
        }
            
            
        function myFunction(){
            $.ajax({

                url:"<?php echo site_url("Login/consultadni")?>",
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

                url:"<?php echo site_url("Login/consultaruc")?>",
                                data:{id:$("#txtdoc").val()},
                                dataType:"json",
                                type:"POST",
                                success:function(data){
                                    $("#txtnombre").val("");
                                    $("#txtnombre").val(data.razonsocial);
                                }                
                });
                
        }
            
        $(function(){
            
            $("#cboTipoPersona").change(function(){
                                    
                $("#cboTipoPersona option:selected").each(function() {
                   TipoPersona = $('#cboTipoPersona').val();
                    $.post(
                       "<?php echo(site_url("Login/gettipodoc"))?>", 
                        {TipoPersona : TipoPersona}, 
                        function(data) {$("#coTipoDocumento").html(data); }
                    );
                });                                                                                                                                
                                      
                var optionSelected = $("option:selected", this);
                var valueSelected = this.value;
                     
                     if(valueSelected==1){
                         $("#txtdoc").prop("disabled",false);
                         $("#divRazon").css("display", "none");
                         $("#divRazon").removeClass("required");
                         $("#divIE").css("display", "none");
                         $("#divIE").removeClass("required");
                         $("#divNombres").css("display", "");

                         $("#txtnombres").val("");
                         $("#txtapePaterno").val("");
                         $("#txtapeMaterno").val("");

                         $("#txtapepat").addClass("required");
                         $("#txtapemat").addClass("required");
                         $("#txtnombre").addClass("required");
                         $('#lblNroDoc').text("Número de Documento");
                         $('#lblBus').text("Búsqueda");

                         $("#btnbsuquedadni").show();
                         $("#btnbsuquedaruc").hide();
                          
                         $("#txtdoc").attr('maxlength', 9);
                         $("#txtdoc").val("");
                         
                     }else if(valueSelected==2){
                         
                         $("#txtdoc").prop("disabled",false);
                         $("#divNombres").css("display", "none");
                         $("#divNombres").removeClass("required");
                         $("#divIE").css("display", "none");
                         $("#divIE").removeClass("required");
                         $("#divRazon").css("display", "");
                         $("#divRazon").addClass("required");

                         $("#txtnombres").val("");
                         $("#txtapePaterno").val("");
                         $("#txtapeMaterno").val("");
                         $("#txtapepat").removeClass("required");
                         $("#txtapemat").removeClass("required");
                         $("#txtnombre").addClass("required");
                         $('#lblNroDoc').text("Número de Documento");
                         $('#lblBus').text("Búsqueda");

                         $("#btnbsuquedadni").hide();
                         $("#btnbsuquedaruc").show();
                          
                         $("#txtdoc").attr('maxlength', 11);
                         $("#txtdoc").val("");
                         
                     } else if(valueSelected==4){
                            
                         $("#txtdoc").prop("disabled",false);
                         $("#divNombres").css("display", "none");
                         $("#divNombres").removeClass("required");
                         $("#divRazon").css("display", "none");
                         $("#divRazon").removeClass("required");
                         $("#divIE").css("display", "");
                         $("#divIE").addClass("required");

                         $("#txtnombres").val("");
                         $("#txtapePaterno").val("");
                         $("#txtapeMaterno").val("");
                         $("#txtapepat").removeClass("required");
                         $("#txtapemat").removeClass("required");
                         $("#txtnombre").addClass("required");
                         $('#lblNroDoc').text("Cod Local y/o Modular");
                         $('#lblBus').text("");

                         $("#btnbsuquedadni").hide();
                         $("#btnbsuquedaruc").hide();
                          
                         $("#txtdoc").attr('maxlength', 6);
                         $("#txtdoc").attr("placeholder", "Ingrese código modular/local");
                         $("#txtdoc").val("");
                     }               
            }); 
        })  

        $(function() {

            $("#ap-frmRegistro").validate({
                    errorElement: "span",
                    errorClass: "afr-error",
                    errorPlacement: function(error, element) {},
                    submitHandler: function(forms) {
                        enviarFormDatosPersonales()
                    }
                })
        });

    
        function enviarFormDatosPersonales() {

                var datastring = $("#ap-frmRegistro").serialize();

                $.ajax({
                    url: $("#ap-frmRegistro").attr('action'),
                    method: "POST",
                    data: datastring,
                    dataType: "JSON",
                    beforeSend: function() {
                    },
                    success: function(data) {

                       switch (data.resp) {
                            case 10:
                                alert(data.text);
                                break;
                            default:
                                // code block
                        }

                    }
                })

        }
            
    </script>   


<body class="h-100">

                <div class="authincation h-100">
                <div class="container h-100">
                <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                <div class="authincation-content">
                <div class="row no-gutters">
                <div class="col-xl-12">
                <div class="auth-form">    
                    <div class="text-center mb-3">
                        <a href="index.html"><img src="<?php echo site_resource('mdp')?>/images/logo-full.png" alt=""></a>
                    </div>
                    <h4 class="text-center mb-4 text-white"><strong>Registrarse</strong></h4>
                        <form  id="ap-frmRegistro" name="ap-frmRegistro" action="<?php echo(site_url('Login/enviarRegistroDatos'))?>" method="post" enctype="multipart/form-data">
                            
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label class="mb-1 text-white">Tipo de Persona</label>
                                                <?php 
                                                echo "<select class='form-control' id='cboTipoPersona' name='cboTipoPersona' required='required' >";
                                                    if (count($tipopersona)) {
                                                        echo "<option value='0'>[--Seleccione--]</option>";
                                                        foreach ($tipopersona as $list) {
                                                        echo "<option value='". $list['id'] . "'>" . $list['descripcion'] . "</option>";
                                                        }
                                                    }
                                                echo "</select>";
                                                ?> 
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label class="mb-1 text-white">Tipo de Documento</label>
                                                <select class="form-control" required="required"  id="coTipoDocumento" name="coTipoDocumento">
                                                    <option value="0">[--Seleccione--]</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-10">
                                                <label class="mb-1 text-white" id="lblNroDoc" name="lblNroDoc">Nro Documento</label>
                                                <input class="form-control" type="text" onkeypress="return soloNumeros(event);" maxlength="11" placeholder="Ingrese Documento" name="txtdoc" id="txtdoc" >
                                            </div>
                                            <div class="form-group col-md-1">
                                                <label class="mb-1 text-white" id="lblBus" name="lblBus"></label>
                                                <button id="btnbsuquedadni"  name="btnbsuquedadni" onclick="myFunction()" style="background-color: #E12222;color: white;height: 55px;width: 65px;display:none" ><i class="fa fa-search"></i></button>
                                                <button id="btnbsuquedaruc"  name="btnbsuquedaruc" onclick="myFunction2()" style="background-color: #E12222;color: white;height: 55px;width: 65px;display:none " ><i class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                        <div class="form-row" id="divNombres" name="divNombres">
                                            <div class="form-group col-md-12">
                                                    <label class="mb-1 text-white">Nombres:</label>
                                                    <input type="text" class="form-control" placeholder="Ingrese Nombres" name="txtnombre" id="txtnombre">
                                            </div>
                                            <div class="form-group col-md-12">
                                                    <label class="mb-1 text-white">Apellido Paterno:</label>
                                                    <input type="text" class="form-control" placeholder="Ingrese Apellido Paterno"  name="txtapepat" id="txtapepat">
                                            </div>
                                            <div class="form-group col-md-12">
                                                    <label class="mb-1 text-white">Apellido Materno:</label>
                                                    <input type="text" class="form-control" placeholder="Ingrese Apellido Materno"  name="txtapemat" id="txtapemat">
                                            </div>
                                        </div>
                                        <div class="form-row" id="divRazon"  name="divRazon" style="display:none;">
                                            <div class="form-group col-md-12">
                                                    <label class="mb-1 text-white">Razón Social:</label>
                                                    <input type="text" class="form-control" placeholder="Ingrese Razón Social" name="txtrazonsocial" id="txtrazonsocial">
                                            </div>
                                        </div>
                                        <div class="form-row" id="divIE"  name="divIE" style="display:none;">
                                            <div class="form-group col-md-12">
                                                    <label class="mb-1 text-white">Institución Educativa:</label>
                                                    <input type="text" class="form-control" placeholder="Ingrese I.E." id="txtie" name="txtie">
                                            </div>
                                            <div class="form-group col-md-12">
                                                    <label class="mb-1 text-white">Cargo:</label>
                                                    <input type="text" class="form-control" placeholder="Ingrese Cargo" name="txtcargo" id="txtcargo">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label class="mb-1 text-white">Teléfono</label>
                                                <input class="form-control" onkeypress="return soloNumeros(event);" placeholder="Ingrese Teléfono" maxlength="9" type="text" name="txtphone" id="txtphone" required >
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label class="mb-1 text-white">Correo</label>
                                                <input class="form-control" type="email" placeholder="Ingrese Correo" name="txtemail" id="txtemail" required >
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label class="mb-1 text-white">Repetir correo</label>
                                                <input class="form-control" type="email" placeholder="Repetir Correo" name="txtemail2" id="txtemail2" required >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="resultadocheck">
                                                <label class="mb-1 text-white">
                                                    Acepto contacto por el correo ingresado
                                                </label>
                                            </div>
                                        </div>

                                        <div class="text-center mt-4">
                                                <button type="submit" class="btn bg-danger text-white btn-block">
                                                    <i class="fa fa-check color-info"></i> Registrarse
                                                </button>
                                        </div>
                        
                        </form>

                        <div class="new-account mt-3 text-center">
                                            <p class="text-white">
                                                ¿Ya tienes con una cuenta? <br>
                                                <a class="text-white" href="<?php echo(site_url('Login'))?>">Iniciar Sesión</a>
                                            </p>
                        </div>
                       

                </div>
                </div>
                </div>
                </div>
                </div>
                </div>
                </div>
                </div>

    <script src="<?php echo site_resource('mdp')?>/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <!--<script src="<?php echo site_resource('mdp')?>/js/custom.min.js"></script>-->
    <script src="<?php echo site_resource('mdp')?>/js/deznav-init.js"></script>
    
</body>

</html>