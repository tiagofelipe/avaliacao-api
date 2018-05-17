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
     * @ORM\Column(name="dataCriacao", type="datetime")
     */
    private $dataCriacao;

    /**
     * @var int
     *
     * @ORM\Column(name="nota", type="smallint")
     */
    private $nota;


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
}
