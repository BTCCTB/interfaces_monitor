<?php

namespace App\Command;

use App\Entity\Group;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class UserPromoteCommand extends Command
{
    protected static $defaultName = 'user:promote';

    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct(self::$defaultName);
    }

    protected function configure()
    {
        $this
            ->setDescription('Promote a user by addind this user to admin group')
            ->setHelp(<<<'EOT'
The <info>user:promote</info> command promotes a user by adding this user to admin group
  <info>php %command.full_name% firstname.lastname@enabel.be</info>
EOT
            )
            ->addArgument(
                'email',
                InputArgument::REQUIRED,
                'User email [@enabel.be]?'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $console = new SymfonyStyle($input, $output);
        $email = $input->getArgument('email');

        if ($email) {
            $console->note(sprintf('You are trying to promote : "%s"', $email));
            $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);
            $group = $this->entityManager->getRepository(Group::class)->findOneBy(['name' => 'Admin']);
            $user->addGroup($group);
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        }

        $console->success(sprintf('Success! The user "%s" has been promoted to admin.', $email));
    }
}
