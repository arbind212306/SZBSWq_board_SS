<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password | Spring Board</title>
    <!-- Bootstrap -->
    <?php echo $this->Html->css(['bootstrap', 'style']); ?>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
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
                    <h3>Reset Password</h3>
                </div>
                 <div class="<?php echo @$class; ?>">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close"><?php echo @$close; ?></a>
                   <i class="<?php echo @$iclass; ?>"></i><?php echo @$sucessful; ?>.
                </div>
                <hr/>
                <?php echo $this->Form->create('',['id'=>"reset_password"]);?>
                      <div class="margin-top-lg">
                        <div class="form-group row">
                            <div class="col-md-3">
                                <label for="new_password" class="padding-top-md">New Password</label>
                            </div>
                            <div class="col-md-9">
                                <input type="password" id="new_password" name="new_password" class="form-control" >
                                <span id="check_new_password"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3">
                                <label for="confirm_password" class="padding-top-md">Confirm New Password</label>
                            </div>
                            <div class="col-md-9">
                                <input type="password" id="confirm_password" name="confirm_password" class="form-control">
                                <span id="check_confirm_password"></span>
                            </div>
                        </div>
                        <div class="form-group text-center margin-top-xl">
                            <button class="btn btn-danger" id="changepaswrd"><i class="fa fa-paper-plane"></i> Change Password</button>
                        </div>
                    </div>
                <?php echo $this->Form->end(); ?>
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
<?php echo $this->Html->script(['jquery-1.12.4', 'bootstrap.min', 'sidebar','jquery-ui','dashboard','chart.min','guage']); ?>
</body>
</html>

<script type="text/javascript">
    $(document).ready(function(){
     
     $('#changepaswrd').click(function(){
        var valid = true;

            if($('#new_password').val()=='')
            {
                $('#new_password').css('border','1px solid red');
                $('#check_new_password').text('Please enter new password');
                $('#check_new_password').addClass('error_label');
                valid = false;
            }
            else {
                $('#new_password').css('border','1px solid #cccccc');
                $('#check_new_password').text('');
            }

            if($('#confirm_password').val()=='')
            {
                $('#confirm_password').css('border','1px solid red');
                $('#check_confirm_password').text('Please enter confirm password');
                $('#check_confirm_password').addClass('error_label');
                valid = false;
            }
            else {
                $('#confirm_password').css('border','1px solid #cccccc');
                $('#check_confirm_password').text('');
            }
            if(($('#new_password').val()!= '' && $('#confirm_password').val()!='') && ($('#new_password').val() != $('#confirm_password').val()))
            {
                $('#confirm_password').css('border','1px solid red');
                $('#new_password').css('border','1px solid red');
                $('#check_confirm_password').text('Password mismatch');
                $('#check_confirm_password').addClass('error_label');
                $('#check_new_password').text('Password mismatch');
                $('#check_new_password').addClass('error_label');
                valid = false;
            }
            else
            {   
                
            }

            if(valid == true){
                $('#reset_password').submit();
            }

            else
            {
                return false;
            }
       
         
     }) ;   
 
    });

</script>
