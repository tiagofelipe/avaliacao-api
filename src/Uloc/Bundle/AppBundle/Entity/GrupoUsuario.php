<?php

namespace Uloc\Bundle\AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * GrupoUsuario
 *
 * @ORM\Table(name="app_usuario_grupo")
 * @ORM\Entity(repositoryClass="Uloc\Bundle\AppBundle\Repository\GrupoUsuarioRepository")
 */
class GrupoUsuario
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
     * @ORM\Column(name="titulo", type="string", length=50)
     */
    private $titulo;

    /**
     * @var \stdClass
     *
     * @ORM\Column(name="acl", type="object")
     */
    private $acl;

    /**
     * Many Groups have Many Users.
     * @ORM\ManyToMany(targetEntity="Usuario", mappedBy="grupos")
     */
    private $usuarios;

    /**
     * Um Pai tem Muitos Filhos
     * @ORM\OneToMany(targetEntity="GrupoUsuario", mappedBy="pai")
     */
    private $filhos;

    /**
     * Muitos Filhos tem Um GrupoUsuario.
     * @ORM\ManyToOne(targetEntity="GrupoUsuario", inversedBy="filhos")
     * @ORM\JoinColumn(name="pai_id", referencedColumnName="id")
     */
    private $pai;

    /**
     * @return mixed
     */
    public function getPai()
    {
        return $this->pai;
    }

    /**
     * @param GrupoUsuario $pai
     */
    public function setPai(GrupoUsuario $pai)
    {
        $this->pai = $pai;
    }

    /**
     * @return mixed
     */
    public function getFilhos()
    {
        return $this->filhos;
    }

    /**
     * @param GrupoUsuario $filho
     */
    public function addFilho(GrupoUsuario $filho)
    {
        $this->filhos[] = $filho;
    }

    /**
     * GrupoUsuario constructor.
     */
    public function __construct()
    {
        $this->usuarios = new ArrayCollection();
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
     * Set titulo
     *
     * @param string $titulo
     *
     * @return GrupoUsuario
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get titulo
     *
     * @return string
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set acl
     *
     * @param \stdClass $acl
     *
     * @return GrupoUsuario
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

    /**
     * @return mixed
     */
    public function getUsuarios()
    {
        return $this->usuarios;
    }

    /**
     * @param mixed $usuario
     */
    public function addUsuario(Usuario $usuario)
    {
        $this->usuarios[] = $usuario;
    }


    /**
     * Remove usuario
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Usuario $usuario
     */
    public function removeUsuario(\Uloc\Bundle\AppBundle\Entity\Usuario $usuario)
    {
        $this->usuarios->removeElement($usuario);
    }

    /**
     * Remove filho
     *
     * @param \Uloc\Bundle\AppBundle\Entity\GrupoUsuario $filho
     */
    public function removeFilho(\Uloc\Bundle\AppBundle\Entity\GrupoUsuario $filho)
    {
        $this->filhos->removeElement($filho);
    }
}
