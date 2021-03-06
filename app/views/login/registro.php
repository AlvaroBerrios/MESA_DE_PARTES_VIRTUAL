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
                         $('#lblNroDoc').text("N??mero de Documento");
                         $('#lblBus').text("B??squeda");

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
                         $('#lblNroDoc').text("N??mero de Documento");
                         $('#lblBus').text("B??squeda");

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
                            $("#txtdoc").attr("placeholder", "Ingrese c??digo modular/local");
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
                         $('#lblBus').text("B??squeda");

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
                                                    <label class="mb-1 text-white">Raz??n Social:</label>
                                                    <input type="text" class="form-control" placeholder="Ingrese Raz??n Social" name="txtrazonsocial" id="txtrazonsocial" maxlength="40">
                                            </div>
                                        </div>
                                        <div class="form-row" id="divIE"  name="divIE" style="display:none;">
                                            <div class="form-group col-md-8">
                                                    <label class="mb-1 text-white">Instituci??n Educativa:</label>
                                                    <input type="text" class="form-control" placeholder="Ingrese Instituci??n Educativa" id="txtie" name="txtie" maxlength="80">
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
                                                <label class="mb-1 text-white">Tel??fono</label>
                                                <input class="form-control" onkeypress="return soloNumeros(event);" placeholder="Ingrese Tel??fono" maxlength="9" type="tel" name="txtphone" id="txtphone" required >
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
                                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">??</span></button>
                                                    </div>
                                                    <div class="modal-body">
                                                                <p style="text-align:justify"> Al dar click en este casillero, usted est?? autorizando </p>
                                                                <p style="text-align:justify"><b> Veracidad de la informaci??n declara por el administrado</b></p>

                                                                <p style="text-align:justify"> Declaro expresamente que la informaci??n ingresa en la Plataforma para el proceso de contrataci??n docente 2020 es verdadera y conforme con lo establecido en el art??culo 49 del Texto ??nico Ordenado de la Ley N?? 27444, Ley del Procedimiento Administrativo General, y en caso de resultar falsa la informaci??n que proporciono, me sujeto a los alcances de lo establecido en el art??culo 411 del C??digo Penal, concordante con el art??culo 33 del Texto ??nico Ordenado de la Ley N?? 27444, Ley del Procedimiento Administrativo General; autorizando a efectuar la comprobaci??n de la veracidad de la informaci??n declarada en la presente plataforma.</p>

                                                                <p style="text-align:justify"><b> Autorizaci??n para la notificaci??n al correo electr??nico</b> </p>

                                                                <p style="text-align:justify">AUTORIZO de forma expresa y conforme a lo dispuesto por el art??culo N?? 20 del Texto ??nico Ordenando de la Ley N?? 27444 ??? Ley del Procedimiento Administrativo General, aprobado mediante el DECRETO SUPREMO N?? 004-2019-JUS y modificado mediante el Decreto Legislativo N?? 1497, a la UNIDAD DE GESTION EDUCATIVA LOCAL 03 ??? UGEL 05, que me notifique el/los acto(s) administrativo(s), comunicados o documentaci??n adicional que se emitan a consecuencia del proceso de contrataci??n docente 2020 al correo electr??nico consignado en presente plataforma; as?? mismo acuerdo que el  acto administrativo, los comunicados o la documentaci??n adicional pueda estar contenida en un archivo adjunto o un enlace web a trav??s del cual se descargar?? y/o otros mecanismo que garanticen su notificaci??n.</p>

                                                                <p style="text-align:justify">Tengo conocimiento que las notificaciones dirigidas a la direcci??n de mi correo electr??nico se??alada en la presente Plataforma se entiende v??lidamente efectuadas cuando la UGEL 05 reciba la respuesta de recepci??n de la direcci??n electr??nica antes se??alada; a trav??s del acuse de recibo, el mismo que dejar?? constancia del acto de notificaci??n; en concordancia a lo establecido por el art??culo 20 del mencionado Texto ??nico Ordenado, surtiendo efectos el d??a siguiente que conste haber sido recibido en mi bandeja de entrada, conforme a lo previsto en el numeral 2 del art??culo 25 del citado Texto ??nico Ordenado.</p>

                                                                <p style="text-align:justify">
                                                                En atenci??n a la presente autorizaci??n me comprometo con las siguientes obligaciones:
                                                                1.	Se??alar una direcci??n de correo electr??nica v??lida, a la cual tenga acceso y que se mantenga activa durante el proceso de contrataci??n docente 2020.
                                                                2.	Asegurar que la capacidad del buz??n de la direcci??n de correo electr??nico permita recibir los documentos a notificar.
                                                                3.	Revisar continuamente la cuenta de correo electr??nico, incluyendo la bandeja de spam o el buz??n de correo no deseado.</p>

                                                                <p style="text-align:justify">El no tomar conocimiento oportuno de las notificaciones remitidas por la UNIDAD DE GESTION EDUCATIVA LOCAL 03 ??? UGEL 05, debido al incumplimiento de las presentes obligaciones, constituye exclusiva responsabilidad de mi persona. </p>

                                                                <p style="text-align:justify">DECRETO LEGISLATIVO N?? 1497: DECRETO LEGISLATIVO QUE ESTABLECE MEDIDAS PARA PROMOVER Y FACILITAR CONDICIONES REGULATORIAS QUE CONTRIBUYAN A REDUCIR EL IMPACTO EN LA ECONOM??A PERUANA POR LA EMERGENCIA SANITARIA PRODUCIDA POR EL COVID- 19
                                                                Art??culo 3.- Incorporaci??n de p??rrafo en el art??culo 20 de la Ley N?? 27444, Ley del Procedimiento Administrativo General
                                                                Incorp??rase un ??ltimo p??rrafo en el art??culo 20 de la Ley N?? 27444, Ley del Procedimiento Administrativo General, cuyo texto queda redactado de la manera siguiente:
                                                                ???Art??culo 20.- Modalidades de notificaci??n
                                                                (???)</p>
                                                                <p style="text-align:justify">El consentimiento expreso a que se refiere el quinto p??rrafo del numeral 20.4 de la presente Ley puede ser otorgado por v??a electr??nica.???</p>

                                                                <p style="text-align:justify"><b>Autorizaci??n para el tratamiento de los datos personal del administrado</b></p>

                                                                <p style="text-align:justify">En atenci??n a los dispuesto por la Ley N?? 29733, Ley de Protecci??n de Datos Personales y su Reglamento aprobado por Decreto Supremo N?? 003-2013-JUS, AUTORIZO a la UNIDAD DE GESTION EDUCATIVA LOCAL 03 ??? UGEL 05 al tratamiento de mis datos personales, as?? como cualquier otra informaci??n ingresada en la plataforma para el proceso de contrataci??n docente 2020.</p>
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
                                                        <span aria-hidden="true">??</span>
                                                    </div>
                                                    <div  style="display:none" id="error" class="alert alert-card alert-danger" role="alert"><strong>Ocurrio un error !</strong> vuelva a registrar nuevamente.<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">??</span>
                                                    </div>  
                                            </div>
                                            
                                        <div class="text-center mt-1">
                                                <button type="submit" class="btn bg-danger text-white btn-block">
                                                    <i class="fa fa-check color-info"></i> Registrarse
                                                </button>
                                        </div>                  
                        </form>

                        <div class="new-account mt-3 text-right">
                            <p class="text-white"> ??Ya tienes con una cuenta?  <a class="text-white" href="<?php echo(site_url('Login'))?>">Iniciar Sesi??n</a> </p>
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