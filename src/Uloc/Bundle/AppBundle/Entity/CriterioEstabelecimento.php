<?php

namespace Uloc\Bundle\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CriterioEstabelecimento
 *
 * @ORM\Table(name="criterio_estabelecimento")
 * @ORM\Entity(repositoryClass="Uloc\Bundle\AppBundle\Repository\CriterioEstabelecimentoRepository")
 */
class CriterioEstabelecimento
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Criterio
     *
     * @ORM\ManyToOne(targetEntity="Criterio", inversedBy="estabelecimentoCriterios")
     */
    private $criterio;



    /**
     * @var Estabelecimento
     * @ORM\ManyToOne(targetEntity="Estabelecimento", inversedBy="criterioEstabelecimentos")
     */
    private  $estabelecimento;


    /**
     * @var Avaliacao[]
     * @ORM\OneToMany(targetEntity="Avaliacao", mappedBy="criterioEstabelecimento")
     */
    private $avaliacaos;

    

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->avaliacaos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set criterio.
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Criterio|null $criterio
     *
     * @return CriterioEstabelecimento
     */
    public function setCriterio(\Uloc\Bundle\AppBundle\Entity\Criterio $criterio = null)
    {
        $this->criterio = $criterio;

        return $this;
    }

    /**
     * Get criterio.
     *
     * @return \Uloc\Bundle\AppBundle\Entity\Criterio|null
     */
    public function getCriterio()
    {
        return $this->criterio;
    }

    /**
     * Set estabelecimento.
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Estabelecimento|null $estabelecimento
     *
     * @return CriterioEstabelecimento
     */
    public function setEstabelecimento(\Uloc\Bundle\AppBundle\Entity\Estabelecimento $estabelecimento = null)
    {
        $this->estabelecimento = $estabelecimento;

        return $this;
    }

    /**
     * Get estabelecimento.
     *
     * @return \Uloc\Bundle\AppBundle\Entity\Estabelecimento|null
     */
    public function getEstabelecimento()
    {
        return $this->estabelecimento;
    }

    /**
     * Add avaliacao.
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Avaliacao $avaliacao
     *
     * @return CriterioEstabelecimento
     */
    public function addAvaliacao(\Uloc\Bundle\AppBundle\Entity\Avaliacao $avaliacao)
    {
        $this->avaliacaos[] = $avaliacao;

        return $this;
    }

    /**
     * Remove avaliacao.
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Avaliacao $avaliacao
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeAvaliacao(\Uloc\Bundle\AppBundle\Entity\Avaliacao $avaliacao)
    {
        return $this->avaliacaos->removeElement($avaliacao);
    }

    /**
     * Get avaliacaos.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAvaliacaos()
    {
        return $this->avaliacaos;
    }
}
