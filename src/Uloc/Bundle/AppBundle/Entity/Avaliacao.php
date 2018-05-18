<?php

namespace Uloc\Bundle\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\Range(
     *     min=1,
     *     max=5,
     *     minMessage="A nota mínima é 1",
     *     maxMessage="A nota máxima é 5",
     *     invalidMessage="A nota deve ser um número inteiro"
     * )
     * @Assert\NotNull(message="Necessário informar a nota")
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
     * @ORM\JoinColumn(nullable=true)
     */
    private $criterioEstabelecimento;

    /**
     * @var Estabelecimento
     *
     * @ORM\ManyToOne(targetEntity="Uloc\Bundle\AppBundle\Entity\Estabelecimento", inversedBy="avaliacaos")
     * @ORM\JoinColumn(nullable=true)
     */
    private $estabelecimento;

    /**
     * @var Funcionario
     *
     * @ORM\ManyToOne(targetEntity="Uloc\Bundle\AppBundle\Entity\Funcionario", inversedBy="avaliacoes")
     * @ORM\JoinColumn(nullable=true)
     */
    private $funcionario;


    public function __construct()
    {
        $this->dataCriacao = new \DateTime();
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

    /**
     * @return Funcionario
     */
    public function getFuncionario()
    {
        return $this->funcionario;
    }

    /**
     * @param Funcionario $funcionario
     * @return Avaliacao
     */
    public function setFuncionario($funcionario)
    {
        $this->funcionario = $funcionario;

        return $this;
    }
}
