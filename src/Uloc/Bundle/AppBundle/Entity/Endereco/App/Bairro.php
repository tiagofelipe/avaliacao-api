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
 * Bairro
 *
 * @ORM\Table(name="app_bairro")
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
     * @ORM\OneToMany(targetEntity="Endereco", mappedBy="bairro")
     */
    private $enderecos;

    /**
     * Bairro constructor.
     */
    public function __construct()
    {
        $this->enderecos = new ArrayCollection();
    }


    /**
     * @return mixed
     */
    public function getEnderecos()
    {
        return $this->enderecos;
    }

    /**
     * @param Endereco $endereco
     */
    public function addEndereco(Endereco $endereco)
    {
        $this->enderecos[] = $endereco;
    }

    /**
     * @return mixed
     */
    public function getMunicipio()
    {
        return $this->municipio;
    }

    /**
     * @param Municipio $municipio
     */
    public function setMunicipio(Municipio $municipio)
    {
        $this->municipio = $municipio;
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
     * @return Bairro
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
     * Remove endereco
     *
     * @param \Uloc\Bundle\AppBundle\Entity\App\Endereco $endereco
     */
    public function removeEndereco(\Uloc\Bundle\AppBundle\Entity\App\Endereco $endereco)
    {
        $this->enderecos->removeElement($endereco);
    }
}
