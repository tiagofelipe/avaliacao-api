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

use Doctrine\ORM\Mapping as ORM;

/**
 * ConfigMunicipio
 *
 * @ORM\Table(name="config_municipio")
 * @ORM\Entity(repositoryClass="Uloc\Bundle\AppBundle\Repository\App\ConfigMunicipioRepository")
 */
class ConfigMunicipio
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
     * @ORM\Column(name="nome", type="string", length=255, unique=true)
     */
    private $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="valor", type="text")
     */
    private $valor;

    /**
     * @var \stdClass
     *
     * @ORM\Column(name="extra", type="object")
     */
    private $extra;

    /**
     * @var bool
     *
     * @ORM\Column(name="fixo", type="boolean")
     */
    private $fixo;

    /**
     * Muitos Configuracoes tem Um Municipio.
     * @ORM\ManyToOne(targetEntity="Municipio", inversedBy="configuracoes")
     * @ORM\JoinColumn(name="municipio_id", referencedColumnName="id")
     */
    private $municipio;

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
     * @return ConfigMunicipio
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
     * Set valor
     *
     * @param string $valor
     *
     * @return ConfigMunicipio
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor
     *
     * @return string
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set extra
     *
     * @param \stdClass $extra
     *
     * @return ConfigMunicipio
     */
    public function setExtra($extra)
    {
        $this->extra = $extra;

        return $this;
    }

    /**
     * Get extra
     *
     * @return \stdClass
     */
    public function getExtra()
    {
        return $this->extra;
    }

    /**
     * Set fixo
     *
     * @param boolean $fixo
     *
     * @return ConfigMunicipio
     */
    public function setFixo($fixo)
    {
        $this->fixo = $fixo;

        return $this;
    }

    /**
     * Get fixo
     *
     * @return bool
     */
    public function getFixo()
    {
        return $this->fixo;
    }
}
