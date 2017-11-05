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
        <script src="//cdn.rawgit.com/ashl1/datatables-rowsgroup/v1.0.0/dataTables.rowsGroup.js"></script>
    </script>
    </head>
    <body>
        
        <div id="container">
            <h1>Lista de Productos</h1>

            <div id="body"> 
                <div class="search-container">                    
                    <label>
                        <span>Fecha de Reporte: </span>
                        <input type="date" id="search-week" class="search">                    
                    </label>
                </div>
                <table id="table" class="stripe">
                    <thead></thead>
                    <tbody></tbody>
                    <tfoot>
                    </tfoot>
                </table>
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
                Date.prototype.getWeek = function() {
                    var onejan = new Date(this.getFullYear(),0,1);
                    var millisecsInDay = 86400000;
                    return Math.ceil((((this - onejan) /millisecsInDay) + onejan.getDay()+1)/7);
                };
                APP.init();                
            });
            
            var APP = {
                ////////////////
                // Attributes //
                ////////////////
                
                records : [],
                filteredProducts: [],
                table: {},
                
                /////////////
                // Methods //
                /////////////
                
                // Init function, used to inicialize APP object
                init: function() {
                    $.fn.dataTable.ext.search.push(
                        function( settings, data, dataIndex ) {
                            var search_week = $("#search-week").val();
                            if (search_week) {
                                var date_array = search_week.split('-');
                                var date = new Date(date_array[0],date_array[1]-1,date_array[2]);
                                var date_year_week = (date.getYear()+1900)+"-"+date.getWeek();
                                return data[1] == date_year_week;
                            } else {
                                return false;
                            }
                        }
                    );
                    // Init sites list from data
                    APP.records = JSON.parse('<?php echo str_replace("'","\'",json_encode($records)); ?>');
                    APP.initDataTable();
                    $(".search").change(function(){APP.table.draw();}).keyup(function(){APP.table.draw();});
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
                    APP.table = $('#table').DataTable({ 
                        scrollX: true,
                        order: [[ 1, 'desc' ]],
                        dom: 'Bfrtip',
                        buttons: [
                            {
                                extend:'copy',
                                exportOptions: {
                                    columns: [ 0, 2, 3, 4, 5, 6, 7, 8, 9]
                                }
                            }, 
                            {
                                extend:'csv',
                                exportOptions: {
                                    columns: [ 0, 2, 3, 4, 5, 6, 7, 8, 9]
                                }
                            }, 
                            {
                                extend:'excel',
                                exportOptions: {
                                    columns: [ 0, 2, 3, 4, 5, 6, 7, 8, 9]
                                }
                            }, 
                            {
                                extend:'pdf',
                                exportOptions: {
                                    columns: [ 0, 2, 3, 4, 5, 6, 7, 8, 9]
                                }
                            }, 
                            {
                                extend:'print',
                                exportOptions: {
                                    columns: [ 0, 2, 3, 4, 5, 6, 7, 8, 9]
                                }
                            }
                        ],
                        drawCallback: function ( settings ) {
                            var api = this.api();
                            var rows = api.rows( {page:'current'} ).nodes();
                            var last=null;

                            api.column(0, {page:'current'} ).data().each( function ( group, i ) {
                                if ( last !== group ) {
                                    $(rows).eq( i ).before(
                                        '<tr class="group table_section_title"><td colspan="10">'+group+'</td></tr>'
                                    );

                                    last = group;
                                }
                            } );
                        },
                        data: APP.records,
                        rowsGroup: [0],
                        columns: [
                            { title: "Tipo", data: 'product_type', name: 'product_type' },
                            { title: "year week", data:'year_week', visible: false },
                            { title: "Consumos", data:'name' },
                            { title: "D", data:'day_0' },
                            { title: "L", data:'day_1' },
                            { title: "M", data:'day_2' },
                            { title: "X", data:'day_3' },
                            { title: "J", data:'day_4' },
                            { title: "V", data:'day_5' },
                            { title: "S", data:'day_6' },
                        ],
                        columnDefs: [
                            { className: "vertical-text border-top", "targets": [ 0 ] },
                            { width: "40px", "targets": [ 0 ] }
                        ],
                        pageLength: 100,
                        order: [[ 0, "desc" ],[1, 'desc']],
                        ordering: false,
                        "language": {
                            "emptyTable": "Seleccione una fecha"
                        }
                    });
                }
            };
        </script>
    </body>
</html>