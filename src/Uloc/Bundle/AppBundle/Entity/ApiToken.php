<?php

namespace Uloc\Bundle\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ApiToken
 *
 * @ORM\Table(name="api_token")
 * @ORM\Entity(repositoryClass="Uloc\Bundle\AppBundle\Repository\ApiTokenRepository")
 */
class ApiToken
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
     * @ORM\Column(name="token", type="string", length=100, unique=true)
     */
    private $token;

    /**
     * @var \stdClass
     *
     * @ORM\Column(name="permissoes", type="object")
     */
    private $permissoes;

    /**
     * @var string
     *
     * @ORM\Column(name="notas", type="text", nullable=true)
     */
    private $notas;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dataCriacao", type="datetime")
     */
    private $dataCriacao;


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
     * Set token
     *
     * @param string $token
     *
     * @return ApiToken
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set permissoes
     *
     * @param \stdClass $permissoes
     *
     * @return ApiToken
     */
    public function setPermissoes($permissoes)
    {
        $this->permissoes = $permissoes;

        return $this;
    }

    /**
     * Get permissoes
     *
     * @return \stdClass
     */
    public function getPermissoes()
    {
        return $this->permissoes;
    }

    /**
     * Set notas
     *
     * @param string $notas
     *
     * @return ApiToken
     */
    public function setNotas($notas)
    {
        $this->notas = $notas;

        return $this;
    }

    /**
     * Get notas
     *
     * @return string
     */
    public function getNotas()
    {
        return $this->notas;
    }

    /**
     * Set dataCriacao
     *
     * @param \DateTime $dataCriacao
     *
     * @return ApiToken
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
}
