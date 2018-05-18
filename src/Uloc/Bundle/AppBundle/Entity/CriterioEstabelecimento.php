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
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Criterio[]
     *
     * @ORM\OneToMany(targetEntity="Criterio", mappedBy="estabelecimentoCriterio")
     */
    private $criterios;



    /**
     * @var Estabelecimento[]
     * @ORM\OneToMany(targetEntity="Estabelecimento", mappedBy="criterioEstabelecimento")
     */
    private  $estabelecimentos;


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
        $this->criterios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->estabelecimentos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add criterio.
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Criterio $criterio
     *
     * @return CriterioEstabelecimento
     */
    public function addCriterio(\Uloc\Bundle\AppBundle\Entity\Criterio $criterio)
    {
        $this->criterios[] = $criterio;

        return $this;
    }

    /**
     * Remove criterio.
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Criterio $criterio
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeCriterio(\Uloc\Bundle\AppBundle\Entity\Criterio $criterio)
    {
        return $this->criterios->removeElement($criterio);
    }

    /**
     * Get criterios.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCriterios()
    {
        return $this->criterios;
    }

    /**
     * Add estabelecimento.
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Estabelecimento $estabelecimento
     *
     * @return CriterioEstabelecimento
     */
    public function addEstabelecimento(\Uloc\Bundle\AppBundle\Entity\Estabelecimento $estabelecimento)
    {
        $this->estabelecimentos[] = $estabelecimento;

        return $this;
    }

    /**
     * Remove estabelecimento.
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Estabelecimento $estabelecimento
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeEstabelecimento(\Uloc\Bundle\AppBundle\Entity\Estabelecimento $estabelecimento)
    {
        return $this->estabelecimentos->removeElement($estabelecimento);
    }

    /**
     * Get estabelecimentos.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEstabelecimentos()
    {
        return $this->estabelecimentos;
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
