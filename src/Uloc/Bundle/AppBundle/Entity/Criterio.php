<?php

namespace Uloc\Bundle\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Uloc\Bundle\AppBundle\Serializer\ApiRepresentationMetadataInterface;

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
     * @var CriterioEstabelecimento[]
     *
     * @ORM\OneToMany(targetEntity="CriterioEstabelecimento", mappedBy="criterio" )
     *
     */
    private $estabelecimentoCriterios;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->estabelecimentoCriterios = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Add estabelecimentoCriterio.
     *
     * @param \Uloc\Bundle\AppBundle\Entity\CriterioEstabelecimento $estabelecimentoCriterio
     *
     * @return Criterio
     */
    public function addEstabelecimentoCriterio(\Uloc\Bundle\AppBundle\Entity\CriterioEstabelecimento $estabelecimentoCriterio)
    {
        $this->estabelecimentoCriterios[] = $estabelecimentoCriterio;

        return $this;
    }

    /**
     * Remove estabelecimentoCriterio.
     *
     * @param \Uloc\Bundle\AppBundle\Entity\CriterioEstabelecimento $estabelecimentoCriterio
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeEstabelecimentoCriterio(\Uloc\Bundle\AppBundle\Entity\CriterioEstabelecimento $estabelecimentoCriterio)
    {
        return $this->estabelecimentoCriterios->removeElement($estabelecimentoCriterio);
    }

    /**
     * Get estabelecimentoCriterios.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEstabelecimentoCriterios()
    {
        return $this->estabelecimentoCriterios;
    }

    public static function loadApiRepresentation(ApiRepresentationMetadataInterface $representation)
    {
        $representation->setGroup('public')
            ->addProperties([
                'id',
                'nome',
                'ativo',

            ]);
        $representation->build();
    }
}