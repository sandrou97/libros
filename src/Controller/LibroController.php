<?php
    
    namespace App\Controller;

    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use App\Service\BDPruebaLibros;
    use App\Entity\Libro;
    use App\Entity\Editorial;
    use Symfony\Component\Form\Extension\Core\Type\TextType; 
    use Symfony\Component\Form\Extension\Core\Type\IntegerType; 
    use Symfony\Component\Form\Extension\Core\Type\SubmitType; 
    use Symfony\Component\Form\Extension\Core\Type\EntityTpe;
    use Symfony\Bridge\Doctrine\Form\Type\EntityType;
    use Symfony\Component\Form\Extension\Core\Type\HiddenType;
    use Symfony\Component\HttpFoundation\Request;
    
    class LibroController extends AbstractController
    {
        
        public function pedir(){
            $libro_rep = $this->getDoctrine()->getRepository(Libro::class); 
            $libros = $libro_rep->findAll();
            return $libros;
        }

        public function pedir2(){
            $libro_rep = $this->getDoctrine()->getRepository(Editorial::class); 
            $libros = $libro_rep->findAll();
            return $libros;
        }


        /**
         * @Route("/libro/insertar", name="insertar")
         */
        public function insertar(){
            $entityManager = $this->getDoctrine()->getManager();
            $libros = array(
                array("isbn" => "A001", "titulo" => "Jarry Choped", "autor" => "JK Bowling", "paginas" => 100),
                array("isbn" => "A002", "titulo" => "El señor de los palillos", "autor" => "JRR TolQuien", "paginas" => 200), 
                array("isbn" => "A003", "titulo" => "Los polares de la tierra", "autor" => "Ken Follonett", "paginas" => 300), 
                array("isbn" => "A004", "titulo" => "Los juegos de enjambre", "autor" => "Suzanne Collonins", "paginas" => 400),
                );
            foreach ($libros as $lib){
                $libro = new Libro();
                $libro->setIsbn($lib["isbn"]);
                $libro->setTitulo($lib["titulo"]);
                $libro->setAutor($lib["autor"]);
                $libro->setPaginas($lib["paginas"]);
                $entityManager->persist($libro);
            }
            $entityManager->flush();
            return $this->redirectToRoute('libros');
        }

        /**
         * @Route("/nuevo", name="nuevo")
         */
        public function nuevo_libro(Request $request){
            $libro = new Libro();
            $formulario = $this->createFormBuilder($libro)
                ->add('isbn', TextType::class)
                ->add('titulo', TextType::class)
                ->add('autor', TextType::class)
                ->add('paginas', IntegerType::class)
                ->add('editorial', EntityType::class, array(
                    'class' => Editorial::class, 'choice_label' => 'editorial', ))
                ->add('save', SubmitType::class, array('label' => 'Enviar')) ->getForm();

                $formulario->handleRequest($request);

                if ($formulario->isSubmitted() && $formulario->isValid())
                {   
                    $libro = $formulario->getData();
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($libro); $entityManager->flush();
                    return $this->redirectToRoute('libros');
                }

            return $this->render('nuevo_libro.html.twig', array('formulario' => $formulario->createView()));
        }

        /**
         * @Route("/buscar", name="buscar")
         */
        public function buscar_libro(Request $request){
            $cadena = NULL;
            $libros = NULL;
            if($request->server->get('REQUEST_METHOD')=='POST'){
                $cadena = $request->request->get('cadena');
                $repositorio = $this->getDoctrine()->getRepository(Libro::class);
                $libros = $repositorio->tituloLibro($cadena);
            }
      
           
                
            return $this->render('buscar_libro.html.twig', array('libros' => $libros));
        }

        /**
         * @Route("/libro/editar/{isbn}", name="editar")
         */
        public function editar_libro(Request $request, $isbn){
            $libro_rep = $this->getDoctrine()->getRepository(Libro::class); 
            $libro = $libro_rep->find($isbn);
            $formulario = $this->createFormBuilder($libro)
                ->add('isbn', TextType::class)
                ->add('titulo', TextType::class)
                ->add('autor', TextType::class)
                ->add('paginas', IntegerType::class)
                ->add('editorial', EntityType::class, array(
                    'class' => Editorial::class, 'choice_label' => 'editorial', ))
                ->add('save', SubmitType::class, array('label' => 'Enviar')) ->getForm();

                $formulario->handleRequest($request);

                if ($formulario->isSubmitted() && $formulario->isValid())
                {   
                    $libro = $formulario->getData();
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($libro); $entityManager->flush();
                    return $this->redirectToRoute('libros');
                }

            return $this->render('editar_libro.html.twig', array('formulario' => $formulario->createView()));
        }

        /**
         * @Route("/eliminar/{isbn}", name="eliminar")
         */
        public function eliminar($isbn){
            $entityManager = $this->getDoctrine()->getManager();
            $libro_rep = $this->getDoctrine()->getRepository(Libro::class); 
            $libro = $libro_rep->find($isbn);
            if ($libro)
            {
                $entityManager->remove($libro); 
                $entityManager->flush();
            }
            return $this->redirectToRoute('libros');
        }

        /**
         * @Route("/libros/paginas/{paginas}", name="paginas")
         */
        public function filtrarPaginas($paginas){
                $repositorio = $this->getDoctrine()->getRepository(Libro::class);
                $libros = $repositorio->nPaginas($paginas);
                return $this->render('lista_libros_paginas.html.twig', array('libros' => $libros));
        }

        /**
         * @Route("/libro/{isbn}", name="ficha_libro")
         */
        public function ficha($isbn)
        {
            $libros = $this->pedir();
                foreach($libros as $lib)
                {
                    if($lib->getIsbn()==$isbn)
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
            return $this->render('lista_libros.html.twig', array('libros' => $this->pedir()));
        }

        /**
         * @Route("/contacto/insertarConEditorial", name="paginas")
         */
        public function insertarConEditorial(){
            $entityManager = $this->getDoctrine()->getManager();
            $editorial = new Editorial();
            $editorial->setNombre("Alfaomega");
            $libro = new Libro();
            $libro->setIsbn("2222BBBB");
            $libro->setTitulo("Libro de prueba con editorial");
            $libro->setAutor("Autor de prueba con editorial");
            $libro->setPaginas(200);
            $libro->setEditorial($editorial);
            $entityManager->persist($libro);
            $entityManager->persist($editorial);
            $entityManager->flush();
            return $this->redirectToRoute('libros');
        }
    }

?>