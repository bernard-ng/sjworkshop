<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class CreateUserCommand
 * @package App\Command
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class CreateUserCommand extends Command
{
    protected static $defaultName = 'app:create-user';
    private EntityManagerInterface $manager;
    private UserPasswordEncoderInterface $encoder;

    /**
     * CreateUserCommand constructor.
     * @param EntityManagerInterface $manager
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {
        parent::__construct(self::$defaultName);
        $this->manager = $manager;
        $this->encoder = $encoder;
    }

    /**
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    protected function configure()
    {
        $this
            ->setDescription('Create The Default User')
            ->setHelp('This command allows you to create a user...')
            ->addOption('email', null, InputOption::VALUE_REQUIRED, 'The User Email')
            ->addOption('password', 'p', InputOption::VALUE_REQUIRED, 'The user password')
            ->addOption('role', 'r', InputArgument::OPTIONAL, 'The user role', "ROLE_USER");
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $user = User::register($input->getOption('email'), $input->getOption('role'));
        $password = $this->encoder->encodePassword($user, $input->getOption('password'));
        $user->setPassword($password);

        $this->manager->persist($user);
        $this->manager->flush();

        $io->success(sprintf('User %s Created', $input->getOption('email')));
        return 0;
    }
}
