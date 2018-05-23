<?php

namespace Uloc\Bundle\AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Uloc\Bundle\AppBundle\Serializer\ApiRepresentationMetadataInterface;


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
     * @ORM\Column(name="logo", type="string", length=255, nullable=true)
     */
    private $logo;

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
     * @ORM\OneToMany(targetEntity="CriterioEstabelecimento", mappedBy="estabelecimento" )
     *
     */
    private $criterioEstabelecimentos;

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
        $this->criterioEstabelecimentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->avaliacaos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->funcionarios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->proprietarios = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set logo.
     *
     * @param string $logo
     *
     * @return Estabelecimento
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo.
     *
     * @return string
     */
    public function getlogo()
    {
        return $this->logo;
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
     * Add criterioEstabelecimento.
     *
     * @param \Uloc\Bundle\AppBundle\Entity\CriterioEstabelecimento $criterioEstabelecimento
     *
     * @return Estabelecimento
     */
    public function addCriterioEstabelecimento(\Uloc\Bundle\AppBundle\Entity\CriterioEstabelecimento $criterioEstabelecimento)
    {
        $this->criterioEstabelecimentos[] = $criterioEstabelecimento;

        return $this;
    }

    /**
     * Remove criterioEstabelecimento.
     *
     * @param \Uloc\Bundle\AppBundle\Entity\CriterioEstabelecimento $criterioEstabelecimento
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeCriterioEstabelecimento(\Uloc\Bundle\AppBundle\Entity\CriterioEstabelecimento $criterioEstabelecimento)
    {
        return $this->criterioEstabelecimentos->removeElement($criterioEstabelecimento);
    }

    /**
     * Get criterioEstabelecimentos.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCriterioEstabelecimentos()
    {
        return $this->criterioEstabelecimentos;
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
     * Add proprietario.
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Usuario $proprietario
     *
     * @return Estabelecimento
     */
    public function addProprietario(\Uloc\Bundle\AppBundle\Entity\Usuario $proprietario)
    {
        $this->proprietarios[] = $proprietario;

        return $this;
    }

    /**
     * Remove proprietario.
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Usuario $proprietario
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeProprietario(\Uloc\Bundle\AppBundle\Entity\Usuario $proprietario)
    {
        return $this->proprietarios->removeElement($proprietario);
    }

    /**
     * Get proprietarios.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProprietarios()
    {
        return $this->proprietarios;
    }

    public static function loadApiRepresentation(ApiRepresentationMetadataInterface $representation)
    {
        $representation->setGroup('public')
            ->addProperties([
                'id',
                'cnpj',
                'nomeFantasia',
                'razaoSocial',
                'tipo',
                'avaliacaos as avaliacoes'=>
                    array('id','comentario','dataCriacao','nota', 'usuario'=>
                        array('nome','id'))
                ]);
        $representation->build();
    }
}
