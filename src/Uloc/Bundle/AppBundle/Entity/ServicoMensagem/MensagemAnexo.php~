<?php

namespace Uloc\Bundle\AppBundle\Entity\ServicoMensagem;

use Doctrine\ORM\Mapping as ORM;
use Uloc\Bundle\AppBundle\Entity\App\Arquivo;

/**
 * Há recomendações que os objetos menores que 256K são melhor armazenados em um
 * banco de dados, enquanto os objetos maiores que 1M são melhor armazenados no
 * sistema de arquivos.
 *
 * Como não teremos este controle, decidi por manter os objetos no sistema de
 * arquivos do SO (filesystem).
 *
 * @ORM\Table(name="sm_mensagem_anexo")
 * @ORM\Entity(repositoryClass="Uloc\Bundle\AppBundle\Repository\ServicoMensagem\MensagemAnexoRepository")
 */
class MensagemAnexo extends Arquivo
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
     * @var string
     *
     * @ORM\Column(name="descricao", type="string", length=255, nullable=true)
     */
    private $descricao;

    /**
     * @var int
     *
     * @ORM\Column(name="tamanho", type="integer", nullable=true)
     */
    private $tamanho;

    /**
     * Muitos Anexos tem Um Mensagem.
     * @ORM\ManyToOne(targetEntity="Mensagem", inversedBy="anexos")
     * @ORM\JoinColumn(name="mensagem_id", referencedColumnName="id")
     */
    private $mensagem;

    /**
     * @return mixed
     */
    public function getMensagem()
    {
        return $this->mensagem;
    }

    /**
     * @param Mensagem $mensagem
     */
    public function setMensagem(Mensagem $mensagem)
    {
        $this->mensagem = $mensagem;
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
     * @return MensagemAnexo
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
     * Set descricao
     *
     * @param string $descricao
     *
     * @return MensagemAnexo
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
     * Set tamanho
     *
     * @param integer $tamanho
     *
     * @return MensagemAnexo
     */
    public function setTamanho($tamanho)
    {
        $this->tamanho = $tamanho;

        return $this;
    }

    /**
     * Get tamanho
     *
     * @return int
     */
    public function getTamanho()
    {
        return $this->tamanho;
    }
}
