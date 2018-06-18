<?php

namespace Uloc\Bundle\AppBundle\Entity\Endereco;

use Doctrine\ORM\Mapping as ORM;
use Uloc\Bundle\AppBundle\Entity\Endereco\App\Pais;
use Uloc\Bundle\AppBundle\Entity\Endereco\App\Municipio;
use Symfony\Component\Validator\Constraints as Assert;
use Uloc\Bundle\AppBundle\Entity\Estabelecimento;
use Uloc\Bundle\AppBundle\Entity\Usuario;

/**
 * EnderecoFisico
 *
 * @ORM\Table(name="endereco_fisico")
 * @ORM\Entity(repositoryClass="Uloc\Bundle\AppBundle\Repository\Pessoa\EnderecoFisicoRepository")
 */
class EnderecoFisico
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
     * @Assert\NotBlank(message="Logradouro invalido", groups={"PessoaFisica", "PessoaJuridica"})
     * @ORM\Column(name="logradouro", type="string", length=255)
     */
    private $logradouro;

    /**
     * @var string
     *
     * @ORM\Column(name="complemento", type="string", length=255, nullable=true)
     */
    private $complemento;

    /**
     * @var string
     * @Assert\NotBlank(message="É necessário informar um número", groups={"PessoaFisica", "PessoaJuridica"})
     * @ORM\Column(name="numero", type="string", length=50, nullable=true)
     */
    private $numero;

    /**
     * @var string
     * @Assert\NotBlank(message="É necessário informar um bairro", groups={"PessoaFisica", "PessoaJuridica"})
     * @ORM\Column(name="bairro", type="string", length=100, nullable=true)
     */
    private $bairro;

    /**
     * @var int
     * @Assert\NotBlank(message="É necessário informar um cep", groups={"PessoaFisica", "PessoaJuridica"})
     * @ORM\Column(name="cep", type="integer", nullable=true)
     */
    private $cep;

    /**
     * @var string
     *
     * @ORM\Column(name="nomeCidadeExterior", type="string", length=100, nullable=true)
     */
    private $nomeCidadeExterior;

    /**
     * @var string
     *
     * @ORM\Column(name="tipoFinalidadeEnderecoOutros", type="string", length=255, nullable=true)
     */
    private $tipoFinalidadeEnderecoOutros;

    /**
     * @var bool
     *
     * @ORM\Column(name="principal", type="boolean", nullable=true)
     */
    private $principal;

    /**
     * @var string
     *
     * @ORM\Column(name="latitude", type="string", length=255, nullable=true)
     */
    private $latitude;

    /**
     * @var string
     *
     * @ORM\Column(name="longitude", type="string", length=255, nullable=true)
     */
    private $longitude;

    /**
     * @var string
     *
     * @ORM\Column(name="bairro_outros", type="string", length=255, nullable=true)
     */
    private $bairroOutros;

    /**
     * @var string
     *
     * @ORM\Column(name="cidade_outros", type="string", length=255, nullable=true)
     */
    private $cidadeOutros;

    /**
     * @var string
     *
     * @ORM\Column(name="uf_outros", type="string", length=255, nullable=true)
     */
    private $ufOutros;

    /**
     * Muitos Enderecos tem Um TipoFinalidadeEndereco.
     * @ORM\ManyToOne(targetEntity="Uloc\Bundle\AppBundle\Entity\Endereco\TipoFinalidadeEndereco", inversedBy="enderecos")
     * @ORM\JoinColumn(name="finalidade_id", referencedColumnName="id")
     */
    private $finalidade;

    /**
     * Caso a pessoa for do exterior, o país deve ser selecionado e relacionado diretamente ao endereço
     *
     * @ORM\ManyToOne(targetEntity="Uloc\Bundle\AppBundle\Entity\Endereco\App\Pais")
     * @ORM\JoinColumn(name="pais_id", referencedColumnName="id")
     */
    private $pais;

    /**
     * @Assert\NotBlank(message="Municipio invalido", groups={"ComMunicipio"})
     * Muitos Enderecos tem Um Uloc\Bundle\AppBundle\Entity\logradouro\App\Municipio.
     * @ORM\ManyToOne(targetEntity="Uloc\Bundle\AppBundle\Entity\Endereco\App\Municipio", inversedBy="enderecos")
     * @ORM\JoinColumn(name="municipio_id", referencedColumnName="id")
     */
    private $municipio;

    /**
     * @var Usuario
     *
     * @ORM\ManyToOne(targetEntity="Uloc\Bundle\AppBundle\Entity\Usuario", inversedBy="enderecos")
     */
    private $usuario;

    /**
     * @var Estabelecimento
     *
     * @ORM\ManyToOne(targetEntity="Uloc\Bundle\AppBundle\Entity\Estabelecimento", inversedBy="enderecos")
     */
    private $estabelecimento;


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
     * @return mixed
     */
    public function getPais()
    {
        return $this->pais;
    }

    /**
     * @param Pais $pais
     */
    public function setPais(Pais $pais)
    {
        $this->pais = $pais;
    }

    /**
     * @return mixed
     */
    public function getFinalidade()
    {
        return $this->finalidade;
    }

    /**
     * @param TipoFinalidadeEndereco $finalidade
     */
    public function setFinalidade(TipoFinalidadeEndereco $finalidade)
    {
        $this->finalidade = $finalidade;
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
     * Set logradouro
     *
     * @param string $logradouro
     *
     * @return EnderecoFisico
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
     * @return EnderecoFisico
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

    /**
     * Set numero
     *
     * @param string $numero
     *
     * @return EnderecoFisico
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return string
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set bairro
     *
     * @param string $bairro
     *
     * @return EnderecoFisico
     */
    public function setBairro($bairro)
    {
        $this->bairro = $bairro;

        return $this;
    }

    /**
     * Get bairro
     *
     * @return string
     */
    public function getBairro()
    {
        return $this->bairro;
    }

    /**
     * Set cep
     *
     * @param integer $cep
     *
     * @return EnderecoFisico
     */
    public function setCep($cep)
    {
        $this->cep = preg_replace('/\D/', '$1', $cep);;

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
     * Set nomeCidadeExterior
     *
     * @param string $nomeCidadeExterior
     *
     * @return EnderecoFisico
     */
    public function setNomeCidadeExterior($nomeCidadeExterior)
    {
        $this->nomeCidadeExterior = $nomeCidadeExterior;

        return $this;
    }

    /**
     * Get nomeCidadeExterior
     *
     * @return string
     */
    public function getNomeCidadeExterior()
    {
        return $this->nomeCidadeExterior;
    }

    /**
     * Set tipoFinalidadeEnderecoOutros
     *
     * @param string $tipoFinalidadeEnderecoOutros
     *
     * @return EnderecoFisico
     */
    public function setTipoFinalidadeEnderecoOutros($tipoFinalidadeEnderecoOutros)
    {
        $this->tipoFinalidadeEnderecoOutros = $tipoFinalidadeEnderecoOutros;

        return $this;
    }

    /**
     * Get tipoFinalidadeEnderecoOutros
     *
     * @return string
     */
    public function getTipoFinalidadeEnderecoOutros()
    {
        return $this->tipoFinalidadeEnderecoOutros;
    }

    /**
     * Set principal
     *
     * @param boolean $principal
     *
     * @return EnderecoFisico
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
     * Set latitude
     *
     * @param string $latitude
     *
     * @return EnderecoFisico
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     *
     * @return EnderecoFisico
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @return string
     */
    public function getBairroOutros()
    {
        return $this->bairroOutros;
    }

    /**
     * @param string $bairroOutros
     */
    public function setBairroOutros($bairroOutros)
    {
        $this->bairroOutros = $bairroOutros;
    }

    /**
     * @return string
     */
    public function getCidadeOutros()
    {
        return $this->cidadeOutros;
    }

    /**
     * @param string $cidadeOutros
     */
    public function setCidadeOutros($cidadeOutros)
    {
        $this->cidadeOutros = $cidadeOutros;
    }

    /**
     * @return string
     */
    public function getUfOutros()
    {
        return $this->ufOutros;
    }

    /**
     * @param string $ufOutros
     */
    public function setUfOutros($ufOutros)
    {
        $this->ufOutros = $ufOutros;
    }

    /**
     * @return Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param Usuario $usuario
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    /**
     * @return Estabelecimento
     */
    public function getEstabelecimento()
    {
        return $this->estabelecimento;
    }

    /**
     * @param Estabelecimento $estabelecimento
     */
    public function setEstabelecimento($estabelecimento)
    {
        $this->estabelecimento = $estabelecimento;
    }
}
