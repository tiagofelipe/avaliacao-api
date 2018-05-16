<?php
/**
 * Este arquivo é parte do código fonte Uloc
 *
 * (c) Tiago Felipe <tiago@tiagofelipe.com>
 *
 * Para informações completas dos direitos autorais, por favor veja o arquivo LICENSE
 * distribuído junto com o código fonte.
 */

namespace Uloc\Bundle\AppBundle\Services\Log;

use Doctrine\ORM\EntityManager;
use Uloc\Bundle\AppBundle\Entity\Usuario;

/**
 * Serviço responsável pelo armazenamento do Logger de todas as ações dos usuários
 */
class UserLog implements LogInterface
{

    private $em;
    /**
     * UserLog constructor.
     * @param object $em    EntityManager para persistência do log
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function log(Usuario $user, $mensagem, $entidade, $acao, $contexto, $oldObject, $newObject){

    }

}