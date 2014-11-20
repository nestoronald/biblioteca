<?php

	/************************************************************
	Función que muestra las Capas que Contendrán los Graficos
	************************************************************/

	/*************************************************************
	Función que Grafica la cantidad del Personal Activo y retirado
	**************************************************************/

	function detalleGraficosEstadisticos1($idCategory){
		$respuesta = new xajaxResponse();
	    switch($idCategory){
	    	case 1:
				$tabla="Publicaciones";
			break;
	    	case 2:
				$tabla="Ponencias";
			break;
	    	case 3:
				$tabla="Información Interna";
			break;
	    	case 4:
				$tabla="Asuntos Académicos";
			break;
	    }

		$strXML = "";
		$strXML = "<chart caption='Detalle de " . $tabla ."  ' subcaption='(en Unidades)' xAxisName='Date' showValues='1' labelStep='2' >";
		$link = connectToDB();
		$strQuery ="SELECT s.idsubcategory, s.subcategory_description, Count(s.idsubcategory) as count FROM data d, subcategory s WHERE d.idsubcategory=s.idsubcategory and s.idcategory=$idCategory GROUP BY s.idsubcategory";
		$result = mysql_query($strQuery) or die(mysql_error());

	    if ($result) {
	        while($ors = mysql_fetch_array($result)) {
	            $strXML .= "<set label='" . $ors['subcategory_description'] . "' value='" . $ors['count'] . "' />";
	        }
	    }
		mysql_close($link);
		$strXML .= "</chart>";
		$grafico=renderChartHTML("swf_charts/Pie3D.swf", "",$strXML, "detalle", 300, 300, false);
		$respuesta->Assign("detalle_chart","innerHTML",$grafico);
		return $respuesta;
	}



?>