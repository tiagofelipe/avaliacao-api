<?php

namespace Uloc\Bundle\AppBundle\Entity\Pessoa;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ContatoEmail
 *
 * @ORM\Table(name="pessoa_contato_email")
 * @ORM\Entity(repositoryClass="Uloc\Bundle\AppBundle\Repository\Pessoa\ContatoEmailRepository")
 */
class ContatoEmail
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
     * @ORM\Column(name="finalidadeOutros", type="string", length=100, nullable=true)
     */
    private $finalidadeOutros;

    /**
     * @var string
     * @Assert\NotBlank(message="Necessario informar um email")
     * @Assert\Email(message="Email invalido")
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var bool
     *
     * @ORM\Column(name="validado", type="boolean", nullable=true)
     */
    private $validado;

    /**
     * @var bool
     *
     * @ORM\Column(name="principal", type="boolean", nullable=true)
     */
    private $principal;

    /**
     * Muitos Emails tem Um Pessoa.
     * @ORM\ManyToOne(targetEntity="Pessoa", inversedBy="emails")
     * @ORM\JoinColumn(name="pessoa_id", referencedColumnName="id")
     */
    private $pessoa;

    /**
     * Muitos Emails tem Um TipoFinalidadeEmail.
     * @ORM\ManyToOne(targetEntity="TipoFinalidadeEmail", inversedBy="emails")
     * @ORM\JoinColumn(name="tipo_finalidade_id", referencedColumnName="id")
     */
    private $tipoFinalidade;

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
    public function setPessoa(?Pessoa $pessoa)
    {
        $this->pessoa = $pessoa;
    }

    /**
     * @return mixed
     */
    public function getTipoFinalidade()
    {
        return $this->tipoFinalidade;
    }

    /**
     * @return mixed
     */
    public function getFinalidade()
    {
        if( null === $this->tipoFinalidade ){
            return $this->finalidadeOutros;
        }
        return array("id" => $this->tipoFinalidade->getId(), "nome" => $this->tipoFinalidade->getNome());
    }

    /**
     * @param TipoFinalidadeEmail $tipoFinalidade
     */
    public function setTipoFinalidade(TipoFinalidadeEmail $tipoFinalidade)
    {
        $this->tipoFinalidade = $tipoFinalidade;
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
     * Set finalidadeOutros
     *
     * @param string $finalidadeOutros
     *
     * @return ContatoEmail
     */
    public function setFinalidadeOutros($finalidadeOutros)
    {
        $this->finalidadeOutros = $finalidadeOutros;

        return $this;
    }

    /**
     * Get finalidadeOutros
     *
     * @return string
     */
    public function getFinalidadeOutros()
    {
        return $this->finalidadeOutros;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return ContatoEmail
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set validado
     *
     * @param boolean $validado
     *
     * @return ContatoEmail
     */
    public function setValidado($validado)
    {
        $this->validado = $validado;

        return $this;
    }

    /**
     * Get validado
     *
     * @return bool
     */
    public function getValidado()
    {
        return $this->validado;
    }

    /**
     * Set principal
     *
     * @param boolean $principal
     *
     * @return ContatoEmail
     */
    public function setPrincipal($principal)
    {
        $this->principal = $principal;

        return $this;
    }

    /**
     * Get principal
     *
     * @return bool
     */
    public function getPrincipal()
    {
        return $this->principal;
    }
}
