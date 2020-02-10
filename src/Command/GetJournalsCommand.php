<?php

namespace App\Command;

use App\Entity\JournalEntry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class GetJournalsCommand extends Command
{
    protected static $defaultName = 'app:get-journals';

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Get all journal entries')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $journal_repo = $this->em->getRepository(JournalEntry::class);

        //
        // USE CASE: Querying objects through repository findAll() method
        //
        $io->section('Querying entities through repository findAll method');
        $journal_entries = $journal_repo->findAll();
        $io->writeln(json_encode($journal_entries, JSON_PRETTY_PRINT));

        //
        // USE CASE: Querying objects through a findBy method
        //
        $io->section('Querying entities through repository findBy method using changed column name');
        $journal_entries = $journal_repo->findBy(['body' => 'Super secret hidden column']);
        $io->writeln(json_encode($journal_entries, JSON_PRETTY_PRINT));

        //
        // USE CASE: Querying objects with a QueryBuilder using a changed column name
        //
        $io->section('Querying objects with a QueryBuilder using a changed column name');
        $qb = $this->em->createQueryBuilder();
        $query = $qb->select('j')
            ->from(JournalEntry::class, 'j')
            ->where($qb->expr()->orX(
                $qb->expr()->eq('j.body', ':body1'),
                $qb->expr()->eq('j.body', ':body2')))
            ->orderBy('j.body', 'DESC')
            ->setParameters(
                [
                    'body1' => 'Super secret hidden column',
                    'body2' => 'This field is secret',
                ])
            ->getQuery();
        $journal_entries = $query->getResult();
        $io->writeln(json_encode($journal_entries, JSON_PRETTY_PRINT));

        //
        // USE CASE: Querying objects directly using DQL
        //
        $io->section('Querying entities through DQL');
        $query = $this->em->createQuery('SELECT j FROM ' . JournalEntry::class . ' j WHERE j.body = :body');
        $query->setParameter('body', 'Super secret hidden column');
        $journal_entries = $query->getResult();
        $io->writeln(json_encode($journal_entries, JSON_PRETTY_PRINT));

        return 0;
    }
}
