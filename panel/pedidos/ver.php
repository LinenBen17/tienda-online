<?php 
  error_reporting(E_ALL);
  ini_set('display_errors', '1');

  session_start();

  if (!isset($_SESSION['usuario_info']) OR empty($_SESSION['usuario_info'])) {
    header("Location: ../index.php");
    die();
  }
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
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/estilos.css">
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
          <a class="navbar-brand" href="../dashboard.php">Kawschool Store</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav pull-right">
            <li class="active">
              <a href="index.php" class="btn">Pedidos</a>
            </li> 
            <li>
              <a href="../peliculas/index.php" class="btn">Peliculas</a>
            </li> 
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo htmlspecialchars($_SESSION['usuario_info']['nombre_usuario']) ?> <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="../cerrar.php">Cerrar Sesion</a></li>
              </ul>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container" id="main">
      <div class="row">
        <div class="col-md-12">
          <fieldset>
            <?php
              require '../../vendor/autoload.php';
              $id = $_GET['id'];
              $pedido = new LinenBen17\Pedido;

              $info_pedido = $pedido->mostrarPorId($id);
              $info_detalle_pedido = $pedido->mostrarDetallePorIdPedido($id);
            ?>
            <legend>Información de la compra</legend>
            <div class="form-group">
              <label>Nombre</label>
              <input type="text" class="form-control" value="<?php echo htmlspecialchars($info_pedido['nombre']); ?>" readonly>
            </div>
            <div class="form-group">
              <label>Apellidos</label>
              <input type="text" class="form-control" value="<?php echo htmlspecialchars($info_pedido['apellidos']); ?>" readonly>
            </div>
            <div class="form-group">
              <label>Email</label>
              <input type="text" class="form-control" value="<?php echo htmlspecialchars($info_pedido['email']); ?>" readonly>
            </div>
            <div class="form-group">
              <label>Fecha</label>
              <input type="text" class="form-control" value="<?php echo htmlspecialchars($info_pedido['fecha']); ?>" readonly>
            </div>
            <hr>
              Productos Comprados
            <hr>
            <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Titulo</th>
                    <th>Foto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $cantidad = count($info_detalle_pedido);

                    if ($cantidad>0) {
                      $c=0;
                      for ($i = 0; $i < $cantidad; $i++) {
                        $c++;
                        $item = $info_detalle_pedido[$i];
                        $total = $item['precio'] * $item['cantidad'];
                  ?>
                  <tr>
                    <td><?php echo $c; ?></td>
                    <td><?php echo htmlspecialchars($item['titulo']); ?></td>
                    <td class="text-center">
                      <?php 
                        $foto = '../../upload/' . $item['foto'];
                        if (file_exists($foto)) {
                      ?>
                        <img src="<?php echo $foto; ?>" alt="" width="35">
                      <?php 
                        }else{
                      ?>
                          SIN FOTO
                      <?php 
                        }
                      ?>
                    </td>
                    <td>Q<?php echo htmlspecialchars($item['precio']); ?></td>
                    <td><?php echo htmlspecialchars($item['cantidad']); ?></td>
                    <td>Q<?php echo htmlspecialchars($total);?></td>
                  </tr>

                  <?php
                      }
                    }else{
                  ?>
                  <tr>
                    <td colspan="6">NO HAY REGISTROS</td>
                  </tr>
                  <?php
                    }
                  ?>
                </tbody>
              </table>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Total Compra</label>
                  <input type="text" class="form-control" value="<?php echo htmlspecialchars($info_pedido['total']); ?>" readonly>
                </div>
              </div>
          </fieldset>
          <div class="pull-left">
            <a href="index.php" class="btn btn-default hidden-print">Regresar</a>
          </div>
          <div class="pull-right">
            <a href="javascript:;" id="btnImprimir" class="btn btn-danger hidden-print">Imprimir</a>
          </div>
        </div>
      </div>
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="../../assets/js/jquery.min.js"></script>
    <script src="../../assets/js/bootstrap.min.js"></script>
    <script>
      $('#btnImprimir').on('click', function(){
        window.print();
        return false;
      })
    </script>
  </body>
</html>
