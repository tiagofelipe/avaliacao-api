<?php

namespace Uloc\Bundle\AppBundle\Entity\Pessoa;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * TipoFinalidadeTelefone
 *
 * @ORM\Table(name="pessoa_tipo_finalidade_telefone")
 * @ORM\Entity(repositoryClass="Uloc\Bundle\AppBundle\Repository\Pessoa\TipoFinalidadeTelefoneRepository")
 */
class TipoFinalidadeTelefone extends TipoFinalidade
{
    const TIPO_PESSOAL = 'system-1';
    const TIPO_TRABALHO = 'system-2';
    const TIPO_OUTROS = 'system-3';

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
     * @ORM\Column(name="nome", type="string", length=100)
     */
    private $nome;

    /**
     * Um TipoFinalidade tem Muitos Telefones
     * @ORM\OneToMany(targetEntity="ContatoTelefone", mappedBy="tipoFinalidade", fetch="EXTRA_LAZY")
     */
    private $telefones;

    public function __construct()
    {
        $this->telefones = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getTelefones()
    {
        return $this->telefones;
    }

    /**
     * @param ContatoTelefone $telefone
     */
    public function addTelefone(ContatoTelefone $telefone)
    {
        $this->telefones[] = $telefone;
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
     * @return TipoFinalidadeTelefone
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
     * Remove telefone
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Pessoa\ContatoTelefone $telefone
     */
    public function removeTelefone(\Uloc\Bundle\AppBundle\Entity\Pessoa\ContatoTelefone $telefone)
    {
        $this->telefones->removeElement($telefone);
    }
}
