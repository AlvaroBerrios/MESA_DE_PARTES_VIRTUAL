<!DOCTYPE>
<html>

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Reasignación | Ugel03 </title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet" />
    <link href="<?php echo site_resource('adjudicacion')?>/css/themes/lite-blue.min.css" rel="stylesheet" />
    <link href="<?php echo site_resource('adjudicacion')?>/css/plugins/perfect-scrollbar.min.css" rel="stylesheet" />

    
    <script src="<?php echo site_resource('adjudicacion')?>/js/plugins/jquery-3.3.1.min.js"></script>
    <script src="<?php echo site_resource('admin') ?>/js/jquery.validate.min.js"></script>
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo site_resource('adjudicacion') ?>/icon/adjudicaciones.png">
    <script src="https://www.google.com/recaptcha/api.js?render=6Ld3b9EZAAAAAIIrnNIJsV1bRdL-ES_muj_fDSa3"></script>
    
    <script>



$(function() {
    

$('#condiciones').click(function() {
  if ($(this).is(':checked')) {
    
    $("#resultadocheck").val(1);
  }else{
    $("#resultadocheck").val(0); 
  }
});


    $('#panelCui [data-toggle="tooltip"]').tooltip({
    animated: 'fade',
    placement: 'bottom',
    html: true
});
});
</script>
    <style>
     
     .layout-horizontal-bar .main-content-wrap {
     
         margin-top: 110px !important;
        
     }
 
      .afr-error{
        background: #ffe1e1; 
      }
     .layout-horizontal-bar .main-header {
         background: #003473 !important;
     }

     .mb-2{
          color:white;
     }

    

     @media (max-width: 4268px) {

          .mb-2:after {
          content:'REASIGNACIÓN DOCENTE NO PRESENCIAL - UGEL03 '; 
          font-size:20px;
      }
      .layout-horizontal-bar .header-topnav {

           background-color: #FFFFFF;
      }

    }
    @media (max-width: 768px) { 
        .mb-2:after {
          content:'REASIGNACIÓN ONLINE'; 
      }
      .layout-horizontal-bar .main-content-wrap {
           margin-top: 60px !important;
       }

       .layout-horizontal-bar .main-header .header-icon {
            font-size: 30px;
        }

        
    }

    @media (max-width: 468px) { 
        .card-body {
           flex: 1 1 auto;
          padding: 0.25rem;
         }
         
         .col-1, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-10, .col-11, .col-12, .col, .col-auto, .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm, .col-sm-auto, .col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12, .col-md, .col-md-auto, .col-lg-1, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg, .col-lg-auto, .col-xl-1, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9, .col-xl-10, .col-xl-11, .col-xl-12, .col-xl, .col-xl-auto {
    position: relative;
    width: 100%;
    min-height: 1px;
    padding-right: 0px;
    padding-left: 0px;
}
    .col-md-9{
        padding-right: 15px !important;
        padding-left: 15px ;
        text-align: justify;
    }
}
     .container-fluid {
         background-color: #eee !important;
     }


     .layout-horizontal-bar .header-topnav .topnav a {
         color: black!important;
     }

     .any:hover {
         background-color: white;
     }
     .any2:hover {
       color: white !important;
     }
     .bg-transparent {
    text-align: center;
}

