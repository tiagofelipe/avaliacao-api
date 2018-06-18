<?php

namespace Uloc\Bundle\AppBundle\Entity\Endereco;

use Doctrine\ORM\Mapping as ORM;

/**
 * TipoFinalidade
 *
 * @ORM\MappedSuperclass()
 */
abstract class TipoFinalidade
{

    /**
     * @var string
     *
     * @ORM\Column(name="codigo", type="string", length=100, unique=true)
     */
    private $codigo;

    public function __construct()
    {
    }

    /**
     * @return string
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * @param string $codigo
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }

}
