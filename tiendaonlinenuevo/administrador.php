<?php 
    header('Content-Type: text/html; charset=ISO-8859-1');
    include("static/site_config.php"); 
    include ("static/clase_mysql.php");
    
    $miconexion = new clase_mysql;
    $miconexion->conectar($db_name,$db_host, $db_user,$db_password);
?>

<?php
    session_start();
    if (isset($_SESSION['usuario'])){  
?>  

<!DOCTYPE html>
<html lang="es">
  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Line Buy - Registro</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/agency.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
    <script src="js/modernizr.js"></script> <!-- Modernizr -->
    <link rel="stylesheet" type="text/css" href="css/jquery.lightbox.css">


    <link rel="stylesheet" href="css/style.css">
    <script src="js/script.js"></script>
    <link rel="shortcut icon" href="http://www.azulweb.net/wp-content/uploads/2014/02/icono-2.png" />
  </head>

  <body>

       <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top navbar-shrink">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Menu de Navegación</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand page-scroll" href="#page-top"><img style="width: 20%;" src="img/logo.png"></a>
                <!--<a class="navbar-brand page-scroll" href="#page-top" style="margin-left:45%;";>LINE BUY</a> -->
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="hidden">
                        <a href="http://localhost/carritovirtual/">Line Buy</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#">BIENVENIDO: <?php echo $_SESSION['usuario']; ?></a>
                    </li>
                    <li>
                        <a class="page-scroll" href="logout.php">CERRAR SESION</a>
                    </li>                    
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>



        <!-- Services Section -->
    <section id="services">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-4">
                    <h4>Tablas</h4>
                    <h3 class="section-subheading text-muted">Compre nuestros productos en linea...</h3>
                    <?php
                        $miconexion->consulta("show tables");
                        $miconexion->verconsultablas();
                    ?>
                </div>
                <div class="col-md-8" >
                    <h4>Datos de las Tablas</h4><br><br>
                       <aside id="modulos">       
                        <section class="cd-gallery" width="100%">                            
                                <?php
                                    extract($_GET);
                                    if (isset($tabla)) {
                                        echo "<h3 class='section-subheading text-muted'>Tabla: ".$tabla."</h3>";
                                        echo "<form method='post'>";
                                        $miconexion->consulta("select * from ".$tabla);
                                        $miconexion->verconsulta2($tabla);    
                                        //echo "<a href='administrador.php?tabl=$tabla&edi=3'><button type='submit' class='btn btn-xl'>Nuevo</button></a>"; 
                                        echo "<br><button type='submit'  class='btn btn-xl' name='nuevo' value='nuevo'>Nuevos</button><br><br><br>"; 

                                    }
                                  
                                    if (isset($id)) {  
                                        if ($edi==2) {                          
                                            $miconexion->consulta("DELETE FROM ".$tabla." WHERE ".$act."=".$id);
                                            $miconexion->consulta();
                                        }else{
                                            if ($edi==1) { 
                                                if (isset($act)) {
                                                    echo "<form method='post'>";
                                                        $query = "SELECT * FROM ".$tabla." WHERE ".$act."=".$id;
                                                        $result = mysql_query($query) or die("error". mysql_error());
                                                        $a = mysql_num_fields($result);
                                                        while ($row = mysql_fetch_array($result)) {
                                                            for ($i=0; $i < $a ; $i++) { 
                                                                echo "<div class='form-group'>";
                                                                   echo mysql_field_name($result, $i).":<input class='form-control' placeholder='".$row[$i]."' name='".mysql_field_name($result, $i)."' type='text'>";
                                                                   echo "<p class='help-block text-danger'></p>";
                                                                echo "</div>";
                                                                
                                                            }
                                                            echo "<br>";
                                                            $a=0;                             
                                                        }
                                                        echo "<button type='submit' class='btn btn-xl' name='actualizar' value='actualizar'>Actualizar</button>"; 
                                                    echo "</form>";
                                                        if (isset($_REQUEST['actualizar'])) {                                                          
                                                            $ressql=$miconexion->consulta("$sent");
                                                            if ($ressql==NULL) {
                                                                echo "No se guardo";
                                                                //echo "<script>location.href='.php'</script>";
                                                                //header('Location:index.php');
                                                            }else{
                                                                echo"Sus datos se han guardado con exito";
                                                                //echo "<script>location.href='admin.php'</script>";
                                                                    //header('Location:index.php');
                                                            }
                                                        }
                                                    
                                                }
                                            }
                                        }
                                    }else{
                                        if (isset($_REQUEST['nuevo'])) {                                             
                                            echo "<form method='post'>";
                                                switch ($tabla) {
                                                    case 'carrito':
                                                        echo "<script language='javascript'> alert('Se ha registrado con exito)</script>";
                                                        break;
                                                    case 'categoria_estado':
                                                        $query = "SELECT estado FROM ".$tabla;
                                                        break;
                                                    case 'categoria_producto':
                                                        $query = "SELECT categoria FROM ".$tabla;
                                                        break;
                                                    case 'categoria_usuario':
                                                        $query = "SELECT tipo, descripcion FROM ".$tabla;
                                                        break;
                                                    case 'estado':
                                                        $query = "SELECT nombre, descripcion, descuento, id_categoria_estado FROM ".$tabla;
                                                        break;
                                                    case 'producto':
                                                        
                                                            echo "Categoria: ";
                                                            $query = "SELECT * FROM categoria_producto WHERE id_categoria";
                                                            $result = mysql_query($query) or die("error". mysql_error());
                                                            
                                                            echo "<div class='form-group'>";                                                                
                                                                echo "<select class='form-control' name='idcat'>";
                                                                while ($row = mysql_fetch_array($result)) {
                                                                    echo "<h3 class='section-subheading text-muted'> string   ".$row[0]."</h3>";   
                                                                    echo "string  ".$row[0];
                                                                    echo "<option value='".$row[0]."'>".$row[1]."</option>"; 
                                                                }
                                                                echo "</select><br>";
                                                             echo "<p class='help-block text-danger'></p>";
                                                            echo "</div><br>";


                                                            echo "Estado del Producto: ";
                                                            $query = "SELECT * FROM estado WHERE id_estado";
                                                            $result = mysql_query($query) or die("error". mysql_error());
                                                            echo "<div class='form-group'>";
                                                            echo "<select class='form-control' name='idest'>";
                                                                while ($row = mysql_fetch_array($result)) {
                                                                    echo "<option value='".$row[0]."'>".$row[1]."</option>"; 
                                                                }
                                                                echo "</select><br>";
                                                                echo "<p class='help-block text-danger'></p>";
                                                            echo "</div><br>";

                                                            echo "Descrpcion del estado: ";
                                                            $query = "SELECT * FROM categoria_estado WHERE id_categoria_estado";
                                                            $result = mysql_query($query) or die("error". mysql_error());
                                                            echo "<div class='form-group'>";
                                                                echo "<select class='form-control' name='idcatest'>";
                                                                while ($row = mysql_fetch_array($result)) {
                                                                        echo "<option class='form-control' value='".$row[0]."'>".$row[1]."</option>"; 
                                                                }
                                                                echo "</select>";
                                                                echo "<p class='help-block text-danger'></p>";
                                                            echo "</div><br>";

                                                            $query = "SELECT codigo, nombre, nota, valor, estado, cantidad, imagen FROM producto";
                                                            $result = mysql_query($query) or die("error". mysql_error());
                                                            $a = mysql_num_fields($result);
                                                            while ($row = mysql_fetch_array($result)) {
                                                                for ($i=0; $i < $a ; $i++) { 
                                                                    echo "<div class='form-group'>";
                                                                       echo mysql_field_name($result, $i).":<input class='form-control' name='".mysql_field_name($result, $i)."' type='text'>";
                                                                       echo "<p class='help-block text-danger'></p>";
                                                                    echo "</div>";
                                                                    
                                                                }
                                                                echo "<br>";
                                                                $a=0;                             
                                                            }                                                        
                                                        break;
                                                }
                                                if ($tabla== 'categoria_estado' OR $tabla== 'categoria_producto' OR $tabla=='categoria_usuario') {
                                                    $result = mysql_query($query) or die("error". mysql_error());
                                                    $a = mysql_num_fields($result);
                                                    while ($row = mysql_fetch_array($result)) {
                                                        for ($i=0; $i < $a ; $i++) { 
                                                            echo "<div class='form-group'>";
                                                               echo mysql_field_name($result, $i).":<input class='form-control' name='".mysql_field_name($result, $i)."' type='text'>";
                                                               echo "<p class='help-block text-danger'></p>";
                                                            echo "</div>";
                                                            
                                                        }
                                                        echo "<br>";
                                                        $a=0;                             
                                                    }
                                                }
                                               
                                                echo "<button type='submit' class='btn btn-xl' name='guardar' value='guarda'>Guardar</button>"; 
                                            echo "</form>";    
                                                if (isset($_REQUEST['guardar'])) {                                                           
                                                    $ressql=$miconexion->consulta("$sent");
                                                    if ($ressql==NULL) {
                                                        echo "No se guardo";
                                                        //echo "<script>location.href='.php'</script>";
                                                        //header('Location:index.php');
                                                    }else{
                                                        echo"Sus datos se han guardado con exito";
                                                        //echo "<script>location.href='admin.php'</script>";
                                                            //header('Location:index.php');
                                                    }
                                                }
                                        }
                                    }
                                ?>
                           
                            <div class="cd-fail-message">No hay resultados</div>
                        </section> <!-- cd-gallery -->
                    </aside> 
                </div>
            </div>
        </div>
    </section>


    

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <span class="copyright">Copyright &copy; Your Website 2014</span>
                </div>
                <div class="col-md-4">
                    <ul class="list-inline social-buttons">
                        <li><a href="#"><i class="fa fa-twitter"></i></a>
                        </li>
                        <li><a href="#"><i class="fa fa-facebook"></i></a>
                        </li>
                        <li><a href="#"><i class="fa fa-linkedin"></i></a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <ul class="list-inline quicklinks">
                        <li><a href="#">Privacy Policy</a>
                        </li>
                        <li><a href="#">Terms of Use</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>


        <!-- Portfolio Modals -->
    <!-- Use the modals below to showcase details about your portfolio projects! -->


    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
    <script src="js/classie.js"></script>
    <script src="js/cbpAnimatedHeader.js"></script>

    <!-- Contact Form JavaScript -->
    <script src="js/jqBootstrapValidation.js"></script>
    <script src="js/contact_me.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="js/agency.js"></script>

    <script src="js/jquery-2.1.1.js"></script>
    <script src="js/jquery.mixitup.min.js"></script>
    <script src="js/main.js"></script> <!-- Resource jQuery -->
    <script src="js/jquery.lightbox.js"></script>
    <script>
      // Initiate Lightbox
      $(function() {
        $('.gallery a').lightbox(); 
      });
    </script>


    <script language="JavaScript">
        function muestra_oculta(id){
        if (document.getElementById){ //se obtiene el id
        var el = document.getElementById(id); //se define la variable "el" igual a nuestro div
        el.style.display = (el.style.display == 'none') ? 'block' : 'none'; //damos un atributo display:none que oculta el div
        }
        }
        window.onload = function(){/*hace que se cargue la función lo que predetermina que div estará oculto hasta llamar a la función nuevamente*/
        muestra_oculta('contenido_a_mostrar');/* "contenido_a_mostrar" es el nombre que le dimos al DIV */
        }
    </script>


  </body>
</html>
    <?php
      }
        else{
        echo '<script>location.href = "login.php";</script>'; 
      }
    ?>
