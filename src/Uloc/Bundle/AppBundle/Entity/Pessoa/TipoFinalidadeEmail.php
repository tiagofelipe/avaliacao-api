<?php

namespace Uloc\Bundle\AppBundle\Entity\Pessoa;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * TipoFinalidadeEmail
 *
 * @ORM\Table(name="pessoa_tipo_finalidade_email")
 * @ORM\Entity(repositoryClass="Uloc\Bundle\AppBundle\Repository\Pessoa\TipoFinalidadeEmailRepository")
 */
class TipoFinalidadeEmail extends TipoFinalidade
{

    const TIPO_PESSOAL = 'system-1';
    const TIPO_TRABALHO = 'system-2';

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
     * Um TipoFinalidade tem Muitos Emails
     * @ORM\OneToMany(targetEntity="ContatoEmail", mappedBy="tipoFinalidade", fetch="EXTRA_LAZY")
     */
    private $emails;

    public function __construct()
    {
        $this->emails = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getEmails()
    {
        return $this->emails;
    }

    /**
     * @param ContatoEmail $email
     */
    public function addEmail(ContatoEmail $email)
    {
        $this->emails[] = $email;
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
     * @return TipoFinalidadeEmail
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
     * Remove email
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Pessoa\ContatoEmail $email
     */
    public function removeEmail(\Uloc\Bundle\AppBundle\Entity\Pessoa\ContatoEmail $email)
    {
        $this->emails->removeElement($email);
    }
}
