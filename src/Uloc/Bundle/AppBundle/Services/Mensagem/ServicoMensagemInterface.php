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

/**
 * O sistema deve prover uma arquitetura e funcionalidades para um serviço de
 * envio de mensagem.
 * @author Tiago Felipe
 * @version 0.0.1
 */
interface ServicoMensagemInterface
{
    /*
     * TODO: Criar doc dos métodos
     */
    public function setTransmissor();
    public function getTransmissor();
    public function getRemetenteNome();
    public function getRemetente();
    public function getDestinatarioNome();
    public function getDestinatario();

}