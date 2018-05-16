<?php

namespace Uloc\Bundle\AppBundle\Entity\Pessoa;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * CampoExtra
 *
 * @ORM\Table(name="pessoa_campo_extra")
 * @ORM\Entity(repositoryClass="Uloc\Bundle\AppBundle\Repository\Pessoa\CampoExtraRepository")
 */
class CampoExtra
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
     * @ORM\Column(name="codigo", type="string", length=100, unique=true)
     */
    private $codigo;

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=255)
     */
    private $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="descricao", type="string", length=255, nullable=true)
     */
    private $descricao;

    /**
     * @var bool
     *
     * @ORM\Column(name="obrigatorio", type="boolean")
     */
    private $obrigatorio;

    /**
     * Um CampoExtra tem Muitos CamposPreenchidos
     * @ORM\OneToMany(targetEntity="PessoaCampoExtra", mappedBy="campoExtra", fetch="EXTRA_LAZY")
     */
    private $camposPreenchidos;

    public function __construct()
    {
        $this->camposPreenchidos = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getCamposPreenchidos()
    {
        return $this->camposPreenchidos;
    }

    /**
     * @param PessoaCampoExtra $campoPreenchido
     */
    public function addCampoPreenchido(PessoaCampoExtra $campoPreenchido)
    {
        $this->camposPreenchidos[] = $campoPreenchido;
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
     * Set codigo
     *
     * @param string $codigo
     *
     * @return CampoExtra
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo
     *
     * @return string
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set nome
     *
     * @param string $nome
     *
     * @return CampoExtra
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
     * Set descricao
     *
     * @param string $descricao
     *
     * @return CampoExtra
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;

        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Set obrigatorio
     *
     * @param boolean $obrigatorio
     *
     * @return CampoExtra
     */
    public function setObrigatorio($obrigatorio)
    {
        $this->obrigatorio = $obrigatorio;

        return $this;
    }

    /**
     * Get obrigatorio
     *
     * @return bool
     */
    public function getObrigatorio()
    {
        return $this->obrigatorio;
    }

    /**
     * Add camposPreenchido
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Pessoa\PessoaCampoExtra $camposPreenchido
     *
     * @return CampoExtra
     */
    public function addCamposPreenchido(\Uloc\Bundle\AppBundle\Entity\Pessoa\PessoaCampoExtra $camposPreenchido)
    {
        $this->camposPreenchidos[] = $camposPreenchido;

        return $this;
    }

    /**
     * Remove camposPreenchido
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Pessoa\PessoaCampoExtra $camposPreenchido
     */
    public function removeCamposPreenchido(\Uloc\Bundle\AppBundle\Entity\Pessoa\PessoaCampoExtra $camposPreenchido)
    {
        $this->camposPreenchidos->removeElement($camposPreenchido);
    }

    public function __toString()
    {
        return $this->nome;
    }
}
