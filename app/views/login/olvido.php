<!DOCTYPE>
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
    
    $(function() {
        $("#ap-frmLogin").validate({
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
                beforeSend: function() {},
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
                        <h4 class="text-center mb-4 text-white"><strong>¿Olvido su Contraseña?</strong></h4>    
                        <div class="alert alert-primary left-icon-big alert-dismissible fade show">
                                            <div class="media">
                                                <div class="alert-left-icon-big">
                                                    <span><i class="fa fa-info-circle"></i></span>
                                                </div>
                                                <div class="media-body">
                                                    <p class="mb-0">
                                                        Si olvidó su contraseña ingrese la dirección de correo electrónico utilizada para su cuenta y le enviaremos un correo electrónico con instrucciones sobre cómo acceder a su cuenta.
                                                    </p>
                                                </div>
                                            </div>
                        </div>
                        <form  id="ap-frmLogin" name="ap-frmLogin" action="<?php echo(site_url('Login/olvidoPassword'))?>" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <p class="mb-1 text-white"><strong>Email:</strong></p>
                                <input type="email" class="form-control" id="userLogin" name="userLogin" placeholder="ejemplo@ejemplo.com" required="required">
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn bg-danger text-white">Enviar</button>
                                <a href="<?php echo(site_url('Login'))?>" class="btn bg-white text-primary"> <i class="fa fa-arrow-left color-info"></i> Regresar </a>
                            </div>
                        </form>

                </div>
                </div>
                </div>
                </div>
                </div>
                </div>
                </div>
                </div>
    <script src="<?php echo site_resource('mdp')?>/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="<?php echo site_resource('mdp')?>/js/custom.min.js"></script>
    <script src="<?php echo site_resource('mdp')?>/js/deznav-init.js"></script>
</body>

</html>