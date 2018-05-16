<?php

namespace Uloc\Bundle\AppBundle\Entity\Pessoa;

use Doctrine\ORM\Mapping as ORM;

/**
 * PessoaEssencialCache
 *
 * Classe para
 *
 * @ORM\Table(name="pessoa_pessoa_essencial_cache")
 * @ORM\Entity(repositoryClass="Uloc\Bundle\AppBundle\Repository\Pessoa\PessoaEssencialCacheRepository")
 */
class PessoaEssencialCache
{

    /**
     * @ORM\Id
     * @ORM\OneToOne(targetEntity="Pessoa", inversedBy="essencial")
     * @ORM\JoinColumn(name="pessoa_id", referencedColumnName="id")
     */
    private $pessoa;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cidade", type="string", length=255, nullable=true)
     */
    private $cidade;

    /**
     * @var string|null
     *
     * @ORM\Column(name="uf", type="string", length=100, nullable=true)
     */
    private $uf;

    /**
     * @var string|null
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * Set cidade.
     *
     * @param string|null $cidade
     *
     * @return PessoaEssencialCache
     */
    public function setCidade($cidade = null)
    {
        $this->cidade = $cidade;

        return $this;
    }

    /**
     * Get cidade.
     *
     * @return string|null
     */
    public function getCidade()
    {
        return $this->cidade;
    }

    /**
     * Set uf.
     *
     * @param string|null $uf
     *
     * @return PessoaEssencialCache
     */
    public function setUF($uf = null)
    {
        $this->uf = $uf;

        return $this;
    }

    /**
     * Get uf.
     *
     * @return string|null
     */
    public function getUF()
    {
        return $this->uf;
    }

    /**
     * Set email.
     *
     * @param string|null $email
     *
     * @return PessoaEssencialCache
     */
    public function setEmail($email = null)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email.
     *
     * @return string|null
     */
    public function getEmail()
    {
        return $this->email;
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
}
