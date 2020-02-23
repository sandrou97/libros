<?php
    
    namespace App\Controller;

    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use App\Service\BDPruebaLibros;
    use App\Entity\Libro;

    class InicioController extends AbstractController
    {

        /**
         * @Route("/", name="inicio")
         */
        public function inicio()
        {
            $libro_rep = $this->getDoctrine()->getRepository(Libro::class); 
            $libros = $libro_rep->findAll();
            $params = array('fecha' => date('d-m-y'));
            return $this->render('inicio.html.twig', ['fecha' => $params, 'cantidad' => count($libros)]);
        }
    }

?>