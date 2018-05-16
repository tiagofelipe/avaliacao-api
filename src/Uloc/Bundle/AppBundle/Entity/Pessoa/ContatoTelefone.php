<?php

namespace Uloc\Bundle\AppBundle\Entity\Pessoa;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Uloc\Bundle\AppBundle\Validator\Constraints as CustomAssert;

/**
 * ContatoTelefone
 *
 * @ORM\Table(name="pessoa_contato_telefone")
 * @ORM\Entity(repositoryClass="Uloc\Bundle\AppBundle\Repository\Pessoa\ContatoTelefoneRepository")
 * #CustomAssert\Telefone(groups={"Default"})
 */
class ContatoTelefone
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
     * @ORM\Column(name="finalidadeOutros", type="string", length=100, nullable=true)
     */
    private $finalidadeOutros;

    /**
     * @var string
     *
     * @ORM\Column(name="areaCode", type="string", length=5)
     */
    private $areaCode;

    /**
     * @var string
     *
     * @ORM\Column(name="telefone", type="string", length=50)
     */
    private $telefone;

    /**
     * @var bool
     *
     * @ORM\Column(name="celular", type="boolean", nullable=true)
     */
    private $celular;

    /**
     * @var bool
     *
     * @ORM\Column(name="principal", type="boolean", nullable=true)
     */
    private $principal;

    /**
     * Armazena em objeto os aplicativos de mensagem instantânea compatíveis com este número de telefone.
     *
     * @var \stdClass
     *
     * @ORM\Column(name="im", type="object", nullable=true)
     */
    private $im;

    /**
     * Muitos Telefones tem Um Pessoa.
     * @ORM\ManyToOne(targetEntity="Pessoa", inversedBy="telefones")
     * @ORM\JoinColumn(name="pessoa_id", referencedColumnName="id")
     */
    private $pessoa;

    /**
     * Muitos Telefones tem Um TipoFinalidadeTelefone.
     * @ORM\ManyToOne(targetEntity="TipoFinalidadeTelefone", inversedBy="telefones")
     * @ORM\JoinColumn(name="tipo_finalidade_id", referencedColumnName="id")
     */
    private $tipoFinalidade;

    public function __construct()
    {
        $this->areaCode = '55'; //Brasil defaults
    }

    /**
     * @return mixed
     */
    public function getTipoFinalidade()
    {
        return $this->tipoFinalidade;
    }

    /**
     * @param TipoFinalidadeTelefone $tipoFinalidade
     */
    public function setTipoFinalidade(TipoFinalidadeTelefone $tipoFinalidade)
    {
        $this->tipoFinalidade = $tipoFinalidade;
    }

    /**
     * @return mixed
     */
    public function getPessoa()
    {
        return $this->pessoa;
    }

    /**
     * @param Pessoa $pessoa
     */
    public function setPessoa(Pessoa $pessoa)
    {
        $this->pessoa = $pessoa;
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
     * Set finalidadeOutros
     *
     * @param string $finalidadeOutros
     *
     * @return ContatoTelefone
     */
    public function setFinalidadeOutros($finalidadeOutros)
    {
        $this->finalidadeOutros = $finalidadeOutros;

        return $this;
    }

    /**
     * Get finalidadeOutros
     *
     * @return string
     */
    public function getFinalidadeOutros()
    {
        return $this->finalidadeOutros;
    }

    /**
     * Set areaCode
     *
     * @param string $areaCode
     *
     * @return ContatoTelefone
     */
    public function setAreaCode($areaCode)
    {
        $this->areaCode = $areaCode;

        return $this;
    }

    /**
     * Get areaCode
     *
     * @return string
     */
    public function getAreaCode()
    {
        return $this->areaCode;
    }

    /**
     * Set telefone
     *
     * @param string $telefone
     *
     * @return ContatoTelefone
     */
    public function setTelefone($telefone)
    {
        $this->telefone = preg_replace('/\D/', '$1', $telefone);

        return $this;
    }

    /**
     * Get telefone
     *
     * @return string
     */
    public function getTelefone()
    {
        return $this->telefone;
    }

    /**
     * Set celular
     *
     * @param boolean $celular
     *
     * @return ContatoTelefone
     */
    public function setCelular($celular)
    {
        $this->celular = $celular;

        return $this;
    }

    /**
     * Get celular
     *
     * @return bool
     */
    public function getCelular()
    {
        return $this->celular;
    }

    /**
     * Set principal
     *
     * @param boolean $principal
     *
     * @return ContatoTelefone
     */
    public function setPrincipal($principal)
    {
        $this->principal = $principal;

        return $this;
    }

    /**
     * Get principal
     *
     * @return bool
     */
    public function getPrincipal()
    {
        return $this->principal;
    }

    /**
     * Set im
     *
     * @param \stdClass $im
     *
     * @return ContatoTelefone
     */
    public function setIm($im)
    {
        $this->im = $im;

        return $this;
    }

    /**
     * Get im
     *
     * @return \stdClass
     */
    public function getIm()
    {
        return $this->im;
    }

    public function splitBrazilianDDD()
    {
        $telefone = preg_replace('/\D/', '$1', $this->telefone);
        $ddd = substr($telefone, 0, 2);
        $telefone = substr($telefone, 2, strlen($telefone) - 2);
        return array($ddd, $telefone);
    }
}
