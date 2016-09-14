<?php
session_start();
$path = 'lib/';
?>

<!DOCTYPE html>
<html lang="es" ng-app="autobusesApp">
  <head>
    <meta charset="utf-8">
    <title>Mi cuenta</title>
    <link rel="stylesheet" type="text/css" href="<?php echo $path; ?>css/bootstrap.css">
  </head>
  <body ng-controller="autobusesController">

    <div id="agregarCamion" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Agregar camion</h4>
          </div>
          <div class="modal-body">
            <form>
              <div class="form-group">
                <label for="">Nombre: </label>
                <input type="text" ng-model="camion.nombre" value="">
              </div>

              <div class="form-group">
                <label for="">Lugares: </label>
                <input type="number" ng-model="camion.lugares" value="">
              </div>

              <div class="form-group">
                <label for="">Horario: </label>
                <input type="text" ng-model="camion.horario" value="">
              </div>
              <div class="">
                {{resultado.mensaje}}
              </div>
              <input type="button" value="Agregar" ng-click="agregarCamion(datosSesion.id)">
            </form>
          </div>
        </div>

      </div>
    </div>

    <div id="busqueda" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Invitar a bus {{busSelected}}</h4>
          </div>
          <div class="modal-body">
            <input ng-model="busqueda" ng-change="buscar()" placeholder="Buscar usuario" />
            <table class="table">
                <tr ng-repeat="usuario in personasBusqueda">
                    <td>{{ usuario.id }}</td>
                    <td>{{ usuario.nombre+" "+usuario.aPaterno+" "+usuario.aMaterno }}</td>
                    <td><button ng-click="interaccion(busSelected,datosSesion.id,usuario.id,'Invitacion')"> Invitar </button></td>
                </tr>
            </table>
          </div>
        </div>

      </div>
    </div>


    <!-- Modal -->
    <div id="solicitudes" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Aprobar solicitudes</h4>
          </div>
          <div class="modal-body">
            <table class="table">
              <thead>
                <th>#</th>
                <th>Solicitante</th>
                <th>Autobus</th>
                <th></th>
              </thead>
              <tr ng-repeat="person in solicitudesDatos">
                <td>
                  {{person.id}}
                </td>
                <td>{{person.nombre+" "+person.aPaterno+" "+person.aMaterno}}</td>
                <td>{{person.autobus}} </td>
                <td><button type="button" ng-click="cambiarEstado(person.inte,'Aceptado')"class="btn btn-sm btn-default" name="button">Aceptar</button></td>
              </tr>
            </table>
          </div>
          <div class="modal-footer">
            {{cambio.mensaje}}
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>

      </div>
    </div>

    <div id="invitaciones" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Aprobar invitaciones</h4>
          </div>
          <div class="modal-body">
            <table class="table">
              <thead>
                <th>#</th>
                <th>Emisor</th>
                <th>Autobus</th>
                <th></th>
              </thead>
              <tr ng-repeat="person in invitacionesDatos">
                <td>
                  {{person.id}}
                </td>
                <td>{{person.nombre+" "+person.aPaterno+" "+person.aMaterno}}</td>
                <td>{{person.autobus}} </td>
                <td><button type="button" ng-click="cambiarEstado(person.inte,'Aceptado')"class="btn btn-sm btn-default" name="button">Aceptar</button></td>
              </tr>
            </table>
          </div>
          <div class="modal-footer">
            {{cambio.mensaje}}
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>

      </div>
    </div>


    <label for=""><span class="glyphicon glyphicon-user"></span> {{datosSesion.nombre}}</label></br>
    <button class="btn btn-primary btn-sm" ng-click="aprobarSolicitudes(datosSesion.id)" data-toggle="modal" data-target="#solicitudes">Solicitudes <span class="badge">{{solicitudes[0].s}}</span></button>
    <button class="btn btn-primary btn-sm" ng-click="aprobarInvitaciones(datosSesion.id)" data-toggle="modal" data-target="#invitaciones">Invitaciones <span class="badge">{{invitaciones[0].s}}</span></button>
    <button ng-click="autobuses(datosSesion.id)" onclick="ocultar('#personasDiv')"> Mis autobuses </button>
    <button ng-click="personas(datosSesion.id)"> Ver los autobuses de otros</button>
    <button ng-click="cerrarSesion()"><span class="glyphicon glyphicon-off"></span> Cerrar Sesion</button>
    <div class="alert alert-success" id = "mensaje" onclick="ocultar('#mensaje')" style="display:none;">

    </div>
    <div class="row">
      <div class="col-md-4" id="personasDiv" style="display: none;">
        <table class="table table-hover">
          <thead>
            <th>#</th>
            <th>Nombre</th>
            <th> </th>
          </thead>
          <tr ng-repeat="persona in personasData">
            <td>{{persona.id}}</td>
            <td>{{persona.nombre+" "+persona.aPaterno}}</td>
            <td><button type="button" name="button" ng-click="autobuses(persona.id)"><span class="glyphicon glyphicon-plus" style="color: green;"> </span>Ver autobuses</button></td>
          </tr>
        </table>
      </div>

      <div class="col-md-4" id="autobuses" style="display: none;">
        <!--<legend>Autobuses de {{buses.user}}</legend>-->
        <table class="table">
            <thead>
              <th>#</th>
              <th>Nombre</th>
              <th>Capacidad</th>
              <th>  </th>
            </thead>

            <tr ng-repeat="bus in buses">
              <td>{{bus.id}}</td>
              <td>{{bus.nombre}}</td>
              <td>{{bus.lugares}}</td>
              <td ng-if="buses.user != datosSesion.id"> <button ng-click="interaccion(bus.id,datosSesion.id,buses.user,'Solicitud')"> Unirse </button> </td>
              <td ng-if="buses.user == datosSesion.id"> <button ng-click="tripulantes(bus.id,datosSesion.id)"><span class="glyphicon glyphicon-eye-open"> </span> Ver tripulantes </button> </td>
            </tr>
        </table>

        <button data-toggle="modal" data-target="#agregarCamion" ng-if="buses.user == datosSesion.id"> <span class="glyphicon glyphicon-plus" style="color: green;"> </span> Agregar camión</button>
      </div>
      <div id="tripulantesDiv" class="col-md-4" style="display: none;">

        <table class="table">
          <thead>
            <th>#</th>
            <th>Nombre</th>
            <th>Estado</th>

          </thead>
          <tr ng-repeat="p in personasBus" ng-if="p.estado  == 'Aceptado'">
            <td>
              {{p.id}}
            </td>
            <td>{{p.nombre+" "+p.aPaterno+" "+a.Materno}} </td>
            <td>{{p.estado}} </td>
          </tr>
        </table>

        <button type="button" name="button" ng-click="selectBus(personasBus[0].autobus)" data-toggle="modal" data-target="#busqueda"><span class="glyphicon glyphicon-plus" style="color:green;" > </span>Invitar persona</button>
      </div>
    </div>



    <script type="text/javascript" src="<?php echo $path; ?>js/jquery.js"></script>
    <script type="text/javascript" src="<?php echo $path; ?>js/bootstrap.js"></script>
    <script type="text/javascript" src="<?php echo $path; ?>js/angular.js"></script>
    <script type="text/javascript" src="<?php echo $path; ?>js/autobusesApp.js"></script>
  </body>
</html>
