<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Lista de Productos</title>

        <link href="<?php echo base_url(); ?>public/css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.qrcode/1.0/jquery.qrcode.min.js"></script>
        <link href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css" rel="stylesheet" />
        <script src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js"></script>
        <script src="//cdn.datatables.net/buttons/1.4.2/js/buttons.flash.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
        <script src="//cdn.datatables.net/buttons/1.4.2/js/buttons.html5.min.js"></script>
        <script src="//cdn.datatables.net/buttons/1.4.2/js/buttons.print.min.js"></script>
    </script>
    </head>
    <body>
        
        <div id="container">
            <h1>Lista de Productos</h1>

            <div id="body"> 
                <table id="table" class="stripe">
                    <thead></thead>
                    <tbody></tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td><input type="text" class="search" id="search-name" placeholder="Buscar Por Nombre"></td>
                            <td><input type="text" class="search" id="search-product-type" placeholder="Buscar Por Tipo"></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div id="qr" style="display: none;">
                <div class="header">
                    <span class="title"></span>
                    <span class="close" onclick="$('#qr').hide();">x</span>
                </div>
                <div id="code"></div>
                <div class="footer">                    
                    <span class="link"><a href="#"></a></span>
                </div>
            </div>
            
            <div id="logout">
                <?php if($account->is_admin){ ?>
                <?php echo anchor('product/add','Create Product'); ?>
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
                
                products : [],
                filteredProducts: [],
                table: {},
                
                /////////////
                // Methods //
                /////////////
                
                // Init function, used to inicialize APP object
                init: function() {
                    $(window).keyup(function(event){ 
                        if(event.originalEvent.keyCode === 27){
                            $("#qr").hide();
                        }                                
                    });
                    $.fn.dataTable.ext.search.push(
                        function( settings, data, dataIndex ) {
                            var valid = false, filtered = false;
                            var search_name = $("#search-name").val();
                            var search_product_type = $("#search-product-type").val();
                            
                            // very very very hard filter
                            if(search_name.length > 0 
                                    || search_product_type.length > 0
                                ) {
                                filtered = true;
                                if (search_name.length > 0) 
                                    if(data[0].toLowerCase().indexOf(search_name.toLowerCase()) >= 0) { valid = true; } else {return false; }
                                if (search_product_type.length > 0)
                                    if(data[1].toLowerCase().indexOf(search_product_type.toLowerCase()) >= 0) { valid = true; } else {return false; }
                            }                          
                            
                            return !filtered || valid;
                        }
                    );
                    // Init sites list from data
                    APP.products = JSON.parse('<?php echo str_replace("'","\'",json_encode($products)); ?>');
                    APP.initDataTable();
                    $(".search").change(function(){APP.table.draw();}).keyup(function(){APP.table.draw();});
                },
                mapProducts: function() {
                    APP.filteredProducts = [];
                    for (product of APP.products) {
                        APP.filteredProducts.push([
                            product.id,
                            product.name,
                            product.type,
                            product.current_quantity,
                        ]);
                    }
                },  
                showQR: function(id, name) {
                    $('#qr #code').html('');
                    $("#qr .title").html(name);
                    var url = "<?php echo site_url(['product','inventory']); ?>/"+id;
                    $("#qr .link a").html(url);
                    $("#qr .link a").attr('href',url);
                    $('#qr #code').qrcode(url);
                    $("#qr").show();
                },
                // 
                initDataTable : function () {
                    APP.mapProducts();
                    APP.table = $('#table').DataTable({ 
                        scrollX: true,
                        order: [[ 1, 'desc' ]],
                        dom: 'Bfrtip',
                        buttons: [
                            'copy', 'csv', 'excel', 'pdf', 'print'
                        ],
                        data: APP.filteredProducts,
                        columns: [
                            { title: "", 
                                render: function(data, type, row){
                                    return '<button type="button" onclick="APP.showQR('+data+',\''+row[1]+'\')">QR</button>'+
                                           '<button type="button" onclick="APP.edit('+data+')">Modificar</button>'+
                                           '<button type="button" onclick="APP.inventory('+data+')">Inventario</button>'
                                    ;
                                }
                            },
                            { title: "Producto" },
                            { title: "Tipo" },
                            { title: "Cantidad Actual", visible: false },
                        ],
                        columnDefs: [
                            { "width": "250px", "targets": [0] },
                            { "width": "120px", "targets": [1,2,3] }
                        ],
                        pagingType: "full_numbers"
                    });
                },
                edit: function(id) {
                    window.location = '<?php echo site_url(['product','edit']) ?>/'+id;
                },
                inventory: function(id) {
                    window.location = '<?php echo site_url(['product','inventory']) ?>/'+id;
                }
            };
        </script>
    </body>
</html>