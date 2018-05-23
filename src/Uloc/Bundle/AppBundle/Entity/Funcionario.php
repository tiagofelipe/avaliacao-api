<?php

namespace Uloc\Bundle\AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Uloc\Bundle\AppBundle\Serializer\ApiRepresentationMetadataInterface;

/**
 * Funcionario
 *
 * @ORM\Table(name="funcionario")
 * @ORM\Entity(repositoryClass="Uloc\Bundle\AppBundle\Repository\FuncionarioRepository")
 */
class Funcionario
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
     * @var string|null
     *
     * @ORM\Column(name="foto", type="string", length=255, nullable=true)
     */
    private $foto;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nome", type="string", length=255)
     */
    private $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="cargo", type="string", length=100)
     */
    private $cargo;

    /**
     * @var Estabelecimento
     *
     * @ORM\ManyToOne(targetEntity="Uloc\Bundle\AppBundle\Entity\Estabelecimento", inversedBy="funcionarios")
     */
    private $estabelecimento;

    /**
     * @var Avaliacao[]
     *
     * @ORM\OneToMany(targetEntity="Uloc\Bundle\AppBundle\Entity\Avaliacao", mappedBy="funcionario")
     */
    private $avaliacoes;

    public function __construct()
    {
        $this->avaliacoes = new ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set foto.
     *
     * @param string|null $foto
     *
     * @return Funcionario
     */
    public function setFoto($foto = null)
    {
        $this->foto = $foto;

        return $this;
    }

    /**
     * Get foto.
     *
     * @return string|null
     */
    public function getFoto()
    {
        return $this->foto;
    }

    /**
     * Set nome.
     *
     * @param string|null $nome
     *
     * @return Funcionario
     */
    public function setNome($nome = null)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get nome.
     *
     * @return string|null
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set cargo.
     *
     * @param string $cargo
     *
     * @return Funcionario
     */
    public function setCargo($cargo)
    {
        $this->cargo = $cargo;

        return $this;
    }

    /**
     * Get cargo.
     *
     * @return string
     */
    public function getCargo()
    {
        return $this->cargo;
    }

    /**
     * @return Estabelecimento
     */
    public function getEstabelecimento()
    {
        return $this->estabelecimento;
    }

    /**
     * @param Estabelecimento $estabelecimento
     * @return Funcionario
     */
    public function setEstabelecimento(Estabelecimento $estabelecimento)
    {
        $this->estabelecimento = $estabelecimento;

        return $this;
    }

    /**
     * @return Avaliacao[]
     */
    public function getAvaliacoes()
    {
        return $this->avaliacoes;
    }

    /**
     * @param Avaliacao $avaliacao
     */
    public function addAvaliacoes(Avaliacao $avaliacao)
    {
        $this->avaliacoes = $avaliacao;
    }
    public static function loadApiRepresentation(ApiRepresentationMetadataInterface $representation)
    {
        $representation->setGroup('public')
            ->addProperties([
                'id',
                'foto',
                'nome',
                'cargo',
                'estabelecimento'=>
                    array('id','cnpj', 'nomeFantasia', 'razaoSocial','tipo'),
                'avaliacoes'=>
                    array('id','comentario','dataCriacao','nota', 'usuario'=>
                        array('nome','id'))
            ]);
        $representation->build();
    }
}
