<?php

namespace Uloc\Bundle\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Avaliacao
 *
 * @ORM\Table(name="avaliacao")
 * @ORM\Entity(repositoryClass="Uloc\Bundle\AppBundle\Repository\AvaliacaoRepository")
 */
class Avaliacao
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
     * @var string|null
     *
     * @ORM\Column(name="comentario", type="text", nullable=true)
     */
    private $comentario;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data_criacao", type="datetime")
     */
    private $dataCriacao;

    /**
     * @var int
     *
     * @ORM\Column(name="nota", type="smallint")
     */
    private $nota;

    /**
     * @var Usuario
     *
     * @ORM\ManyToOne(targetEntity="Uloc\Bundle\AppBundle\Entity\Usuario", inversedBy="avaliacoes")
     */
    private $usuario;

    /**
     * @var CriterioEstabelecimento
     *
     * @ORM\ManyToOne(targetEntity="Uloc\Bundle\AppBundle\Entity\CriterioEstabelecimento", inversedBy="avaliacaos")
     */
    private $criterioEstabelecimento;

    /**
     * @var Estabelecimento
     *
     * @ORM\ManyToOne(targetEntity="Uloc\Bundle\AppBundle\Entity\Estabelecimento", inversedBy="avaliacaos")
     */
    private $estabelecimento;

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
     * Set comentario.
     *
     * @param string|null $comentario
     *
     * @return Avaliacao
     */
    public function setComentario($comentario = null)
    {
        $this->comentario = $comentario;

        return $this;
    }

    /**
     * Get comentario.
     *
     * @return string|null
     */
    public function getComentario()
    {
        return $this->comentario;
    }

    /**
     * Set dataCriacao.
     *
     * @param \DateTime $dataCriacao
     *
     * @return Avaliacao
     */
    public function setDataCriacao($dataCriacao)
    {
        $this->dataCriacao = $dataCriacao;

        return $this;
    }

    /**
     * Get dataCriacao.
     *
     * @return \DateTime
     */
    public function getDataCriacao()
    {
        return $this->dataCriacao;
    }

    /**
     * Set nota.
     *
     * @param int $nota
     *
     * @return Avaliacao
     */
    public function setNota($nota)
    {
        $this->nota = $nota;

        return $this;
    }

    /**
     * Get nota.
     *
     * @return int
     */
    public function getNota()
    {
        return $this->nota;
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
     * @return Avaliacao
     */
    public function setUsuario(Usuario $usuario)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * @return CriterioEstabelecimento
     */
    public function getCriterioEstabelecimento()
    {
        return $this->criterioEstabelecimento;
    }

    /**
     * @param CriterioEstabelecimento $criterioEstabelecimento
     *
     * @return Avaliacao
     */
    public function setCriterioEstabelecimento($criterioEstabelecimento)
    {
        $this->criterioEstabelecimento = $criterioEstabelecimento;

        return $this;
    }

    /**
     * @return Estabelecimento
     */
    public function getEstabelecimento()
    {
        return $this->estabelecimento;
    }

    /**
     * @param Estabelecimento $estabelecimento
     *
     * @return Avaliacao
     */
    public function setEstabelecimento($estabelecimento)
    {
        $this->estabelecimento = $estabelecimento;

        return $this;
    }
}
