<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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


        $(window).resize(function() {
            $('#afr-cmessage').css({
                left: ($(window).width() - $('#afr-cmessage').outerWidth(true))/2,
                top: ($(window).height() - $('#afr-cmessage').outerHeight(true))/2
            });
        });

      
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

        // MUESTRA EL INPUT DONDE INGRESA CARGO SI SELECCIONA 12
        $(function(){

                $('#cboCargo').click(function() {
                if ($('#cboCargo').val() == 12) {
                    $('#txtcargo').css("display", "");
                    return true;
                }else{
                    $('#txtcargo').css("display", "none");
                    return false; 
            }
            });
        })
            
        $(function(){

            $('#condiciones').click(function() {
              if ($(this).is(':checked')) {
                $("#resultadocheck").val(1);
              }else{
                $("#resultadocheck").val(0); 
              }
            });

            
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
                          
                         $("#txtdoc").attr('maxlength', 8);
                         $("#txtdoc").attr("placeholder", "Ingrese Documento");
                         $("#txtdoc").val("");

                         //$('#txtcontra').val("AF@34d");
                         //console.log($("#txtnombre").val());
                         
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
                         $("#txtdoc").attr("placeholder", "Ingrese Numero R.U.C");
                         $("#txtdoc").val("");
                         
                     } else if(valueSelected==3){
                            
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

                            $("#cboCargo").css("display", "");
                            $("#lblCargo").text("Cargo:");
                            //$("#txtcargo").addClass("required");
                             
                            $("#txtdoc").attr('maxlength', 6);
                            $("#txtdoc").attr("placeholder", "Ingrese código modular/local");
                            $("#txtdoc").val("");

                     } else if(valueSelected==4){
                            
                         $("#txtdoc").prop("disabled",false);
                         $("#divNombres").css("display", "");
                         $("#divNombres").addClass("required");
                         $("#divRazon").css("display", "none");
                         $("#divRazon").removeClass("required");
                         $("#divIE").css("display", "");
                         $("#divIE").addClass("required");

                         $("#txtnombres").val("");
                         //$("#txtnombres").css("display", "");
                         $("#txtapePaterno").val("");
                         //$("#txtapePaterno").css("display", "");
                         $("#txtapeMaterno").val("");
                         //$("#txtapeMaterno").css("display", "");
                         $("#txtapepat").addClass("required");
                         $("#txtapemat").addClass("required");
                         $("#txtnombre").addClass("required");

                         $('#lblNroDoc').text("Numero de Documento");
                         $('#lblBus').text("Búsqueda");

                         $("#btnbsuquedadni").show();
                         $("#btnbsuquedaruc").hide();

                         $("#cboCargo").css("display", "none");
                         $("#lblCargo").text("");
                          
                         $("#txtdoc").attr('maxlength', 8);
                         $("#txtdoc").attr("placeholder", "Ingrese Doc. Nacional de Identidad");
                         $("#txtdoc").val("");
                     }               
            }); 

            $("#ap-frmRegistro").validate({
                errorElement: "span",
                errorClass: "afr-error",
                errorPlacement: function(error, element) {},
                submitHandler: function(forms) {
                    //$('.afr-btn').attr("disabled","disabled");
                    // forms.submit();
                    enviarFormDatosPersonales()
                }
            })

            $("#afr-btnclose").click(function() {
                $("#afr-cmessage").fadeOut(500, function() {
                    $("#afr-overlay").fadeOut(700);
                });
            });

            $('#afr-cmessage').css({
                left: ($(window).outerWidth() - $('#afr-cmessage').outerWidth(true)) / 2,
                top: ($(window).outerHeight() - $('#afr-cmessage').outerHeight(true)) / 2
            });

            setTimeout(function() {

                $("#afr-msg").fadeOut(12000);

            }, 1800);

                            
            $("#ap-frmRegistro").validate({
                rules: {
                    userLogin: "required",
                    userLogin: {
                        required: true,
                        email: true
                    }
                },
                messages: {
                  userLogin: "Por favor ingresar email."
                },
                errorElement: "span",
                errorClass: "afr-error",
                errorPlacement: function(error, element) {},
                submitHandler: function(forms) { 
                    enviarFormDatosPersonales();
                }
            })

        })  


        function enviarFormDatosPersonales__() {

            var datastring = $("#ap-frmRegistro").serialize();

            $(".loader").css("display", "block");
            $(".alert-success").css("display", "none");
            $(".alert-danger").css("display", "none");

            $.ajax({
                url: $("#ap-frmRegistro").attr('action'),
                method: "POST",
                data: datastring,
                dataType: "JSON",
                beforeSend: function() {
                    // $("#in-pogress").html("Processing daata");
                },
                success: function(data) {

                    // alert(data.msg);

                    switch (data.error) {
                        case 0:

                            $(".alert-success").text(data.msg);
                            $(".alert-success").css("display", "block");
                            $(".alert-danger").css("display", "none");
                            $(".loader").css("display", "none");
                            /*
                    <?php  $this->session->sess_destroy();  ?>
                        location.reload();*/
                            break;
                        case 1:

                            $(".alert-danger").text(data.msg);
                            $(".alert-danger").css("display", "block");
                            $(".alert-success").css("display", "none");
                            $(".loader").css("display", "none");
                            break;
                        case 2:
                            $(".alert-danger").text(data.msg);
                            $(".alert-danger").css("display", "block");
                            $(".alert-success").css("display", "none");
                            $(".loader").css("display", "none");
                            break;

                        case 3:
                            $(".alert-danger").text(data.msg);
                            $(".alert-danger").css("display", "block");
                            $(".alert-success").css("display", "none");
                            $(".loader").css("display", "none");
                            break;

                        default:
                            // code block
                    }

                    if (data.error == 3) {

                    } else {

                    }

                }
            })

        }


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
                            case 100:
                                $(this).closest('form').find("input[type=text]").val("");
                                alert(data.text);
                                window.location.href = "<?php echo site_url('Login') ?>";
                                break;
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
                <div class="col-md-10">
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
                                            <div class="form-group col-md-4">
                                                <label class="mb-1 text-white">Tipo de Persona</label>
                                                <?php 
                                                echo "<select class='form-control' id='cboTipoPersona' name='cboTipoPersona' required='required' >";
                                                    if (count($tipopersona)) {
                                                        echo "<option value='0'>[--Seleccione--]</option>";
                                                        foreach ($tipopersona as $list) {
                                                        echo "<option value='". $list['idTipPer'] . "'>" . $list['descripcion'] . "</option>";
                                                        }
                                                    }
                                                echo "</select>";
                                                ?> 
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label class="mb-1 text-white">Tipo de Documento</label>
                                                <select class="form-control" required="required"  id="coTipoDocumento" name="coTipoDocumento">
                                                    <option value="0">[--Seleccione--]</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label class="mb-1 text-white" id="lblNroDoc" name="lblNroDoc">Nro Documento</label>
                                                <input class="form-control" type="text" onkeypress="return soloNumeros(event);" maxlength="11" placeholder="Ingrese Documento" name="txtdoc" id="txtdoc">
                                            </div>
                                            <div class="form-group col-md-1">
                                                <label class="mb-1 text-white" id="lblBus" name="lblBus"></label>
                                                <button id="btnbsuquedadni"  name="btnbsuquedadni" onclick="myFunction()" style="background-color: #E12222;color: white;height: 55px;width: 65px;display:none" ><i class="fa fa-search"></i></button>
                                                <button id="btnbsuquedaruc"  name="btnbsuquedaruc" onclick="myFunction2()" style="background-color: #E12222;color: white;height: 55px;width: 65px;display:none " ><i class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                        <div class="form-row" id="divNombres" name="divNombres">
                                            <div class="form-group col-md-4">
                                                    <label class="mb-1 text-white">Nombres:</label>
                                                    <input type="text" class="form-control" placeholder="Ingrese Nombres" name="txtnombre" id="txtnombre" maxlength="40" >
                                            </div>
                                            <div class="form-group col-md-4">
                                                    <label class="mb-1 text-white">Apellido Paterno:</label>
                                                    <input type="text" class="form-control" placeholder="Ingrese Apellido Paterno"  name="txtapepat" id="txtapepat" maxlength="30" >
                                            </div>
                                            <div class="form-group col-md-4">
                                                    <label class="mb-1 text-white">Apellido Materno:</label>
                                                    <input type="text" class="form-control" placeholder="Ingrese Apellido Materno"  name="txtapemat" id="txtapemat" maxlength="30" >
                                            </div>
                                        </div>
                                        <div class="form-row" id="divRazon"  name="divRazon" style="display:none;">
                                            <div class="form-group col-md-12">
                                                    <label class="mb-1 text-white">Razón Social:</label>
                                                    <input type="text" class="form-control" placeholder="Ingrese Razón Social" name="txtrazonsocial" id="txtrazonsocial" maxlength="40">
                                            </div>
                                        </div>
                                        <div class="form-row" id="divIE"  name="divIE" style="display:none;">
                                            <div class="form-group col-md-8">
                                                    <label class="mb-1 text-white">Institución Educativa:</label>
                                                    <input type="text" class="form-control" placeholder="Ingrese Institución Educativa" id="txtie" name="txtie" maxlength="80">
                                            </div>
                                            <div class="form-group col-md-4">
                                                    <label class="mb-1 text-white"  id="lblCargo">Cargo:</label>
                                                    <?php 
                                                     echo "<select class='form-control' id='cboCargo' name='cboCargo'>";
                                                        if (count($Cargo)) {
                                                            echo "<option value=''>[--Seleccione--]</option>";
                                                            foreach ($Cargo as $list) {
                                                            echo "<option value='". $list['idCargo'] . "'>" . $list['descripcion_cargo'] . "</option>";
                                                        }
                                                            echo "<option value='12'>".'OTROS'."</option> <br>";
                                                            echo '<input style="display:none" type="text" class="form-control" placeholder="Ingrese Otro Cargo" name="txtcargo" id="txtcargo" maxlength="30">';
                                                    }
                                                     echo "</select>";
                                                    ?> 
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label class="mb-1 text-white">Teléfono</label>
                                                <input class="form-control" onkeypress="return soloNumeros(event);" placeholder="Ingrese Teléfono" maxlength="9" type="tel" name="txtphone" id="txtphone" required >
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label class="mb-1 text-white">Correo</label>
                                                <input class="form-control" type="email" placeholder="Ingrese Correo" name="txtemail" id="txtemail" maxlength="80" required >
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label class="mb-1 text-white">Repetir correo</label>
                                                <input class="form-control" type="email" placeholder="Repetir Correo" name="txtemail2" id="txtemail2" maxlength="80" required >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="condiciones" name="condiciones" data-toggle="modal" data-target="#exampleModalLong" >
                                                <label class="mb-1 text-white">
                                                    Acepto contacto por el correo ingresado
                                                </label>
                                                 <input id="resultadocheck" name="resultadocheck" type="hidden" value="0">
                                            </div>
                                        </div>
                                        <!--  Modal -->
                                        <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">Terminos y condiciones</h5>
                                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                    </div>
                                                    <div class="modal-body">
                                                                <p style="text-align:justify"> Al dar click en este casillero, usted está autorizando </p>
                                                                <p style="text-align:justify"><b> Veracidad de la información declara por el administrado</b></p>

                                                                <p style="text-align:justify"> Declaro expresamente que la información ingresa en la Plataforma para el proceso de contratación docente 2020 es verdadera y conforme con lo establecido en el artículo 49 del Texto Único Ordenado de la Ley N° 27444, Ley del Procedimiento Administrativo General, y en caso de resultar falsa la información que proporciono, me sujeto a los alcances de lo establecido en el artículo 411 del Código Penal, concordante con el artículo 33 del Texto Único Ordenado de la Ley N° 27444, Ley del Procedimiento Administrativo General; autorizando a efectuar la comprobación de la veracidad de la información declarada en la presente plataforma.</p>

                                                                <p style="text-align:justify"><b> Autorización para la notificación al correo electrónico</b> </p>

                                                                <p style="text-align:justify">AUTORIZO de forma expresa y conforme a lo dispuesto por el artículo N° 20 del Texto único Ordenando de la Ley N° 27444 – Ley del Procedimiento Administrativo General, aprobado mediante el DECRETO SUPREMO Nº 004-2019-JUS y modificado mediante el Decreto Legislativo N° 1497, a la UNIDAD DE GESTION EDUCATIVA LOCAL 03 – UGEL 05, que me notifique el/los acto(s) administrativo(s), comunicados o documentación adicional que se emitan a consecuencia del proceso de contratación docente 2020 al correo electrónico consignado en presente plataforma; así mismo acuerdo que el  acto administrativo, los comunicados o la documentación adicional pueda estar contenida en un archivo adjunto o un enlace web a través del cual se descargará y/o otros mecanismo que garanticen su notificación.</p>

                                                                <p style="text-align:justify">Tengo conocimiento que las notificaciones dirigidas a la dirección de mi correo electrónico señalada en la presente Plataforma se entiende válidamente efectuadas cuando la UGEL 05 reciba la respuesta de recepción de la dirección electrónica antes señalada; a través del acuse de recibo, el mismo que dejará constancia del acto de notificación; en concordancia a lo establecido por el artículo 20 del mencionado Texto Único Ordenado, surtiendo efectos el día siguiente que conste haber sido recibido en mi bandeja de entrada, conforme a lo previsto en el numeral 2 del artículo 25 del citado Texto Único Ordenado.</p>

                                                                <p style="text-align:justify">
                                                                En atención a la presente autorización me comprometo con las siguientes obligaciones:
                                                                1.	Señalar una dirección de correo electrónica válida, a la cual tenga acceso y que se mantenga activa durante el proceso de contratación docente 2020.
                                                                2.	Asegurar que la capacidad del buzón de la dirección de correo electrónico permita recibir los documentos a notificar.
                                                                3.	Revisar continuamente la cuenta de correo electrónico, incluyendo la bandeja de spam o el buzón de correo no deseado.</p>

                                                                <p style="text-align:justify">El no tomar conocimiento oportuno de las notificaciones remitidas por la UNIDAD DE GESTION EDUCATIVA LOCAL 03 – UGEL 05, debido al incumplimiento de las presentes obligaciones, constituye exclusiva responsabilidad de mi persona. </p>

                                                                <p style="text-align:justify">DECRETO LEGISLATIVO Nº 1497: DECRETO LEGISLATIVO QUE ESTABLECE MEDIDAS PARA PROMOVER Y FACILITAR CONDICIONES REGULATORIAS QUE CONTRIBUYAN A REDUCIR EL IMPACTO EN LA ECONOMÍA PERUANA POR LA EMERGENCIA SANITARIA PRODUCIDA POR EL COVID- 19
                                                                Artículo 3.- Incorporación de párrafo en el artículo 20 de la Ley Nº 27444, Ley del Procedimiento Administrativo General
                                                                Incorpórase un último párrafo en el artículo 20 de la Ley Nº 27444, Ley del Procedimiento Administrativo General, cuyo texto queda redactado de la manera siguiente:
                                                                “Artículo 20.- Modalidades de notificación
                                                                (…)</p>
                                                                <p style="text-align:justify">El consentimiento expreso a que se refiere el quinto párrafo del numeral 20.4 de la presente Ley puede ser otorgado por vía electrónica.”</p>

                                                                <p style="text-align:justify"><b>Autorización para el tratamiento de los datos personal del administrado</b></p>

                                                                <p style="text-align:justify">En atención a los dispuesto por la Ley N° 29733, Ley de Protección de Datos Personales y su Reglamento aprobado por Decreto Supremo N° 003-2013-JUS, AUTORIZO a la UNIDAD DE GESTION EDUCATIVA LOCAL 03 – UGEL 05 al tratamiento de mis datos personales, así como cualquier otra información ingresada en la plataforma para el proceso de contratación docente 2020.</p>
                                                    </div>
                                                            <div class="modal-footer">
                                                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cerrar</button>
                                                            </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!--- MENSAJE DE ERROR Y/O BIENVENIDA -->
                                            <div class="mc-footer">
                                                    <div style="display:none" class="alert alert-card alert-success" role="alert"> <strong>Registro Exitoso!</strong> el sistema enviara un correo con los accesos. <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </div>
                                                    <div  style="display:none" id="error" class="alert alert-card alert-danger" role="alert"><strong>Ocurrio un error !</strong> vuelva a registrar nuevamente.<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </div>  
                                            </div>
                                            
                                        <div class="text-center mt-1">
                                                <button type="submit" class="btn bg-danger text-white btn-block">
                                                    <i class="fa fa-check color-info"></i> Registrarse
                                                </button>
                                        </div>                  
                        </form>

                        <div class="new-account mt-3 text-right">
                            <p class="text-white"> ¿Ya tienes con una cuenta?  <a class="text-white" href="<?php echo(site_url('Login'))?>">Iniciar Sesión</a> </p>
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
   <!-- <script src="<?php echo site_resource('mdp')?>/js/deznav-init.js"></script>-->
   <!--<script src="<?php echo site_resource('mdp')?>/vendor/global/global.min.js"></script>-->
   <script src="<?php echo site_resource('mdp')?>/js/plugins/bootstrap.bundle.min.js"></script>

    
</body>

</html>