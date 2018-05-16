<?php
/**
 * Este arquivo é parte do código fonte Uloc
 *
 * (c) Tiago Felipe <tiago@tiagofelipe.com>
 *
 * Para informações completas dos direitos autorais, por favor veja o arquivo LICENSE
 * distribuído junto com o código fonte.
 */

namespace Uloc\Bundle\AppBundle\Entity\Pessoa;

use Doctrine\ORM\Mapping as ORM;

/**
 * Uma pessoa pode ter um proprietário (account owner), este proprietário pode mudar
 * Esta classe armazena os proprietários de uma pessoa, porém somente um pode estar ativo, ou seja
 * somente um pode ser o accouont owner/manager
 *
 * @ORM\Table(name="pessoa_proprietario")
 * @ORM\Entity(repositoryClass="Uloc\Bundle\AppBundle\Repository\Pessoa\PessoaProprietarioRepository")
 */
class PessoaProprietario
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
     * @ORM\Column(name="descricaoAtribuicao", type="text", nullable=true)
     */
    private $descricaoAtribuicao;

    /**
     * @var bool
     *
     * @ORM\Column(name="ativo", type="boolean")
     */
    private $ativo;

    /**
     * Muitos Proprietarios tem Um Pessoa.
     * @ORM\ManyToOne(targetEntity="Pessoa", inversedBy="proprietarios")
     * @ORM\JoinColumn(name="pessoa_id", referencedColumnName="id")
     */
    private $pessoa;

    /**
     * Muitos PessoasGerenciadas tem Um Pessoa.
     * @ORM\ManyToOne(targetEntity="Pessoa", inversedBy="pessoasGerenciadas")
     * @ORM\JoinColumn(name="proprietario_id", referencedColumnName="id")
     */
    private $proprietario;

    /**
     * @return mixed
     */
    public function getProprietario()
    {
        return $this->proprietario;
    }

    /**
     * @param Pessoa $proprietario
     */
    public function setProprietario(Pessoa $proprietario)
    {
        $this->proprietario = $proprietario;
    }

    /**
     * @return mixed
     */
    public function getPessoa()
    {
        return $this->pessoa;
    }

    /**
     * @param Pessoa $pessoa
     */
    public function setPessoa(Pessoa $pessoa)
    {
        $this->pessoa = $pessoa;
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
     * Set data
     *
     * @param \DateTime $data
     *
     * @return PessoaProprietario
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
     * Set descricaoAtribuicao
     *
     * @param string $descricaoAtribuicao
     *
     * @return PessoaProprietario
     */
    public function setDescricaoAtribuicao($descricaoAtribuicao)
    {
        $this->descricaoAtribuicao = $descricaoAtribuicao;

        return $this;
    }

    /**
     * Get descricaoAtribuicao
     *
     * @return string
     */
    public function getDescricaoAtribuicao()
    {
        return $this->descricaoAtribuicao;
    }

    /**
     * @return bool
     */
    public function isAtivo()
    {
        return $this->ativo;
    }

    /**
     * @param bool $ativo
     */
    public function setAtivo($ativo)
    {
        $this->ativo = $ativo;
    }

    /**
     * Get ativo
     *
     * @return boolean
     */
    public function getAtivo()
    {
        return $this->ativo;
    }
}
