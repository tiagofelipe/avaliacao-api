<?php

namespace Uloc\Bundle\AppBundle\Entity\Pessoa;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * TipoIdentificadorRegistrado
 *
 * @ORM\Table(name="pessoa_tipo_identificador_registrado")
 * @ORM\Entity(repositoryClass="Uloc\Bundle\AppBundle\Repository\Pessoa\TipoIdentificadorRegistradoRepository")
 */
class TipoIdentificadorRegistrado extends TipoFinalidade
{

    const TIPO_BRAZIL_RG = 'system-1';
    const TIPO_PASSAPORTE = 'system-2';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=100)
     */
    private $nome;

    /**
     * Um Tipo tem Muitos Identificadores
     * @ORM\OneToMany(targetEntity="IdentificadorRegistrado", mappedBy="tipo", fetch="EXTRA_LAZY")
     */
    private $identificadores;

    public function __construct()
    {
        $this->identificadores = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getIdentificadores()
    {
        return $this->identificadores;
    }

    /**
     * @param IdentificadorRegistrado $identificador
     */
    public function addIdentificador(IdentificadorRegistrado $identificador)
    {
        $this->identificadores[] = $identificador;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nome
     *
     * @param string $nome
     *
     * @return TipoIdentificadorRegistrado
     */
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get nome
     *
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Add identificadore
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Pessoa\IdentificadorRegistrado $identificadore
     *
     * @return TipoIdentificadorRegistrado
     */
    public function addIdentificadore(\Uloc\Bundle\AppBundle\Entity\Pessoa\IdentificadorRegistrado $identificadore)
    {
        $this->identificadores[] = $identificadore;

        return $this;
    }

    /**
     * Remove identificadore
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Pessoa\IdentificadorRegistrado $identificadore
     */
    public function removeIdentificadore(\Uloc\Bundle\AppBundle\Entity\Pessoa\IdentificadorRegistrado $identificadore)
    {
        $this->identificadores->removeElement($identificadore);
    }
}
