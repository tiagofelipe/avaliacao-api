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
use Uloc\Bundle\AppBundle\Serializer\ApiRepresentationMetadataInterface;

/**
 * logradouro
 *
 * @ORM\Table(name="logradouros")
 * @ORM\Entity(repositoryClass="Uloc\Bundle\AppBundle\Repository\App\EnderecoRepository")
 */
class Logradouro
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
     * Muitos Logradouros tem Um Bairro.
     * @ORM\ManyToOne(targetEntity="Bairro", inversedBy="logradouros")
     * @ORM\JoinColumn(name="bairro_id", referencedColumnName="id")
     */
    private $bairro;

    /**
     * Um logradouro tem muitos endereços
     * @ORM\OneToMany(targetEntity="Endereco",mappedBy="logradouro" )
     */
    private $enderecos;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->enderecos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set cep.
     *
     * @param int $cep
     *
     * @return Logradouro
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
     * Set logradouro.
     *
     * @param string $logradouro
     *
     * @return Logradouro
     */
    public function setLogradouro($logradouro)
    {
        $this->logradouro = $logradouro;

        return $this;
    }

    /**
     * Get logradouro.
     *
     * @return string
     */
    public function getLogradouro()
    {
        return $this->logradouro;
    }


    /**
     * Set bairro.
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Enderecos\Bairro|null $bairro
     *
     * @return Logradouro
     */
    public function setBairro(\Uloc\Bundle\AppBundle\Entity\Enderecos\Bairro $bairro = null)
    {
        $this->bairro = $bairro;

        return $this;
    }

    /**
     * Get bairro.
     *
     * @return \Uloc\Bundle\AppBundle\Entity\Enderecos\Bairro|null
     */
    public function getBairro()
    {
        return $this->bairro;
    }

    /**
     * Add endereco.
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Enderecos\Endereco $endereco
     *
     * @return Logradouro
     */
    public function addEndereco(\Uloc\Bundle\AppBundle\Entity\Enderecos\Endereco $endereco)
    {
        $this->enderecos[] = $endereco;

        return $this;
    }

    /**
     * Remove endereco.
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Enderecos\Endereco $endereco
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeEndereco(\Uloc\Bundle\AppBundle\Entity\Enderecos\Endereco $endereco)
    {
        return $this->enderecos->removeElement($endereco);
    }

    /**
     * Get enderecos.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEnderecos()
    {
        return $this->enderecos;
    }

    public static function loadApiRepresentation(ApiRepresentationMetadataInterface $representation)
    {
        $representation->setGroup('public')
            ->addProperties([
                'id',
                'cep',
                'logradouro',
                'bairro'=> array(
                    'id',
                    'nome',
                    'municipio'=>array(
                        'id',
                        'nome',
                        'ufs' => array(
                            'id',
                            'nome',
                            'sigla',
                )))
            ]);
        $representation->build();
    }
}
