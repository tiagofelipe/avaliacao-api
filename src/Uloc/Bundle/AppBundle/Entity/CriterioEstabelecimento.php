<?php

namespace Uloc\Bundle\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CriterioEstabelecimento
 *
 * @ORM\Table(name="criterio_estabelecimento")
 * @ORM\Entity(repositoryClass="Uloc\Bundle\AppBundle\Repository\CriterioEstabelecimentoRepository")
 */
class CriterioEstabelecimento
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
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
