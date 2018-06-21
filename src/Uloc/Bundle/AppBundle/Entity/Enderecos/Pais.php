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
 * Pais
 *
 * @ORM\Table(name="paises")
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
     * Constructor
     */
    public function __construct()
    {
        $this->ufs = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set nomeGlobal.
     *
     * @param string|null $nomeGlobal
     *
     * @return Pais
     */
    public function setNomeGlobal($nomeGlobal = null)
    {
        $this->nomeGlobal = $nomeGlobal;

        return $this;
    }

    /**
     * Get nomeGlobal.
     *
     * @return string|null
     */
    public function getNomeGlobal()
    {
        return $this->nomeGlobal;
    }

    /**
     * Set nome.
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
     * @return Pais
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
     * Set bacen.
     *
     * @param int|null $bacen
     *
     * @return Pais
     */
    public function setBacen($bacen = null)
    {
        $this->bacen = $bacen;

        return $this;
    }

    /**
     * Get bacen.
     *
     * @return int|null
     */
    public function getBacen()
    {
        return $this->bacen;
    }

    /**
     * Add uf.
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Enderecos\UnidadeFederativa $uf
     *
     * @return Pais
     */
    public function addUf(\Uloc\Bundle\AppBundle\Entity\Enderecos\UnidadeFederativa $uf)
    {
        $this->ufs[] = $uf;

        return $this;
    }

    /**
     * Remove uf.
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Enderecos\UnidadeFederativa $uf
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeUf(\Uloc\Bundle\AppBundle\Entity\Enderecos\UnidadeFederativa $uf)
    {
        return $this->ufs->removeElement($uf);
    }

    /**
     * Get ufs.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUfs()
    {
        return $this->ufs;
    }

    public static function loadApiRepresentation(ApiRepresentationMetadataInterface $representation)
    {
        $representation->setGroup('public')
            ->addProperties([
                'id',
                'nome',
                'sigla',
                'ufs' => array(
                    'id',
                    'nome',
                    'sigla',
                    'ibge'
                )
            ]);
        $representation->build();
    }
}
