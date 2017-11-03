<!DOCTYPE html>
<html>
    <head>
        <link href="<?php echo base_url(); ?>public/css/styles.css" rel="stylesheet" />
    </head>
    <body>
        <?php echo validation_errors(); ?>
        
        <?php if($this->session->flashdata('message')) { ?>
        <div id="container">
            <div id="body">
                <p><?php echo $this->session->flashdata('message'); ?></p>
            </div>
        </div>
        <?php } ?>
        
        <?php if($this->session->flashdata('login_error')) { ?>
        <div id="container">
            <div id="body">
                <p class="error-message"><?php echo $this->session->flashdata('login_error'); ?></p>
            </div>
        </div>
        <?php } ?>
        
        <div id="container">
            <h1>Login</h1>
            <div id="body">
                <?php echo form_open(); ?>
                <div>
                    <label for="username">
                        <span>Username</span>
                        <input type="text" name="username" id="username" placeholder="" maxlength="200" required>
                    </label>
                </div>                
                <div>
                    <label for="password">
                        <span>Password</span>
                        <input type="password" name="password" id="password" placeholder="" maxlength="200" required>
                    </label>
                </div>   
                <div>
                    <input type="submit" value="Login" />
                </div>
                <?php echo form_close(); ?>
            </div>
            <p class="footer">&copy; <?php echo date('Y'); ?> All rights reserved</p>
        </div>
        <script>
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    </body>
</html>