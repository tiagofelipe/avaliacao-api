<?php

namespace Uloc\Bundle\AppBundle\Entity;

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
     * @var int
     *
     *
     */
    private $CriterioEstabelecimento;


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
}