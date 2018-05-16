<?php
/**
 * Created by PhpStorm.
 * User: Tiago
 * Date: 20/01/2018
 * Time: 19:57
 */

namespace Uloc\Bundle\AppBundle\Services\Stats;


use Doctrine\ORM\EntityManager;
use Uloc\Bundle\AppBundle\Entity\Leilao;
use Uloc\Bundle\AppBundle\Entity\Lote;
use Uloc\Bundle\AppBundle\Entity\Stats\StatsLeilao;
use Uloc\Bundle\AppBundle\Entity\Stats\StatsLote;
use Uloc\Bundle\AppBundle\Entity\Usuario;

class StatsService
{

    private $em;

    /**
     * UserLog constructor.
     * @param object $em EntityManager para persistência do log
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function registraAcessoLeilao(Usuario $usuario = null, Leilao $leilao)
    {
        $stats = new StatsLeilao();
        if (null !== $usuario) {
            $stats->setUsuario($usuario);
        }
        $stats->setLeilao($leilao);

        // TODO: Implement security to prevent attack

        $this->em->persist($stats);
        $this->em->flush();
        return true;
    }

    public function registraAcessoLote(Usuario $usuario = null, Lote $lote)
    {
        $stats = new StatsLote();
        if (null !== $usuario) {
            $stats->setUsuario($usuario);
        }
        $stats->setLote($lote);

        // TODO: Implement security to prevent attack

        $this->em->persist($stats);
        $this->em->flush();
        return true;
    }

}