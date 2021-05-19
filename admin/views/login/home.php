<!DOCTYPE>
<html>

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Mesa de Partes Virtual | Ugel03 </title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet" />
    <link href="<?php echo site_resource('adjudicacion')?>/css/themes/lite-blue.min.css" rel="stylesheet" />
    <link href="<?php echo site_resource('adjudicacion')?>/css/plugins/perfect-scrollbar.min.css" rel="stylesheet" />
    <script src="<?php echo site_resource('adjudicacion')?>/js/plugins/jquery-3.3.1.min.js"></script>
    <script src="<?php echo site_resource('admin') ?>/js/jquery.validate.min.js"></script>
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo site_resource('mdp')?>/images/laptop.png">
    <script src="https://www.google.com/recaptcha/api.js?render=6LfZBasUAAAAAOJ8aj-pNqZQTFny0QFeH1nN7mHb"></script>

<style>
     
    .layout-horizontal-bar .main-content-wrap {margin-top: 110px !important;}
    .afr-error{ background: #ffe1e1;  }
    .layout-horizontal-bar .main-header { background:#09bf94 !important; }
    .mb-2{ color:white; }

    @media (max-width: 4268px) {
        .mb-2:after {
          content:'REASIGNACION DOCENTE NO PRESENCIAL - UGEL03 '; 
          font-size:14px;
        }
        .layout-horizontal-bar .header-topnav {
          background-color: #bf090973;
        }
    }

    @media (max-width: 768px) { 
        .mb-2:after {
          content:'Reasignacion Ugel03'; 
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

    .container-fluid { background-color: #eee !important; }
    .layout-horizontal-bar .header-topnav .topnav a { color: black!important; }
    .any:hover { background-color: white; }
    .any2:hover {  color: white !important; }
    .bg-transparent {text-align: center; }
    .layout-horizontal-bar .header-topnav .topnav a, .layout-horizontal-bar .header-topnav .topnav label {
        display: flex;
        flex-direction: row;
        align-items: center;
        padding: 13px 20px;
        height: 54px;
        font-size: .955rem;
    }

</style>
    
</head>
    

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
        $("#ap-frmLogin").validate({
            rules: {
                userLogin: "required",
                userLogin: {
                    required: true,
                    email: false
                }
            },
            errorElement: "span",
            errorClass: "afr-error",
            errorPlacement: function(error, element) {},
            submitHandler: function(forms) { 
                enviarLogueo();
            }
        })

    });
                  
    function enviarLogueo() {

        var datastring = $("#ap-frmLogin").serialize();
        $.ajax({
            url: $("#ap-frmLogin").attr('action'),
            method: "POST",
            data: datastring,
            dataType: "JSON",
            beforeSend: function() {  
            },
            success: function(data) {
                switch (data.resp) {
                    case 100:
                        $(this).closest('form').find("input[type=text]").val("");
                        window.location.href = "<?php echo site_url('Adjudicacalifica') ?>";
                      
                        break;
                    case 10:
                        alert(data.text);
                        break;
                    default:
                }
            }
        })
    }

</script>


<body>

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
                <!-- Full screen toggle--><i class="i-Full-Screen header-icon d-none d-sm-inline-block"
                    data-fullscreen=""></i>
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
                                            
                                            <li class="nav-item"><a class="nav-link active show " id="contact-basic-tab"
                                                    data-toggle="tab" href="#contactBasic" role="tab"
                                                    aria-controls="contactBasic" aria-selected="true">Acceder</a></li>
                                        </ul>



                                                <!-- LOGIN -->
                                                <div class="card-header bg-transparent">
                                                    <h3 class="card-title"
                                                        style="margin-bottom: 0rem !important;font-size: 1rem !important;">
                                                        Bienvenido</h3>
                                                </div>
                                                <form  id="ap-frmLogin" name="ap-frmLogin" action="<?php echo(site_url('login/enviarLogin'))?>" method="post" enctype="multipart/form-data">

                                                <div class="card-body">
                                                    <input type="hidden" name="_token" value="EHCaqetA3yZlHAhaLGoLqBGTxyUsu7HmR9uKLqsR">
                                                    <div class="form-group row">
                                                        <label
                                                            class="ul-form__label ul-form--margin col-lg-5 col-form-label"
                                                            for="staticEmail6">DNI:</label>
                                                        <div class="col-lg-2">
                                                            <input class="form-control" id="userLogin" name="userLogin" type="email"
                                                                placeholder="" /><small
                                                                class="ul-form__text form-text" id="passwordHelpBlock">
                                                                Por favor ingrese usuario
                                                            </small>
                                                        </div>
                                                    </div>
                                                    <div class="custom-separator"></div>
                                                    <div class="form-group row">
                                                        <label
                                                            class="ul-form__label ul-form--margin col-lg-5 col-form-label"
                                                            for="staticEmail6">Contraseña:</label>
                                                        <div class="col-lg-2">
                                                            <input class="form-control" id="passuser" name="passuser" type="password"
                                                                placeholder="" /><small
                                                                class="ul-form__text form-text" id="passwordHelpBlock">
                                                                Por favor ingrese contraseña
                                                            </small>
                                                        </div>

                                                    </div>
                                                    <div class="custom-separator"></div>
                                                </div>
                                                <div class="card-footer">
                                                    <div class="mc-footer">
                                                        <div class="row text-center">
                                                            <div class="col-lg-12">
                                                                
                                                                    <button type="submit" value="Enviar" class="btn btn-primary m-1">ACCEDER</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                              </form>
                                            </div>
                                        </div>
                                    
                            </div>


                        </div>
                        <!--  end of main row -->
                    </div>
                </div><!-- end of main-content -->
            </div>

                    <!-- Footer Start -->
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
                        </div>
                        <div class="footer-bottom border-top pt-3 d-flex flex-column flex-sm-row align-items-center">
                            <a class="btn btn-primary text-white btn-rounded" href="#" target="_blank">
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
   



    <script>
        grecaptcha.ready(function() {
            grecaptcha.execute('6LfZBasUAAAAAOJ8aj-pNqZQTFny0QFeH1nN7mHb', {
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