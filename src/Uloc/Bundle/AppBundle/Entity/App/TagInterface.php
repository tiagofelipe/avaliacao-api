<?php
/**
 * Este arquivo é parte do código fonte Uloc
 *
 * (c) Tiago Felipe <tiago@tiagofelipe.com>
 *
 * Para informações completas dos direitos autorais, por favor veja o arquivo LICENSE
 * distribuído junto com o código fonte.
 */

namespace Uloc\Bundle\AppBundle\Entity\App;


/**
 * @author Tiago Felipe
 * @version 0.0.1
 */
interface TagInterface
{

    /**
     * Retorna o nome da tag
     *
     * @return string Uma tag
     */
    public function getNome();


}