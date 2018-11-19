<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forgot Password | Spring Board</title>
    <!-- Bootstrap -->
    <?php echo $this->Html->css(['bootstrap', 'style','restrict_data']); ?>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="./js/html5shiv.min.js"></script>
    <script src="./js/respond.min.js"></script>
    <![endif]-->
</head>
<body class="bg-light">

<nav class="navbar navbar-default navbar-white navbar-fixed-top" role="navigation">
    <div class="navbar-header">
        <a class="navbar-brand navbar-brand-image" href=""></a>
    </div>
</nav>

<div class="container-fluid container-padding-top">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 bg-white margin-bottom-xl">
            <div class="padding-md">
                <div class="text-center">
                    <h3>Forgot Password</h3>
                </div>

                <hr/>
                <span style="margin-left: 150px;"class="<?php echo @$class?>"><?php echo @$email_error; ?></span>
                 <span style="margin-left: 39px;" class="<?php echo @$class1?>"><?php echo @$email_success; ?></span>
                <?php echo $this->Form->create('',['id'=>"forgot_password"]);?>
                    <div class="margin-top-lg">
                        <div class="form-group row">
                            <div class="col-md-3">
                                <label for="username" class="padding-top-md">Username<span style="color: red">*</span></label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" id="username" name="username" class="form-control">  
                                <span id="check_username"></span>        
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3">
                                <label for="username" class="padding-top-md">Email<span style="color: red">*</span></label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" id="email" name="email" class="form-control">
                                <span id="check_email"></span>
                              </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3">
                                <label for="username" class="padding-top-md">Doj<span style="color: red">*</span></label>
                            </div>
                            <div class="col-md-6">
                                <input type="date" id="doj" name="doj" class="form-control">
                                <span id="check_doj"></span><br>
                                <small class="text-muted">Just enter your details and we'll send you an email containing link to reset password , remember this has to be email address you registerd with</small>
                            </div>
                        </div>
                        <div class="form-group text-center margin-top-xl">
                            <button class="btn btn-danger" id="forgotpassword"><i class="fa fa-paper-plane"></i> Send me a link</button>
                        </div>
                        <div class="form-group text-center margin-top-xl">
                                <?php $url1= $this->Url->build(['controller' => 'Users', 'action' => 'login']);?>
                                <a href="<?= $url1; ?>"><small class="text-muted">&larr;Back to SpringBoard</small></a>
                            </div>
                    </div>
                <?php echo $this->Form->end();?>
            </div>
        </div>
    </div>
</div>

<footer class="bg-white container-fluid">
    <div class="row">
        <div class="col-md-12 text-center">
            <?php echo $this->Html->image('springboard-logo.png'); ?>
        </div>
    </div>
</footer>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="./js/jquery-1.12.4.js"></script>
<script src="./js/jquery-ui.js"></script>
<?php echo $this->Html->script(['jquery-1.12.4', 'bootstrap.min', 'sidebar','jquery-ui','dashboard','chart.min','guage','restrict_data']); ?>

        <script>
        $(document).ready(function(){
            $('#forgotpassword').click(function(){

     var valid = true;            
    if($('#username').val()=='')
    {   
        $('#username').css('border','1px solid red');
        $('#check_username').text('Please enter username');
        $('#check_username').addClass('error_label');
        valid = false;
    }
    else {
        $('#username').css('border','1px solid #cccccc');
        $('#check_username').text('');
    }
    if($('#doj').val()=='')
    {
        $('#doj').css('border','1px solid red');
        $('#check_doj').text('Please enter doj');
        $('#check_doj').addClass('error_label');
        valid = false;

    }
    else
    {
        $('#doj').css('border','1px solid #cccccc');
        $('#check_doj').text('');


    }

     if($('#email').val()=='')
    {
        $('#email').css('border','1px solid red');
        $('#check_email').text('Please enter email id');
        $('#check_email').addClass('error_label');
        valid = false;

    }
    else
    {
        $('#email').css('border','1px solid #cccccc');
        $('#check_email').text('');


    }

    if(valid == true)
    {
    $('#forgot_password').submit();
    }
    else
    {
      return false;
    }

                
            });
        });
        
       
        </script>
</body>
</html>