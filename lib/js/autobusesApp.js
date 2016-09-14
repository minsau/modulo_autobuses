'use strict'
  var idP = 0;
var angular_module = angular.module('autobusesApp',[]);
angular_module.controller('autobusesController',function($scope,$http){
  $scope.datosSesion = {};
  $scope.cambio = "";
  $scope.busqueda = "";
  $scope.busSelected = "";
  $scope.camion ={};
  $http.post('autobuses.php',{op: 1}).success(function(data){
    $scope.datosSesion = data;
    idP = $scope.datosSesion.id;
    //console.log(data);
    if($scope.datosSesion.hecho == -1){
      alert($scope.datosSesion.mensaje);
      window.location.href = 'login.php';
    }else{
      $http.post('autobuses.php',{op: 8, id: $scope.datosSesion.id}).success(function(data){
        console.log("Entro id = " + idP);
        $scope.solicitudes = data;
        console.log(data);
      });

      $http.post('autobuses.php',{op: 13, id: $scope.datosSesion.id}).success(function(data){
        console.log("Entro id = " + idP);
        $scope.invitaciones = data;
        console.log(data);
      });
    }
  });

  $scope.agregarCamion = function(id){
    //console.log(id);
    //console.log($scope.camion.nombre);
    //console.log($scope.camion.lugares);
    //console.log($scope.camion.horario);

    $http.post('autobuses.php',{op:0, propietario: id, nombre: $scope.camion.nombre, lugares:$scope.camion.lugares, horario: $scope.camion.horario}).success(function(res){
      $scope.resultado = res;
      console.log(res);
    });
  }

  $scope.cambiarEstado = function(idInter,nuevoEstado){
    console.log(idInter+" "+nuevoEstado);
    $http.post('autobuses.php',{op: 10, id: idInter,estado:nuevoEstado}).success(function(data){
      //console.log("Entro id = " + idP);
      $scope.cambio = data;
      console.log(data);
    });
  }

  $scope.aprobarSolicitudes = function(id){
    $http.post('autobuses.php',{op: 9, id: idP}).success(function(data){
      //console.log("Entro id = " + idP);
      $scope.solicitudesDatos = data;
      console.log(data);
    });
  }

  $scope.aprobarInvitaciones = function(id){
    $http.post('autobuses.php',{op: 12, id: idP}).success(function(data){
      //console.log("Entro id = " + idP);
      $scope.invitacionesDatos = data;
      console.log(data);
    });
  }

  $scope.cerrarSesion = function(){
    $http.post('autobuses.php',{op: 4}).success(function(data){
      $scope.destruir = data;
      alert($scope.destruir.mensaje);
      window.location.href = 'login.php';
    });
  }

  $scope.autobuses = function(idUsuario){
    $http.post('autobuses.php',{op: 3,id:idUsuario}).success(function(datos){
      $scope.buses = datos;
      $scope.buses.user = idUsuario;
      console.log(datos);
      $("#autobuses").show();
    });
  }

  $scope.buscar = function(){
    $http.post('autobuses.php',{op: 11,search:$scope.busqueda}).success(function(datos){
      $scope.personasBusqueda = datos;
      console.log(datos);
    });
  }

  $scope.personas = function(idUsuario){
    $http.post('autobuses.php',{op: 5,id:idUsuario}).success(function(datos){
      $scope.personasData = datos;
      $("#personasDiv").show();
      $("#autobuses").hide();
    });
  }

  $scope.interaccion = function(bus,emisor,receptor,tipo){
    $http.post('autobuses.php',{op: 6,autobus: bus,emiter: emisor, receiver: receptor, type:tipo}).success(function(data){
      $scope.datos = data;
      console.log(data);
      if($scope.datos.hecho == 1){
        $("#mensaje").html(tipo +" enviada");
        $("#mensaje").show();
      }
    });
  }

  $scope.tripulantes = function(bus, idUsuario){
    $http.post('autobuses.php',{op: 7,id:idUsuario,autobus:bus}).success(function(datos){
      $scope.personasBus = datos;
      $("#tripulantesDiv").show();
      //$("#autobuses").hide();
    });
  }

  $scope.selectBus = function(bus){
    $scope.busSelected = bus;
    console.log($scope.busSelected);
  }
});

function ocultar(objeto){
  $(objeto).hide();
}
