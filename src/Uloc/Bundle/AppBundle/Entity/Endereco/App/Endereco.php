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
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Endereco
 *
 * @ORM\Table(name="endereco")
 * @ORM\Entity(repositoryClass="Uloc\Bundle\AppBundle\Repository\App\EnderecoRepository")
 */
class Endereco
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
     * @var int
     *
     * @ORM\Column(name="cep", type="integer")
     */
    private $cep;

    /**
     * @var string
     *
     * @ORM\Column(name="logradouro", type="string", length=255)
     */
    private $logradouro;

    /**
     * @var string
     *
     * @ORM\Column(name="complemento", type="string", length=255)
     */
    private $complemento;

    /**
     * Muitos Enderecos tem Um Bairro.
     * @ORM\ManyToOne(targetEntity="Bairro", inversedBy="enderecos")
     * @ORM\JoinColumn(name="bairro_id", referencedColumnName="id")
     */
    private $bairro;

    /**
     * @return mixed
     */
    public function getBairro()
    {
        return $this->bairro;
    }

    /**
     * @param Bairro $bairro
     */
    public function setBairro(Bairro $bairro)
    {
        $this->bairro = $bairro;
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
     * Set cep
     *
     * @param integer $cep
     *
     * @return Endereco
     */
    public function setCep($cep)
    {
        $this->cep = $cep;

        return $this;
    }

    /**
     * Get cep
     *
     * @return int
     */
    public function getCep()
    {
        return $this->cep;
    }

    /**
     * Set logradouro
     *
     * @param string $logradouro
     *
     * @return Endereco
     */
    public function setLogradouro($logradouro)
    {
        $this->logradouro = $logradouro;

        return $this;
    }

    /**
     * Get logradouro
     *
     * @return string
     */
    public function getLogradouro()
    {
        return $this->logradouro;
    }

    /**
     * Set complemento
     *
     * @param string $complemento
     *
     * @return Endereco
     */
    public function setComplemento($complemento)
    {
        $this->complemento = $complemento;

        return $this;
    }

    /**
     * Get complemento
     *
     * @return string
     */
    public function getComplemento()
    {
        return $this->complemento;
    }
}
