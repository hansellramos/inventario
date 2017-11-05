<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Modificar Inventario de Producto <?php echo $product->name ?></title>
        <link href="<?php echo base_url(); ?>public/css/styles.css" rel="stylesheet" />
        <?php if($this->session->flashdata('redirect')) { ?>
        <meta http-equiv="refresh" content="<?php echo $redirect_time; ?>; url=<?php echo site_url("product/inventory/{$product->id}") ?>" />
        <style>
            #container {
                display: none;
            }
        </style>
        <?php } ?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    </head>
    <body>
        
        <?php if($this->session->flashdata('message')) { ?>
        <div id="flash-message">
            <div id="body">
                <p class="success-message"><?php echo $this->session->flashdata('message'); ?></p>
                <?php if($this->session->flashdata('redirect')) { ?>
                <p>Redirecting, click <?php echo anchor("product/inventory/{$product->id}",'here') ?> to go now</p> 
                <?php } ?>
            </div>
        </div>
        <?php } ?>
        
        <div id="container">
            <h1>Modificar Inventario de Producto <?php echo $product->name ?></h1>
            <div id="body">
                
                <div class="product_current_quantity">
                    <h2 style="display: none;">Cantidad Actual: <?php echo $product->current_quantity ?> Unidades</h2>
                    <?php echo form_open('',['onsubmit'=>'return APP.validate();']); ?>
                    <div>
                        <div>
                            <input type="number" min="0" name="movement" 
                                   id="movement" value="<?php echo $default_inventory_movement; ?>">
                        </div>
                        <div>
                            <span>Este movimiento se guardará como: <?php echo "{$account->name} {$account->lastname}" ?></span>
                        </div>
                        <div>
                            <input type="hidden" id="entry_type" name="entry_type" value="out">
                            <button type="submit" disabled="disabled" onclick="$('#entry_type').val('in');">Entrada</button>
                            <button type="submit" onclick="$('#entry_type').val('out');">Salida</button>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
                
                <br />
                <?php echo anchor('welcome/index','Home'); ?>
                <?php echo anchor('product/index','Lista de Productos',['class'=>'']); ?>
            </div>

            <div id="logout">
                <?php echo anchor('welcome/logout','Logout'); ?>
            </div>
            
            <p class="footer">&copy; <?php echo date('Y'); ?> All rights reserved</p>
        </div>
        <script>
            $(document).ready(function(){
                APP.init();                
            });
            
            var APP = {
                init: function() {},
                validate: function() {
                    if ($("#movement").val() === "0"){
                        alert("La entrada o salida del producto debe ser diferente de cero (0).");
                        return false;
                    }
                    return true;
                }
            };
        </script>
    </body>
</html>