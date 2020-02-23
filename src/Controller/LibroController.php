<?php
    
    namespace App\Controller;

    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

    
    class LibroController extends AbstractController
    {

        private $librosar = array(
            array("isbn" => "A001", "titulo" => "Jarry Choped", "autor" => "JK Bowling", "paginas" => 100),
            array("isbn" => "A002", "titulo" => "El señor de los palillos", "autor" => "JRR TolQuien", "paginas" => 200), 
            array("isbn" => "A003", "titulo" => "Los polares de la tierra", "autor" => "Ken Follonett", "paginas" => 300), 
            array("isbn" => "A004", "titulo" => "Los juegos de enjambre", "autor" => "Suzanne Collonins", "paginas" => 400),
            );

        /**
         * @Route("/libro/{isbn}", name="ficha_libro")
         */
        public function ficha($isbn)
        {
            $libro = NULL;
                foreach($this->librosar as $lib)
                {
                    if($lib["isbn"]==$isbn)
                    {
                        $libro=$lib;
                    }
                }
            return $this->render('ficha_libro.html.twig', array('libro' => $libro));
        }
    
        /**
         * @Route("/libro", name="libros")
         */
        public function libros()
        {
            $libros = array(
                array("isbn" => "A001", "titulo" => "Jarry Choped", "autor" => "JK Bowling", "paginas" => 100),
                array("isbn" => "A002", "titulo" => "El señor de los palillos", "autor" => "JRR TolQuien", "paginas" => 200),
                array("isbn" => "A003", "titulo" => "Los polares de la tierra", "autor" => "Ken Follonet", "paginas" => 300),
                array("isbn" => "A004", "titulo" => "Los juegos del enjambre", "autor" => "Suzanne Collonins", "paginas" => 400)
            );
            return $this->render('lista_libros.html.twig', array('libros' => $libros));
        }
    }

?>