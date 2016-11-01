<?php
	include_once '15cero2/controladoras/dominio/Evento.php';
	include_once '15cero2/controladoras/EventoDataPrueba.php';


	//Prueba

	class PruebaUnitaria extends PHPUnit_Framework_TestCase{

		function testPruebaUnitaria(){

			$eventodata = new EventoDataPrueba();
			$evento = new Evento();
			$evento->nombre = "Name";
			$evento->fechaInicio = "2016-11-23";
			$evento->fechaFinal = "2016-10-23";
			$evento->ubicacion = "Chepe";
			$evento->idCliente = 0;

			//inserta el evento
			$this->assertEquals('true',$eventodata->insertarEvento($evento));

			//recupera el evento y compara a ver si es el que se inserto
			$even = $eventodata->consultarEvento($evento->nombre);
			$evento->id = $even->id;
			$this->assertEquals($evento->nombre,$even->nombre);

			//modifica el evento y recupera para saber si se hizo la modificacion correcta
			$even->nombre = "Nuevo nombre";
			$even->ubicacion = "Nueva ubicacion";
			$this->assertEquals('true',$eventodata->modificarEvento($even));
			$evento = $eventodata->consultarEvento($even->nombre);
			$this->assertEquals($evento->nombre,$even->nombre);
			$this->assertEquals($evento->ubicacion,$even->ubicacion);

			//se elimina el registro
			$this->assertEquals('true',$eventodata->eliminarEvento($evento->id));
	}
}

// metodos que se pueden usar http://www.simpletest.org/en/unit_test_documentation.html
?>
