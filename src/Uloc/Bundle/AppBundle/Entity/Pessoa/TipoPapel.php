<?php
/**
 * Este arquivo é parte do código fonte Uloc
 *
 * (c) Tiago Felipe <tiago@tiagofelipe.com>
 *
 * Para informações completas dos direitos autorais, por favor veja o arquivo LICENSE
 * distribuído junto com o código fonte.
 */

/**
 * Este arquivo é parte do código fonte Uloc
 *
 * (c) Tiago Felipe <tiago@tiagofelipe.com>
 *
 * Para informações completas dos direitos autorais, por favor veja o arquivo LICENSE
 * distribuído junto com o código fonte.
 */

namespace Uloc\Bundle\AppBundle\Entity\Pessoa;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * TipoPapel
 *
 * @ORM\Table(name="pessoa_tipo_papel")
 * @ORM\Entity(repositoryClass="Uloc\Bundle\AppBundle\Repository\Pessoa\TipoPapelRepository")
 */
class TipoPapel
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
     * @ORM\Column(name="codigo", type="string", length=20, unique=true)
     */
    private $codigo;

    /**
     * @var string
     *
     * @ORM\Column(name="descricao", type="string", length=255)
     */
    private $descricao;

    /**
     * Um TipoPapel tem Muitos Papeis
     * @ORM\OneToMany(targetEntity="Papel", mappedBy="tipoPapel")
     */
    private $papeis;

    public function __construct()
    {
        $this->papeis = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getPapeis()
    {
        return $this->papeis;
    }

    /**
     * @param Papel $papel
     */
    public function addPapel(Papel $papel)
    {
        $this->papeis[] = $papel;
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
     * @return TipoPapel
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
     * Set descricao
     *
     * @param string $descricao
     *
     * @return TipoPapel
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
     * Add papei
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Pessoa\Papel $papei
     *
     * @return TipoPapel
     */
    public function addPapei(\Uloc\Bundle\AppBundle\Entity\Pessoa\Papel $papei)
    {
        $this->papeis[] = $papei;

        return $this;
    }

    /**
     * Remove papei
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Pessoa\Papel $papei
     */
    public function removePapei(\Uloc\Bundle\AppBundle\Entity\Pessoa\Papel $papei)
    {
        $this->papeis->removeElement($papei);
    }
}
