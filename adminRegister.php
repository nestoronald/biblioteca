<?php

	function registerLugar($lugar){
	    $respuesta = new xajaxResponse();

	    if($lugar==""){
	        $respuesta->alert("Ingrese Lugar");
	    }
	    else{
	        if(isset($_SESSION["edit"])){
	            $_SESSION["edit"]["lugar"]=$lugar;
	        }
	        else{

	            $_SESSION["tmp"]["lugar"]=$lugar;
	        }
		}

	    return $respuesta;
	}



	function registerNomEvento($evento_description){
	    $respuesta = new xajaxResponse();

	    if($evento_description==""){
	        $respuesta->alert("Ingrese Nombre del Evento");
	    }
	    else{
	        if(isset($_SESSION["editar"])){
	            if($_SESSION["editar"]==1){
	                $_SESSION["edit"]["evento_description"]=$evento_description;
	            }
	        }
	        else{
	            $_SESSION["tmp"]["evento_description"]=$evento_description;
	        }


	        }
	    return $respuesta;
	}

/**************************************************
Funcion que muestra un combo
***************************************************/

	function registerYearCompendio($yearCompendio){
	    $respuesta = new xajaxResponse();

	    if($yearCompendio==0){
	        $respuesta->alert("Ingrese Año de Compendio");
	    }
	    else{
	        if(isset($_SESSION["edit"])){
	            $_SESSION["edit"]["yearCompendio"]=$yearCompendio;

	        }
	        else{
	            $_SESSION["tmp"]["yearCompendio"]=$yearCompendio;
	        }
		}

                $respuesta->alert(print_r($_SESSION["tmp"], true));
	    return $respuesta;
	}


	function registerDateIng(){
            $respuesta = new xajaxResponse();
            /*
             $fecha=date("Y-m-d");
	     if(isset($_SESSION["edit"]["date_ing"])){
	         unset($_SESSION["edit"]["date_ing"]);
	         $_SESSION["edit"]["date_ing"]=$fecha;
	     }
	     else{
	     */
	     if(!isset($_SESSION["edit"]["date_ing"])){
		$fecha=date("Y-m-d");
		$_SESSION["tmp"]["date_ing"]=$fecha;
	     }

             //$respuesta->alert(print_r($_SESSION["tmp"], true));
             return $respuesta;
	}

	function registerDatePub($value){

	     if(isset($_SESSION["edit"]["date_pub"])){
	         unset($_SESSION["edit"]["date_pub"]);
	         $_SESSION["edit"]["date_pub"]=$value;
	     }
	     else{
	         $_SESSION["tmp"]["date_pub"]=$value;
	     }
	}

	function registerPermissionKey($idclave){

		if(isset($_SESSION["editar"])){
		    if(isset($_SESSION["edit"]["key"][$idclave])){
		        unset($_SESSION["edit"]["key"][$idclave]);
		    }
		    else{
		        $_SESSION["edit"]["key"][$idclave]=1;
		    }
		}
		else{
		    if(isset($_SESSION["tmp"]["key"][$idclave])){
		        unset($_SESSION["tmp"]["key"][$idclave]);
		    }
		    else{
		        $_SESSION["tmp"]["key"][$idclave]=1;
		    }
		}
	    //echo print_r($_SESSION["edit"]);
	}

	function registerStatus($idstatus){

	     if(isset($_SESSION["edit"]["status"])){
	         unset($_SESSION["edit"]["status"]);
	         $_SESSION["edit"]["status"]=$idstatus;
	     }
	     else{
	        $_SESSION["tmp"]["status"]=$idstatus;
	     }
	}


	function new_registerfbook($new_fbook){
		 $objResponse = new xajaxResponse();
		 if ($new_fbook=="") {
		 	$objResponse->alert("Debe ingresar nuevo formato");
		 }
		 else{
		 	if (isset($_SESSION["edit"])) {
		 		$_SESSION["edit"]["fbook_descripcion"]=$new_fbook;
		 	}
		 	else{
		 		$_SESSION["tmp"]["fbook_descripcion"]=$new_fbook;
		 	}
		 }

		 return $objResponse;

	}

	function register_input($val_input,$label,$idinput, $index=""){
		// $respuesta = new RegisterInput();
		// $objresponse = new xajaxResponse();
		// $_SESSION["required"]["$idinput"]=1;

		// $reg_response = $respuesta->register("$val_input",$label,$idinput, $index="");

		// if (isset($reg_response["msj"]) and $reg_response["msj"]!="") {
		// 	$objresponse->alert(print_r($reg_response["msj"],TRUE));
		// 	$objresponse->script($reg_response["script"]);
		// }

		// return $objresponse;
	}


	function registraAuthorResult($form_entrada){
	    $resultCheck=checkDataForm($form_entrada);
	    if ($resultCheck["Error"]==1){
	            $result["Msg"]=$resultCheck["Msg"];
	            $result["Error"]="completar";
	    }

	    else{
/*
	        $pNombre=strtolower($form_entrada["pNombre"]);
	        $sNombre=strtolower($form_entrada["sNombre"]);
	        $apellido=strtolower($form_entrada["apellido"]);
*/

	        //$pNombre=$form_entrada["pNombre"];
	        //$sNombre=$form_entrada["sNombre"];
	        //$apellido=$form_entrada["apellido"];

/*                if(ereg("'",$form_entrada["apellido"])){
                    $apellido=explode("'",$form_entrada["apellido"]);
                    $antes_caracter=ucfirst($apellido[0]);
                    $despues_caracter=$apellido[1];
                    $apellido=$antes_caracter."'".$despues_caracter;
                }
                else{
                    $apellido=strtolower($form_entrada["apellido"]);
                }
*/
	        $result=registraAuthorSQL($form_entrada);
	    }

		return $result;
	}

	function registraAuthorShow($form_entrada=""){
		$respuesta = new xajaxResponse();
                //$respuesta->alert(print_r($form_entrada, true));


		$result=registraAuthorResult($form_entrada);
                //$respuesta->alert(print_r($result, true));

		$error=isset($result["Error"])?$result["Error"]:"";

		switch($error){
		case "completar":
		    $respuesta->alert($result["Msg"]);
		break;
		case "existe":
		    $respuesta->alert($result["Msg"]);
		    $respuesta->assign('pNombre', 'value','');
		    $respuesta->assign('sNombre', 'value','');
		    $respuesta->assign('apellido', 'value','');

		break;
		case "registrado":
		    $respuesta->alert($result["Msg"]);
                    //$respuesta->alert($error);
		            $apellido=$result["apellido"];
		            $respuesta->assign('sAuthor', 'value',$apellido);
		            $respuesta->assign('author_name', 'value','');
		            $respuesta->assign('author_surname', 'value','');

		$respuesta->script("xajax_auxAuthorPriShow(5,1,xajax.getFormValues('autorPRI'))");

		break;
                case 4:
                    $respuesta->alert($result["Msg"]);
		break;
		}

		return $respuesta;
	}


?>
