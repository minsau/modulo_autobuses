<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <link rel="stylesheet" href="lib/css/estilo.css" />
      <link rel="stylesheet" href="lib/css/bootstrap.css"/>
      <link rel="stylesheet" href="lib/css/fontello.css" />
      
      
      <title>Constituyente CDMX</title>

      
  </head>
  <body>
        <div class="menu_administrador  col-lg-12 col-md-2 col-sm-2 col-xs-12">
          <h1 class="text-center">index principal</h1>
          <div class="ul">
              <li><a href="#" id="botonInicio" name="botonInicio"> <span class="icon-home"></span>Boton que llama mi modulo</a></li>
          </div>
        </div>
    
       <div class="noticias_constituyente col-lg-12 col-md-8 col-sm-8 col-xs-12" id="muro" >
      
       </div>
     

      
     
     
     
    
     

     
      <script src="lib/js/jquery.js"></script>
      <script src="lib/js/bootstrap.min.js"></script>      
      <script type="text/javascript" src="lib/js/angular.js"></script>
      <script type="text/javascript" src="lib/js/app.js"></script>
             <script type="text/javascript">
              $(document).ready(function() {
                  $("#botonInicio").click(function () { 
                      $("#muro").load( "admin/adminUsuarios/", function() { });
                  });
              });
      </script>    
  </body>
</html>