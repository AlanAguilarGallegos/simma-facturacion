# Servicios Reportados el Mes Anterios por generador
# Barras

SELECT IF(gen.nombrecorto IS NULL OR gen.nombrecorto='',gen.razonsocial,gen.nombrecorto) AS Item,COUNT(DISTINCT idmanifiesto,idgenerador,fecha) AS Cantidad
FROM manifiesto AS man INNER JOIN relgenman USING(idmanifiesto) INNER JOIN generador AS gen USING(idgenerador)
__WHR__ AND YEAR(man.fecha) = IF(MONTH(CURDATE())=1,YEAR(CURDATE())-1,YEAR(CURDATE())) AND MONTH(man.fecha) = IF(MONTH(CURDATE())=1,12,MONTH(CURDATE())-1)
		AND ((motivo IS NOT NULL AND motivo != '') OR idmanifiesto IN (SELECT idmanifiesto FROM relmanrec))
GROUP BY gen.razonsocial
ORDER BY Cantidad Desc