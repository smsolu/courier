DROP VIEW IF EXISTS actuacion_v;

CREATE DEFINER = 'root'@'localhost' VIEW actuacion_v
(
  id,
  fechayhora,
  descripcion,
  tipoactuacion_nombre,
  usuario_nombre,
  `status`,
  id_estudio,
  id_tipoactuacion,
  id_usuario,
  id_documento,
  id_expediente
)
AS
select 
  `e`.`id` AS `id`,
  `e`.`fechayhora` AS `fechayhora`,
  `e`.`descripcion` AS `descripcion`,
  `ta`.`nombre` AS `tipoactuacion_nombre`,
  `usuario`.`nombre` AS `usuario_nombre`,
  `e`.`status` AS `status`,
  `e`.`id_estudio` AS `id_estudio`,
  `e`.`id_tipoactuacion` AS `id_tipoactuacion`,
  `e`.`id_usuario` AS `id_usuario`,
  `e`.`id_documento` AS `id_documento`,
  `e`.`id_expediente` AS `id_expediente` 
from ((`expediente_actuacion` `e` 
  left join `actuacion_tipoactuacion` `ta` on
    (
      (`e`.`id_tipoactuacion` = `ta`.`id`)
    )) 
  left join `usuario` on
    (
      (`e`.`id_usuario` = `usuario`.`id`)
    ));



DROP VIEW IF EXISTS documento_v;

CREATE DEFINER = 'root'@'localhost' VIEW documento_v
(
  id,
  fechayhora,
  nombre,
  filename,
  descripcion,
  usuario_nombre,
  `status`,
  modificando,
  modificando_fechayhora,
  id_estudio,
  id_usuario,
  id_usuario_modificacion,
  id_expediente
)
AS
select 
  `e`.`id` AS `id`,
  `e`.`fechayhora` AS `fechayhora`,
  `e`.`nombre` AS `nombre`,
  `e`.`filename` AS `filename`,
  `e`.`descripcion` AS `descripcion`,
  `user`.`username` AS `usuario_nombre`,
  `e`.`status` AS `status`,
  `e`.`modificando` AS `modificando`,
  `e`.`modificando_fechayhora` AS `modificando_fechayhora`,
  `e`.`id_estudio` AS `id_estudio`,
  `e`.`id_usuario` AS `id_usuario`,
  `e`.`id_usuario_modificacion` AS `id_usuario_modificacion`,
  `e`.`id_expediente` AS `id_expediente` 
from (`expediente_documento` `e` 
  left join `fos_user` `user` on
    (
      (`e`.`id_usuario` = `user`.`id`)
    ));

DROP VIEW IF EXISTS actuacion_v;

CREATE DEFINER = 'root'@'localhost' VIEW actuacion_v
(
  id,
  fechayhora,
  descripcion,
  tipoactuacion_nombre,
  usuario_nombre,
  `status`,
  id_estudio,
  id_tipoactuacion,
  id_usuario,
  id_documento,
  id_expediente
)
AS
select 
  `e`.`id` AS `id`,
  `e`.`fechayhora` AS `fechayhora`,
  `e`.`descripcion` AS `descripcion`,
  `ta`.`nombre` AS `tipoactuacion_nombre`,
  `fos_user`.`username` AS `usuario_nombre`,
  `e`.`status` AS `status`,
  `e`.`id_estudio` AS `id_estudio`,
  `e`.`id_tipoactuacion` AS `id_tipoactuacion`,
  `e`.`id_usuario` AS `id_usuario`,
  `e`.`id_documento` AS `id_documento`,
  `e`.`id_expediente` AS `id_expediente` 
from ((`expediente_actuacion` `e` 
  left join `actuacion_tipoactuacion` `ta` on
    (
      (`e`.`id_tipoactuacion` = `ta`.`id`)
    )) 
  left join `fos_user` on
    (
      (`e`.`id_usuario` = `fos_user`.`id`)
    ));