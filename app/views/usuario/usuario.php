<!DOCTYPE html>
<html lang="en" class="h-100">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <title>Ugel 03 - Mesa de Partes Virtual</title>
        <link href="<?php echo site_resource('mdp')?>/css/style.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.lineicons.com/2.0/LineIcons.css">
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo site_resource('mdp')?>/images/logo-full.png">
        <script src="<?php echo site_resource('mdp')?>/js/plugins/jquery-3.3.1.min.js"></script>
    </head>

    <script type="text/javascript">


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

        $(function(){

            if(<?=$data_usuario->idTipPer?> == "1"){
                //document.getElementById('DivapPaterno').style.display='block';
                //document.getElementById('DivapMaterno').style.display='block';
                document.getElementById('tipoPersona').placeholder="PERSONA NATURAL";
            }
            if(<?=$data_usuario->idTipPer?> == "2"){
                document.getElementById('lblnroDoc').innerHTML="NUMERO DE R.U.C";
                document.getElementById('DivapPaterno').style.display='none';
                document.getElementById('DivapMaterno').style.display='none';
                document.getElementById('tipoPersona').placeholder="PERSONA JURIDICA";
            }
            if(<?=$data_usuario->idTipPer?> == "3"){
                document.getElementById('lblnroDoc').innerHTML="CODIGO MODULAR Y/O LOCAL";
                document.getElementById('lblNombre').innerHTML="NOMBRE INSTITUCION EDUCATIVA";
                document.getElementById('DivapPaterno').style.display='none';
                document.getElementById('DivapMaterno').style.display='none';
                document.getElementById('tipoPersona').placeholder="INSTITUCION EDUCATIVA";
                if(<?=$data_usuario->idCargo?> == "12"){
                    document.getElementById('DivCargo').style.display='block';
                }
            }
            if(<?=$data_usuario->idTipPer?> == "4"){
                document.getElementById('lblnroDoc').innerHTML="D.N.I";
                //document.getElementById('DivapPaterno').style.display='block';
                //document.getElementById('DivapMaterno').style.display='block';
                document.getElementById('tipoPersona').placeholder="MENOR DE EDAD";
            }

        })

    
        $(function(){

            $('#comunicadoadjudicacion').modal('show');

            $('#show').mousedown(function(){
                $('#password1').removeAttr('type');
            });

            $('#show').mouseup(function(){
                $('#password1').attr('type','password');
            });

            $('#show').mousedown(function(){
                $('#password2').removeAttr('type');
            });

            $('#show').mouseup(function(){
                $('#password2').attr('type','password');
            });
           
           
            $("#cbDepartamento").change(function(){      
                $("#cbDepartamento option:selected").each(function() {
                    depa_id = $('#cbDepartamento').val();
                    $.post(
                         "<?php echo(site_url("Login/getprovincia"))?>", 
                        {depa_id:depa_id}, 
                        function(data)
                        {
                            $("#cbProvincia").html(data); 
                        }
                    );
                });   
            });    

            $("#cbProvincia").change(function(){      
                $("#cbProvincia option:selected").each(function() {
                    id_prov = $('#cbProvincia').val();
                    $.post(
                         "<?php echo(site_url("Login/getdistrito"))?>", 
                        {id_prov:id_prov}, 
                        function(data)
                        {
                            $("#cbDistrito").html(data); 
                        }
                    );
                });   
            });   

            $("#ap-frmActualizacion").validate({
                errorElement: "span",
                errorClass: "afr-error",
                errorPlacement: function(error, element) {},
                submitHandler: function(forms) {
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

                             
            $("#ap-frmActualizacion").validate({
                rules: {
                    userLogin: "required",
                    userLogin: {
                        required: true,
                        email: true
                    }
                },
                messages: {
                    userLogin: "Error en Nombre."
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

            var datastring = $("#ap-frmActualizacion").serialize();

            $(".loader").css("display", "block");
            $(".alert-success").css("display", "none");
            $(".alert-danger").css("display", "none");

            $.ajax({
                url: $("#ap-frmActualizacion").attr('action'),
                method: "POST",
                data: datastring,
                dataType: "JSON",
                beforeSend: function() {

                },
                success: function(data) {

                   

                    switch (data.error) {
                        case 0:

                            $(".alert-success").text(data.msg);
                            $(".alert-success").css("display", "block");
                            $(".alert-danger").css("display", "none");
                            $(".loader").css("display", "none");

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
                            
                    }

                    if (data.error == 3) {

                    } else {

                    }

                }
            })

        }

        
        function enviarFormDatosPersonales() {

                var datastring = $("#ap-frmActualizacion").serialize();

                $.ajax({
                    url: $("#ap-frmActualizacion").attr('action'),
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

    <style>

        .Contra{
            position: relative;
        }
        .Contra i{
            position: absolute;
            right:0;
            margin-right:15px;
            top:50px;
            width:80px; 
            height:55px;
            color: black;
            text-align: center;
            font-size: 15px;
        }
    </style>

    <body>
            <!--- MODAL DE AVISO DE LLENAR CAMPOS DE DATOS -->
            <div class="modal fade" id="comunicadoadjudicacion" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">COMUNICADO</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p style="text-align:justify"><b>Lenado de Formulario</b></p>
                            <p style="text-align:justify">Porfavor debe Completar el formulario de Vivienda ya que contamos con un Courier para poder entregar documentos necesarios y determinar la ubicacion.</p>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>

        <div id="preloader">
            <div class="sk-three-bounce">
                <div class="sk-child sk-bounce1"></div>
                <div class="sk-child sk-bounce2"></div>
                <div class="sk-child sk-bounce3"></div>
            </div>
        </div>
        <div id="main-wrapper">
            <div class="nav-header">
                <a href="index.html" class="brand-logo">
                    <img class="logo-abbr" src="<?php echo site_resource('mdp')?>/images/logo.png" alt="">
                    <!--<img class="logo-abbr" src="./images/logo.png" alt="">-->
                </a>
                <div class="nav-control">
                    <div class="hamburger">
                        <span class="line"></span><span class="line"></span><span class="line"></span>
                    </div>
                </div>
            </div>
            <!--**********************************
                    Header start
                ***********************************-->
            <div class="header">
                <div class="header-content">
                    <nav class="navbar navbar-expand">
                        <div class="collapse navbar-collapse justify-content-between">
                            <div class="header-left">
                                <div class="dashboard_bar">
                                    Datos Personales
                                </div>
                            </div>
                            <ul class="navbar-nav header-right">
                                <li class="nav-item dropdown header-profile">
                                    <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                                        <img src="<?php echo site_resource('mdp')?>/images/default.jpg" width="20" alt="">
                                        <div class="header-info">
                                            <!--<span class="text-black" style="display:none"><?=$data_usuario->nombre?></span>-->
                                            <span class="text-black"><?=$data_usuario->nombre."\n".$data_usuario->apPaterno;?></span>
                                            <p class="fs-12 mb-0">USUARIO</p>
                                        </div>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="<?php echo(site_url('Login'))?>" class="dropdown-item ai-icon">
                                            <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger"
                                                 width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                                <polyline points="16 17 21 12 16 7"></polyline>
                                                <line x1="21" y1="12" x2="9" y2="12"></line>
                                            </svg>
                                            <span class="ml-2">Cerrar Sesión </span>
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
            <div class="deznav">
                <div class="deznav-scroll">
                    <ul class="metismenu mm-show" id="menu">
                        <li class="mm-active">
                            <a class="has-arrow ai-icon" href="javascript:" aria-expanded="false">
                                <i class="flaticon-381-networking"></i>
                                <span class="nav-text">Datos Personales</span>
                            </a>
                            <ul class="mm-collapse mm-show" aria-expanded="false">
                                <li class="mm-active">
                                    <a href="vista-principal-usuario.html" class="mm-active">Perfil</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a class="ai-icon" href="tramite-usuario.html" aria-expanded="false">
                                <i class="flaticon-381-television"></i>
                                <span class="nav-text">Nuevo Tramite</span>
                            </a>
                        </li>
                        <li>
                            <a class="ai-icon" href="seguimiento-usuario.html" aria-expanded="false">
                                <i class="flaticon-381-television"></i>
                                <span class="nav-text">Seguimiento</span>
                            </a>
                        </li>
                    </ul>
                    <div class="copyright">
                        <p><strong>UGEL 03</strong><br>© Derechos Reservados</p>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <div class="container-fluid">
                    <div class="page-titles">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:">Datos Personales</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:">Perfil</a></li>
                        </ol>
                    </div>
                    <div class="row">
                        <div class="col-xl-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="fs-24 text-black font-w600 mr-auto mb-2 pr-3">Perfil</h3>
                                    <!--a href="javascript:" class="btn btn-dark light btn-rounded mr-3 mb-2">Cancelar</a>
                                    <a href="javascript:" class="btn btn-primary btn-rounded mb-2">Guardar Cambios</a>
                                    <div class="text-center mt-1">
                                                <button type="submit" class="btn btn-primary btn-rounded mb-2">
                                                    <i class="fa fa-check color-info"></i> Guardar Cambios
                                                </button>
                                    </div>-->
                                </div>
                                <div class="card-body">
                                    <form id="ap-frmActualizacion" name="ap-frmActualizacion" action="<?php echo(site_url('Login/enviarActualizarDatos'))?>" method="POST" enctype="multipart/form-data" >
                                        <div class="mb-5">
                                            <div class="title mb-4">
                                                <span class="fs-18 text-black font-w600">Datos Personales</span>
                                            </div>
                                            <div class="row">
                    
                                                <div class="col-xl-3 col-sm-6" id="DivTipoPersona">
                                                    <div class="form-group">
                                                        <label class="font-weight-bold">TIPO</label>
                                                        <input class='form-control' type='text' id='tipoPersona' name='tipoPersona'  placeholder="TIPO PERSONA" disabled>
                                                    </div>
                                                </div>

                                                <!--- DIV DE PRUEBA PARA JALAR EL NUMERO DE TIPO DE PERSONA --->
                                                <div class="col-xl-3 col-sm-6" id="DivTipoPersona1" style="display: none;" >
                                                    <div class="form-group">
                                                        <label class="font-weight-bold">TIPO PERSONA</label>
                                                        <input class='form-control' type='text' id='tipoPersona1' name='tipoPersona1'  value="<?=$data_usuario->idTipPer?>" disabled>
                                                    </div>
                                                </div>

                                                <div class="col-xl-3 col-sm-6" id="DivNumeroDocumento">
                                                    <div class="form-group">
                                                            <label class='font-weight-bold' id="lblnroDoc">NUMERO DE DOCUMENTO</label>
                                                            <input class='form-control' type='text' id='nroDocumento' name='nroDocumento' value="<?=$data_usuario->nroDocumento?>" disabled>
                                                    </div>
                                                </div>

                                                <div class="col-xl-3 col-sm-6" id="DivNombres">
                                                    <div class="form-group">
                                                        <label class="font-weight-bold" id="lblNombre">NOMBRES</label>
                                                            <input class='form-control' type='text' id='nombre' name='nombre' value="<?=$data_usuario->nombre?>" disabled>
                                                    </div>
                                                </div>

                                                <div class="col-xl-3 col-sm-6" id="DivapPaterno">
                                                    <div class="form-group">
                                                        <label class="font-weight-bold">APELLIDO PATERNO</label>
                                                            <input class='form-control' type='text' id='apPaterno' name='apPaterno' value="<?=$data_usuario->apPaterno?>" disabled>
                                                    </div>
                                                </div>

                                                <div class="col-xl-3 col-sm-6" id="DivapMaterno">
                                                    <div class="form-group">
                                                        <label class="font-weight-bold">APELLIDO MATERNO</label>
                                                            <input class='form-control' type='text' id='apMaterno' name='apMaterno' value="<?=$data_usuario->apMaterno?>" disabled>
                                                    </div>
                                                </div>

                                                <div class="col-xl-3 col-sm-6" id="DivCargo" style="display: none;">
                                                    <div class="form-group">
                                                        <label class="font-weight-bold">CARGO</label>
                                                            <input class='form-control' type='text' id='cargo' name='cargo' value="<?=$data_usuario->descripcion_cargo?>" disabled>
                                                    </div>
                                                </div>

                                                <div class="col-xl-3 col-sm-6" >
                                                    <div class="form-group">
                                                        <label class="font-weight-bold">CELULAR</label>
                                                            <input class='form-control' type='phone' onkeypress="return soloNumeros(event);" maxlength="9" id='celular' name='celular'  style='color:black;' value="<?=$data_usuario->celular?>">
                                                    </div>
                                                </div>

                                                <div class="col-xl-3 col-sm-6" id="CodModular">
                                                    <div class="form-group">
                                                        <label class="font-weight-bold">CORREO ELECTRONICO</label>
                                                            <input class='form-control' type='text' id='correo' name='correo' style='color:black;' value="<?=$data_usuario->correo?> ">
                                                    </div>
                                                </div>

                                                <div class="col-xl-3 col-sm-6 Contra" >
                                                    <div class="form-group">
                                                        <label class="font-weight-bold">CONTRASEÑA</label> <i class="fa fa-eye" id="show"></i>
                                                            <input class='form-control' maxlength="6" type='password' id='password1' name='password1' style='color:black;' value="<?=$data_usuario->pass?>"> 
                                                    </div>
                                                </div>
                                                
                                                <div class="col-xl-3 col-sm-6 Contra" >
                                                    <div class="form-group">
                                                        <label class="font-weight-bold">CONFIRMAR CONTRASEÑA</label> 
                                                            <input class='form-control' maxlength="6" type='password' id='password2' name='password2' style='color:black;' value="<?=$data_usuario->pass?>"> 
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <!--------------------- DATOS DE DOMICILIO ----------------->
                                        <div class="mb-5">
                                            <div class="title mb-4">
                                                <span class="fs-18 text-black font-w600">Dirección</span>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-4 col-sm-6">
                                                    <div class="form-group">
                                                        <label class="font-weight-bold" for="cbDepartamento">Departamento</label>
                                                            <?php 
                                                                echo "<select class='form-control' id='cbDepartamento' name='cbDepartamento' required='required' >";
                                                                    if (count($ubicacion)) {
                                                                        echo "<option value='0'>[--Seleccione--]</option>";
                                                                        foreach ($ubicacion as $list) {
                                                                        echo "<option value='". $list['idDepa'] . "'>" . $list['departamento'] . "</option>";
                                                                        }
                                                                    }
                                                                echo "</select>";
                                                             ?> 
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-sm-6">
                                                    <div class="form-group">
                                                        <label class="font-weight-bold" >Provincia</label>
                                                        <select class="form-control" data-width="100%" id="cbProvincia" name="cbProvincia">
                                                            <option value=""  >[--Seleccione--]</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-xl-4 col-sm-6">
                                                    <div class="form-group">
                                                        <label class="font-weight-bold">Distrito</label>
                                                        <select class="form-control" data-width="100%"  name="cbDistrito" id="cbDistrito">
                                                            <option value="" selected="selected">[--Seleccione--]</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-sm-6">
                                                    <div class="form-group">
                                                        <label class="font-weight-bold">Tipo de Vía</label>
                                                        <?php 
                                                            echo "<select class='form-control' id='cbVia' name='cbVia'>";
                                                                if (count($Via)) {
                                                                    echo "<option value=''>[--Seleccione--]</option>";
                                                                    foreach ($Via as $list) {
                                                                    echo "<option value='". $list['idVia'] . "'>" . $list['descripcion'] . "</option>";
                                                                    }
                                                                }
                                                            echo "</select>";
                                                            ?> 
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-sm-6">
                                                    <div class="form-group">
                                                        <label class="font-weight-bold">Tipo de Zona</label>
                                                        <?php 
                                                            echo "<select class='form-control' id='cbZona' name='cbZona'>";
                                                                if (count($Zona)) {
                                                                    echo "<option value=''>[--Seleccione--]</option>";
                                                                    foreach ($Zona as $list) {
                                                                    echo "<option value='". $list['idZona'] . "'>" . $list['descripcion'] . "</option>";
                                                                    }
                                                                }
                                                            echo "</select>";
                                                            ?> 
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-sm-6">
                                                    <div class="form-group">
                                                        <label class="font-weight-bold">Nombre de la Vía</label>
                                                        <input type="text" class="form-control" id="txtvia" name="txtvia">
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-sm-6">
                                                    <div class="form-group">
                                                        <label class="font-weight-bold">Nombre de la Zona</label>
                                                        <input type="text" class="form-control" id="txtzona" name="txtzona">
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-sm-6">
                                                    <div class="form-group">
                                                        <label class="font-weight-bold">Referencia</label>
                                                        <input type="text" class="form-control" id="txtreferencia" name="txtreferencia">
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-sm-6">
                                                    <div class="form-group">
                                                        <label class="font-weight-bold">Nro Inmueble</label>
                                                        <input type="text" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-sm-6">
                                                    <div class="form-group">
                                                        <label class="font-weight-bold">Block</label>
                                                        <input type="text" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-sm-6">
                                                    <div class="form-group">
                                                        <label class="font-weight-bold">Piso</label>
                                                        <input type="text" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-sm-6">
                                                    <div class="form-group">
                                                        <label class="font-weight-bold">Manzana</label>
                                                        <input type="text" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-sm-6">
                                                    <div class="form-group">
                                                        <label class="font-weight-bold">Lote</label>
                                                        <input type="text" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-sm-6">
                                                    <div class="form-group">
                                                        <label class="font-weight-bold">Kilometro</label>
                                                        <input type="text" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-right ">
                                                <button type="submit" class="btn btn-primary btn-rounded mr-3 mb-2">
                                                    <i class="fa fa-check color-info"></i> Guardar Cambios
                                                </button>
                                                <button type="submit" class="btn btn-dark light btn-rounded mr-3 mb-2">
                                                    Cancelar
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
            <div class="footer">
                <div class="copyright">
                    <p><strong>Unidad de Gestión Educativa Local N° 3</strong><br>© Derechos Reservados</p>
                </div>
            </div>
        </div>

        <script src="<?php echo site_resource('mdp')?>/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
        <script src="<?php echo site_resource('mdp')?>/vendor/global/global.min.js"></script>
        <script src="<?php echo site_resource('mdp')?>/js/custom.min.js"></script>
        <script src="<?php echo site_resource('mdp')?>/js/deznav-init.js"></script>
        <script src="<?php echo site_resource('mdp')?>/js/plugins/bootstrap.bundle.min.js"></script>
        <script src="<?php echo site_resource('mdp')?>/js/jquery.validate.min.js"></script>

    </body>
</html>
