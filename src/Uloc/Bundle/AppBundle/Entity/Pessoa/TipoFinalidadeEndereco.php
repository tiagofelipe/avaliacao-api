<?php

namespace Uloc\Bundle\AppBundle\Entity\Pessoa;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * TipoFinalidadeEndereco
 *
 * @ORM\Table(name="pessoa_tipo_finalidade_endereco")
 * @ORM\Entity(repositoryClass="Uloc\Bundle\AppBundle\Repository\Pessoa\TipoFinalidadeEnderecoRepository")
 */
class TipoFinalidadeEndereco extends TipoFinalidade
{

    const TIPO_RESIDENCIAL = 'system-1';
    const TIPO_COMERCIAL = 'system-2';

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
     * Um Finalidade tem Muitos Enderecos
     * @ORM\OneToMany(targetEntity="EnderecoFisico", mappedBy="finalidade", fetch="EXTRA_LAZY")
     */
    private $enderecos;

    /**
     * TipoFinalidadeEndereco constructor.
     */
    public function __construct()
    {
        $this->enderecos = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getEnderecos()
    {
        return $this->enderecos;
    }

    /**
     * @param EnderecoFisico $endereco
     */
    public function addEndereco(EnderecoFisico $endereco)
    {
        $this->enderecos[] = $endereco;
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
     * @return TipoFinalidadeEndereco
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
     * Remove endereco
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Pessoa\EnderecoFisico $endereco
     */
    public function removeEndereco(\Uloc\Bundle\AppBundle\Entity\Pessoa\EnderecoFisico $endereco)
    {
        $this->enderecos->removeElement($endereco);
    }
}
