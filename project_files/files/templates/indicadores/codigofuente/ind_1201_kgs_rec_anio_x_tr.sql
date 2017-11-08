# Kilogramos Recolectados en el Año (Por Tipo de Residuo)
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
	AND YEAR(man.fecha) = IF(MONTH(CURDATE())=1,YEAR(CURDATE())-1,YEAR(CURDATE())) 
	AND cantidad != 0.0
GROUP BY tr.descripcion
ORDER BY Cantidad DESC