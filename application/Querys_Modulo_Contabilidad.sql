--Creación de Base de Datos
CREATE DATABASE modConta
--Creacion de tabla de Opciones,Bitacoras,Acciones,Permisos
BEGIN TRAN 
CREATE TABLE opcionModulo(
	id INT PRIMARY KEY NOT NULL IDENTITY(1,1),
	categoria VARCHAR(50),
	descripcion VARCHAR(250),
	estado VARCHAR(2),
	fechaServ DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE permiso(
	id INT PRIMARY KEY NOT NULL IDENTITY(1,1),
	usuario VARCHAR(50),
	idOpcion INT,
	permiso INT,
	update_by VARCHAR(50),
	fechaCrea DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	fechaUpd DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE bitacora(
	id INT PRIMARY KEY NOT NULL IDENTITY(1,1),
	idAccion INT,
	descripcion NVARCHAR(500),
	usuario NVARCHAR(50),
	dirIp VARCHAR(50),
	nomMaquina VARCHAR(150),
	fechaServ DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP 
);
CREATE TABLE accion(
	id INT PRIMARY KEY,
	accion NVARCHAR(500),
	fechaServ DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP 
);
COMMIT
--Creacion de tablas especificas(Nombres temporales)
BEGIN TRAN 
CREATE TABLE sujetoExcluido(
	id INT PRIMARY KEY NOT NULL IDENTITY(1,1),
	nombre NVARCHAR(500),
	apellido NVARCHAR(500),
	dui NVARCHAR(500),
	nit NVARCHAR(500),
	contacto NVARCHAR(500),
	direccion NVARCHAR(500),
	noCasa NVARCHAR(500),
	aptoLocal NVARCHAR(500),
	colonia NVARCHAR(500),
	correo NVARCHAR(500),
	depto NVARCHAR(500),
	municipio NVARCHAR(500),
	telefono NVARCHAR(500),
	fechaServ DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP 
);
CREATE TABLE factura(
	id INT PRIMARY KEY NOT NULL IDENTITY(1,1),
	idSujeto NVARCHAR(500),
	usuario NVARCHAR(500),
	fecCrea DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	corTemp NVARCHAR(50),
	tipo NVARCHAR(20),
	detalle NVARCHAR(500),
	monto DECIMAL,
	corAsig NVARCHAR(50),
	usuAsig NVARCHAR(500),
	fecAsig DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	estado NVARCHAR(2),
	fechaServ DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP 
);
CREATE TABLE resolucion(
	id INT PRIMARY KEY NOT NULL IDENTITY(1,1),
	fecEmision DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	resolucion NVARCHAR(500),
	corIni NVARCHAR(100),
	corFin NVARCHAR(100),
	usuario NVARCHAR(500),
	corActual NVARCHAR(100),
	estadp DECIMAL,
	fechaServ DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP 
);
COMMIT
SELECT * FROM sujetoExcluido
SELECT * FROM factura
SELECT * FROM resolucion
--
--SELECT * FROM ASEIRTM.dbo.usuarios AS u
--SELECT * FROM ASEIRTM.dbo.accion AS ASEIaccion
--WHERE ASEIaccion.id NOT IN modConta.dbo.accion.id

SELECT * FROM bitacora AS b
--insert into opcionModulo(categoria,descripcion,estado) values('Sesion','Inicio de Sesión','')
----Padres
--insert into opcionModulo(categoria,descripcion,estado) values('Padres','Nueva Factura de Sujeto Excluido','')
--insert into opcionModulo(categoria,descripcion,estado) values('Padres','Consultas','')
--insert into opcionModulo(categoria,descripcion,estado) values('Padres','Impresión de Formato Legal','')
--insert into opcionModulo(categoria,descripcion,estado) values('Padres','Reportes','')
--insert into opcionModulo(categoria,descripcion,estado) values('Padres','Sistema','')
----Consultas
--insert into opcionModulo(categoria,descripcion,estado) values('Consultas','Documento Generado','')
--insert into opcionModulo(categoria,descripcion,estado) values('Consultas','Sujeto Excluido','')
----Impresión
--insert into opcionModulo(categoria,descripcion,estado) values('Impresión','Generación de Correlativos','')
--insert into opcionModulo(categoria,descripcion,estado) values('Impresión','Anulación de Sujeto Excluido','')
--insert into opcionModulo(categoria,descripcion,estado) values('Impresión','Impresión de Factura','')
----Reportes
--insert into opcionModulo(categoria,descripcion,estado) values('Reportes','Datos para F987','')
--insert into opcionModulo(categoria,descripcion,estado) values('Reportes','Facturas Generadas','')
----Sistema
--insert into opcionModulo(categoria,descripcion,estado) values('Sistema','Bitacoras del sistema','')
--insert into opcionModulo(categoria,descripcion,estado) values('Sistema','Gestion de permisos','')
--insert into permiso(usuario,idOpcion,permiso,update_by) values('SEDF','1','1','SEDF')
SELECT om.id AS idOpcion, om.descripcion, om.estado, p.permiso 
FROM opcionModulo AS om
JOIN permiso AS p ON p.idOpcion = om.id
WHERE p.usuario = 'SEDF'

SELECT * FROM sujetoExcluido AS se