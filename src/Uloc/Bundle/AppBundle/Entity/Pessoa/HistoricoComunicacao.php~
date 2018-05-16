<?php

namespace Uloc\Bundle\AppBundle\Entity\Pessoa;

use Doctrine\ORM\Mapping as ORM;
use Uloc\Bundle\AppBundle\Entity\ServicoMensagem\Mensagem;

//TODO: Deve existir um event listener para escutar o ServicoMensagem e registrar um histórico de comunicação com uma Pessoa

/**
 * HistoricoComunicacao
 *
 * @ORM\Table(name="pessoa_historico_comunicacao")
 * @ORM\Entity(repositoryClass="Uloc\Bundle\AppBundle\Repository\Pessoa\HistoricoComunicacaoRepository")
 */
class HistoricoComunicacao
{

    /**
     * Método facilitador para construir um histórico de comunicação baseado no Serviço de Mensagem da aplicação
     * @param Pessoa $pessoa
     * @param Mensagem $mensagem
     * @return HistoricoComunicacao instance
     */
    public static function factory(Pessoa $pessoa, Mensagem $mensagem){
        $class = new HistoricoComunicacao();
        $class->setPessoa($pessoa);
        $class->setMensagem($mensagem);
        return $class;
    }

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Muitos HistoricoComunicacao tem Um Pessoa.
     * @ORM\ManyToOne(targetEntity="Pessoa", inversedBy="historicoComunicacao")
     * @ORM\JoinColumn(name="pessoa_id", referencedColumnName="id")
     */
    private $pessoa;

    /**
     * Um Histórico pode estar relacionado à somente um usuário do sistema
     * @ORM\OneToOne(targetEntity="Uloc\Bundle\AppBundle\Entity\Usuario")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     */
    private $usuario;

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
     * Set usuario
     *
     * @param \Uloc\Bundle\AppBundle\Entity\Usuario $usuario
     *
     * @return HistoricoComunicacao
     */
    public function setUsuario(\Uloc\Bundle\AppBundle\Entity\Usuario $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \Uloc\Bundle\AppBundle\Entity\Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
}
