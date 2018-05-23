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
use Uloc\Bundle\AppBundle\Entity\Pessoa\EnderecoFisico;

/**
 * Municipio
 *
 * @ORM\Table(name="municipio")
 * @ORM\Entity(repositoryClass="Uloc\Bundle\AppBundle\Repository\App\MunicipioRepository")
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
     * Um Municipio tem Muitos Configuracoes
     * @ORM\OneToMany(targetEntity="ConfigMunicipio", mappedBy="municipio")
     */
    private $configuracoes;

    /**
     * Um Municipio tem Muitos Bairros
     * @ORM\OneToMany(targetEntity="Bairro", mappedBy="municipio")
     */
    private $bairros;

    /**
     * Um Municipio tem Muitos Enderecos
     * @ORM\OneToMany(targetEntity="Uloc\Bundle\AppBundle\Entity\Pessoa\EnderecoFisico", mappedBy="municipio")
     */
    private $enderecos;

    /**
     * @return mixed
     */
    public function getEnderecos()
    {
        return $this->enderecos;
    }

    /**
     * @param mixed $enderecos
     */
    public function addEnderecos(EnderecoFisico $enderecos)
    {
        $this->enderecos[] = $enderecos;
    }


    /**
     * @return mixed
     */
    public function getBairros()
    {
        return $this->bairros;
    }

    /**
     * @param Bairro $bairro
     */
    public function addBairro(Bairro $bairro)
    {
        $this->bairros[] = $bairro;
    }

    /**
     * Municipio constructor.
     */
    public function __construct()
    {
        $this->configuracoes = new ArrayCollection();
        $this->bairros = new ArrayCollection();
        $this->enderecos  =  new  ArrayCollection ();
    }


    /**
     * @return mixed
     */
    public function getConfiguracoes()
    {
        return $this->configuracoes;
    }

    /**
     * @param ConfigMunicipio $configuracao
     */
    public function addConfiguracao(ConfigMunicipio $configuracao)
    {
        $this->configuracoes[] = $configuracao;
    }

    /**
     * @return mixed
     */
    public function getUf()
    {
        return $this->uf;
    }

    /**
     * @param UnidadeFederativa $uf
     */
    public function setUf(UnidadeFederativa $uf)
    {
        $this->uf = $uf;
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
     * @return Municipio
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
     * Add configuraco
     *
     * @param \Uloc\Bundle\AppBundle\Entity\App\ConfigMunicipio $configuraco
     *
     * @return Municipio
     */
    public function addConfiguraco(\Uloc\Bundle\AppBundle\Entity\App\ConfigMunicipio $configuraco)
    {
        $this->configuracoes[] = $configuraco;

        return $this;
    }

    /**
     * Remove configuraco
     *
     * @param \Uloc\Bundle\AppBundle\Entity\App\ConfigMunicipio $configuraco
     */
    public function removeConfiguraco(\Uloc\Bundle\AppBundle\Entity\App\ConfigMunicipio $configuraco)
    {
        $this->configuracoes->removeElement($configuraco);
    }

    /**
     * Remove bairro
     *
     * @param \Uloc\Bundle\AppBundle\Entity\App\Bairro $bairro
     */
    public function removeBairro(\Uloc\Bundle\AppBundle\Entity\App\Bairro $bairro)
    {
        $this->bairros->removeElement($bairro);
    }

    /**
     * Add endereco
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Pessoa\EnderecoFisico $endereco
     *
     * @return Municipio
     */
    public function addEndereco(\Uloc\Bundle\AppBundle\Entity\Pessoa\EnderecoFisico $endereco)
    {
        $this->enderecos[] = $endereco;

        return $this;
    }

    /**
     * Remove endereco
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Pessoa\EnderecoFisico $endereco
     */
    public function removeEndereco(\Uloc\Bundle\AppBundle\Entity\Pessoa\EnderecoFisico $endereco)
    {
        $this->enderecos->removeElement($endereco);
    }
}
