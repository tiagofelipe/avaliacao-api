<?php

namespace Uloc\Bundle\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Uloc\Bundle\AppBundle\Serializer\ApiRepresentationMetadataInterface;

/**
 * Contato
 *
 * @ORM\Table(name="contato")
 * @ORM\Entity(repositoryClass="Uloc\Bundle\AppBundle\Repository\ContatoRepository")
 */
class Contato
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
     * @ORM\Column(name="nome", type="string", length=255)
     */
    private $nome;

    /**
     * @var string
     * @Assert\Email(
     *     message = "O email '{{ value }}' não é válido.",
     *     checkMX = true
     * )
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="telefone", type="string", length=60)
     */
    private $telefone;

    /**
     * @var string
     *
     * @ORM\Column(name="assunto", type="string", length=255)
     */
    private $assunto;

    /**
     * @var string
     *
     * @ORM\Column(name="mensagem", type="text")
     */
    private $mensagem;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_respondido", type="boolean")
     */
    private $isRespondido;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data", type="datetime")
     */
    private $data;

    /**
     * @var boolean
     *
     * @ORM\Column(name="lido", type="boolean")
     */
    private $lido;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_excluido", type="boolean")
     */
    private $isExcluido;

    public function __construct()
    {
        $this->data = new \DateTime();
        $this->isRespondido = false;
        $this->lido = false;
        $this->isExcluido = false;
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
     * @return Contato
     */
    public function setNome($nome)
    {
        $this->nome = trim(ucwords(strtolower($nome)));

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
     * Set email
     *
     * @param string $email
     *
     * @return Contato
     */
    public function setEmail($email)
    {
        $this->email = trim(strtolower($email));

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
     * Set telefone
     *
     * @param string $telefone
     *
     * @return Contato
     */
    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;

        return $this;
    }

    /**
     * Get telefone
     *
     * @return string
     */
    public function getTelefone()
    {
        return $this->telefone;
    }

    /**
     * Set assunto
     *
     * @param string $assunto
     *
     * @return Contato
     */
    public function setAssunto($assunto)
    {
        $this->assunto = $assunto;

        return $this;
    }

    /**
     * Get assunto
     *
     * @return string
     */
    public function getAssunto()
    {
        return $this->assunto;
    }

    /**
     * Set mensagem
     *
     * @param string $mensagem
     *
     * @return Contato
     */
    public function setMensagem($mensagem)
    {
        $this->mensagem = $mensagem;

        return $this;
    }

    /**
     * Get mensagem
     *
     * @return string
     */
    public function getMensagem()
    {
        return $this->mensagem;
    }

    /**
     * @return bool
     */
    public function getIsRespondido()
    {
        return $this->isRespondido;
    }

    /**
     * @param bool $isRespondido
     */
    public function setIsRespondido($isRespondido)
    {
        $this->isRespondido = $isRespondido;
    }

    /**
     * @return \DateTime
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param \DateTime $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    public static function loadApiRepresentation(ApiRepresentationMetadataInterface $representation)
    {
        $representation->setGroup('public')
            ->addProperties([
                'id',
                'nome',
                'email',
                'telefone',
                'assunto',
                'mensagem',
                'data',
                'isRespondido',
                'lido',
                'isExcluido'
            ]);
        $representation->build();

    }

    /**
     * @return bool
     */
    public function getLido()
    {
        return $this->lido;
    }

    /**
     * @param bool $lido
     */
    public function setLido($lido)
    {
        $this->lido = $lido;
    }

    /**
     * @return bool
     */
    public function isExcluido()
    {
        return $this->isExcluido;
    }

    /**
     * @param bool $isExcluido
     */
    public function setIsExcluido($isExcluido)
    {
        $this->isExcluido = $isExcluido;
    }
}

