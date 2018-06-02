<?php
/**
 * Created by PhpStorm.
 * User: raphael
 * Date: 29/05/18
 * Time: 18:57
 */

namespace Uloc\Bundle\AppBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Uloc\Bundle\AppBundle\Entity\Usuario;

class AppFixtures extends Fixture
{

    /**
     * @var ObjectManager
     */
    private $manager;
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $this->createUsuario(Usuario::USER_PANEL, 'usuario', 'teste', 'Usuário Teste', 'usertest@gmail.com');
    }

    private function createUsuario ($tipo, $username, $senha, $nome, $email) {
        $user = new Usuario();

        $user->setTipoUsuario($tipo);
        $user->setNome($nome);
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPassword($this->encoder->encodePassword($user, $senha));

        $user->setRoles(['ROLE_USER']);

        /*
        if (intval($tipo) === Usuario::USUARIO_ROOT) {
            $user->setRoles(['ROLE_ROOT']);
        } elseif(intval($tipo) === Usuario::USER_PANEL) {
            $user->setRoles(['ROLE_GERENTE']);
        } elseif (intval($tipo) === Usuario::USER_APP) {
            $user->setRoles(['ROLE_CLIENT']);
        } elseif (intval($tipo) === Usuario::USER_PUBLIC) {
            $user->setRoles([]);
        } */

        $this->manager->persist($user);
        $this->manager->flush();

        return $user;
    }
}