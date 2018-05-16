<?php

namespace Uloc\Bundle\AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class UlocTokenGetCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('uloc:token:get')
            ->setDescription('Criar um novo token para um usuário')
            ->addArgument('usuario', InputArgument::REQUIRED, 'Nome do usuário')
            ->addOption('exp', null, InputOption::VALUE_REQUIRED, 'Expiração do token em horas. Exemplo: 27H')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $username = $input->getArgument('usuario');
        $em = $this->getContainer()->get("doctrine.orm.entity_manager");
        $findUser = $em->getRepository("UlocAppBundle:Usuario")->findOneBy(['username' => $username]);
        if($findUser === null || count($findUser) < 1){
            $io->error("Usuário ".$username." não encontrado!");
            return;
        }

        $exp = 3600; //1 hora

        if ($input->getOption('exp')) {
            $exp = (intval( preg_replace('/\D/', '', $input->getOption('exp')) ) * 60) * 60;
        }
        $tempoEmHoras = ($exp/60)/60;

        $token = $this->getContainer()->get('lexik_jwt_authentication.encoder')
            ->encode([
                'username' => $username,
                'exp' => time() + $exp
            ]);

        $io->title('Token para '.$username);
        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        $date = strftime("%d de %B de %G %H:%M", time() + $exp);
        $io->text('Expira em '. $date . ' ('. $tempoEmHoras .' hora'. ($tempoEmHoras>1?'s':'').')' );
        $io->newLine();
        $output->writeln('<info>'.$token.'</info>');
        /*$output->writeln([
            'Token para '.$username,
            'Expiração: '. ($exp/60)/60 .' horas',
            '====================================',
            '<info>'.$token.'</info>',
        ]);*/
    }

}
