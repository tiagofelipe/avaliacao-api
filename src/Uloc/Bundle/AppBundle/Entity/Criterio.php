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
     * @var CriterioEstabelecimento
     *
     * @ORM\ManyToOne(targetEntity="CriterioEstabelecimento", inversedBy="criterios" )
     * @ORM\JoinColumn(name="estabelecimento_criterio_id", referencedColumnName="id" )
     */
    private $estabelecimentoCriterio;


    

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

    /**
     * Set estabelecimentoCriterio.
     *
     * @param \Uloc\Bundle\AppBundle\Entity\CriterioEstabelecimento|null $estabelecimentoCriterio
     *
     * @return Criterio
     */
    public function setEstabelecimentoCriterio(\Uloc\Bundle\AppBundle\Entity\CriterioEstabelecimento $estabelecimentoCriterio = null)
    {
        $this->estabelecimentoCriterio = $estabelecimentoCriterio;

        return $this;
    }

    /**
     * Get estabelecimentoCriterio.
     *
     * @return \Uloc\Bundle\AppBundle\Entity\CriterioEstabelecimento|null
     */
    public function getEstabelecimentoCriterio()
    {
        return $this->estabelecimentoCriterio;
    }
}
