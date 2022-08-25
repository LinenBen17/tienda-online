<?php 
  //Activar las sesiones en php
  session_start();
  require 'funciones.php';

  error_reporting(E_ALL);
  ini_set('display_errors', '1');

  if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    require 'vendor/autoload.php';
    $pelicula = new LinenBen17\Pelicula;
    $resultado = $pelicula->mostrarPorId($id);

    if (!$resultado) {
      header("Location:index.php");
      die();
    }

    if (isset($_SESSION['carrito'])) { //Si EL CARRITO EXISTE
      //SI LA PELICULA EXISTE EN EL CARRITO
      if (array_key_exists($id, $_SESSION['carrito'])) {
        actualizarPelicula($id);
      } else{
        // SI LA PELICULA NO EXISTE EN EL CARRITO
        agregarPelicula($resultado, $id);        
      }
    }else{
      // SI EL CARRITO NO EXISTE
      agregarPelicula($resultado, $id);
    }
  }

  require 'vendor/autoload.php';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Kawschool Store</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/estilos.css">
  </head>

  <body>

    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">Kawschool Store</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav pull-right">
            <li>
              <a href="carrito.php" class="btn">CARRITO <span class="badge"><?php print cantidadPeliculas(); ?></span></a>
            </li> 
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container" id="main">
      <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <th>#</th>
            <th>Pelicula</th>
            <th>Foto</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Total</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <?php
              if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {
                $c = 0;
                foreach ($_SESSION['carrito'] as $indice=>$value) {
                  $c++;
                  $total = $value['precio'] * $value['cantidad'];
            ?>
              <tr>
                <form action="actualizar_carrito.php" method="POST">
                  <td><?php echo $c; ?></td>
                  <td><?php echo htmlspecialchars($value['titulo']); ?></td>
                  <td>
                    <?php 
                          $foto = 'upload/' . $value['foto'];
                          if (file_exists($foto)) {
                        ?>
                          <img src="<?php echo $foto; ?>" width="35">
                        <?php 
                          }else{
                        ?>
                            <img src="assets/imagenes/not-found.jpg" alt="" width="35">
                        <?php 
                          }
                      ?>
                  </td>
                  <td><?php echo htmlspecialchars($value['precio']); ?></td>
                  <td>
                    <input type="hidden" name="id" value="<?php echo $value['id'] ?>">
                    <input type="text" name="cantidad" class="form-control u-size-100" value="<?php echo htmlspecialchars($value['cantidad']) ?>">
                  </td>
                  <td>
                    <?php echo htmlspecialchars($total) ?>
                  </td>
                  <td>
                    <button type="submit" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-refresh"></span></button>
                    <a href="eliminar_carrito.php?id=<?php echo $value['id']; ?>" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span></a>
                  </td>
                </form>
              </tr>
            <?php
                }
              }else{
            ?>
              <tr>
                <td colspan="7">NO HAY PRODUCTOS EN EL CARRITO</td>
              </tr>
            <?php
              }
            ?>
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="5" class="text-right"> Total</td>
            <td>Q<?php echo calcularTotal(); ?></td>
            <td></td>
          </tr>
        </tfoot>
      </table>
      <hr>
      <?php
        if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {
      ?>
      <div class="row">
        <div class="pull-left">
          <a href="index.php" class="btn btn-info">Seguir Comprando</a>
        </div>
        <div class="pull-right">
          <a href="finalizar.php" class="btn btn-success">Finalizar compra</a>
        </div>
      </div>
      <?php
        }
      ?>
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

  </body>
</html>
