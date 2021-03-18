<?php
/**
 * Created by PhpStorm.
 * User: stephane
 * Date: 25.02.19
 * Time: 14:28
 */

namespace App\Controller;

use App\Entity\Job;
use App\Entity\Log;
use App\Repository\JobRepository;
use App\Repository\LogRepository;
use App\Service\LaunchJobHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LogController extends AbstractController
{

    private $launchJobHandler;

    public function __construct(LaunchJobHandler $launchJobHandler)
    {
        $this->launchJobHandler = $launchJobHandler;
    }

    /**
     * @Route("/", name="log_index", methods={"GET"})
     *
     * @param LogRepository $logRepository
     * @param JobRepository $jobRepository
     *
     * @return Response
     */
    public function homepage(LogRepository $logRepository, JobRepository $jobRepository): Response
    {
        $nbExec = 10;
        $jobs = $jobRepository->findAll();
        /**
         * @var Job[]
         */
        $jobsLogs = [];

        foreach ($jobs as $job) {
            $job->setArrayLogs($logRepository->findLastByJob($job, $nbExec));
            $jobsLogs[$job->getId()] = $job;
        }

        return $this->render('log/index.html.twig', ['jobsLogs' => $jobsLogs, 'nbExec' => $nbExec]);
    }

    /**
     * @Route("/detail/{id}", name="log_detail", methods={"GET"})
     *
     * @param Job           $job
     * @param LogRepository $logRepository
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function detail(Job $job, LogRepository $logRepository)
    {
        return $this->render(
            'log/detail.html.twig',
            [
                'job' => $job,
                'logs' => $logRepository->findAllByJob($job),
            ]
        );
    }

    /**
     * @Route("/run/{id}", name="run_job", methods={"GET"})
     *
     * @param Job $job
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function run(Job $job)
    {
        $this->launchJobHandler->startJob($job);
        $response = new Response();
        $response->setContent('<html><body><h1>Check logs for details </h1></body></html> ');
        $response->setStatusCode(Response::HTTP_OK);

        return $response;
    }
}
