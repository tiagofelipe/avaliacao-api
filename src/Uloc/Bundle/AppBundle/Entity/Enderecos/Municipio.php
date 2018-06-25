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
use Uloc\Bundle\AppBundle\Serializer\ApiRepresentationMetadataInterface;

/**
 * Municipio
 *
 * @ORM\Table(name="municipios")
 * @ORM\Entity(repositoryClass="Uloc\Bundle\AppBundle\Repository\Enderecos\MunicipioRepository")
 */
class Municipio
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
     * @ORM\Column(name="ibge", type="integer", length=7, nullable=true)
     */
    private $ibge;

    /**
     * Muitos Municipios tem Um UF.
     * @ORM\ManyToOne(targetEntity="UnidadeFederativa", inversedBy="municipios")
     * @ORM\JoinColumn(name="uf_id", referencedColumnName="id")
     */
    private $uf;


    /**
     * Um Municipio tem Muitos Bairros
     * @ORM\OneToMany(targetEntity="Bairro", mappedBy="municipio")
     */
    private $bairros;




    /**
     * Constructor
     */
    public function __construct()
    {
        $this->bairros = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Municipio
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
     * Set ibge.
     *
     * @param int|null $ibge
     *
     * @return Municipio
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
     * Set uf.
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Enderecos\UnidadeFederativa|null $uf
     *
     * @return Municipio
     */
    public function setUf(\Uloc\Bundle\AppBundle\Entity\Enderecos\UnidadeFederativa $uf = null)
    {
        $this->uf = $uf;

        return $this;
    }

    /**
     * Get uf.
     *
     * @return \Uloc\Bundle\AppBundle\Entity\Enderecos\UnidadeFederativa|null
     */
    public function getUf()
    {
        return $this->uf;
    }

    /**
     * Add bairro.
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Enderecos\Bairro $bairro
     *
     * @return Municipio
     */
    public function addBairro(\Uloc\Bundle\AppBundle\Entity\Enderecos\Bairro $bairro)
    {
        $this->bairros[] = $bairro;

        return $this;
    }

    /**
     * Remove bairro.
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Enderecos\Bairro $bairro
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeBairro(\Uloc\Bundle\AppBundle\Entity\Enderecos\Bairro $bairro)
    {
        return $this->bairros->removeElement($bairro);
    }

    /**
     * Get bairros.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBairros()
    {
        return $this->bairros;
    }


    public static function loadApiRepresentation(ApiRepresentationMetadataInterface $representation)
    {
        $representation->setGroup('public')
            ->addProperties([
                'id',
                'nome',
                'ibge',
                ]);
        $representation->build();
    }
}
