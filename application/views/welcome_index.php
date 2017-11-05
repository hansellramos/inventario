<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home</title>
        <link href="<?php echo base_url(); ?>public/css/styles.css" rel="stylesheet" />

    </head>
    <body>
        <div id="container">
            <h1>Bienvenido <?php echo "$account->name $account->lastname ($account->username)"; ?></h1>
            <div id="body">
                <?php if($account->is_admin){ ?>
                <?php echo anchor('account/add','Create Account'); ?>
                <?php echo anchor('product/add','Create Product'); ?>
                <?php } ?>
                <?php echo anchor('product/index','Lista de Productos',['class'=>'']); ?>
            </div>

            <div id="logout">
                <?php echo anchor('welcome/logout','Logout'); ?>
            </div>
            
            <p class="footer">&copy; <?php echo date('Y'); ?> All rights reserved</p>
        </div>
        <script>
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    </body>
</html>