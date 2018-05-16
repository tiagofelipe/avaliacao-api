<?php

namespace Uloc\Bundle\AppBundle\Entity\ServicoMensagem;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Canal de comunicação do serviço de mensagem.
 *
 * Exemplo:
 *
 * Nome: Email
 * Classname: EmailTransmissor
 *
 * @ORM\Table(name="sm_tipo_mensagem")
 * @ORM\Entity(repositoryClass="Uloc\Bundle\AppBundle\Repository\ServicoMensagem\TipoMensagemRepository")
 */
class TipoMensagem
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
     * @ORM\Column(name="classname", type="string", length=100, nullable=true)
     */
    private $classname;

    /**
     * @var \stdClass
     *
     * @ORM\Column(name="config", type="object", nullable=true)
     */
    private $config;

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=50, unique=true)
     */
    private $nome;

    /**
     * @var Mensagem[]
     * @ORM\OneToMany(targetEntity="Uloc\Bundle\AppBundle\Entity\ServicoMensagem\Mensagem", mappedBy="tipo")
     * @ORM\JoinColumn(name="mensagem_id", referencedColumnName="id")
     */
    private $mensagens;

    public function __construct()
    {
        $this->mensagens = new ArrayCollection();
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
     * Set classname
     *
     * @param string $classname
     *
     * @return TipoMensagem
     */
    public function setClassname($classname)
    {
        $this->classname = $classname;

        return $this;
    }

    /**
     * Get classname
     *
     * @return string
     */
    public function getClassname()
    {
        return $this->classname;
    }

    /**
     * Set config
     *
     * @param \stdClass $config
     *
     * @return TipoMensagem
     */
    public function setConfig($config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * Get config
     *
     * @return \stdClass
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Set nome
     *
     * @param string $nome
     *
     * @return TipoMensagem
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
     * @return Mensagem[]
     */
    public function getMensagens()
    {
        return $this->mensagens;
    }

    /**
     * @param Mensagem[] $mensagens
     */
    public function setMensagens($mensagens)
    {
        $this->mensagens = $mensagens;
    }
}
