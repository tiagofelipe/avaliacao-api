<?php
/**
 * Este arquivo é parte do código fonte Uloc
 *
 * (c) Tiago Felipe <tiago@tiagofelipe.com>
 *
 * Para informações completas dos direitos autorais, por favor veja o arquivo LICENSE
 * distribuído junto com o código fonte.
 */

namespace Uloc\Bundle\AppBundle\Entity\Permissao;

use Doctrine\ORM\Mapping as ORM;

/**
 * PermissaoModulo
 *
 * @ORM\Table(name="permissao_permissao_modulo")
 * @ORM\Entity(repositoryClass="Uloc\Bundle\AppBundle\Repository\Permissao\PermissaoModuloRepository")
 */
class PermissaoModulo
{
        /**
     * @var string
     * @ORM\Id
     * @ORM\Column(name="modulo", type="string", length=50, unique=true)
     */
    private $modulo;

    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(name="componente", type="string", length=50, unique=true)
     */
    private $componente;

    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(name="acao", type="integer", unique=true)
     */
    private $acao;

    /**
     * @var string
     *
     * @ORM\Column(name="acaoNome", type="string", length=255)
     */
    private $acaoNome;

    /**
     * @var string
     *
     * @ORM\Column(name="descricao", type="text", nullable=true)
     */
    private $descricao;

    /**
     * Set modulo
     *
     * @param string $modulo
     *
     * @return PermissaoModulo
     */
    public function setModulo($modulo)
    {
        $this->modulo = $modulo;

        return $this;
    }

    /**
     * Get modulo
     *
     * @return string
     */
    public function getModulo()
    {
        return $this->modulo;
    }

    /**
     * Set componente
     *
     * @param string $componente
     *
     * @return PermissaoModulo
     */
    public function setComponente($componente)
    {
        $this->componente = $componente;

        return $this;
    }

    /**
     * Get componente
     *
     * @return string
     */
    public function getComponente()
    {
        return $this->componente;
    }

    /**
     * Set acao
     *
     * @param integer $acao
     *
     * @return PermissaoModulo
     */
    public function setAcao($acao)
    {
        $this->acao = $acao;

        return $this;
    }

    /**
     * Get acao
     *
     * @return int
     */
    public function getAcao()
    {
        return $this->acao;
    }

    /**
     * Set acaoNome
     *
     * @param string $acaoNome
     *
     * @return PermissaoModulo
     */
    public function setAcaoNome($acaoNome)
    {
        $this->acaoNome = $acaoNome;

        return $this;
    }

    /**
     * Get acaoNome
     *
     * @return string
     */
    public function getAcaoNome()
    {
        return $this->acaoNome;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     *
     * @return PermissaoModulo
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
}
