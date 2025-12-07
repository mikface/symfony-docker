<?php

declare(strict_types=1);

namespace App\User\Command;

use App\User\Entity\User;
use App\User\Repository\UserRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use function array_map;
use function json_encode;

use const JSON_THROW_ON_ERROR;

final class ListUsersCommand extends Command
{
    public function __construct(private readonly UserRepository $userRepository) {
        parent::__construct();
    }

    protected function configure(): void {
        $this->setName('app:user:list')
            ->setDescription('Creates a new user.')
            ->setHelp('This command allows you to list all users');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int {
        $table = new Table($output);
        $table->setHeaders(['ID', 'Email', 'Roles']);
        array_map(
            static function (User $user) use ($table): void {
                $table->addRow([$user->id, $user->email, json_encode($user->getRoles(), JSON_THROW_ON_ERROR)]);
            },
            $this->userRepository->getAllUsers(),
        );
        $table->render();

        return Command::SUCCESS;
    }
}
