<?php
/**
 * Este arquivo é parte do código fonte Uloc
 *
 * (c) Tiago Felipe <tiago@tiagofelipe.com>
 *
 * Para informações completas dos direitos autorais, por favor veja o arquivo LICENSE
 * distribuído junto com o código fonte.
 */

namespace Uloc\Bundle\AppBundle\Entity\Pessoa;

use Doctrine\ORM\Mapping as ORM;

/**
 * Uma pessoa pode ter vários papéis.
 *
 * Exemplos:
 *
 * - Tiago (Pessoa) é (Papel) CEO (Tipo Papel) da Wtis (Pessoa/superPapel)
 * - João é Representante Comercial de Pedro
 *
 * @ORM\Table(name="pessoa_papel")
 * @ORM\Entity(repositoryClass="Uloc\Bundle\AppBundle\Repository\Pessoa\PapelRepository")
 */
class Papel
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
     * @var \DateTime
     *
     * @ORM\Column(name="inicio", type="date")
     */
    private $inicio;

    /**
     * Se fim for preenchido quer dizer que este papel não é mais exercido por esta pessoa
     *
     * @var \DateTime
     *
     * @ORM\Column(name="fim", type="date", nullable=true)
     */
    private $fim;

    /**
     * Muitos Papeis tem Um Pessoa.
     * @ORM\ManyToOne(targetEntity="Pessoa", inversedBy="papeis")
     * @ORM\JoinColumn(name="pessoa_id", referencedColumnName="id")
     */
    private $pessoa;

    /**
     * Muitos SuperPapeis tem Um Pessoa.
     * @ORM\ManyToOne(targetEntity="Pessoa", inversedBy="superPapeis")
     * @ORM\JoinColumn(name="super_pessoa_id", referencedColumnName="id")
     */
    private $superPessoa;

    /**
     * Muitos Papeis tem Um TipoPapel.
     * @ORM\ManyToOne(targetEntity="TipoPapel", inversedBy="papeis")
     * @ORM\JoinColumn(name="tipo_papel_id", referencedColumnName="id")
     */
    private $tipoPapel;

    /**
     * @return mixed
     */
    public function getTipoPapel()
    {
        return $this->tipoPapel;
    }

    /**
     * @param TipoPapel $tipoPapel
     */
    public function setTipoPapel(TipoPapel $tipoPapel)
    {
        $this->tipoPapel = $tipoPapel;
    }

    /**
     * @return mixed
     */
    public function getSuperPessoa()
    {
        return $this->superPessoa;
    }

    /**
     * @param Pessoa $superPessoa
     */
    public function setSuperPessoa(Pessoa $superPessoa)
    {
        $this->superPessoa = $superPessoa;
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
     * Set inicio
     *
     * @param \DateTime $inicio
     *
     * @return Papel
     */
    public function setInicio($inicio)
    {
        $this->inicio = $inicio;

        return $this;
    }

    /**
     * Get inicio
     *
     * @return \DateTime
     */
    public function getInicio()
    {
        return $this->inicio;
    }

    /**
     * Set fim
     *
     * @param \DateTime $fim
     *
     * @return Papel
     */
    public function setFim($fim)
    {
        $this->fim = $fim;

        return $this;
    }

    /**
     * Get fim
     *
     * @return \DateTime
     */
    public function getFim()
    {
        return $this->fim;
    }
}
