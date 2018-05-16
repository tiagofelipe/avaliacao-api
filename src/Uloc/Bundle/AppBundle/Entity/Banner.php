<?php

namespace Uloc\Bundle\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Uloc\Bundle\AppBundle\Serializer\ApiRepresentationMetadataInterface;

/**
 * Banner
 *
 * @ORM\Table(name="banner")
 * @ORM\Entity(repositoryClass="Uloc\Bundle\AppBundle\Repository\BannerRepository")
 */
class Banner
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
     * Nome do arquivo gravado no diretório
     * @var string
     *
     * @ORM\Column(name="nome_arquivo", type="string", length=255, nullable=true)
     */
    private $nomeArquivo;

    /**
     * Nome do arquivo no banco de dados
     * @var string
     *
     * @ORM\Column(name="nome_original", type="string", length=255)
     */
    private $nomeOriginal;

    /**
     * @var int
     *
     * @ORM\Column(name="posicao", type="smallint")
     */
    private $posicao;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data_exibicao", type="datetime")
     */
    private $dataExibicao;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data_expiracao", type="datetime")
     */
    private $dataExpiracao;

    /**
     * @var bool    true = ativo false = inativo
     *
     * @ORM\Column(name="situacao", type="boolean")
     */
    private $situacao;

    /**
     * @var bool
     *
     * @ORM\Column(name="has_video", type="boolean")
     */
    private $hasVideo;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url;

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
     * @param string $nomeArquivo
     *
     * @return Banner
     */
    public function setNomeArquivo($nomeArquivo)
    {
        $this->nomeArquivo = $nomeArquivo;

        return $this;
    }

    /**
     * Get nome
     *
     * @return string
     */
    public function getNomeArquivo()
    {
        return $this->nomeArquivo;
    }

    /**
     * @return string
     */
    public function getNomeOriginal()
    {
        return $this->nomeOriginal;
    }

    /**
     * @param string $nomeOriginal
     */
    public function setNomeOriginal($nomeOriginal)
    {
        $this->nomeOriginal = $nomeOriginal;
    }

    /**
     * Set posicao
     *
     * @param integer $posicao
     *
     * @return Banner
     */
    public function setPosicao($posicao)
    {
        $this->posicao = $posicao;

        return $this;
    }

    /**
     * Get posicao
     *
     * @return int
     */
    public function getPosicao()
    {
        return $this->posicao;
    }

    /**
     * Set dataExibicao
     *
     * @param \DateTime $dataExibicao
     *
     * @return Banner
     */
    public function setDataExibicao($dataExibicao)
    {
        $this->dataExibicao = $dataExibicao;

        return $this;
    }

    /**
     * Get dataExibicao
     *
     * @return \DateTime
     */
    public function getDataExibicao()
    {
        return $this->dataExibicao;
    }

    /**
     * Set situacao
     *
     * @param boolean $situacao
     *
     * @return Banner
     */
    public function setSituacao($situacao)
    {
        $this->situacao = $situacao;

        return $this;
    }

    /**
     * Get situacao
     *
     * @return bool
     */
    public function getSituacao()
    {
        return $this->situacao;
    }

    /**
     * Set hasVideo
     *
     * @param boolean $hasVideo
     *
     * @return Banner
     */
    public function setHasVideo($hasVideo)
    {
        $this->hasVideo = $hasVideo;

        return $this;
    }

    /**
     * Get hasVideo
     *
     * @return bool
     */
    public function getHasVideo()
    {
        return $this->hasVideo;
    }

    /**
     * @return \DateTime
     */
    public function getDataExpiracao()
    {
        return $this->dataExpiracao;
    }

    /**
     * @param \DateTime $dataExpiracao
     */
    public function setDataExpiracao($dataExpiracao)
    {
        $this->dataExpiracao = $dataExpiracao;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    public static function loadApiRepresentation(ApiRepresentationMetadataInterface $representation)
    {
        $representation->setGroup('public')
            ->addProperties([
                'id',
                'nomeOriginal as nome',
                'dataExibicao',
                'dataExpiracao',
                'posicao',
                'situacao',
                'hasVideo',
                'url'
            ]);
        $representation->build();

    }
}

