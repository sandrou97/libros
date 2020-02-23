<?php
namespace App\Service;
class BDPruebaLibros {
    private $libros = array(
        array("isbn" => "A001", "titulo" => "Jarry Choped", "autor" => "JK Bowling", "paginas" => 100),
        array("isbn" => "A002", "titulo" => "El señor de los palillos", "autor" => "JRR TolQuien", "paginas" => 200), 
        array("isbn" => "A003", "titulo" => "Los polares de la tierra", "autor" => "Ken Follonett", "paginas" => 300), 
        array("isbn" => "A004", "titulo" => "Los juegos de enjambre", "autor" => "Suzanne Collonins", "paginas" => 400),
        );
public function get() {
    return $this->libros; }
    } 
?>