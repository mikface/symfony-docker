<?php

declare(strict_types=1);

namespace App\User\Command;

use App\User\Entity\User;
use App\User\Repository\UserRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use function array_map;
use function json_encode;

class ListUsersCommand extends Command
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userManager)
    {
        $this->userRepository = $userManager;

        parent::__construct();
    }

    protected function configure() : void
    {
        $this->setName('app:user:list')
            ->setDescription('Creates a new user.')
            ->setHelp('This command allows you to list all users');
    }

    protected function execute(InputInterface $input, OutputInterface $output) : int
    {
        array_map(
            static function (User $user) use ($output) : void {
                $output->writeln('Email: ' . $user->getEmail() . ' | Roles: ' . json_encode($user->getRoles()));
            },
            $this->userRepository->getAllUsers()
        );

        return Command::SUCCESS;
    }
}
