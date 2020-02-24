<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LibroRepository")
 * @ORM\Entity
 * @UniqueEntity("isbn")
 */
class Libro
{

    /**
     * @ORM\Id()
     * @var string $isbn
     * 
     * @ORM\Column(name="isbn", type="string", length=20, unique=true)
     * 
     */
    private $isbn;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titulo;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $autor;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(
     *      min = 100,
     *      minMessage = "El número mínimo de páginas es {{ limit }}"
     * )
     */
    private $paginas;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Editorial")
     */
    private $editorial;

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function setIsbn(string $isbn): self
    {
        $this->isbn = $isbn;

        return $this;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): self
    {
        $this->titulo = $titulo;

        return $this;
    }

    public function getAutor(): ?string
    {
        return $this->autor;
    }

    public function setAutor(string $autor): self
    {
        $this->autor = $autor;

        return $this;
    }

    public function getPaginas(): ?int
    {
        return $this->paginas;
    }

    public function setPaginas(int $paginas): self
    {
        $this->paginas = $paginas;

        return $this;
    }

    public function getEditorial(): ?Editorial
    {
        return $this->editorial;
    }

    public function setEditorial(?Editorial $editorial): self
    {
        $this->editorial = $editorial;

        return $this;
    }
}
