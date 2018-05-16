<?php
/**
 * Este arquivo é parte do código fonte Uloc
 *
 * (c) Tiago Felipe <tiago@tiagofelipe.com>
 *
 * Para informações completas dos direitos autorais, por favor veja o arquivo LICENSE
 * distribuído junto com o código fonte.
 */

namespace Uloc\Bundle\AppBundle\Entity\Notificacao;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Notificacao
 *
 * @ORM\Table(name="notificacao")
 * @ORM\Entity(repositoryClass="Uloc\Bundle\AppBundle\Repository\Notificacao\NotificacaoRepository")
 */
class Notificacao
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
     * @ORM\Column(name="titulo", type="string", length=255)
     */
    private $titulo;

    /**
     * @var string
     *
     * @ORM\Column(name="descricao", type="text", nullable=true)
     */
    private $descricao;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data", type="datetime")
     */
    private $data;

    /**
     * @var \stdClass
     *
     * @ORM\Column(name="extra", type="object", nullable=true)
     */
    private $extra;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="inicio", type="datetime")
     */
    private $inicio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expiracao", type="datetime", nullable=true)
     */
    private $expiracao;

    /**
     * @var bool
     *
     * @ORM\Column(name="fixo", type="boolean")
     */
    private $fixo;

    /**
     * @var int
     *
     * @ORM\Column(name="tipo", type="smallint")
     */
    private $tipo;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="smallint")
     */
    private $status;

    /**
     * Uma Notificacao tem Muitos NotificacaoUsuario
     * @ORM\OneToMany(targetEntity="NotificacaoUsuario", mappedBy="notificacao")
     */
    private $usuarios;

    /**
     * Notificacao constructor.
     */
    public function __construct()
    {
        $this->usuarios = new ArrayCollection();
    }


    /**
     * @return mixed
     */
    public function getUsuarios()
    {
        return $this->usuarios;
    }

    /**
     * @param NotificacaoUsuario $usuario
     */
    public function addUsuario(NotificacaoUsuario $usuario)
    {
        $this->usuarios[] = $usuario;
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
     * Set titulo
     *
     * @param string $titulo
     *
     * @return Notificacao
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get titulo
     *
     * @return string
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     *
     * @return Notificacao
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
     * Set data
     *
     * @param \DateTime $data
     *
     * @return Notificacao
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
     * Set extra
     *
     * @param \stdClass $extra
     *
     * @return Notificacao
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

    /**
     * Set inicio
     *
     * @param \DateTime $inicio
     *
     * @return Notificacao
     */
    public function setInicio($inicio)
    {
        $this->inicio = $inicio;

        return $this;
    }

    /**
     * Get inicio
     *
     * @return \DateTime
     */
    public function getInicio()
    {
        return $this->inicio;
    }

    /**
     * Set expiracao
     *
     * @param \DateTime $expiracao
     *
     * @return Notificacao
     */
    public function setExpiracao($expiracao)
    {
        $this->expiracao = $expiracao;

        return $this;
    }

    /**
     * Get expiracao
     *
     * @return \DateTime
     */
    public function getExpiracao()
    {
        return $this->expiracao;
    }

    /**
     * Set fixo
     *
     * @param boolean $fixo
     *
     * @return Notificacao
     */
    public function setFixo($fixo)
    {
        $this->fixo = $fixo;

        return $this;
    }

    /**
     * Get fixo
     *
     * @return bool
     */
    public function getFixo()
    {
        return $this->fixo;
    }

    /**
     * Set tipo
     *
     * @param integer $tipo
     *
     * @return Notificacao
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return int
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return Notificacao
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
     * Remove usuario
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Notificacao\NotificacaoUsuario $usuario
     */
    public function removeUsuario(\Uloc\Bundle\AppBundle\Entity\Notificacao\NotificacaoUsuario $usuario)
    {
        $this->usuarios->removeElement($usuario);
    }
}
