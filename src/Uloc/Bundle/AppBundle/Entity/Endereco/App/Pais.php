<?php
/**
 * Este arquivo é parte do código fonte Uloc
 *
 * (c) Tiago Felipe <tiago@tiagofelipe.com>
 *
 * Para informações completas dos direitos autorais, por favor veja o arquivo LICENSE
 * distribuído junto com o código fonte.
 */

namespace Uloc\Bundle\AppBundle\Entity\Endereco\App;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Pais
 *
 * @ORM\Table(name="pais")
 * @ORM\Entity(repositoryClass="Uloc\Bundle\AppBundle\Repository\App\PaisRepository")
 */
class Pais
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
     * @ORM\Column(name="nome_global", type="string", length=100, nullable=true)
     */
    private $nomeGlobal;

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=50)
     */
    private $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="sigla", type="string", length=5, nullable=true)
     */
    private $sigla;

    /**
     * @ORM\OneToMany(targetEntity="UnidadeFederativa", mappedBy="pais")
     */
    private $ufs;

    /**
     * @var string
     *
     * @ORM\Column(name="bacen", type="integer", length=5, nullable=true)
     */
    private $bacen;

    /**
     * Pais constructor.
     */
    public function __construct()
    {
        $this->ufs = new ArrayCollection();
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
     * Set nome
     *
     * @param string $nome
     *
     * @return Pais
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
     * Set sigla
     *
     * @param string $sigla
     *
     * @return Pais
     */
    public function setSigla($sigla)
    {
        $this->sigla = $sigla;

        return $this;
    }

    /**
     * Get sigla
     *
     * @return string
     */
    public function getSigla()
    {
        return $this->sigla;
    }

    /**
     * @return mixed
     */
    public function getUfs()
    {
        return $this->ufs;
    }

    /**
     * @param UnidadeFederativa $uf
     */
    public function addUf(UnidadeFederativa $uf)
    {
        $this->ufs[] = $uf;
    }

    /**
     * @return string
     */
    public function getNomeGlobal()
    {
        return $this->nomeGlobal;
    }

    /**
     * @param string $nomeGlobal
     */
    public function setNomeGlobal($nomeGlobal)
    {
        $this->nomeGlobal = $nomeGlobal;
    }

    /**
     * @return string
     */
    public function getBacen()
    {
        return $this->bacen;
    }

    /**
     * @param string $bacen
     */
    public function setBacen($bacen)
    {
        $this->bacen = $bacen;
    }


    /**
     * Remove uf
     *
     * @param \Uloc\Bundle\AppBundle\Entity\App\UnidadeFederativa $uf
     */
    public function removeUf(\Uloc\Bundle\AppBundle\Entity\App\UnidadeFederativa $uf)
    {
        $this->ufs->removeElement($uf);
    }
}
