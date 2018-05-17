<?php

namespace Uloc\Bundle\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Funcionario
 *
 * @ORM\Table(name="funcionario")
 * @ORM\Entity(repositoryClass="Uloc\Bundle\AppBundle\Repository\FuncionarioRepository")
 */
class Funcionario
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="foto", type="string", length=255, nullable=true)
     */
    private $foto;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nome", type="string", length=255)
     */
    private $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="cargo", type="string", length=100)
     */
    private $cargo;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set foto.
     *
     * @param string|null $foto
     *
     * @return Funcionario
     */
    public function setFoto($foto = null)
    {
        $this->foto = $foto;

        return $this;
    }

    /**
     * Get foto.
     *
     * @return string|null
     */
    public function getFoto()
    {
        return $this->foto;
    }

    /**
     * Set nome.
     *
     * @param string|null $nome
     *
     * @return Funcionario
     */
    public function setNome($nome = null)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get nome.
     *
     * @return string|null
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set cargo.
     *
     * @param string $cargo
     *
     * @return Funcionario
     */
    public function setCargo($cargo)
    {
        $this->cargo = $cargo;

        return $this;
    }

    /**
     * Get cargo.
     *
     * @return string
     */
    public function getCargo()
    {
        return $this->cargo;
    }
}
