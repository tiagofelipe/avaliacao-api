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

use Uloc\Bundle\AppBundle\Entity\Enderecos\Logradouro;
use Uloc\Bundle\AppBundle\Entity\Enderecos\UnidadeFederativa;
use Uloc\Bundle\AppBundle\Entity\Enderecos\Pais;
use Uloc\Bundle\AppBundle\Entity\Estabelecimento;
use Uloc\Bundle\AppBundle\Entity\Funcionario;
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

        /* criando endereços*/
        $this->createEndereco( 'a', '39402302');

        /* criando estabelecimentos*/
        $estab = $this->createEstabelecimento();

        /* criando usuários*/
        $user = $this->createUsuario(Usuario::USER_PANEL, 'usuario', 'teste', 'Usuário Teste', 'usertest@gmail.com', $estab);

        /* criando funcionários*/
        $func1 = $this->createFuncionario($estab);
        $func2 = $this->createFuncionario($estab, 'João da Silva Souza Santos', 'Garçom');
    }

    private function createUsuario ($tipo, $username, $senha, $nome, $email, Estabelecimento $estabelecimento = null) {
        $user = new Usuario();

        $user->setTipoUsuario($tipo);
        $user->setNome($nome);
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPassword($this->encoder->encodePassword($user, $senha));

        $user->setRoles(['ROLE_USER']);

        if ($estabelecimento) {
            $user->addEstabelecimento($estabelecimento);
        }

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

    private function createEstabelecimento($cnpj = '03.486.845/0001-27', $razaoSocial = 'Estabelecimento Cobaia LTDA', $nomeFantasia = 'Estabelecimento Cobaia'){

        $estab = new Estabelecimento();

        $estab->setRazaoSocial($razaoSocial);
        $estab->setNomeFantasia($nomeFantasia);
        $estab->setCnpj($cnpj);

        $this->manager->persist($estab);
        $this->manager->flush();

        return $estab;
    }

    private function  createEndereco( $complemento, $cep){

        $em = $this->manager;

        $pais= new Pais();
        $pais->setSigla('BR');
        $pais->setNome('Brasil');
        $pais->setNomeGlobal('Brasil');
        $em->persist($pais);

        $uf = new UnidadeFederativa();
        $uf->setNome('Minas Gerais');
        $uf->setSigla('MG');
        $uf->setPais($pais);
        $em->persist($uf);

        $municipio=new \Uloc\Bundle\AppBundle\Entity\Enderecos\Municipio();
        $municipio->setNome('Montes Claros');
        $municipio-> setIbge('MOC');
        $municipio->setUf($uf);
        $em->persist($municipio);

        $bairro=new \Uloc\Bundle\AppBundle\Entity\Enderecos\Bairro();
        $bairro->setMunicipio($municipio);
        $bairro->setNome('Centro');
        $em->persist($bairro);


        $rua = new Logradouro();
        $rua->setBairro($bairro);
        $rua->setCep('39400000');
        $rua->setLogradouro('avenida');
        $em->persist($rua);

        $endereco = new \Uloc\Bundle\AppBundle\Entity\Enderecos\Endereco();
        $endereco->setLogradouro($rua);

        $endereco->setComplemento($complemento);
        $endereco->setCep($cep);
        $em->persist($endereco);
        $em->flush();
        return $endereco;

    }

    public function createFuncionario (Estabelecimento $estabelecimento, $nome = 'Funcionário Teste', $cargo = 'Tester', $foto = null) {
        $func = new Funcionario();

        $func->setNome($nome);
        $func->setCargo($cargo);
        $func->setFoto($foto);
        $func->setEstabelecimento($estabelecimento);

        $this->manager->persist($func);
        $this->manager->flush();

        return $func;
    }
}