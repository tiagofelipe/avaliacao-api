<?php

namespace Uloc\Bundle\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Criterio
 *
 * @ORM\Table(name="criterio")
 * @ORM\Entity(repositoryClass="Uloc\Bundle\AppBundle\Repository\CriterioRepository")
 */
class Criterio
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
     * @var bool|null
     *
     * @ORM\Column(name="ativo", type="boolean", nullable=true)
     */
    private $ativo;

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=255)
     */
    private $nome;


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
     * Set ativo.
     *
     * @param bool|null $ativo
     *
     * @return Criterio
     */
    public function setAtivo($ativo = null)
    {
        $this->ativo = $ativo;

        return $this;
    }

    /**
     * Get ativo.
     *
     * @return bool|null
     */
    public function getAtivo()
    {
        return $this->ativo;
    }

    /**
     * Set nome.
     *
     * @param string $nome
     *
     * @return Criterio
     */
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get nome.
     *
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }


}
