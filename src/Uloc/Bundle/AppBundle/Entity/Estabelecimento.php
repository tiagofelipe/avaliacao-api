<?php

namespace Uloc\Bundle\AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;


/**
 * Estabelecimento
 *
 * @ORM\Table(name="estabelecimento")
 * @ORM\Entity(repositoryClass="Uloc\Bundle\AppBundle\Repository\EstabelecimentoRepository")
 */
class Estabelecimento
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
     * @ORM\Column(name="cnpj", type="string", length=14, unique=true)
     */
    private $cnpj;

    /**
     * @var string
     *
     * @ORM\Column(name="nome_fantasia", type="string", length=255)
     */
    private $nomeFantasia;

    /**
     * @var string
     *
     * @ORM\Column(name="razao_social", type="string", length=255)
     */
    private $razaoSocial;

    /**
     * @var int|null
     *
     * @ORM\Column(name="tipo", type="smallint", nullable=true)
     */
    private $tipo;


    /**
     * @var CriterioEstabelecimento
     *
     * @ORM\ManyToOne(targetEntity="CriterioEstabelecimento", inversedBy="estabelecimentos" )
     * @ORM\JoinColumn(name="criterio_estabelecimento_id", referencedColumnName="id" )
     */
    private $criterioEstabelecimento;

    /**
     * @var Avaliacao
     *
     * @ORM\OneToMany(targetEntity="Avaliacao", mappedBy="estabelecimento")
     */
    private $avaliacaos;

    /**
     * @var Funcionario[]
     * @ORM\OneToMany(targetEntity="Funcionario", mappedBy="estabelecimento")
     */
    private $funcionarios;

    /**
     * @var Usuario[]
     *
     * @ORM\ManyToMany(targetEntity="Uloc\Bundle\AppBundle\Entity\Usuario", mappedBy="estabelecimentos")
     */
    private $proprietarios;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->avaliacaos = new ArrayCollection();
        $this->funcionarios = new ArrayCollection();
        $this->proprietarios = new ArrayCollection();
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
     * Set cnpj.
     *
     * @param string $cnpj
     *
     * @return Estabelecimento
     */
    public function setCnpj($cnpj)
    {
        $this->cnpj = $cnpj;

        return $this;
    }

    /**
     * Get cnpj.
     *
     * @return string
     */
    public function getCnpj()
    {
        return $this->cnpj;
    }

    /**
     * Set nomeFantasia.
     *
     * @param string $nomeFantasia
     *
     * @return Estabelecimento
     */
    public function setNomeFantasia($nomeFantasia)
    {
        $this->nomeFantasia = $nomeFantasia;

        return $this;
    }

    /**
     * Get nomeFantasia.
     *
     * @return string
     */
    public function getNomeFantasia()
    {
        return $this->nomeFantasia;
    }

    /**
     * Set razaoSocial.
     *
     * @param string $razaoSocial
     *
     * @return Estabelecimento
     */
    public function setRazaoSocial($razaoSocial)
    {
        $this->razaoSocial = $razaoSocial;

        return $this;
    }

    /**
     * Get razaoSocial.
     *
     * @return string
     */
    public function getRazaoSocial()
    {
        return $this->razaoSocial;
    }

    /**
     * Set tipo.
     *
     * @param int|null $tipo
     *
     * @return Estabelecimento
     */
    public function setTipo($tipo = null)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo.
     *
     * @return int|null
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set criterioEstabelecimento.
     *
     * @param \Uloc\Bundle\AppBundle\Entity\CriterioEstabelecimento|null $criterioEstabelecimento
     *
     * @return Estabelecimento
     */
    public function setCriterioEstabelecimento(\Uloc\Bundle\AppBundle\Entity\CriterioEstabelecimento $criterioEstabelecimento = null)
    {
        $this->criterioEstabelecimento = $criterioEstabelecimento;

        return $this;
    }

    /**
     * Get criterioEstabelecimento.
     *
     * @return CriterioEstabelecimento
     */
    public function getCriterioEstabelecimento()
    {
        return $this->criterioEstabelecimento;
    }


    /**
     * Add avaliacao.
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Avaliacao $avaliacao
     *
     * @return Estabelecimento
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

    /**
     * Add funcionario.
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Funcionario $funcionario
     *
     * @return Estabelecimento
     */
    public function addFuncionario(\Uloc\Bundle\AppBundle\Entity\Funcionario $funcionario)
    {
        $this->funcionarios[] = $funcionario;

        return $this;
    }

    /**
     * Remove funcionario.
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Funcionario $funcionario
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeFuncionario(\Uloc\Bundle\AppBundle\Entity\Funcionario $funcionario)
    {
        return $this->funcionarios->removeElement($funcionario);
    }

    /**
     * Get funcionarios.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFuncionarios()
    {
        return $this->funcionarios;
    }

    /**
     * @return Usuario[]
     */
    public function getProprietarios()
    {
        return $this->proprietarios;
    }

    /**
     * @param Usuario $proprietario
     */
    public function addProprietario(Usuario $proprietario)
    {
        $this->proprietarios[] = $proprietario;
    }
}
