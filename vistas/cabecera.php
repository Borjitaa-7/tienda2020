<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Floristeria</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
        <link rel='icon' href='/iaw/tienda2020/imagenes/favicon.png' type='image/x-icon' sizes="16x16" />
    </head>
    <style type="text/css">
    
    @import url('https://fonts.googleapis.com/css?family=Numans');
    html,body{
        font-family: 'Numans', sans-serif;
        font-size: 13px;
        }
            .wrapper{
                width: 650px;
                margin: 0 auto;
            }
            .page-header h2{
                margin-top: -8px;
            }
            table tr td:last-child a{
                margin-right: 15px;
            }
            li {
                padding: 10px 0 0 6px;
            }
            table {
                background-color: rgba(255,255,255,0.5);  
            }
            table.carrito {
                background-color: rgba(255,255,255,0.5);  
                margin-left: 15%;
                margin-top: 5%;   
                border : solid 11px
            }

            th{
                padding: 20px;
            }
           
            tbody.cesta {
                background: grey;
                text-align: center;
                border: 20px;
                
            }
            .table-bordered {
                background: white;
            }

            .mimenu{
                margin-top: 4%;
                margin-left: 35%;
            }
    </style>

    <script type="text/javascript">
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
    </head>

<?php require_once "navbar.php"; ?>