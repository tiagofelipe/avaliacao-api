<?php

namespace Uloc\Bundle\AppBundle\Entity\Pessoa;

use Doctrine\ORM\Mapping as ORM;

/**
 * PessoaCampoExtra
 *
 * @ORM\Table(name="pessoa_pessoa_campo_extra")
 * @ORM\Entity(repositoryClass="Uloc\Bundle\AppBundle\Repository\Pessoa\PessoaCampoExtraRepository")
 */
class PessoaCampoExtra
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
     * @var string
     *
     * @ORM\Column(name="valor", type="text", nullable=true)
     */
    private $valor;


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
     * Muitos CamposExtras tem Um Pessoa.
     * @ORM\ManyToOne(targetEntity="Pessoa", inversedBy="camposExtras")
     * @ORM\JoinColumn(name="pessoa_id", referencedColumnName="id")
     */
    private $pessoa;

    /**
     * Muitos CamposPreenchidos tem Um CampoExtra.
     * @ORM\ManyToOne(targetEntity="CampoExtra", inversedBy="camposPreenchidos", cascade={"persist"})
     * @ORM\JoinColumn(name="campo_extra_id", referencedColumnName="id")
     */
    private $campoExtra;

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
    public function getCampoExtra()
    {
        return $this->campoExtra;
    }

    /**
     * @param CampoExtra $campoExtra
     */
    public function setCampoExtra(CampoExtra $campoExtra)
    {
        $this->campoExtra = $campoExtra;
    }

    /**
     * Set valor
     *
     * @param string $valor
     *
     * @return PessoaCampoExtra
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor
     *
     * @return string
     */
    public function getValor()
    {
        return $this->valor;
    }
}
