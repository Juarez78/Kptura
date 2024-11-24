-- Active: 1708630569922@@127.0.0.1@3306@store_sv
DROP PROCEDURE CRUD;
DELIMITER //
-- Cambia el delimitador a // para permitir definir procedimientos almacenados
CREATE PROCEDURE CRUD(
    IN in_tabla TEXT,        -- Parámetro de entrada que define el nombre de la tabla en la consulta
    IN in_campos TEXT,       -- Parámetro de entrada que define los campos a utilizar en la consulta
    IN in_val_cond TEXT,     -- Parámetro de entrada que define los valores de las condiciones
    IN in_campo TEXT,        -- Parámetro de entrada que define el campo específico para la condición dinámica
    IN in_valor TEXT,        -- Parámetro de entrada que define el valor específico para la condición dinámica
    IN accion VARCHAR(3),    -- Parámetro de entrada que define la acción a realizar (I=INSERT, U=UPDATE, D=DELETE, S=SELECT, SC=SELECT con condición)
    OUT resultado INT        -- Parámetro de salida que devuelve el resultado de la operación
)
BEGIN
    -- Crear la condición dinámica para las consultas
    SET @condicion = CONCAT(in_campo, "='", in_valor, "'");
    -- Inicializar el resultado en 0
    SET resultado = 0;
    -- Validación para la acción INSERT
    IF accion = 'I' OR accion = 'i' THEN
        -- Verificar si el dato ya existe en la tabla
        SET @proceso = CONCAT('SELECT COUNT(*) INTO @v_count FROM ', in_tabla, ' WHERE ', @condicion);
        -- Preparar la consulta para verificar si el dato ya existe
        PREPARE stmt_count FROM @proceso;
        -- Ejecutar la consulta preparada
        EXECUTE stmt_count;
        -- Liberar los recursos de la consulta preparada
        DEALLOCATE PREPARE stmt_count;
        
        -- Si existe un registro con ese valor
        IF @v_count > 0 THEN
            -- Establecer resultado como 3 para indicar dato duplicado
            SET resultado = 3; 
        ELSE
            -- Ejecutar la consulta de inserción
            SET @queryI = CONCAT('INSERT INTO ', in_tabla, ' (', in_campos, ') VALUES(', in_val_cond, ')');
            -- Preparar la consulta de inserción
            PREPARE stmt_insert FROM @queryI;
            -- Ejecutar la consulta preparada
            EXECUTE stmt_insert;
            -- Liberar los recursos de la consulta preparada
            DEALLOCATE PREPARE stmt_insert;
            -- Establecer resultado como 1 para indicar inserción exitosa
            SET resultado = 1;
        END IF;
    -- Validación para la acción INSERT sin busqueda previa
    ELSEIF accion = 'ISB' OR accion = 'isb' THEN
        -- Ejecutar la consulta de inserción
        SET @queryI = CONCAT('INSERT INTO ', in_tabla, ' (', in_campos, ') VALUES(', in_val_cond, ')');
        -- Preparar la consulta de inserción
        PREPARE stmt_insert FROM @queryI;
        -- Ejecutar la consulta preparada
        EXECUTE stmt_insert;
        -- Liberar los recursos de la consulta preparada
        DEALLOCATE PREPARE stmt_insert;
        -- Establecer resultado como 1 para indicar inserción exitosa
        SET resultado = 1;
    -- Validación para la acción SELECT
    ELSEIF accion = 'S' || accion = 's' THEN
        -- Crear la consulta de selección
        SET @queryS = CONCAT('SELECT ', in_campos, ' FROM ', in_tabla);
        -- Preparar la consulta de selección
        PREPARE stmt_select FROM @queryS;
        -- Ejecutar la consulta preparada
        EXECUTE stmt_select;
        -- Liberar los recursos de la consulta preparada
        DEALLOCATE PREPARE stmt_select;
        -- No se establece resultado porque el resultado de la consulta se envía al cliente directamente
    
    -- Validación para la acción SELECT con Condición
    ELSEIF accion = 'SC' OR accion = 'sc' THEN
        -- Crear la consulta de selección con condición
        SET @queryS = CONCAT('SELECT ', in_campos, ' FROM ', in_tabla, ' WHERE ', in_val_cond);
        -- Preparar la consulta de selección con condición
        PREPARE stmt_select_cond FROM @queryS;
        -- Ejecutar la consulta preparada
        EXECUTE stmt_select_cond;
        -- Liberar los recursos de la consulta preparada
        DEALLOCATE PREPARE stmt_select_cond;
        -- No se establece resultado porque el resultado de la consulta se envía al cliente directamente
    -- Validación para la acción UPDATE
    ELSEIF accion = 'U' OR accion = 'u' THEN
        -- Crear la consulta de actualización
        SET @queryU = CONCAT('UPDATE ', in_tabla, ' SET ', in_campos, ' WHERE ', in_val_cond);
        -- Preparar la consulta de actualización
        PREPARE stmt_update FROM @queryU;
        -- Ejecutar la consulta preparada
        EXECUTE stmt_update;
        -- Liberar los recursos de la consulta preparada
        DEALLOCATE PREPARE stmt_update;
        -- Establecer resultado como 1 para indicar actualización exitosa
        SET resultado = 1;

    -- Validación para la acción DELETE
    ELSEIF accion = 'D' OR accion = 'd' THEN
        -- Crear la consulta de eliminación
        SET @queryD = CONCAT('DELETE FROM ', in_tabla, ' WHERE ', in_val_cond);
        -- Preparar la consulta de eliminación
        PREPARE stmt_delete FROM @queryD;
        -- Ejecutar la consulta preparada
        EXECUTE stmt_delete;
        -- Liberar los recursos de la consulta preparada
        DEALLOCATE PREPARE stmt_delete;
        -- Establecer resultado como 1 para indicar eliminación exitosa
        SET resultado = 1;
    
    END IF;
END // -- Finaliza el bloque del procedimiento almacenado
DELIMITER ; -- Cambia el delimitador de nuevo a punto y coma (;) para comandos SQL estándar


-- 
DELIMITER //
CREATE PROCEDURE ObtenerCampo(
    IN in_tabla VARCHAR(64), 
    IN in_campo VARCHAR(64), 
    IN in_condicion TEXT, 
    OUT out_resultado VARCHAR(255)
)
BEGIN
    -- Construir la consulta dinámica para obtener el campo solicitado
    SET @sql = CONCAT('SELECT ', in_campo, ' INTO @resultado FROM ', in_tabla, ' WHERE ', in_condicion, ' LIMIT 1');
    -- Preparar y ejecutar la consulta
    PREPARE stmt FROM @sql;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
    -- Asignar el resultado al parámetro de salida
    SET out_resultado = @resultado;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE ContarRegistros(IN consulta TEXT, OUT cantidad INT)
BEGIN
    -- Preparar la consulta dinámica
    SET @sql = CONCAT('SELECT COUNT(*) INTO @count FROM (', consulta, ') AS subconsulta');
    -- Ejecutar la consulta
    PREPARE stmt FROM @sql;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
    -- Asignar el resultado a la variable de salida
    SET cantidad = @count;
END //
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE ObtenerUltimoID(IN nombreTabla VARCHAR(255),IN idvalor VARCHAR(50), OUT ultimoID INT)
BEGIN
    SET @sql = CONCAT('SELECT MAX(',idvalor,') INTO @resultado FROM ', nombreTabla);
    PREPARE stmt FROM @sql;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
    SET ultimoID = @resultado;
END $$
DELIMITER ;