CREATE TABLE usuario ( 
pk_usuario smallint primary key not null auto_increment, 
nombre varchar(30) not null, 
apellidos varchar(30) not null,
correo varchar(40) not null,
contrasenia varchar(25) not null, 
tipo_usuario int not null
)

create table categoria(
pk_categoria smallint primary key not null auto_increment,
nom_categoria varchar(30) not null
)

create table unidad_medida(
pk_unidad smallint primary key not null auto_increment,
unidad varchar(10) not null
)

create table provedor(
pk_provedor smallint primary key not null auto_increment,
nombre_provedor varchar(30) not null
)

create table producto_provedor(
pk_pp smallint primary key not null auto_increment,
fk_producto smallint not null,
fecha date not null,
fk_provedor smallint not null,
cantidad float(2) not null,
foreign key (fk_producto) references producto(pk_producto),
foreign key (fk_provedor) references provedor(pk_provedor)
)

create table producto(
pk_producto smallint primary key not null auto_increment,
nombre varchar(30) not null,
ruta_img varchar(100) not null,
codigo varchar(50) not null,
precio float(2) not null,
fk_categoria smallint not null,
stok float(2) not null,
importe float(2) not null,
ganancia float(2) not null,
fk_unidad smallint not null,
cant_producto float(2) not null,
fk_provedor smallint,
estado int not null,
foreign key (fk_categoria) references categoria(pk_categoria),
foreign key (fk_unidad) references unidad_medida(pk_unidad),
foreign key (fk_provedor) references provedor(pk_provedor)
)

create table localidad(
pk_localidad smallint primary key not null auto_increment,
nombre varchar(80) not null
)

create table cliente(
pk_cliente smallint primary key not null auto_increment,
nombre_cliente varchar(80) not null,
edad int not null,
telefono_cel varchar(10),
telefono_casa varchar(10),
nombre_local varchar(80) not null,
fk_localidad smallint not null,
calle_ave varchar(100) not null,
descripccion varchar(200) not null,
foreign key (fk_localidad) references localidad(pk_localidad)
)

create table venta(
pk_venta smallint primary key not null auto_increment,
fecha date not null,
hora time not null,
total float(2) not null,
estado varchar(4) not null,
fk_usuario smallint not null,
fk_cliente smallint,
cant_pago float(2),
cambio float(2),
factura int not null,
foreign key (fk_usuario) references usuario(pk_usuario),
foreign key (fk_cliente) references cliente(pk_cliente)
)

create table venta_producto(
pk_vp smallint primary key not null auto_increment,
cant_producto float(2) not null,
cant_importe float(2),
fk_producto smallint not null,
fk_venta smallint not null,
foreign key (fk_producto) references producto(pk_producto),
foreign key (fk_venta) references venta(pk_venta)
)