<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php if($this->session->flashdata('redirect')) { ?>
        <meta http-equiv="refresh" content="<?php echo $redirect_time; ?>; url=<?php echo site_url('account/index') ?>" />
        <style>
            #container {
                display: none;
            }
        </style>
        <?php } ?>
        <title>Create Account</title>

        <link href="<?php echo base_url(); ?>public/css/styles.css" rel="stylesheet" />
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    </script>
    </head>
    <body>
        
        <?php if($this->session->flashdata('message')) { ?>
        <div id="flash-message">
            <div id="body">
                <p class="success-message"><?php echo $this->session->flashdata('message'); ?></p>
                <?php if($this->session->flashdata('redirect')) { ?>
                <p>Redirecting, click <?php echo anchor('account/index','here') ?> to go now</p> 
                <?php } ?>
            </div>
        </div>
        <?php } ?>

        <div id="container">
            <h1>New Account Form</h1>

            <div id="body">
                <?php echo form_open(); ?>
                <fieldset id="save_form">
                    <div>
                        <label for="username">
                            <span>Username</span>
                            <input type="text" name="username" id="username" 
                                   placeholder="" maxlength="200" required 
                                   value="">
                        </label>
                    </div>
                    <div>
                        <label for="Password">
                            <span>Password</span>
                            <input type="password" name="password" id="password" 
                                   placeholder="" maxlength="200" required 
                                   value="">
                        </label>
                    </div>
                    <div>
                        <label for="name">
                            <span>Name</span>
                            <input type="text" name="name" id="name" 
                                   placeholder="" maxlength="200" required 
                                   value="">
                        </label>
                    </div>
                    <div>
                        <label for="lastname">
                            <span>Last Name</span>
                            <input type="text" name="lastname" id="lastname"  
                                   placeholder="" maxlength="200" required 
                                   value="">
                        </label>
                    </div>
                    <div>
                        <label for="is_admin">
                            <span>Is Admin</span>
                            <input type="checkbox" name="is_admin" id="is_admin">
                        </label>
                    </div>
                    <div>
                        <input type="submit" value="Save" />
                    </div>
                </fieldset>
                <?php echo form_close(); ?>
            </div>
            
            <div id="logout">
                <?php if ($account->is_admin) { ?>
                <?php echo anchor('account/index','Accounts List'); ?>
                <?php } ?>
                <?php echo anchor('welcome/index','Home'); ?>
                <?php echo anchor('welcome/logout','Logout'); ?>
            </div>
            
            <p class="footer">&copy; <?php echo date('Y'); ?> All rights reserved</p>
        </div>
        
        <script>
            $(document).ready(function(){
                APP.init();                
            });
            
            var APP = {
                ////////////////
                // Attributes //
                ////////////////
                
                /////////////
                // Methods //
                /////////////
                
                // Init function, used to inicialize APP object
                init: function() {
                },                
            };
        </script>
    </body>
</html>