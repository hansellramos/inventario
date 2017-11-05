<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php if($this->session->flashdata('redirect')) { ?>
        <meta http-equiv="refresh" content="<?php echo $redirect_time; ?>; url=<?php echo site_url('product/index') ?>" />
        <style>
            #container {
                display: none;
            }
        </style>
        <?php } ?>
        <title>Product Form</title>

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
                <p>Redirecting, click <?php echo anchor('product/index','here') ?> to go now</p> 
                <?php } ?>
            </div>
        </div>
        <?php } ?>

        <div id="container">
            <h1>Product Form</h1>

            <div id="body">
                <?php echo form_open('', ['onsubmit'=> 'return APP.validate()']); ?>
                <fieldset id="save_form">
                    <div>
                        <label for="name">
                            <span>Name</span>
                            <input type="text" name="name" id="name" 
                                   placeholder="" maxlength="200" required 
                                   value="<?php echo isset($product) ? $product->name : ''; ?>">
                        </label>
                    </div>
                    
                    <div>
                        <label for="product_type">
                            <span>Tipo</span>
                            <select class="product_types" name="product_type" id="product_type" required></select>                            
                        </label>
                    </div> 
                    
                    <div>
                        <label for="current_quantity">
                            <span>Current Quantity</span>
                            <?php if(isset($product)){ ?>
                            <span class="value"><?php echo $product->current_quantity ?></span>
                            <?php } else { ?>
                            <input type="number" name="current_quantity" id="current_quantity" 
                                   placeholder="" min="0" required 
                                   value="0">
                            <?php } ?>
                        </label>
                    </div>  
                    
                    <input type="submit" value="Save" />
                    
                </fieldset>
                <?php echo form_close(); ?>
            </div>
            
            <div id="logout">
                <?php echo anchor('product/index','Lista de Productos'); ?>
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
                
                product_types : {},
                /////////////
                // Methods //
                /////////////
                
                // Init function, used to inicialize APP object
                init: function() {
                    // Init sites list from data
                    APP.product_types = JSON.parse('<?php echo str_replace("'","\'",json_encode($product_types)); ?>');
                    APP.showProductTypes();
                },
                
                // this function is used to show in sites select if are closests 
                showProductTypes : function() {
                    $('#product_type').html('<option value="-1" label="Seleccione...">Seleccione...</option>');
                    for(product_type of APP.product_types) {
                        $('#product_type').append('<option value="'+product_type.id+
                                        '" label="'+product_type.name+'">'+product_type.name+'</option>');
                    }
                    <?php if(isset($product)){ ?>
                    $("#product_type").val('<?php echo $product->product_type; ?>');
                    <?php } ?>
                },
                        
                validate: function() {
                    if ($("#product_type").val() === "-1"){
                        alert("Seleccione el tipo de producto");
                        return false;
                    }
                    return true;
                }
            };
        </script>
    </body>
</html>