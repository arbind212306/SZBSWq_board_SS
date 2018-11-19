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
                    <h3></h3>
                </div>
                 <div class="alert alert-danger">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times</a>
                   <i class="alert-warning "></i>Your reset password link has expired
                </div>
                <hr/>
                      <div class="margin-top-lg">
                        
                        <div class="form-group text-center margin-top-xl">

                                <?php $url1= $this->Url->build(['controller' => 'Users', 'action' => 'login']);?>
                                <a href="<?= $url1; ?>"><small class="text-muted">&larr;Back to SpringBoard</small></a>
                            
                        </div>
                    </div>
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

