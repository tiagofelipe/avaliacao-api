<?php

namespace Uloc\Bundle\AppBundle\Entity\Chat;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Uloc\Bundle\AppBundle\Entity\Usuario;

/**
 * ChatGrupo
 *
 * @ORM\Table(name="chat_grupo")
 * @ORM\Entity(repositoryClass="Uloc\Bundle\AppBundle\Repository\Chat\ChatGrupoRepository")
 */
class ChatGrupo
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
     * @ORM\Column(name="nome", type="string", length=150, unique=true)
     */
    private $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="descricao", type="string", length=255)
     */
    private $descricao;

    /**
     * @var Usuario[]
     *
     * @ORM\ManyToMany(targetEntity="Uloc\Bundle\AppBundle\Entity\Usuario", inversedBy="chatGrupos")
     */
    private $usuarios;

    /**
     * @var ChatGrupo[]
     *
     * @ORM\OneToMany(targetEntity="Uloc\Bundle\AppBundle\Entity\Chat\ChatMensagem", mappedBy="chatGrupo")
     */
    private $chatMensagens;

    public function __construct()
    {
        $this->usuarios = new ArrayCollection();
        $this->chatMensagens = new ArrayCollection();
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
     * Set nome.
     *
     * @param string $nome
     *
     * @return ChatGrupo
     */
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get nome.
     *
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set descricao.
     *
     * @param string $descricao
     *
     * @return ChatGrupo
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;

        return $this;
    }

    /**
     * Get descricao.
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * @return Usuario[]
     */
    public function getUsuarios()
    {
        return $this->usuarios;
    }

    /**
     * @param Usuario $usuario
     */
    public function addUsuarios(Usuario $usuario)
    {
        $this->usuarios[] = $usuario;
    }

    /**
     * @return ChatGrupo[]
     */
    public function getChatMensagens()
    {
        return $this->chatMensagens;
    }

    /**
     * @param ChatGrupo[] $chatMensagens
     */
    public function addChatMensagens(ChatMensagem $chatMensagem)
    {
        $this->chatMensagens[] = $chatMensagem;
    }
}
