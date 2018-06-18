<?php
/**
 * Este arquivo é parte do código fonte Uloc
 *
 * (c) Tiago Felipe <tiago@tiagofelipe.com>
 *
 * Para informações completas dos direitos autorais, por favor veja o arquivo LICENSE
 * distribuído junto com o código fonte.
 */

namespace Uloc\Bundle\AppBundle\Entity\Enderecos;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * UnidadeFederativa
 *
 * @ORM\Table(name="unidades_federativas")
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
     * Constructor
     */
    public function __construct()
    {
        $this->municipios = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set nome.
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
     * Get nome.
     *
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set sigla.
     *
     * @param string|null $sigla
     *
     * @return UnidadeFederativa
     */
    public function setSigla($sigla = null)
    {
        $this->sigla = $sigla;

        return $this;
    }

    /**
     * Get sigla.
     *
     * @return string|null
     */
    public function getSigla()
    {
        return $this->sigla;
    }

    /**
     * Set ibge.
     *
     * @param int|null $ibge
     *
     * @return UnidadeFederativa
     */
    public function setIbge($ibge = null)
    {
        $this->ibge = $ibge;

        return $this;
    }

    /**
     * Get ibge.
     *
     * @return int|null
     */
    public function getIbge()
    {
        return $this->ibge;
    }

    /**
     * Set ddd.
     *
     * @param string|null $ddd
     *
     * @return UnidadeFederativa
     */
    public function setDdd($ddd = null)
    {
        $this->ddd = $ddd;

        return $this;
    }

    /**
     * Get ddd.
     *
     * @return string|null
     */
    public function getDdd()
    {
        return $this->ddd;
    }

    /**
     * Set pais.
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Enderecos\Pais|null $pais
     *
     * @return UnidadeFederativa
     */
    public function setPais(\Uloc\Bundle\AppBundle\Entity\Enderecos\Pais $pais = null)
    {
        $this->pais = $pais;

        return $this;
    }

    /**
     * Get pais.
     *
     * @return \Uloc\Bundle\AppBundle\Entity\Enderecos\Pais|null
     */
    public function getPais()
    {
        return $this->pais;
    }

    /**
     * Add municipio.
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Enderecos\Municipio $municipio
     *
     * @return UnidadeFederativa
     */
    public function addMunicipio(\Uloc\Bundle\AppBundle\Entity\Enderecos\Municipio $municipio)
    {
        $this->municipios[] = $municipio;

        return $this;
    }

    /**
     * Remove municipio.
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Enderecos\Municipio $municipio
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeMunicipio(\Uloc\Bundle\AppBundle\Entity\Enderecos\Municipio $municipio)
    {
        return $this->municipios->removeElement($municipio);
    }

    /**
     * Get municipios.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMunicipios()
    {
        return $this->municipios;
    }
}
