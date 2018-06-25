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

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Uloc\Bundle\AppBundle\Entity\Estabelecimento;
use Uloc\Bundle\AppBundle\Entity\Usuario;
use Uloc\Bundle\AppBundle\Serializer\ApiRepresentationMetadataInterface;

/**
 * logradouro
 *
 * @ORM\Table(name="Enderecos")
 * @ORM\Entity(repositoryClass="Uloc\Bundle\AppBundle\Repository\Enderecos\EnderecoRepository")
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
     * @var Logradouro
     *
     * @ORM\ManyToOne(targetEntity="Logradouro", inversedBy="enderecos")
     */
    private $logradouro;

    /**
     * @var string
     *
     * @ORM\Column(name="complemento", type="string", length=255)
     */
    private $complemento;


    /**
     * @var string
     *
     * @ORM\Column(name="numero", type="string", length=20, nullable=true)
     */
    private $numero;

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
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set cep.
     *
     * @param int $cep
     *
     * @return Endereco
     */
    public function setCep($cep)
    {
        $this->cep = $cep;

        return $this;
    }

    /**
     * Get cep.
     *
     * @return int
     */
    public function getCep()
    {
        return $this->cep;
    }

    /**
     * Set complemento.
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
     * Get complemento.
     *
     * @return string
     */
    public function getComplemento()
    {
        return $this->complemento;
    }

    /**
     * Set logradouro.
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Enderecos\Logradouro|null $logradouro
     *
     * @return Endereco
     */
    public function setLogradouro(\Uloc\Bundle\AppBundle\Entity\Enderecos\Logradouro $logradouro = null)
    {
        $this->logradouro = $logradouro;

        return $this;
    }

    /**
     * Get logradouro.
     *
     * @return \Uloc\Bundle\AppBundle\Entity\Enderecos\Logradouro|null
     */
    public function getLogradouro()
    {
        return $this->logradouro;
    }

    /**
     * Set numero.
     *
     * @param string|null $numero
     *
     * @return Endereco
     */
    public function setNumero($numero = null)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero.
     *
     * @return string|null
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set latitude.
     *
     * @param string|null $latitude
     *
     * @return Endereco
     */
    public function setLatitude($latitude = null)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude.
     *
     * @return string|null
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude.
     *
     * @param string|null $longitude
     *
     * @return Endereco
     */
    public function setLongitude($longitude = null)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude.
     *
     * @return string|null
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set usuario.
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Usuario|null $usuario
     *
     * @return Endereco
     */
    public function setUsuario(\Uloc\Bundle\AppBundle\Entity\Usuario $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario.
     *
     * @return \Uloc\Bundle\AppBundle\Entity\Usuario|null
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set estabelecimento.
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Estabelecimento|null $estabelecimento
     *
     * @return Endereco
     */
    public function setEstabelecimento(\Uloc\Bundle\AppBundle\Entity\Estabelecimento $estabelecimento = null)
    {
        $this->estabelecimento = $estabelecimento;

        return $this;
    }

    /**
     * Get estabelecimento.
     *
     * @return \Uloc\Bundle\AppBundle\Entity\Estabelecimento|null
     */
    public function getEstabelecimento()
    {
        return $this->estabelecimento;
    }

    public static function loadApiRepresentation(ApiRepresentationMetadataInterface $representation)
    {
        $representation->setGroup('public')
            ->addProperties([
                'id',
                'complemento',
                'numero',
                'latitude',
                'longitude',
                'logradouro'=>array(
                    'id',
                    'cep',
                    'logradouro',
                    'bairro'=> array(
                        'id',
                        'nome',
                        'municipio'=>array(
                            'id',
                            'nome',
                            'uf' => array(
                                'id',
                                'nome',
                                'sigla',
                            ))))
            ]);
        $representation->build();
    }
}
