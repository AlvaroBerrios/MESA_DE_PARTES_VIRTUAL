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
    <link href="<?php echo site_resource('mdp')?>/css/style.css" rel="stylesheet" />
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo site_resource('mdp')?>/images/laptop.png">
    <script src="https://www.google.com/recaptcha/api.js?render=6LfZBasUAAAAAOJ8aj-pNqZQTFny0QFeH1nN7mHb"></script>


    <style>

    .container-fluid { background-color: #09bf94 !important; } 
    .layout-horizontal-bar .main-content-wrap {margin-top: 70px !important;}
    .afr-error{ background: #ffe1e1;  }
    .layout-horizontal-bar .main-header { background:#40189D !important; }
    .mb-2{ color:white; }
    @media (max-width: 4268px) {
        .mb-2:after {
          content:'BIENVENIDO A MESA DE PARTES VIRTUAL - UGEL03 '; 
          font-size:16px;
        }
    }
    .mb-1{ font-size:22px; }
    .layout-horizontal-bar .header-topnav .topnav a { color: black!important; }
    .any:hover { background-color: white; }
    .any2:hover {  color: white !important; }
    .bg-transparent {text-align: center; }

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
                        window.location.href = "<?php echo site_url('Tramite') ?>";
                      
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

            <div class="logo"><img src="<?php echo site_resource('adjudicacion')?>/images/logo.png" alt="">
            </div>

            <div class="d-flex align-items-center">
                <h5 class="mb-2 t-font-boldest"></h5> 
            </div>

            <div style="margin: auto">
            </div>

        </div>
      

 

        <!-- =============== Horizontal bar End ================-->
        <div class="main-content-wrap d-flex flex-column">

            <!-- ============ Body content start ============= -->
            <div class="main-content">

                <div class="authincation h-100">
                <div class="container h-100">
                <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                <div class="authincation-content">
                <div class="row no-gutters">
                <div class="col-xl-12">
                <div class="auth-form">    

                           
                        <form  id="ap-frmLogin" name="ap-frmLogin" action="<?php echo(site_url('Login/enviarLogin'))?>" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <p class="text-white"><strong>Email</strong></p>
                                <input type="email" class="form-control" id="userLogin" name="userLogin" placeholder="ejemplo@ejemplo.com">
                            </div>
                            <div class="form-group">
                                <p class="text-white"><strong>Contraseña</strong></p>
                                <input type="password" class="form-control" id="passuser" name="passuser" placeholder="Contraseña">
                            </div>
                            <div class="form-row d-flex justify-content-between mt-4 mb-3">
                                <div class="form-group">
                                </div>
                                <div class="form-group">
                                    <a class="text-white" href="<?php echo(site_url('Login/olvidar'))?>">¿Olvidaste tu contraseña?</a>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" value="Enviar" class="btn bg-white text-primary btn-block">Ingresar</button>
                            </div>
                        </form>
                        <div class="new-account mt-3">
                                        <p class="text-white">¿No tienes cuenta? <a class="text-white" href="<?php echo(site_url('Login/registrate'))?>">Registrate</a></p>
                        </div>

                </div>
                </div>
                </div>
                </div>
                </div>
                </div>
                </div>
                </div>


            </div>

                    <!-- Footer Start -->
                    <div class="main-content">
                    <div class="flex-grow-1"></div>
                    <div class="app-footer">
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

    
    <script src="<?php echo site_resource('mdp')?>/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="<?php echo site_resource('mdp')?>/js/custom.min.js"></script>
    <script src="<?php echo site_resource('mdp')?>/js/deznav-init.js"></script>
    <script src="<?php echo site_resource('adjudicacion')?>/js/plugins/bootstrap.bundle.min.js"></script>
    <script src="<?php echo site_resource('adjudicacion')?>/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="<?php echo site_resource('adjudicacion')?>/js/scripts/script.min.js"></script>
    <script src="<?php echo site_resource('adjudicacion')?>/js/scripts/sidebar-horizontal.script.js"></script>
</body>

</html>