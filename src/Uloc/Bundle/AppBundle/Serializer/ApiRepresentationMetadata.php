<?php
/**
 * Este arquivo é parte do código fonte Uloc
 *
 * (c) Tiago Felipe <tiago@tiagofelipe.com>
 *
 * Para informações completas dos direitos autorais, por favor veja o arquivo LICENSE
 * distribuído junto com o código fonte.
 */


namespace Uloc\Bundle\AppBundle\Serializer;


use Symfony\Component\Process\Exception\RuntimeException;

class ApiRepresentationMetadata implements ApiRepresentationMetadataInterface
{
    private $group = 'public';
    private $properties = array();

    /**
     * @param $groupName
     * @return ApiRepresentationMetadata
     */
    public function setGroup($groupName)
    {
        $this->group = $groupName;
        return $this;
    }

    public function addProperties($props)
    {
        if (!is_array($props)) {
            throw new RuntimeException('Erro ao adicionar propriedades ao ApiRepresentationMetadata. Props não é um array');
        }
        $this->properties[$this->group] =
            isset($this->properties[$this->group])
                ? array_merge($this->properties[$this->group], $props)
                : $props;

        return $this;
    }

    public function build()
    {
        // TODO: Implement builder() method.
    }

    /**
     * TODO: Verificar obrigatoriedade da existência de ao menos um grupo (public)
     * @return array
     */
    public function getProperties($group = null)
    {
        if (null !== $group) {
            return isset($this->properties[$group])
                ? $this->properties[$group]
                : $this->properties;
        }
        return $this->properties;
    }


}