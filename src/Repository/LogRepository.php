<?php

namespace App\Repository;

use App\Entity\Job;
use App\Entity\Log;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Log|null find($id, $lockMode = null, $lockVersion = null)
 * @method Log|null findOneBy(array $criteria, array $orderBy = null)
 * @method Log[]    findAll()
 * @method Log[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LogRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Log::class);
    }

    /**
     * Get X last execution log for a given job
     *
     * @param Job $job
     * @param int $nbExec Number of execution to get
     * @return Log[]
     */
    public function findLastByJob(Job $job, int $nbExec = 5): array
    {
        return $this->createQueryBuilder('l')
            ->where('l.job = :job_id')
            ->setParameter(':job_id', $job->getId())
            ->orderBy('l.start', 'DESC')
            ->setMaxResults($nbExec)
            ->getQuery()
            ->getResult();
    }

    /**
     * Find all execution log for a given job
     *
     * @param Job $job
     * @return Log[]
     */
    public function findAllByJob(Job $job)
    {
        return $this->createQueryBuilder('l')
            ->where('l.job = :job_id')
            ->setParameter(':job_id', $job->getId())
            ->orderBy('l.start', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
