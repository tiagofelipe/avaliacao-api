<?php

namespace Uloc\Bundle\AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Uloc\Bundle\AppBundle\Entity\Usuario;

class UlocUserCreateCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('uloc:user:create')
            ->setDescription('Criar um novo usuário')
            ->addArgument('usuario', InputArgument::REQUIRED, 'Nome do usuário')
            ->addArgument('senha', InputArgument::REQUIRED, 'Senha do usuário')
            ->addOption('roles', null, InputOption::VALUE_REQUIRED, 'Roles do usuário, separando-os por vírgula. Ex: ROLE_USER,ROLEINTRANET')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $username = $input->getArgument('usuario');
        $plainPassword = $input->getArgument('senha');
        $em = $this->getContainer()->get("doctrine.orm.entity_manager");
        $findUser = $em->getRepository("UlocAppBundle:Usuario")->findOneBy(['username' => $username]);
        if($findUser){
            $io->error("Já existe um usuário com o nome ".$username."!");
            return;
        }

        $user = new Usuario();
        $user->setUsername($username);
        $user->setEmail($username . '@wtis.com.br');
        $password = $this->getContainer()->get('security.password_encoder')
            ->encodePassword($user, $plainPassword);
        $user->setPassword($password);

        $user->setRoles(['ROLE_USER']);

        if ($input->getOption('roles')) {
            $roles = explode(',', $input->getOption('roles'));
            $user->setRoles($roles);
        }

        $em->persist($user);
        $em->flush();

        $io->title('Usuário '.$username. ' criado com sucesso!');
        $io->text('Email: '. $user->getEmail() );
        $io->text('Senha: '. $plainPassword );
        $io->newLine();
    }

}
