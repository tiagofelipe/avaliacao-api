<?php

namespace Uloc\Bundle\AppBundle\Entity\Chat;

use Doctrine\ORM\Mapping as ORM;
use Uloc\Bundle\AppBundle\Entity\Usuario;
use Uloc\Bundle\AppBundle\Serializer\ApiRepresentationMetadataInterface;

/**
 * ChatMensagem
 *
 * @ORM\Table(name="chat_mensagem", indexes={@ORM\Index(name="lido", columns={"lido"})}))
 * @ORM\Entity(repositoryClass="Uloc\Bundle\AppBundle\Repository\Chat\ChatMensagemRepository")
 */
class ChatMensagem
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
     * @ORM\Column(name="mensagem", type="text")
     */
    private $mensagem;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lido", type="datetime", nullable=true)
     */
    private $lido;

    /**
     * @var Usuario
     *
     * @ORM\ManyToOne(targetEntity="Uloc\Bundle\AppBundle\Entity\Usuario", inversedBy="chatMensagensEnviadas")
     */
    private $usuario;

    /**
     * @var Usuario
     *
     * @ORM\ManyToOne(targetEntity="Uloc\Bundle\AppBundle\Entity\Usuario", inversedBy="chatMensagensRecebidas")
     */
    private $destinatario;

    /**
     * @var ChatGrupo
     *
     * @ORM\ManyToOne(targetEntity="Uloc\Bundle\AppBundle\Entity\Chat\ChatGrupo", inversedBy="chatMensagens")
     * @ORM\JoinColumn(name="grupo", referencedColumnName="id")
     */
    private $grupo;

    /**
     * ChatMensagem constructor.
     */
    public function __construct()
    {
        $this->data = new \DateTime('now');
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
     * Set data.
     *
     * @param \DateTime $data
     *
     * @return ChatMensagem
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data.
     *
     * @return \DateTime
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set mensagem.
     *
     * @param string $mensagem
     *
     * @return ChatMensagem
     */
    public function setMensagem($mensagem)
    {
        $this->mensagem = $mensagem;

        return $this;
    }

    /**
     * Get mensagem.
     *
     * @return string
     */
    public function getMensagem()
    {
        return $this->mensagem;
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
     * @return Usuario
     */
    public function getDestinatario()
    {
        return $this->destinatario;
    }

    /**
     * @param Usuario $destinatario
     */
    public function setDestinatario($destinatario)
    {
        $this->destinatario = $destinatario;
    }

    /**
     * @return ChatGrupo
     */
    public function getGrupo()
    {
        return $this->grupo;
    }

    /**
     * @param Grupo $grupo
     */
    public function setGrupo($grupo)
    {
        $this->grupo = $grupo;
    }

    /**
     * @return \DateTime
     */
    public function getLido()
    {
        return $this->lido;
    }

    /**
     * @param \DateTime $lido
     */
    public function setLido($lido)
    {
        $this->lido = $lido;
    }



    public static function loadApiRepresentation(ApiRepresentationMetadataInterface $representation)
    {

        $representation->setGroup('public')
            ->addProperties([
                "id",
                "data",
                "mensagem",
                "usuario as remetente" => array("id", "nome"),
                "destinatario" => array("id", "nome")
            ]);

    }
}
