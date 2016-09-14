DROP DATABASE autobuses;

CREATE DATABASE autobuses;

USE autobuses;

CREATE TABLE Usuario(
  id int not null auto_increment primary key,
  nombre varchar(100),
  aPaterno varchar(100),
  aMaterno varchar(100),
  user varchar(50),
  password varchar(50),
  fechaAlta timestamp
);

CREATE TABLE Autobus(
  id int not null auto_increment primary key,
  propietario int not null,
  nombre varchar(100),
  lugares int,
  fechaRegistro timestamp,
  horariosServicio varchar(100),
  FOREIGN KEY(propietario) REFERENCES Usuario(id)
);

CREATE TABLE Interaccion(
  id int not null auto_increment primary key,
  userEmisor int not null,
  userReceptor int not null,
  autobus int not null,
  estado varchar(200) not null DEFAULT "Pendiente",
  tipo varchar(100),
  fechaCreacion timestamp,
  fechaActualizacion timestamp
);

INSERT INTO Usuario VALUES (null,'Saúl','Gómez','Navarrete','minsau','esasistemas',now());
INSERT INTO Usuario VALUES (null,'Efren','Cruz','Cruz','joker','esasistemas',now());
INSERT INTO Usuario VALUES (null,'Marco','Morales','Lopez','markus','esasistemas',now());

INSERT INTO Autobus VALUES (null,1,'El rayo veloz',45,now(),'5am - 10pm');
INSERT INTO Autobus VALUES (null,2,'El rayo amarillo',45,now(),'5am - 10pm');
INSERT INTO Autobus VALUES (null,1,'koyomi',45,now(),'5am - 10pm');
INSERT INTO Autobus VALUES (null,2,'Senjoughara',45,now(),'5am - 10pm');

INSERT INTO Interaccion (id,userEmisor,userReceptor,autobus,tipo,fechaCreacion,fechaActualizacion) VALUES (null,1,2,1,"Solicitud",now(),now());
INSERT INTO Interaccion (id,userEmisor,userReceptor,autobus,tipo,fechaCreacion,fechaActualizacion) VALUES (null,1,2,3,"Solicitud",now(),now());
INSERT INTO Interaccion (id,userEmisor,userReceptor,autobus,tipo,fechaCreacion,fechaActualizacion) VALUES (null,1,3,1,"Solicitud",now(),now());

INSERT INTO Interaccion (id,userEmisor,userReceptor,autobus,tipo,fechaCreacion,fechaActualizacion) VALUES (null,2,1,1,"Solicitud",now(),now());
INSERT INTO Interaccion (id,userEmisor,userReceptor,autobus,tipo,fechaCreacion,fechaActualizacion) VALUES (null,2,1,3,"Solicitud",now(),now());
INSERT INTO Interaccion (id,userEmisor,userReceptor,autobus,tipo,fechaCreacion,fechaActualizacion) VALUES (null,3,1,1,"Solicitud",now(),now());
