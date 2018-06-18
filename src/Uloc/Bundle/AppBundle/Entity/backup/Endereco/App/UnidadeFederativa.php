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
 * UnidadeFederativa
 *
 * @ORM\Table(name="unidade_federativa")
 * @ORM\Entity(repositoryClass="Uloc\Bundle\AppBundle\Repository\App\UnidadeFederativaRepository")
 */
class UnidadeFederativa
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
     * @ORM\Column(name="nome", type="string", length=100)
     */
    private $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="sigla", type="string", length=20, nullable=true)
     */
    private $sigla;

    /**
     * @var string
     *
     * @ORM\Column(name="ibge", type="integer", length=2, nullable=true)
     */
    private $ibge;

    /**
     * @var string
     *
     * @ORM\Column(name="ddd", type="string", length=50, nullable=true)
     */
    private $ddd;

    /**
     * Many UFs have One Country.
     * @ORM\ManyToOne(targetEntity="Pais", inversedBy="ufs")
     * @ORM\JoinColumn(name="pais_id", referencedColumnName="id")
     */
    private $pais;

    /**
     * Um UF tem Muitos Municipios
     * @ORM\OneToMany(targetEntity="Municipio", mappedBy="uf")
     */
    private $municipios;

    /**
     * constructor.
     */
    public function __construct()
    {
        $this->municipios = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getMunicipios()
    {
        return $this->municipios;
    }

    /**
     * @param Municipio $municipio
     */
    public function addMunicipios(Municipio $municipio)
    {
        $this->municipios[] = $municipio;
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
     * @return UnidadeFederativa
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
     * @return UnidadeFederativa
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
    public function getPais()
    {
        return $this->pais;
    }

    /**
     * @param Pais $pais
     */
    public function setPais(Pais $pais)
    {
        $this->pais = $pais;
    }

    /**
     * @return string
     */
    public function getIbge()
    {
        return $this->ibge;
    }

    /**
     * @param string $ibge
     */
    public function setIbge($ibge)
    {
        $this->ibge = $ibge;
    }

    /**
     * @return string
     */
    public function getDdd()
    {
        return $this->ddd;
    }

    /**
     * @param string $ddd
     */
    public function setDdd($ddd)
    {
        $this->ddd = $ddd;
    }


    /**
     * Add municipio
     *
     * @param \Uloc\Bundle\AppBundle\Entity\App\Municipio $municipio
     *
     * @return UnidadeFederativa
     */
    public function addMunicipio(\Uloc\Bundle\AppBundle\Entity\App\Municipio $municipio)
    {
        $this->municipios[] = $municipio;

        return $this;
    }

    /**
     * Remove municipio
     *
     * @param \Uloc\Bundle\AppBundle\Entity\App\Municipio $municipio
     */
    public function removeMunicipio(\Uloc\Bundle\AppBundle\Entity\App\Municipio $municipio)
    {
        $this->municipios->removeElement($municipio);
    }
}
