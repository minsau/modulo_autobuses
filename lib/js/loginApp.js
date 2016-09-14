'use strict'

var angular_model = angular.module('loginApp', [ ]);

angular_model.controller('loginController',function($scope,$http){
	$scope.mensajes = "";
	$scope.login = "";
	$scope.loguear = function(){
		var user = $scope.usuario.user;
		var pass = $scope.usuario.pass;
			$scope.mensajes = "";
			console.log(user + " " +pass);
			$http.post('autobuses.php',{op:2,user: user,clave:pass}).success(function(res){
				$scope.login = res;
				console.log(res);
				if($scope.login.hecho == 1){
					window.location.href = 'index.php'
				}

			});
		}
});
