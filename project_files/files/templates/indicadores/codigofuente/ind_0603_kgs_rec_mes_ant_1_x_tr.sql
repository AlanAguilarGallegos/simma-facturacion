# Kilogramos Recolectados del Mes Anterior por tipo de residuo
# Barras
# Cada tipo de residuo

SELECT tr.descripcion AS 'Item', sum(cantidad)  AS 'Cantidad'
FROM manifiesto AS man 
	INNER JOIN relgenman USING(idmanifiesto) 
	INNER JOIN generador AS gen USING(idgenerador) 
	INNER JOIN relmanrec USING(idmanifiesto) 
	INNER JOIN recoleccion USING(idrecoleccion) 
	INNER JOIN relresrec USING(idrecoleccion) 
	INNER JOIN residuo AS res USING(idresiduo)
	INNER JOIN catalogodet AS tr ON tiporesiduo = tr.idcatalogodet
__WHR__ 
	AND YEAR(man.fecha) = IF(MONTH(CURDATE())=1,YEAR(CURDATE())-1,YEAR(CURDATE())) AND MONTH(man.fecha) = IF(MONTH(CURDATE())=1,12,MONTH(CURDATE())-1) AND cantidad != 0.0
GROUP BY tr.descripcion
ORDER BY Cantidad DESC