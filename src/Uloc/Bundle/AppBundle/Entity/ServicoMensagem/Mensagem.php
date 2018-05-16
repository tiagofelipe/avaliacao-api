<?php

namespace Uloc\Bundle\AppBundle\Entity\ServicoMensagem;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Uloc\Bundle\AppBundle\Services\Mensagem\ServicoMensagemInterface;

/**
 * Mensagem
 *
 * @ORM\Table(name="sm_mensagem")
 * @ORM\Entity(repositoryClass="Uloc\Bundle\AppBundle\Repository\ServicoMensagem\MensagemRepository")
 */
class Mensagem implements ServicoMensagemInterface
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
     * @ORM\Column(name="dataRegistro", type="datetime")
     */
    private $dataRegistro;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dataEnvio", type="datetime", nullable=true)
     */
    private $dataEnvio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dataRecebimento", type="datetime", nullable=true)
     */
    private $dataRecebimento;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dataLeitura", type="datetime", nullable=true)
     */
    private $dataLeitura;

    /**
     * @var string
     *
     * @ORM\Column(name="remetenteNome", type="string", length=80, nullable=true)
     */
    private $remetenteNome;

    /**
     * @var string
     *
     * @ORM\Column(name="remetente", type="string", length=100)
     */
    private $remetente;

    /**
     * @var string
     *
     * @ORM\Column(name="destinatarioNome", type="string", length=80, nullable=true)
     */
    private $destinatarioNome;

    /**
     * @var string
     *
     * @ORM\Column(name="destinatario", type="string", length=100)
     */
    private $destinatario;

    /**
     * 0=Criado
     * 1=Enviado
     * 2=Recebido
     * 3=Lido
     * 9=Erro
     *
     * @var int
     *
     * @ORM\Column(name="status", type="smallint")
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="mensagem", type="text", nullable=true)
     */
    private $mensagem;

    /**
     * Muitos Mensagem tem Um TipoMensagem.
     * @ORM\ManyToOne(targetEntity="TipoMensagem", inversedBy="mensagens")
     * @ORM\JoinColumn(name="tipo_id", referencedColumnName="id")
     */
    private $tipo;

    /**
     * Um Mensagem tem Muitos Anexos
     * @ORM\OneToMany(targetEntity="MensagemAnexo", mappedBy="mensagem")
     */
    private $anexos;

    /**
     * Um Mensagem tem Muitos Logs
     * @ORM\OneToMany(targetEntity="MensagemLog", mappedBy="mensagem")
     */
    private $logs;

    public function __construct()
    {
        $this->anexos = new ArrayCollection();
        $this->logs = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getLogs()
    {
        return $this->logs;
    }

    /**
     * @param MensagemLog $log
     */
    public function addLog(MensagemLog $log)
    {
        $this->logs[] = $log;
    }

    /**
     * @return mixed
     */
    public function getAnexos()
    {
        return $this->anexos;
    }

    /**
     * @param MensagemAnexo $anexo
     */
    public function addAnexo(MensagemAnexo $anexo)
    {
        $this->anexos[] = $anexo;
    }

    /**
     * @return mixed
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param TipoMensagem $tipo
     */
    public function setTipo(TipoMensagem $tipo)
    {
        $this->tipo = $tipo;
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
     * Set dataRegistro
     *
     * @param \DateTime $dataRegistro
     *
     * @return Mensagem
     */
    public function setDataRegistro($dataRegistro)
    {
        $this->dataRegistro = $dataRegistro;

        return $this;
    }

    /**
     * Get dataRegistro
     *
     * @return \DateTime
     */
    public function getDataRegistro()
    {
        return $this->dataRegistro;
    }

    /**
     * Set dataEnvio
     *
     * @param \DateTime $dataEnvio
     *
     * @return Mensagem
     */
    public function setDataEnvio($dataEnvio)
    {
        $this->dataEnvio = $dataEnvio;

        return $this;
    }

    /**
     * Get dataEnvio
     *
     * @return \DateTime
     */
    public function getDataEnvio()
    {
        return $this->dataEnvio;
    }

    /**
     * Set dataRecebimento
     *
     * @param \DateTime $dataRecebimento
     *
     * @return Mensagem
     */
    public function setDataRecebimento($dataRecebimento)
    {
        $this->dataRecebimento = $dataRecebimento;

        return $this;
    }

    /**
     * Get dataRecebimento
     *
     * @return \DateTime
     */
    public function getDataRecebimento()
    {
        return $this->dataRecebimento;
    }

    /**
     * Set dataLeitura
     *
     * @param \DateTime $dataLeitura
     *
     * @return Mensagem
     */
    public function setDataLeitura($dataLeitura)
    {
        $this->dataLeitura = $dataLeitura;

        return $this;
    }

    /**
     * Get dataLeitura
     *
     * @return \DateTime
     */
    public function getDataLeitura()
    {
        return $this->dataLeitura;
    }

    /**
     * Set remetenteNome
     *
     * @param string $remetenteNome
     *
     * @return Mensagem
     */
    public function setRemetenteNome($remetenteNome)
    {
        $this->remetenteNome = $remetenteNome;

        return $this;
    }

    /**
     * Get remetenteNome
     *
     * @return string
     */
    public function getRemetenteNome()
    {
        return $this->remetenteNome;
    }

    /**
     * Set remetente
     *
     * @param string $remetente
     *
     * @return Mensagem
     */
    public function setRemetente($remetente)
    {
        $this->remetente = $remetente;

        return $this;
    }

    /**
     * Get remetente
     *
     * @return string
     */
    public function getRemetente()
    {
        return $this->remetente;
    }

    /**
     * Set destinatarioNome
     *
     * @param string $destinatarioNome
     *
     * @return Mensagem
     */
    public function setDestinatarioNome($destinatarioNome)
    {
        $this->destinatarioNome = $destinatarioNome;

        return $this;
    }

    /**
     * Get destinatarioNome
     *
     * @return string
     */
    public function getDestinatarioNome()
    {
        return $this->destinatarioNome;
    }

    /**
     * Set destinatario
     *
     * @param string $destinatario
     *
     * @return Mensagem
     */
    public function setDestinatario($destinatario)
    {
        $this->destinatario = $destinatario;

        return $this;
    }

    /**
     * Get destinatario
     *
     * @return string
     */
    public function getDestinatario()
    {
        return $this->destinatario;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return Mensagem
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set mensagem
     *
     * @param string $mensagem
     *
     * @return Mensagem
     */
    public function setMensagem($mensagem)
    {
        $this->mensagem = $mensagem;

        return $this;
    }

    /**
     * Get mensagem
     *
     * @return string
     */
    public function getMensagem()
    {
        return $this->mensagem;
    }

    public function setTransmissor()
    {
        // TODO: Implement setTransmissor() method.
    }

    public function getTransmissor()
    {
        // TODO: Implement getTransmissor() method.
    }



    /**
     * Remove anexo
     *
     * @param \Uloc\Bundle\AppBundle\Entity\ServicoMensagem\MensagemAnexo $anexo
     */
    public function removeAnexo(\Uloc\Bundle\AppBundle\Entity\ServicoMensagem\MensagemAnexo $anexo)
    {
        $this->anexos->removeElement($anexo);
    }

    /**
     * Remove log
     *
     * @param \Uloc\Bundle\AppBundle\Entity\ServicoMensagem\MensagemLog $log
     */
    public function removeLog(\Uloc\Bundle\AppBundle\Entity\ServicoMensagem\MensagemLog $log)
    {
        $this->logs->removeElement($log);
    }
}
