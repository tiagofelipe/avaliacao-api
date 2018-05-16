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

use Doctrine\ORM\Mapping as ORM;
use Uloc\Bundle\AppBundle\Entity\Usuario;

/**
 * NotificacaoUsuario
 *
 * @ORM\Table(name="notificacao_usuario")
 * @ORM\Entity(repositoryClass="Uloc\Bundle\AppBundle\Repository\Notificacao\NotificacaoUsuarioRepository")
 */
class NotificacaoUsuario
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
     * @ORM\Column(name="dataVisualizacao", type="datetime", nullable=true)
     */
    private $dataVisualizacao;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dataClique", type="datetime", nullable=true)
     */
    private $dataClique;

    /**
     * Muitos NotificacaoUsuario tem Uma Notificacao.
     * @ORM\ManyToOne(targetEntity="Notificacao", inversedBy="usuarios")
     * @ORM\JoinColumn(name="notificacao_id", referencedColumnName="id")
     */
    private $notificacao;

    /**
     * Muitas NotificacaoUsuario tem Um Usuario.
     * @ORM\ManyToOne(targetEntity="Uloc\Bundle\AppBundle\Entity\Usuario", inversedBy="notificacoes")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     */
    private $usuario;

    /**
     * @return mixed
     */
    public function getNotificacao()
    {
        return $this->notificacao;
    }

    /**
     * @param Notificacao $notificacao
     */
    public function setNotificacao(Notificacao $notificacao)
    {
        $this->notificacao = $notificacao;
    }

    /**
     * @return mixed
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param Usuario $usuario
     */
    public function setUsuario(Usuario $usuario)
    {
        $this->usuario = $usuario;
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
     * Set dataVisualizacao
     *
     * @param \DateTime $dataVisualizacao
     *
     * @return NotificacaoUsuario
     */
    public function setDataVisualizacao($dataVisualizacao)
    {
        $this->dataVisualizacao = $dataVisualizacao;

        return $this;
    }

    /**
     * Get dataVisualizacao
     *
     * @return \DateTime
     */
    public function getDataVisualizacao()
    {
        return $this->dataVisualizacao;
    }

    /**
     * Set dataClique
     *
     * @param \DateTime $dataClique
     *
     * @return NotificacaoUsuario
     */
    public function setDataClique($dataClique)
    {
        $this->dataClique = $dataClique;

        return $this;
    }

    /**
     * Get dataClique
     *
     * @return \DateTime
     */
    public function getDataClique()
    {
        return $this->dataClique;
    }
}
