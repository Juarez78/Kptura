-- Active: 1708630569922@@127.0.0.1@3306@store_sv
-- Trigger Tabla Categorias 
DROP TRIGGER bitacora_categorias_U;
DELIMITER $$
CREATE TRIGGER bitacora_categorias_U
AFTER UPDATE ON categorias
FOR EACH ROW
BEGIN
    INSERT INTO bitacora (tabla,accion,valores_old,valores_new) VALUES(
        'categorias','UPDATE',
        CONCAT('Categoria: ', OLD.categoria, ', Estado: ', OLD.estado),
        CONCAT('Categoria: ', NEW.categoria, ', Estado: ', NEW.estado)
    );
END$$
DELIMITER ;

DROP TRIGGER bitacora_categorias_D;
DELIMITER $$
CREATE TRIGGER bitacora_categorias_D
AFTER DELETE ON categorias
FOR EACH ROW
BEGIN
    INSERT INTO bitacora (tabla,accion,valores_old,valores_new) VALUES(
        'categorias','DELETE',
        CONCAT('Idcategoria: ', OLD.idcategoria,' Categoria: ', OLD.categoria, ', Estado: ', OLD.estado),''
    );
END$$
DELIMITER ;

DROP TRIGGER bitacora_categorias_I;
DELIMITER $$
CREATE TRIGGER bitacora_categorias_I
AFTER INSERT ON categorias
FOR EACH ROW
BEGIN
    INSERT INTO bitacora (tabla,accion,valores_old,valores_new) VALUES(
        'categorias','INSERT','',
        CONCAT('Categoria: ', NEW.categoria, ', Estado: ', NEW.estado)
    );
END$$
DELIMITER ;
-- 
