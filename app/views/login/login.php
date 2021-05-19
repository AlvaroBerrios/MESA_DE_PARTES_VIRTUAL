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
                passuser: "required",
                userLogin: {
                    required: true,
                    email: true
                }
            },
            messages: {
              passuser: "Por favor ingresar contraseña.",
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
            beforeSend: function() {  
            },
            success: function(data) {
                switch (data.resp) {
                    case 100:
                        $(this).closest('form').find("input[type=text]").val("");
                        window.location.href = "<?php echo site_url('Login/usuario') ?>";
                        alert(data.text);
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
                            <a href="index.php"><img src="<?php echo site_resource('mdp')?>/images/logo-full.png" alt=""></a>
                        </div>
                        <h4 class="text-center mb-4 text-white">Iniciar Sesión</h4> 
                        <form  id="ap-frmLogin" name="ap-frmLogin" action="<?php echo(site_url('Login/enviarLogin'))?>" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <p class="mb-1 text-white"><strong>Email:</strong></p>
                                <input type="email" class="form-control" id="userLogin" name="userLogin" placeholder="ejemplo@ejemplo.com">
                            </div>
                            <div class="form-group">
                                <p class="mb-1 text-white"><strong>Contraseña:</strong></p>
                                <input type="password" class="form-control" id="passuser" name="passuser" placeholder="********">
                            </div>
                            <div class="form-row d-flex justify-content-between mt-4 mb-3">
                                <div class="form-group">
                                </div>
                                <div class="form-group">
                                    <a class="text-white" href="<?php echo(site_url('Login/olvidar'))?>">¿Olvidaste tu contraseña?</a>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" value="Enviar" class="btn bg-danger text-white btn-block"> <i class="fa fa-check color-info"></i> Ingresar </button>
                            </div>
                        </form>
                        <div class="new-account mt-3" style="text-align:center;">
                                        <p class="text-white">¿No tienes cuenta? <a class="text-white" href="<?php echo(site_url('login/registrate'))?>">Registrate</a></p>
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
    <script src="<?php echo site_resource('mdp')?>/js/custom.min.js"></script>
    <script src="<?php echo site_resource('mdp')?>/js/deznav-init.js"></script>
</body>

</html>