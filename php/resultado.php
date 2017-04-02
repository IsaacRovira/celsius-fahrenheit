<?php
    /*
    Calcuo de la conversión de grados Celsius a Farhenheit y viceversa
    Límie inferior -273ºC o 459.4ºF.
    Límite superior 10000ºC o 18032ºF
    Valor por defecto 0ºC o 0ºF
    */

//Función para la conversión
    function CtoF($temp, $und)
    {
        switch($und){
            case 'C': return ($temp * (9/5)) + 32;
            case 'F': return ($temp -32) * (5/9);
        }
    }
    
//Función que devuelve la unidad contraria a la introducida como parámetro.
    function CorF($Ud)
    {
        if($Ud == "C") return " ºF";
        return " ºC";
    }

//Función que lanza una excepción si el valor introducido supera un max o min.
    function checkMaxMin($temp, $und, $max, $min)
    {
        switch($und)
        {
            case "C":
                if($temp < $min || $temp > $max)
                {
                    throw new Exception("Valor fuera de rango (".$min." / ".$max.").");
                }
                return true;
            case "F":
                if($temp < CtoF($min,'C') || $temp > CtoF($max, 'C'))
                {
                    throw new Exception("Valor fuera de rango (".CtoF($min, 'C')." / ".CtoF($max, 'C').").");
                }
                return true;
        }
    }

//Función que devuelve una excepción si el valor introducido no es un número.
    function checkNum($temp)
    {
        if(!is_numeric($temp))
        {
            throw new Exception("Error, el valor introducido no es un número.");
        }
        return true;
    }
    
    //Comprobamos que hemos recibido el POST
    if(isset($_POST['enviar']))
    {
        $datum = $_POST['valor'];
        $unit = $_POST['unidad'];
        $T_max = 10000;
        $T_min = -273;
        
        if(!isset($datum)){$datum = 0;}
        try
        {
            if(checkNum($datum)) //Es un número?
            {
               if(checkMaxMin($datum, $unit, $T_max, $T_min)) //Está dentro del rango definido?
                {
                    print("<p>".$datum." º".$unit." = ".number_format(CtoF($datum,$unit), 2).CorF($unit).".<p>");
                }
            }
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }
    else
    {
        echo "ERROR POST NOT SET";
    }
?>