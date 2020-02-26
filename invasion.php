<?php

	//Leyendo el archivo de entrada
	$fileLines = file('input.txt');
	$output = 'output.txt';
	//Borrar archivo de salida si ya existe.
	if(file_exists($output)){

		unlink($output);
	}

	$ships = $fileLines[0];
	$positionInf = 0;
	$x = 0;
	$lines = count($fileLines);
	//Recorriendo las lineas del archivo
	for ($i=1; $i < $lines; $i++) { 
		
		$separatedLine = explode(" ", $fileLines[$i]);
		//Tomando la informacion de la nave
		if($i == ($positionInf + $x + 1)){

			$x = $separatedLine[0];
			$y = $separatedLine[1];
			$scale = (float)$separatedLine[2];
			$positionInf = $i;
			//echo "Pos: ".$i. " " . " x: ". $x . " y: " . $y .  " escala: " . $scale . "<br>";
			$cCenter = array(); 
			$controlCenters = array();
			$coordX = array();
			$coordY = array();
			$fil = 0; 
		}else{ 

			//Tomando las coordenadas de los centros de control
			foreach ($separatedLine as $key => $letter) {

				$letter = (int) $letter;
				if(!(in_array($letter, $controlCenters))){
					//echo "Letra: " . $letter . "<br>";

					//Creo un objeto para cada letra con sus x - y
					array_push($cCenter,(object)[
                        "letter" => $letter,
                        "x" => array(),
                        "y" => array(),
                        "px" => 0,
                        "py" => 0
                    ]);
					array_push($controlCenters, $letter);
					array_push($cCenter[count($cCenter)-1]->x, $fil);
					array_push($cCenter[count($cCenter)-1]->y, $key);
				}else{

					foreach ($cCenter as $center) {

						if($center->letter == $letter){

							array_push($center->x, $fil);
							array_push($center->y, $key);
						}
					}
				}
			}
			//Si es la ultima vuelta de esa nave
			if($i == ($positionInf + $x)){
				
				foreach ($cCenter as $center) {
					/*
					*Calculo la escala real, con la formula de
					*((xMayor + xMenor + 1)/ 2 ) * scale;
					*/
					$maX = $center->x[count($center->x)-1];
					$minX = $center->x[0];
					$center->px = (($maX + $minX + 1)/2) * $scale;

					$maY = $center->y[count($center->y)-1];
					$minY = $center->y[0];
					$center->py = (($maY + $minY + 1)/2) * $scale;
					//echo "Letra: " . $center->letter . " MayorX: " . $maX . " MenorX: " . $minX . "--" . " MayorY: " . $maY . " MenorY: " . $minY. "<br>";
					echo $center->letter . ":" . $center->px . "," . $center->py . "<br>";
				}
			}
			$fil++;
		}
	}

?>