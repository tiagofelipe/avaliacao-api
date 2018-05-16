<?php

namespace Uloc\Bundle\AppBundle\Entity\Pessoa;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Uloc\Bundle\AppBundle\Entity\App\TagInterface;

/**
 * Tag
 *
 * @ORM\Table(name="pessoa_tag")
 * @ORM\Entity(repositoryClass="Uloc\Bundle\AppBundle\Repository\Pessoa\TagRepository")
 */
class Tag implements TagInterface
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
     * @ORM\Column(name="nome", type="string", length=255)
     */
    private $nome;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dataCriacao", type="datetime")
     */
    private $dataCriacao;

    /**
     * @var string
     *
     * @ORM\Column(name="descricao", type="text", nullable=true)
     */
    private $descricao;

    /**
     * Muitos Tags tem Um Pessoa.
     * @ORM\ManyToMany(targetEntity="Pessoa", mappedBy="tags", fetch="EXTRA_LAZY")
     */
    private $pessoas;

    /**
     * Muitos TagsCriadas tem Um Pessoa.
     * @ORM\ManyToOne(targetEntity="Pessoa", inversedBy="tagsCriadas", fetch="EXTRA_LAZY")
     */
    private $criador;

    public function __construct()
    {
        $this->pessoas = new ArrayCollection();
        $this->dataCriacao = new \DateTime();
    }

    /**
     * @return mixed
     */
    public function getCriador()
    {
        return $this->criador;
    }

    /**
     * @param Pessoa $criador
     */
    public function setCriador(Pessoa $criador)
    {
        $this->criador = $criador;
    }

    /**
     * @return mixed
     */
    public function getPessoa()
    {
        return $this->pessoas;
    }

    /**
     * @param Pessoa $pessoas
     */
    public function addPessoa(Pessoa $pessoa)
    {
        $this->pessoas[] = $pessoa;
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
     * Set nome
     *
     * @param string $nome
     *
     * @return Tag
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
     * Set dataCriacao
     *
     * @param \DateTime $dataCriacao
     *
     * @return Tag
     */
    public function setDataCriacao($dataCriacao)
    {
        $this->dataCriacao = $dataCriacao;

        return $this;
    }

    /**
     * Get dataCriacao
     *
     * @return \DateTime
     */
    public function getDataCriacao()
    {
        return $this->dataCriacao;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     *
     * @return Tag
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
     * Remove pessoa
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Pessoa\Pessoa $pessoa
     */
    public function removePessoa(\Uloc\Bundle\AppBundle\Entity\Pessoa\Pessoa $pessoa)
    {
        $this->pessoas->removeElement($pessoa);
    }

    /**
     * Get pessoas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPessoas()
    {
        return $this->pessoas;
    }
}
