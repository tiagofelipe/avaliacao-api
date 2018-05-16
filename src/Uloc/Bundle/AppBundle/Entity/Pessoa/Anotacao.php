<?php

namespace Uloc\Bundle\AppBundle\Entity\Pessoa;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Anotacao
 *
 * @ORM\Table(name="pessoa_anotacao")
 * @ORM\Entity(repositoryClass="Uloc\Bundle\AppBundle\Repository\Pessoa\AnotacaoRepository")
 */
class Anotacao
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
     * @var \DateTime
     *
     * @ORM\Column(name="dataCriacao", type="datetime")
     */
    private $dataCriacao;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dataAlteracao", type="datetime", nullable=true)
     */
    private $dataAlteracao;

    /**
     * @var string
     *
     * @ORM\Column(name="anotacao", type="text", nullable=true)
     */
    private $anotacao;

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=50, nullable=true)
     */
    private $label;

    /**
     * Muitos Anotacoes tem Um Pessoa.
     * @ORM\ManyToOne(targetEntity="Pessoa", inversedBy="anotacoes")
     * @ORM\JoinColumn(name="pessoa_id", referencedColumnName="id")
     */
    private $pessoa;

    /**
     * Um Anotacoes tem Muitos Historicos
     * @ORM\OneToMany(targetEntity="AnotacaoHistorico", mappedBy="anotacao")
     */
    private $historicos;

    public function __construct()
    {
        $this->historicos = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getPessoa()
    {
        return $this->pessoa;
    }

    /**
     * @param Pessoa $pessoa
     */
    public function setPessoa(Pessoa $pessoa)
    {
        $this->pessoa = $pessoa;
    }

    /**
     * @return mixed
     */
    public function getHistoricos()
    {
        return $this->historicos;
    }

    /**
     * @param AnotacaoHistorico $historico
     */
    public function addHistorico(AnotacaoHistorico $historico)
    {
        $this->historicos[] = $historico;
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
     * Set dataCriacao
     *
     * @param \DateTime $dataCriacao
     *
     * @return Anotacao
     */
    public function setDataCriacao($dataCriacao)
    {
        $this->dataCriacao = $dataCriacao;

        return $this;
    }

    /**
     * Get dataCriacao
     *
     * @return \DateTime
     */
    public function getDataCriacao()
    {
        return $this->dataCriacao;
    }

    /**
     * Set dataAlteracao
     *
     * @param \DateTime $dataAlteracao
     *
     * @return Anotacao
     */
    public function setDataAlteracao($dataAlteracao)
    {
        $this->dataAlteracao = $dataAlteracao;

        return $this;
    }

    /**
     * Get dataAlteracao
     *
     * @return \DateTime
     */
    public function getDataAlteracao()
    {
        return $this->dataAlteracao;
    }

    /**
     * Set anotacao
     *
     * @param string $anotacao
     *
     * @return Anotacao
     */
    public function setAnotacao($anotacao)
    {
        $this->anotacao = $anotacao;

        return $this;
    }

    /**
     * Get anotacao
     *
     * @return string
     */
    public function getAnotacao()
    {
        return $this->anotacao;
    }

    /**
     * Set label
     *
     * @param string $label
     *
     * @return Anotacao
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get label
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Remove historico
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Pessoa\AnotacaoHistorico $historico
     */
    public function removeHistorico(\Uloc\Bundle\AppBundle\Entity\Pessoa\AnotacaoHistorico $historico)
    {
        $this->historicos->removeElement($historico);
    }
}
