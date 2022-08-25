<?php 
  error_reporting(E_ALL);
  ini_set('display_errors', '1');

  session_start();

  if (!isset($_SESSION['usuario_info']) OR empty($_SESSION['usuario_info'])) {
    header("Location: ../index.php");
    die();
  }

  require '../../vendor/autoload.php';
  if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    $pelicula = new LinenBen17\Pelicula;
    $resultado = $pelicula->mostrarPorId($id);

    if (!$resultado) {
      header('Location: index.php');
    die();  
    }
  }else{
    header('Location: index.php');
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
            <li>
              <a href="../pedidos/index.php" class="btn">Pedidos</a>
            </li>
            <li class="active">
              <a href="index.php" class="btn">Peliculas</a>
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
              <legend>Datos de la Pelicula</legend>
              <form method="POST" action="../acciones.php" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $resultado['id'] ?>">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Titulo</label>
                      <input type="text" value="<?php echo htmlspecialchars($resultado['titulo']); ?>" class="form-control" name="titulo" required>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Descripción</label>
                      <textarea class="form-control" name="descripcion" cols="3" required><?php echo htmlspecialchars($resultado['descripcion']); ?></textarea>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Categorías</label>
                      <select class="form-control" name="categoria_id" required>
                        <option value="">--SELECCIONE--</option>
                        <?php
                          require '../../vendor/autoload.php';

                          $categoria = new LinenBen17\Categorias;
                          $info_categoria = $categoria->mostrar();
                          $cantidad = count($info_categoria);

                          for ($i = 0; $i < $cantidad; $i++) {
                            $item = $info_categoria[$i];
                        ?>
                          <option value="<?php echo $item['id']; ?>" <?php echo $resultado['categoria_id'] == $item['id'] ? 'selected' : '' ?>><?php echo $item['nombre']; ?></option>
                        <?php
                          }
                        ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Foto</label>
                      <input type="file" class="form-control" name="foto">
                      <input type="hidden" name="foto_temp" value="<?php echo htmlspecialchars($resultado['foto']); ?>">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Precio</label>
                      <input type="text" value="<?php echo htmlspecialchars($resultado['precio']); ?>" class="form-control" name="precio" placeholder="0.00" required>
                    </div>
                  </div>
                </div>
                <input type="submit" name="accion" class="btn btn-primary" value="Actualizar">
                <a href="index.php" class="btn btn-default">Cancelar</a>
              </form>
            </fieldset>
          </div>
        </div>  

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="../../assets/js/jquery.min.js"></script>
    <script src="../../assets/js/bootstrap.min.js"></script>

  </body>
</html>
