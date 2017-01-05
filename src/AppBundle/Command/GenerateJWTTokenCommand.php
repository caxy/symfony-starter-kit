<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateJWTTokenCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('generate:token')
            ->addArgument('username', InputArgument::REQUIRED)
        ;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \LogicException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var \FOS\UserBundle\Model\UserManagerInterface $userManager */
        $userManager = $this->getContainer()->get('fos_user.user_manager');
        $username = $input->getArgument('username');

        $user = $userManager->findUserByUsername($username);

        $jwtManager = $this->getContainer()->get('lexik_jwt_authentication.jwt_manager');

        $token = $jwtManager->create($user);
        $output->writeln($token);
    }
}
