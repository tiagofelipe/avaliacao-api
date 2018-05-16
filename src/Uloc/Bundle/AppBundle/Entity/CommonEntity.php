<?php
/**
 * Este arquivo é parte do código fonte Uloc
 *
 * (c) Tiago Felipe <tiago@tiagofelipe.com>
 *
 * Para informações completas dos direitos autorais, por favor veja o arquivo LICENSE
 * distribuído junto com o código fonte.
 */

namespace Uloc\Bundle\AppBundle\Entity;


use Uloc\Bundle\AppBundle\Serializer\ApiRepresentationMetadataInterface;

abstract class CommonEntity
{

    abstract static function loadApiRepresentation(ApiRepresentationMetadataInterface $representation);

}
