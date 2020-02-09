<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/iaw/tienda2020/dirs.php";
require_once CONTROLLER_PATH . "ControladorCarrito.php";
require_once CONTROLLER_PATH . "ControladorImagen.php";
require_once VIEW_PATH . "cabecera.php";

error_reporting(E_ALL & ~(E_STRICT|E_NOTICE));
session_start();

// //Avance numero 1 => Acabo de comprender como se instancia un metodo del controlador en este caso index 8(^.^)8
// $sesion = $_SESSION['id'];
// $cc = ControladorCarrito::getControlador();
// $estado = $cc->index();

// echo $estado;



//Para borrar el carrito solo tenemos que pasarle un GET con /localhost/loquesea.php?borrar=loquesea; 
if(isset($_GET["borrar"])){
    $borrar = $_GET["borrar"];
}

if($borrar){
    $cc = ControladorCarrito::getControlador();
    $borrar= $cc->delete_all(); 
}

//Para añadir cosas al carrito solo tenemos que pasarle un GET con /localhost/loquesea.php?id=numero; 
if(isset($_GET["id"])){

    $id = decode($_GET["id"]);

    $ca = ControladorArticulo::getControlador(); //Comprobamos si existe el ID pasado
    $articulo = $ca->buscarArticuloid($id);
        
    if($articulo){              //si todo va bien nos añadirá el producto
        $cc = ControladorCarrito::getControlador();
        $estado = $cc->add($id); 
    }else{                              //Si pasamos un ID que no existe nos alertará
        alerta("El id no existe");
    }
}
if (isset($_SESSION['cesta'])){

?>
<table class='carrito'>
<h1 align="center">Cesta de nuestra tienda</h1>
<thead class='cestilla'>
    <th>Nombre</th>
    <th>ID</th>
    <th>TIPO</th>
    <th>PRECIO</th>
    <th>DESCUENTO</th>
    <th>UNIDADES</th>
    <th>IMAGEN</th>
</thead>
<tbody class='cesta'>
<?php
foreach($_SESSION['cesta'] as $indice => $elemento){
    $articulo = $elemento['articulo'];
    ?> 
    <tr>
    <td> <? echo $articulo->getnombre(); ?></td>
    <td> <? echo $elemento['id_producto'] ;?></td>
    <td> <? echo $articulo->getTipo() ;?></td>
    <td> <? echo $elemento['precio'] ;?></td>
    <td> <? echo $elemento['descuento'] ;?></td>
    <td> <? echo $elemento['cantidad'] ;?></td>
    <td> <img src='<?php echo "/iaw/tienda2020/imagenes/" . $articulo->getimagen() ?>' class='rounded' class='img-thumbnail' width='70'></td>
    </tr>
<? 
}
?>
</tbody>
</table>
                    <div>
                        <input type="hidden" name="id" value="<?php echo trim($id); ?>"/>
                        <p>Seguir comprando</p><br>
                        <p>
                        <a href='/iaw/tienda2020/vistas/carrito_prueba.php?borrar=1' class="btn btn-danger"> <span class="glyphicon glyphicon-trash"></span>  Vaciar carrito</a></button>
                            <a href='catalogo_articulos.php' class="btn btn-primary"><span class="glyphicon glyphicon-chevron-left"></span></span> Volver</a></li>
                        </p>
                    </div>




<?php

}else{
    echo "<p class='lead'><em>No se ha comprado nada.</em></p>";
}

// var_dump($estado) ."</br>";

// var_dump($_SESSION['cesta']);


// unset($_SESSION['cesta']);

// //Avance numero 2 => Acabo de comprender como se instancia un metodo del controlador (Que a su vez este llama a un objeto por su ID ) y ademas se recuperan todos los campos
//del obejeto 8(^.^)8
// $producto_id = 11;
// $id = $producto_id; 
// $ca = ControladorArticulo::getControlador();
// $articulo = $ca->buscarArticuloid($id);

// echo "Nombre : ".$articulo->getnombre() . "<br>";
// echo  "Precio : ". $articulo->getPrecio() ."<br>";
// echo  "Unidades : ". $articulo->getUnidades()."<br>";




// //Avance numero 3 => Acabo de comprender como se hace una consulta a la bbdd usando las instancias
// del controlador de BD y meto todos los campos en un array

//El array lo recorro como un foreach como el objeto ARTICULO y recupero los campos que me den la gana.

// $bd = ControladorBD::getControlador();
// $bd->abrirBD();
// $consulta = "SELECT * FROM articulos ";
// $filas = $bd->consultarBD($consulta);
// $res = $bd->consultarBD($consulta);
// $filas=$res->fetchAll(PDO::FETCH_OBJ);
// if (count($filas) > 0) {
//     foreach ($filas as $a) {
//         $articulo = new Articulo($a->id, $a->nombre, $a->tipo, $a->distribuidor, $a->precio, $a->descuento, $a->unidades, $a->imagen);
//         $lista[] = $articulo;
//     }

// }

// $bd->cerrarBD();

// var_dump($lista);
//  echo "NUMERO DE FILAS =>" .count($lista)."<br>";
//  var_export($lista);

//  echo $lista[0]['id'] ;
// //  echo $id;
// foreach ($lista as $articulo )
// {
    
//     if($articulo->getid()=="11"){
//         $n["articulo"] = array('nombre'=>$articulo->getnombre(),'id'=>$articulo->getid(),'stock'=>$articulo->getUnidades());
//         $n["unidades"] = 99;
//     }
    
// }

// echo   $n["unidades"] - $n["articulo"]['stock'];

// echo "<br>";

// var_dump($n);
            
     
                
    // echo "Numero de Alumnos: " .$nAlumnos . "<br>";
    // echo "Nota media: " . round(($notaTotal/$nAlumnos),2) . "<br>";

    
    

?>