<?php

namespace Uloc\Bundle\AppBundle\Entity\Pessoa;

use Doctrine\ORM\Mapping as ORM;

/**
 * IdentificadorRegistrado
 *
 * @ORM\Table(name="pessoa_identificador_registrado")
 * @ORM\Entity(repositoryClass="Uloc\Bundle\AppBundle\Repository\Pessoa\IdentificadorRegistradoRepository")
 */
class IdentificadorRegistrado
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
     * @ORM\Column(name="identificador", type="string", length=255)
     */
    private $identificador;

    /**
     * @var string
     *
     * @ORM\Column(name="orgaoExpedidor", type="string", length=50, nullable=true)
     */
    private $orgaoExpedidor;

    /**
     * Muitos Identificadores tem Um TipoIdentificadorRegistrado.
     * @ORM\ManyToOne(targetEntity="TipoIdentificadorRegistrado", inversedBy="identificadores")
     * @ORM\JoinColumn(name="tipo_id", referencedColumnName="id")
     */
    private $tipo;

    /**
     * Muitos IdentificadoresRegistrados tem Um Pessoa.
     * @ORM\ManyToOne(targetEntity="Pessoa", inversedBy="identificadoresRegistrados")
     * @ORM\JoinColumn(name="pessoa_id", referencedColumnName="id")
     */
    private $pessoa;

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
     * @return mixed
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param TipoIdentificadorRegistrado $tipo
     */
    public function setTipo(TipoIdentificadorRegistrado $tipo)
    {
        $this->tipo = $tipo;
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
     * Set identificador
     *
     * @param string $identificador
     *
     * @return IdentificadorRegistrado
     */
    public function setIdentificador($identificador)
    {
        $this->identificador = $identificador;

        return $this;
    }

    /**
     * Get identificador
     *
     * @return string
     */
    public function getIdentificador()
    {
        return $this->identificador;
    }

    /**
     * Set orgaoExpedidor
     *
     * @param string $orgaoExpedidor
     *
     * @return IdentificadorRegistrado
     */
    public function setOrgaoExpedidor($orgaoExpedidor)
    {
        $this->orgaoExpedidor = $orgaoExpedidor;

        return $this;
    }

    /**
     * Get orgaoExpedidor
     *
     * @return string
     */
    public function getOrgaoExpedidor()
    {
        return $this->orgaoExpedidor;
    }
}
