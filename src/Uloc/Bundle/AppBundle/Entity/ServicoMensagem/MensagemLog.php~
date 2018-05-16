<?php

namespace Uloc\Bundle\AppBundle\Entity\ServicoMensagem;

use Doctrine\ORM\Mapping as ORM;

/**
 * Armazena um histórico à mensagem sempre que necessário.
 *
 * @ORM\Table(name="sm_mensagem_log")
 * @ORM\Entity(repositoryClass="Uloc\Bundle\AppBundle\Repository\ServicoMensagem\MensagemLogRepository")
 */
class MensagemLog
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
     * @var \DateTime
     *
     * @ORM\Column(name="data", type="datetime")
     */
    private $data;

    /**
     * @var string
     *
     * @ORM\Column(name="assunto", type="string", length=255)
     */
    private $assunto;

    /**
     * @var string
     *
     * @ORM\Column(name="descricao", type="text")
     */
    private $descricao;

    /**
     * @var \stdClass
     *
     * @ORM\Column(name="extra", type="object", nullable=true)
     */
    private $extra;

    /**
     * Muitos Logs tem Um Mensagem.
     * @ORM\ManyToOne(targetEntity="Mensagem", inversedBy="logs")
     * @ORM\JoinColumn(name="mensagem_id", referencedColumnName="id")
     */
    private $mensagem;

    /**
     * @return mixed
     */
    public function getMensagem()
    {
        return $this->mensagem;
    }

    /**
     * @param Mensagem $mensagem
     */
    public function setMensagem(Mensagem $mensagem)
    {
        $this->mensagem = $mensagem;
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
     * Set data
     *
     * @param \DateTime $data
     *
     * @return MensagemLog
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return \DateTime
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set assunto
     *
     * @param string $assunto
     *
     * @return MensagemLog
     */
    public function setAssunto($assunto)
    {
        $this->assunto = $assunto;

        return $this;
    }

    /**
     * Get assunto
     *
     * @return string
     */
    public function getAssunto()
    {
        return $this->assunto;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     *
     * @return MensagemLog
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
     * Set extra
     *
     * @param \stdClass $extra
     *
     * @return MensagemLog
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
}
