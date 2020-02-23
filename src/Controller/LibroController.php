<?php
    
    namespace App\Controller;

    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use App\Service\BDPruebaLibros;
    
    class LibroController extends AbstractController
    {

        private $libros;
        public function __construct($bdPrueba) {
           $this->libros = $bdPrueba->get();
        }

        /**
         * @Route("/libro/{isbn}", name="ficha_libro")
         */
        public function ficha($isbn)
        {
            $libro = NULL;
                foreach($this->libros as $lib)
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
            return $this->render('lista_libros.html.twig', array('libros' => $this->libros));
        }
    }

?>