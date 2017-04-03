<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <meta charset="UTF-8">
        <title>Celcius 'n' Farenheit</title>        
    </head>
    <body>
        <?php
        /*
        Calcuo de la conversión de grados Celsius a Farhenheit y viceversa
        Límie inferior -273ºC o 459.4ºF.
        Límite superior 10000ºC o 18032ºF
        Valor por defecto 0ºC o 0ºF
        */
        
        //Variables
        if(isset($_POST['enviar']))
        {
            $datum = $_POST['valor'];
            $unit = $_POST['unidad'];
            $T_max = 10000;
            $T_min = -273;
        }
        if(!isset($datum)){$datum = "Introduce un valor";} //Valor inicial

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
                            throw new Exception("Valor fuera de rango (".$min." / ".$max.")");
                        }
                        return true;
                    case "F":
                        if($temp < CtoF($min,'C') || $temp > CtoF($max, 'C'))
                        {
                            throw new Exception("Valor fuera de rango (".CtoF($min, 'C')." / ".CtoF($max, 'C').")");
                        }
                        return true;
                }
            }

        //Función que devuelve una excepción si el valor introducido no es un número.
            function checkNum($temp)
            {
                if(!is_numeric($temp))
                {
                    throw new Exception("El valor introducido no es un número.");
                }
                return true;
            }            
        ?>
            
        <div id="frame">
            <div class="header">
                <h1>Conversor Celsius Farhenheit</h1>                
            </div>
                    <form name="conversor" method="POST" action="">
                    <div id="main">
                    <div class="datos">
                        Temperatura<br/>
                        <input class="datum" id="dato" type="text" name="valor" value="<?php echo $datum;?>"/>
                    </div>
                    <div class="datos">
                        <input type="radio" name="unidad" value="C" checked/>°C <input type="radio" name="unidad" value="F"/>°F
                    </div>
                    <div class="datos">
                        Resultado<br/>
                        <?php
                        //Resultado de la conversión
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
                                        print("<p class='datum' id='resultado'>".number_format(CtoF($datum,$unit), 2).CorF($unit)."</p>");
                                    }
                                }
                            }
                            catch(Exception $e)
                            {
                                echo("<p class='error'>".$e->getMessage()."</p>");
                            }
                        }
                        ?>                    
                    </div>
                    <div class="marco">
                        <input class="button" value="Convertir" type="submit"   name="enviar">                    
                    </div>
                    </div>
                    </form>
            <div class="footer">
                Formula:<br/>
                °C = (°F - 32) x 5/9<br/>
                °F = °C x 9/5 + 32<br/>
                Nota: El cero absoluto (0 ºK) es -273ºC o -459.4ºF.<br/>
                Ejercicio PHP primer semestre del segundo curso de DAW.<br/>
                Isaac Rovira
            </div>
        </div>        
    </body>
</html>