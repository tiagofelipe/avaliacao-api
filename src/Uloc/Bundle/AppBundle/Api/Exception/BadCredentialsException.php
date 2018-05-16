<?php
namespace Uloc\Bundle\AppBundle\Api\Exception;

use Symfony\Component\Security\Core\Exception\AuthenticationException;

class BadCredentialsException extends AuthenticationException
{
    private $customMessage;
    /**
     * BadCredentialsException constructor.
     */
    public function __construct($message = 'Credenciais inválidas')
    {
        parent::__construct();
        $this->customMessage = $message;
    }

    /**
     * {@inheritdoc}
     */
    public function getMessageKey()
    {
        return $this->customMessage;
    }
}