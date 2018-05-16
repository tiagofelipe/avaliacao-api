<?php

namespace Uloc\Bundle\AppBundle\Entity\Pessoa;

use Doctrine\ORM\Mapping as ORM;

/**
 * AnotacaoHistorico
 *
 * @ORM\Table(name="pessoa_anotacao_historico")
 * @ORM\Entity(repositoryClass="Uloc\Bundle\AppBundle\Repository\Pessoa\AnotacaoHistoricoRepository")
 */
class AnotacaoHistorico
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
     * @ORM\Column(name="data", type="datetime")
     */
    private $data;

    /**
     * @var \stdClass
     *
     * @ORM\Column(name="objAnterior", type="object")
     */
    private $objAnterior;

    /**
     * Muitos Historicos tem Um Anotacao.
     * @ORM\ManyToOne(targetEntity="Anotacao", inversedBy="historicos")
     * @ORM\JoinColumn(name="anotacao_id", referencedColumnName="id")
     */
    private $anotacao;

    /**
     * @return mixed
     */
    public function getAnotacao()
    {
        return $this->anotacao;
    }

    /**
     * @param Anotacao $anotacao
     */
    public function setAnotacao(Anotacao $anotacao)
    {
        $this->anotacao = $anotacao;
    }

    /**
     * Muitos AnotacoesHistoricoAlteracoes tem Um Pessoa.
     * @ORM\ManyToOne(targetEntity="Pessoa", inversedBy="anotacoesHistoricoAlteracoes")
     * @ORM\JoinColumn(name="pessoa_id", referencedColumnName="id")
     */
    private $pessoa;

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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set data
     *
     * @param \DateTime $data
     *
     * @return AnotacaoHistorico
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return \DateTime
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set objAnterior
     *
     * @param \stdClass $objAnterior
     *
     * @return AnotacaoHistorico
     */
    public function setObjAnterior($objAnterior)
    {
        $this->objAnterior = $objAnterior;

        return $this;
    }

    /**
     * Get objAnterior
     *
     * @return \stdClass
     */
    public function getObjAnterior()
    {
        return $this->objAnterior;
    }
}