.layout-horizontal-bar .header-topnav .topnav a, .layout-horizontal-bar .header-topnav .topnav label {
    display: flex;
    flex-direction: row;
    align-items: center;
    padding: 13px 20px;
    height: 54px;
    font-size: .955rem;
}

 </style>
    

    <script type="text/javascript">

        var cbo;
        var dependencia = [];

        $(window).resize(function() {
            $('#afr-cmessage').css({
                left: ($(window).width() - $('#afr-cmessage').outerWidth(true))/2,
                top: ($(window).height() - $('#afr-cmessage').outerHeight(true))/2
            });
        });


        
        $(function() {


            $("#limpiarForm").click(function(){
              
            $("#ap-frmRecamo")[0].reset();
             });


            $("#enviarForm").click(function(){
              
             document.getElementById('enviarForm').disabled = true;


            });

           

            /***************ap-05122018**********************/

            $("#coTipoDocumento").change(function() {

                var optionSelected = $("option:selected", this);
                var valueSelected = this.value;

                if (valueSelected == 1) {

                    $("#numDocumento").attr('maxlength', 8);
                    $("#numDocumento").attr('minlength', 8);
                    $("#numDocumento").val("");
                    document.getElementById('numCui').disabled = false;
                    
                }else{

                    $("#numDocumento").attr('maxlength', 11);
                    $("#numDocumento").attr('minlength', 11);
                    $("#numDocumento").val("");
                    $("#numCui").val("");
                    document.getElementById('numCui').disabled = true;
                } 

            });

        
            $("#coEtapa").change(function() {

                $("#coEtapa option:selected").each(function() {
                    etapa = $('#coEtapa').val();
                    $.post("<?php echo(site_url('homeAdjudicaciones/getfase'))?>", {etapa:etapa},
                        function(data) {

                            $("#coFase").html(data);
                                                            
                        });
                });
                

            });

            $("#cboModalidad").change(function() {

                $("#cboModalidad option:selected").each(function() {
                    modalidad = $('#cboModalidad').val();
                    $.post("<?php echo(site_url('homeAdjudicaciones/getnivel'))?>", {modalidad:modalidad},
                        function(data) {

                            $("#cboNivel").html(data);
                                if (modalidad == 0) {
                                    $("#cboNivel").val(0);
                                    document.getElementById('cboNivel').disabled = true;
                                    
                                } else{
                                    document.getElementById('cboNivel').disabled = false;
                                }
                            
                        });
                });


            });

             $("#cboCargo").change(function() {

                $("#cboCargo option:selected").each(function() {
                    cargo = $('#cboCargo').val();
                    $.post("<?php echo(site_url('homeAdjudicaciones/getcurricular'))?>", {cargo:cargo},
                        function(data) {
                            $("#cboCurricular").html(data);
                            document.getElementById('cboCurricular').disabled = false;
                        });
                });


            });

             $("#cboNivel").change(function() {
                
                $("#cboNivel option:selected").each(function() {
                    nivel = $('#cboNivel').val();
                    cargo = $('#cboCargo').val();

                    if(cargo == 7 || cargo == 9){
                        if(nivel == 5 || nivel == 6 || nivel == 7 || nivel == 8){

                            $.post("<?php echo(site_url('homeAdjudicaciones/getcurricular2'))?>", {nivel:nivel},
                            function(data) {
                                $("#cboCurricular").html(data);
                                document.getElementById('cboCurricular').disabled = false;
                            });
                        }else{
                            if(cargo==7){
                            $("#cboCurricular").val(19);
                            document.getElementById('cboCurricular').disabled = false;
                            }
                            if(cargo==9){
                            $("#cboCurricular").val(21);
                            document.getElementById('cboCurricular').disabled = false;
                            }
                        }
                    }
                    
                });

            });

            

            /***************************************************/

            $("#ap-frmRecamo").validate({
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

            $("#ap-frmLogin").validate({

                rules: {

                    userLogin: "required",
                    userLogin: {
                        required: true,
                        email: true
                    }

                },

                errorElement: "span",
                errorClass: "afr-error",
                errorPlacement: function(error, element) {},
                submitHandler: function(forms) {

                    enviarLogueo();
                    //$('.afr-btn').attr("disabled","disabled");

                    //  forms.submit();

                }
            })

        })

     

        function enviarFormDatosPersonales() {

            var datastring = $("#ap-frmRecamo").serialize();

            $(".loader").css("display", "block");
            $(".alert-success").css("display", "none");
            $(".alert-danger").css("display", "none");

            $.ajax({
                url: $("#ap-frmRecamo").attr('action'),
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


        

        function enviarContra() {

            var datastring = $("#ap-frmLogin").serialize();
           
            $.ajax({
                url: $("#ap-frmLogin").attr('action'),
                method: "POST",
                data: datastring,
                dataType: "JSON",
                beforeSend: function() {
                    // $("#in-pogress").html("Processing daata");
                   
                },
                success: function(data) {

                    switch (data.resp) {
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
                        case 100:

                            $(this).closest('form').find("input[type=text]").val("");
                            window.location.href = "<?php echo site_url('adjudicaciones') ?>";
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

        
        function countChar(val) {
            var len = val.value.length;
            if (len >= 500) {
                val.value = val.value.substring(0, 500);
            } else {
                $('#charNum').text(500 - len);
            }
        };
    </script>

    <script>
        function isNumberKey(evt) {

            var charCode = (evt.which) ? evt.which : evt.keyCode;
            // Added to allow decimal, period, or delete 
            //if (charCode == 110 || charCode == 190 || charCode == 46)
            //    return true;

            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;

            return true;
        }

        
        function isCharKey(evt){

                var charCode = (evt.which) ? evt.which : evt.keyCode;
                if (charCode != 46 && charCode > 31
                    && (charCode < 48 || charCode > 57))
                    return true;
                return false;
        }

        function isCharKey2(evt) {

            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 65 || charCode > 90) && (charCode < 97 || charCode > 122))
                return false;

            return true;
        }

    </script>
<script>
	
	$(document).ready(function() {
    
  //$('#comunicadoadjudicacion').modal('show');
    });

	</script>
   

</head>

<body>
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
     
	  <a target="_blank" href="<?php echo site_resource('adjudicacion') ?>/comunicados/Comunicado55.pdf" >
      <img class="img-fluid"  src="<?php echo site_resource('adjudicacion') ?>/comunicados/comunicado55.PNG"></img>
      </a>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<div class="app-admin-wrap layout-horizontal-bar">
        <div class="main-header">
            <div class="logo"><img src="<?php echo site_resource('adjudicacion')?>/images/logo.png" alt=""></div>

            <div class="menu-toggle">
                <div></div>
                <div></div>
                <div></div>
            </div>
            <div class="d-flex align-items-center">

                <h5 class="mb-2 t-font-boldest"></h5> 
            </div>
            <div style="margin: auto"></div>
            <div class="header-part-right">
               
            </div>
        </div>
        <!-- header top menu end-->
        <div class="horizontal-bar-wrap">
            <div class="header-topnav">
                <div class="container-fluid">
                    <div class="topnav rtl-ps-none" id="" data-perfect-scrollbar="" data-suppress-scroll-x="true">
                        <ul class="menu float-left">
                            <!--
                            <li>
                                <div>
                                    <div class="any">
                                        <a class="any2" href="<?php echo(site_url('homeAdjudicaciones'))?>"><i class="nav-icon mr-2 i-Shop-4"></i> Inicio</a>
                                    </div>
                                </div>
                            </li>
					       
                           <li>
                                <div>
                                    <div class="any">
                                        <a class="any2" href="#"><i class="i-Professor"> </i> &nbsp;Resultados</a>
                                    </div>
                                </div>
                            </li> 

                            <li>
                                <div>
                                    <div class="any">
                                        <a class="any2" href="#"><i class="i-Computer-Secure"> </i> &nbsp;Cronograma</a>
                                    </div>
                                </div>
                            </li> 

                            <li>
                                <div>
                                    <div class="any">
                                        <a class="any2"  href="<?php echo(site_url('resultados'))?>"><i class="nav-icon i-File-Horizontal-Text"></i> &nbsp; Plazas</a>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div>
                                    <div class="any">
                                        <a class="any2" href="<?php echo(site_url('cronograma"'))?>"><i class="nav-icon i-Checked-User"> </i> &nbsp;Adjudicados</a>
                                    </div>
                                </div>
                            </li> 
                            <li>
                                <div>
                                    <div class="any">
                                        <a class="any2" href="<?php echo(site_url('cronograma"'))?>"><i class="nav-icon i-download"> </i> &nbsp;Tutorial</a>
                                    </div>
                                </div>
                            </li> -->

                             <li>
                                <div>
                                    <div class="any">
                                        <a class="any2" target="_blank" href="<?php echo site_resource('pdf') ?>/Guía_de_Aplicativo_Reasignacion_2020.pdf"><i class="nav-icon i-download"> </i> &nbsp;GUÍA PARA EL REGISTRO Y ENVÍO DE DOCUMENTACIÓN</a>
                                    </div>
                                </div>
                            </li> 
                            
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- =============== Horizontal bar End ================-->
        <div class="main-content-wrap d-flex flex-column">
            <!-- ============ Body content start ============= -->
            <div class="main-content">

                <div class="2-columns-form-layout">
                    <div>
                        <div class="row">

                            <div class="col-lg-12">
                                <div class="card text-left">
                                    <div class="card-body">

                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                          <li class="nav-item"><a class="nav-link " id="home-basic-tab"
                                                    data-toggle="tab" href="#registro" role="tab"
                                                    aria-controls="registro" aria-selected="false">Registrarse</a></li>

                                            <li class="nav-item"><a class="nav-link active show " id="contact-basic-tab"
                                                    data-toggle="tab" href="#contactBasic" role="tab"
                                                    aria-controls="contactBasic" aria-selected="true">Recuperar contraseña</a></li>
                                        </ul>
                                        <div class="tab-content" id="myTabContent">
                                            <div class="tab-pane fade " id="registro" role="tabpanel"
                                                aria-labelledby="home-basic-tab">
                                                <!-- REGISTRAR -->
                                                <div class="card-header bg-transparent">
                                                    <h3 class="card-title"
                                                        style="margin-bottom: 0rem !important ; font-size: 1rem !important;">
                                                        Datos Personales</h3>
                                                </div>

                                                <form id="ap-frmRecamo" name="ap-frmRecamo" action="<?php echo(site_url('homeAdjudicaciones/enviarRegistroDatos'))?>" method="post" enctype="multipart/form-data">

                                                <div class="card-body">

                                                    <div class="form-group row">

                                                        <label
                                                            class="ul-form__label ul-form--margin col-lg-1 col-form-label"
                                                            for="staticEmail19">TIPO DE PERSONA:</label>
                                                        <div class="col-lg-2">
                                                            <div class="input-group-prepend">
                                                                        <div class="input-group-text bg-transparent"><i class="i-Checked-User"></i>
                                                                        </div>
                                                            <select class="form-control valid" id="cboTipoPersona" name="cboTipoPersona" required="required" aria-required="true" aria-invalid="false"><option value="1">Persona Natural</option></select>
                                                            </div>
                                                            <small class="ul-form__text form-text" id="passwordHelpBlock"> Seleccione tipo de persona </small>

                                                        </div>

                                                        <label
                                                            class="ul-form__label ul-form--margin col-lg-1 col-form-label"
                                                            for="staticEmail20">DOCUMENTO :</label>
                                                        <div class="col-lg-2">
                                                            <div class="input-group-prepend">
                                                                        <div class="input-group-text bg-transparent"><i class="i-id-card"></i>
                                                                        </div>
                                                            <select class="form-control valid" required="required" id="coTipoDocumento" name="coTipoDocumento" required="required" aria-required="true" aria-invalid="false">    
                                                                <option value="0">[--Seleccione--]&nbsp;</option>        
                                                                <option value="1">DNI/LE</option>
                                                                <option value="2">Carnet de Extranjería</option>
                                                             </select>
                                                            </div>
                                                            <small class="ul-form__text form-text" id="passwordHelpBlock"> Seleccione tipo de documento </small>
                                                        </div>

                                                        <label
                                                            class="ul-form__label ul-form--margin col-lg-1 col-form-label"
                                                            for="staticEmail21">NUMERO DOCUMENTO:</label>
                                                        <div class="col-lg-3">
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text bg-transparent"><i
                                                                            class="i-File-Horizontal-Text"></i></div>
                                                                </div>
                                                                <input type="text" class="form-control" id="numDocumento" required="required" name="numDocumento" placeholder="Ingrese número de documento" minlength="8" maxlength="8" onkeypress="return isNumberKey(event)">
                                                            </div><small class="ul-form__text form-text"
                                                                id="passwordHelpBlock">
                                                               * Ingrese número de documento </small>
                                                        </div>
                                                    
                                                     <div id="panelCui" class="">
                                                        <a class="ul-form__label ul-form--margin col-lg-1 col-form-label" data-toggle="tooltip" title="<img src='http://sistemas01.ugel03.gob.pe/adjudicacionesOnline/resource/adjudicacion/images/cui.png' />">
                                                            <i class="nav-icon mr-1 i-Cursor-Click"></i>CUI
                                                        </a>
                                                  
                                                    </div>

                                                        <div class="col-lg-1">
                                                            <div class="input-group mb-3">
                                                                
                                                                <input type="text" class="form-control" id="numCui" required="required" name="numCui" placeholder="CUI"  minlength="1" maxlength="1" onkeypress="return isNumberKey(event)">
                                                            </div><small class="ul-form__text form-text"
                                                                id="passwordHelpBlock">
                                                               * Ingrese número de CUI
                                                            </small>
                                                        </div>
                                                    </div>
                                                    <div class="custom-separator"></div>
                                                    <div class="form-group row">
                                                        <label
                                                            class="ul-form__label ul-form--margin col-lg-1 col-form-label"
                                                            for="staticEmail22">NOMBRES:</label>
                                                        <div class="col-lg-3">
                                                            <div class="input-right-icon">
                                                        <input type="text" class="form-control" id="txtnombres" required="required" name="txtnombres" placeholder="Ingrese nombres completos" maxlength="40" onkeypress="return isCharKey(event)">
                                                                <span
                                                                    class="span-right-input-icon"><i
                                                                        class="ul-form__icon i-Male"></i></span>
                                                            </div>
                                                                <small
                                                                class="ul-form__text form-text" id="passwordHelpBlock">
                                                                * Campo Obligatorio
                                                            </small>
                                                        </div>
                                                        <label
                                                            class="ul-form__label ul-form--margin col-lg-1 col-form-label"
                                                            for="staticEmail23">APELLIDO PATERNO:</label>
                                                        <div class="col-lg-3">
                                                            <div class="input-right-icon">
                                                            <input type="text" class="form-control" id="txtapePaterno" required="required" name="txtapePaterno" placeholder="Ingrese apellido paterno" maxlength="30" onkeypress="return isCharKey(event)">
                                                            <span
                                                                    class="span-right-input-icon"><i
                                                                        class="ul-form__icon i-Business-Woman"></i></span>
                                                            </div>
                                                            <small class="ul-form__text form-text"
                                                                id="passwordHelpBlock">
                                                                * Campo Obligatorio
                                                            </small>
                                                            
                                                        </div>
                                                        <label
                                                            class="ul-form__label ul-form--margin col-lg-1 col-form-label"
                                                            for="staticEmail24">APELLIDO MATERNO:</label>
                                                        <div class="col-lg-3">
                                                            <div class="input-right-icon">
                                                            <input type="text" class="form-control" id="txtapeMaterno" required="required" name="txtapeMaterno" placeholder="Ingrese apellido materno" maxlength="30" onkeypress="return isCharKey(event)">
                                                                    <span
                                                                    class="span-right-input-icon"><i
                                                                        class="ul-form__icon i-Administrator"></i></span>
                                                            </div>
                                                            <small class="ul-form__text form-text"
                                                                id="passwordHelpBlock">
                                                                * Campo Obligatorio
                                                            </small>
                                                        </div>
                                                    </div>
                                                    <div class="custom-separator"></div>
                                                    <div class="form-group row">
                                                        

                                                        <label class="ul-form__label ul-form--margin col-lg-1 col-form-label" for="staticEmail20"> ETAPA :</label>
                                                        <div class="col-lg-2">
                                                            <!-- <div class="input-group mb-2"> -->
                                                                <div class="input-group-prepend">
                                                                        <div class="input-group-text bg-transparent"><i class="i-globe"></i>
                                                                        </div>
                                                                 <!-- </div>  -->   
                                                                 <?php echo "<select class='form-control' id='coEtapa' name='coEtapa' required='required' >";
                                                                        if (count($etapa)) {
                                                                          echo "<option value='0'>[--Seleccione--]</option>";
                                                                            foreach ($etapa as $list) {
                                                                           echo "<option value='". $list['id_etapa'] . "'>" . $list['descripcion_etapa'] . "</option>";
                                                                           }
                                                                        }
                                                                           echo "</select>";
                                                                ?> 
                                                            </div>
                                                             <small class="ul-form__text form-text" id="passwordHelpBlock"> * Seleccione etapa
                                                             </small>
                                                        </div>

                                                        <label class="ul-form__label ul-form--margin col-lg-1 col-form-label" for="staticEmail20"> FASE :</label>
                                                        <div class="col-lg-1">
                                                             <div class="input-group-prepend">
                                                                        <div class="input-group-text bg-transparent"><i class="i-flag"></i>
                                                                        </div>
                                                                       <?php echo "<select class='form-control' id='coFase' name='coFase' required='required' >";
                                                                        if (count($fase)) {
                                                                          echo "<option value='0'>[--Seleccione--]</option>";
                                                                            foreach ($fase as $list) {
                                                                           echo "<option value='". $list['id_fase'] . "'>" . $list['descripcion_fase'] . "</option>";
                                                                           }
                                                                        }
                                                                           echo "</select>";
                                                                ?> 
                                                             </div>
                                                             <small class="ul-form__text form-text" id="passwordHelpBlock"> * Seleccione fase
                                                             </small>
                                                        </div>

                                                        <label class="ul-form__label ul-form--margin col-lg-1 col-form-label" for="staticEmail20"> CAUSAL :</label>
                                                        <div class="col-lg-2">
                                                            <div class="input-group-prepend">
                                                                        <div class="input-group-text bg-transparent"><i class="i-shield"></i>
                                                                        </div>
                                                             <select class="form-control valid" required="required" id="coCausa" name="coCausa" aria-required="true" aria-invalid="false">  
                                                                <option value="0">[--Seleccione--]&nbsp;</option>              
                                                                <option value="1">Interés Personal</option>
                                                                <option value="2">Unidad Familiar</option>  
                                                             </select>
                                                             </div>
                                                             <small class="ul-form__text form-text" id="passwordHelpBlock"> * Seleccione causal
                                                             </small>
                                                        </div>

                                                        <label class="ul-form__label ul-form--margin col-lg-1 col-form-label" for="staticEmail20"> CARGO :</label>
                                                        <div class="col-lg-3">
                                                            <div class="input-group-prepend">
                                                                        <div class="input-group-text bg-transparent"><i class="i-Professor"></i>
                                                                        </div>
                                                                 <?php echo "<select class='form-control' id='cboCargo' name='cboCargo' required='required' >";
                                                                        if (count($cargo)) {
                                                                          echo "<option value='0'>[--Seleccione--]</option>";
                                                                            foreach ($cargo as $list) {
                                                                           echo "<option value='". $list['id_cargo'] . "'>" . $list['descripcion_cargo'] . "</option>";
                                                                           }
                                                                        }
                                                                           echo "</select>";
                                                                ?>
                                                             </div>
                                                             <small class="ul-form__text form-text" id="passwordHelpBlock"> * Seleccione cargo
                                                             </small>
                                                        </div>

                                                        
                                                        
                                                       
                                                    </div>
                                                    <div class="custom-separator"></div>
                                                    <div class="form-group row">
                                                        

                                                        <label class="ul-form__label ul-form--margin col-lg-1 col-form-label" for="staticEmail20"> MODALIDAD:</label>
                                                        <div class="col-lg-3">
                                                            <div class="input-group-prepend">
                                                                        <div class="input-group-text bg-transparent"><i class="i-Suitcase"></i>
                                                                        </div>
                                                                 <?php echo "<select class='form-control' id='cboModalidad' name='cboModalidad' required='required' >";
                                                                        if (count($modalidad)) {
                                                                          echo "<option  value='0'>[--Seleccione--]</option>";
                                                                            foreach ($modalidad as $list) {
                                                                           echo "<option value='". $list['id_modalidad'] . "'>" . $list['descripcion_modalidad'] . "</option>";
                                                                           }
                                                                        }
                                                                           echo "</select>";
                                                                ?>
                                                             </div>
                                                             <small class="ul-form__text form-text" id="passwordHelpBlock"> * Seleccione modalidad
                                                             </small>
                                                        </div>

                                                        <label class="ul-form__label ul-form--margin col-lg-1 col-form-label" for="staticEmail20"> NIVEL:</label>
                                                        <div class="col-lg-3">
                                                            <div class="input-group-prepend">
                                                                        <div class="input-group-text bg-transparent"><i class="i-Loading-3"></i>
                                                                        </div>
                                                                 <?php echo "<select disabled class='form-control' id='cboNivel' name='cboNivel' required='required' >";
                                                                        if (count($nivel)) {
                                                                          echo "<option value='0'>[--Seleccione--]</option>";
                                                                            foreach ($nivel as $list) {
                                                                           echo "<option value='". $list['id_nivel'] . "'>" . $list['descripcion_nivel'] . "</option>";
                                                                           }
                                                                        }
                                                                           echo "</select>";
                                                                ?>
                                                             </div>
                                                             <small class="ul-form__text form-text" id="passwordHelpBlock"> * Seleccione nivel
                                                             </small>
                                                        </div>

                                                        <label class="ul-form__label ul-form--margin col-lg-1 col-form-label" for="staticEmail20"> ÁREA CURRICULAR :</label>
                                                        <div class="col-lg-3">
                                                            <div class="input-group-prepend">
                                                                        <div  class="input-group-text bg-transparent"><i class="i-book"></i>
                                                                        </div>
                                                                 <?php echo "<select disabled class='form-control' id='cboCurricular' name='cboCurricular' required='required' >";
                                                                        if (count($curricular)) {
                                                                          echo "<option value='0'>[--Seleccione--]</option>";
                                                                            foreach ($curricular as $list) {
                                                                           echo "<option value='". $list['id_curricular'] . "'>" . $list['descripcion_curricular'] . "</option>";
                                                                           }
                                                                        }
                                                                           echo "</select>";
                                                                ?>
                                                             </div>
                                                             <small class="ul-form__text form-text" id="passwordHelpBlock"> * Seleccione área curricular
                                                             </small>
                                                        </div>
  
                                                       
                                                    </div>
                                                    <div class="custom-separator"></div>
                                                    <div class="form-group row">
                                                        
                                                        <label
                                                            class="ul-form__label ul-form--margin col-lg-1 col-form-label"
                                                            for="staticEmail25">CELULAR:</label>
                                                        <div class="col-lg-2">
                                                            <div class="input-right-icon">
                                                            <input type="text" class="form-control" required="required" id="numCelular" name="numCelular" minlength="9" maxlength="9" placeholder="Número celular" onkeypress="return isNumberKey(event)">
                                                                    
                                                                    <span
                                                                    class="span-right-input-icon"><i
                                                                        class="ul-form__icon i-Telephone"></i></span>
                                                            </div><small class="ul-form__text form-text"
                                                                id="passwordHelpBlock">
                                                                * Campo Obligatorio
                                                            </small>
                                                        </div>
                                                        <label
                                                            class="ul-form__label ul-form--margin col-lg-1 col-form-label"
                                                            for="staticEmail25">CORREO:</label>
                                                        <div class="col-lg-3">
                                                            <div class="input-right-icon">
                                                            <input type="email" class="form-control" id="txtemail" name="txtemail" required="required" placeholder="Ingrese correo" maxlength="80">
                                                                    
                                                                    <span
                                                                    class="span-right-input-icon"><i
                                                                        class="ul-form__icon i-New-Mail"></i></span>
                                                            </div><small class="ul-form__text form-text"
                                                                id="passwordHelpBlock">
                                                                * Campo Obligatorio
                                                            </small>
                                                        </div>
                                                        <label
                                                            class="ul-form__label ul-form--margin col-lg-1 col-form-label"
                                                            for="staticEmail25">REPETIR CORREO:</label>
                                                        <div class="col-lg-3">
                                                            <div class="input-right-icon">
                                                            <input type="email" class="form-control" id="txtemail2" name="txtemail2" required="required" placeholder="Ingrese correo" maxlength="80">
                                                                    
                                                                    <span
                                                                    class="span-right-input-icon"><i
                                                                        class="ul-form__icon i-New-Mail"></i></span>
                                                            </div><small class="ul-form__text form-text"
                                                                id="passwordHelpBlock">
                                                                * Campo Obligatorio
                                                            </small>
                                                        </div>
                                                    </div>

                                                    

                                                

                                                    <div style="display:none;text-align: center;" class="loader loader-bubble loader-bubble-info m-6"></div>
                                                </div>
                                                <label class="checkbox checkbox-outline-success">
                                    <input type="checkbox" id="condiciones" name="condiciones"     data-toggle="modal" data-target="#exampleModalLong" ><span>(*)Acepto Terminos y condiciones</span><span class="checkmark"></span>
                                    <input id="resultadocheck" name="resultadocheck" type="hidden" value="0">
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
                                                <div class="card-footer">
                                                    <div class="mc-footer">
                                                    
                                                    <div style="display:none" class="alert alert-card alert-success" role="alert"> <strong>Registro Exitoso!</strong> el sistema enviara un correo con los accesos. <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                               <span aria-hidden="true">×</span></div>
                                                    <div style="display:none" class="alert alert-card alert-danger" role="alert"><strong>Ocurrio un error !</strong> vuelva a registrar nuevamente.<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                   <span aria-hidden="true">×</span></div>  
                                                    
                                                        <div class="row text-center">
                                                        
                                                            <div class="col-lg-12">

                                
                                                           
                                                           
                                                             
                                                            <button id="enviarForm" name="enviarForm" type="submit" value="Enviar" class="btn btn-primary m-1">ENVIAR</button>
                                                             <button id="limpiarForm" name="limpiarForm"  class="btn btn-outline-secondary m-1" type="button">LIMPIAR</button>
                                                             
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>   
                                                <input type="hidden" id="token" name="token">
                                             </form>

                                            </div>
                                            <div class="tab-pane fade active show " id="contactBasic" role="tabpanel"
                                                aria-labelledby="contact-basic-tab">




                                                <!-- LOGIN -->
                                                <div class="card-header bg-transparent">
                                                    <h3 class="card-title"
                                                        style="margin-bottom: 0rem !important;font-size: 1rem !important;">
                                                        ENVIAR CONTRASEÑA</h3>
                                                </div>
                                                <form  id="ap-frmLogin" name="ap-frmLogin" action="<?php echo(site_url('homeAdjudicaciones2/enviarContra'))?>" method="post" enctype="multipart/form-data">

                                                <div class="card-body">
                                                    <div class="form-group row">
                                                        <label
                                                            class="ul-form__label ul-form--margin col-lg-5 col-form-label"
                                                            for="staticEmail6">Correo:</label>
                                                        <div class="col-lg-2">
                                                            <input class="form-control" id="userLogin" name="userLogin" type="email"
                                                                placeholder="" /><small
                                                                class="ul-form__text form-text" id="passwordHelpBlock">
                                                                Por favor ingrese correo
                                                            </small>
                                                        </div>
                                                    </div>
                                                    
                                                     <div class="row text-center">
                                                        <div class="col-lg-12">
                                                            <a href="<?php echo(site_url('HomeAdjudicaciones'))?>" class="ul-form__text form-text">  Regresar al login </a> 
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class="card-footer">
                                                    <div class="mc-footer">
                                                        <div class="row text-center">
                                                            <div class="col-lg-12">
                                                                
                                                                    <button type="submit" value="Enviar" class="btn btn-primary m-1">ENVIAR</button>
                                                            
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                              </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <!--  end of main row -->
                    </div>
                </div><!-- end of main-content -->
            </div><!-- Footer Start -->
            <div class="flex-grow-1"></div>
            <div class="app-footer">
                <div class="row">
                    <div class="col-md-9">
                        <p><strong>MISIÓN</strong></p>
                        <p>
                            Garantizar un servicio educativo de calidad en todos los niveles y modalidades,
                            fortaleciendo las capacidades de gestión pedagógica y administrativa, impulsando la cohesión
                            social y promoviendo el aporte de los gobiernos locales e instituciones privadas
                            especializadas para mejorar la calidad del servicio educativo.
                            <sunt></sunt>
                        </p>
                    </div>
                    <div class="custom-separator"></div>
                    <div class="col-md-9">
                        <p><strong>PROBLEMAS TÉCNICOS</strong></p>
                        <p>
                            Numeros de Contacto para problemas técnicos de registro: <b style="color:#ae3e3e">936097738-934871792-922905743-986874528- 902487385</b></br>
                            <b>*La atención es de 8:00 a 13:00 y 14:00 hasta las 5:00 p.m.</b>
                            <sunt></sunt>
                        </p>
                    </div>
                </div>
                <div class="footer-bottom border-top pt-3 d-flex flex-column flex-sm-row align-items-center">
                    <a class="btn btn-primary text-white btn-rounded" href="http://www.ugel03.gob.pe/" target="_blank">
                        UGEL03</a>
                    <span class="flex-grow-1"></span>
                    <div class="d-flex align-items-center">
                        <img class="logo" src="<?php echo site_resource('adjudicacion')?>/images/logo.png" alt="">
                        <div>
                            <p class="m-0">&copy; 2020 ETI | APP</p>
                            <p class="m-0">Todos los derechos reservados</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- fotter end -->
        </div>
    </div>
   


 <!-- xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx -->






    


    <script>
        grecaptcha.ready(function() {
            grecaptcha.execute('6Ld3b9EZAAAAAIIrnNIJsV1bRdL-ES_muj_fDSa3', {
                action: 'homepage'
            }).then(function(token) {
                document.getElementById("token").value = token;
            });
        });
    </script>

    <script src="<?php echo site_resource('adjudicacion')?>/js/plugins/bootstrap.bundle.min.js"></script>
    <script src="<?php echo site_resource('adjudicacion')?>/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="<?php echo site_resource('adjudicacion')?>/js/scripts/script.min.js"></script>
    <script src="<?php echo site_resource('adjudicacion')?>/js/scripts/sidebar-horizontal.script.js"></script>
</body>

</html>
