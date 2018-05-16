<?php

namespace Uloc\Bundle\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UsuarioACL
 *
 * @ORM\Table(name="app_usuario_acl")
 * @ORM\Entity(repositoryClass="Uloc\Bundle\AppBundle\Repository\UsuarioACLRepository")
 */
class UsuarioACL
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
     * @var \stdClass
     *
     * @ORM\Column(name="acl", type="object")
     */
    private $acl;

    /**
     * One ACL existe One Usuario.
     * @ORM\OneToOne(targetEntity="Usuario", inversedBy="acl")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     */
    private $usuario;

    /**
     * @return mixed
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param mixed $usuario
     */
    public function setUsuario(Usuario $usuario)
    {
        $this->usuario = $usuario;
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
     * Set acl
     *
     * @param \stdClass $acl
     *
     * @return UsuarioACL
     */
    public function setAcl($acl)
    {
        $this->acl = $acl;

        return $this;
    }

    /**
     * Get acl
     *
     * @return \stdClass
     */
    public function getAcl()
    {
        return $this->acl;
    }
}
