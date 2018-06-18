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
 * Bairro
 *
 * @ORM\Table(name="bairros")
 * @ORM\Entity(repositoryClass="Uloc\Bundle\AppBundle\Repository\App\BairroRepository")
 */
class Bairro
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
     * @ORM\Column(name="nome", type="string", length=255)
     */
    private $nome;

    /**
     * Muitos Bairros tem Um Municipio.
     * @ORM\ManyToOne(targetEntity="Municipio", inversedBy="bairros")
     * @ORM\JoinColumn(name="municipio_id", referencedColumnName="id")
     */
    private $municipio;

    /**
     * Um Bairro tem Muitos Enderecos
     * @ORM\OneToMany(targetEntity="Logradouro", mappedBy="bairro")
     */
    private $logradouros;



    /**
     * Constructor
     */
    public function __construct()
    {
        $this->logradouros = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Bairro
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
     * Set municipio.
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Enderecos\Municipio|null $municipio
     *
     * @return Bairro
     */
    public function setMunicipio(\Uloc\Bundle\AppBundle\Entity\Enderecos\Municipio $municipio = null)
    {
        $this->municipio = $municipio;

        return $this;
    }

    /**
     * Get municipio.
     *
     * @return \Uloc\Bundle\AppBundle\Entity\Enderecos\Municipio|null
     */
    public function getMunicipio()
    {
        return $this->municipio;
    }

    /**
     * Add logradouro.
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Enderecos\Logradouro $logradouro
     *
     * @return Bairro
     */
    public function addLogradouro(\Uloc\Bundle\AppBundle\Entity\Enderecos\Logradouro $logradouro)
    {
        $this->logradouros[] = $logradouro;

        return $this;
    }

    /**
     * Remove logradouro.
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Enderecos\Logradouro $logradouro
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeLogradouro(\Uloc\Bundle\AppBundle\Entity\Enderecos\Logradouro $logradouro)
    {
        return $this->logradouros->removeElement($logradouro);
    }

    /**
     * Get logradouros.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLogradouros()
    {
        return $this->logradouros;
    }
}
