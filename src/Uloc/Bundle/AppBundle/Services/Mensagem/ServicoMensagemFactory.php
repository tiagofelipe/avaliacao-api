<?php
/**
 * Este arquivo é parte do código fonte Uloc
 *
 * (c) Tiago Felipe <tiago@tiagofelipe.com>
 *
 * Para informações completas dos direitos autorais, por favor veja o arquivo LICENSE
 * distribuído junto com o código fonte.
 */

namespace Uloc\Bundle\AppBundle\Services\Mensagem;
use Doctrine\ORM\EntityManager;
use Uloc\Bundle\AppBundle\Entity\ServicoMensagem\Mensagem;

/**
 * Responsável por construir uma mensagem
 * @author Tiago Felipe
 * @version 0.0.1
 */
class ServicoMensagemFactory
{

    public function __construct(EntityManager $em)
    {
    }

    /**
     * Cria uma nova instancia de ServicoMensagem e adiciona o transmissor de acordo o
     * tipo e adiciona a mensagem na fila para envio.
     *
     * O retorno é o ID da mensagem na fila. Com este ID é possível fazer checagens de
     * status e outros dados.
     *
     * @param ServicoMensagemTransmissorInterface $transmissor  Transmissor responsável pelo envio/tipo da mensagem. Exemplo: SMS, Email, Whatsapp, Voice
     * @param string    nomeRemetente
     * @param string    remetente
     * @param string    nomeDestinatario
     * @param string    destinatario
     *
     * @return Mensagem se tudo ocorrer com sucesso ou NULL em caso de erro
     */
    public function queue(ServicoMensagemTransmissorInterface $transmissor, $nomeRemetente, $remetente, $nomeDestinatario, $destinatario)
    {
        //TODO: Transmitir uma mensagem. Código abaixo é somente de exemplo
        $transmissor->transmitir();
        return new Mensagem();
    }

    /**
     * @param id
     * @return \Uloc\Bundle\AppBundle\Entity\ServicoMensagem\Mensagem
     */
    public function find($id)
    {
    }

}