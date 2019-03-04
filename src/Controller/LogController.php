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
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LogController extends AbstractController
{

    /**
     * @Route("/")
     * @param EntityManagerInterface $em
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function homepage(EntityManagerInterface $em): \Symfony\Component\HttpFoundation\Response
    {
        $jobRepository = $em->getRepository(Job::class);
        $jobs = $jobRepository->findAll();
        $repository = $em->getRepository(Log::class);
        $jobLogs = [];
        foreach ($jobs as $job) {
          $jobLogsDate = [];
          $jLogs = $repository->findLatestByJob($job->getId());
            foreach ($jLogs as $jLog) {
                $lStart = $jLog->getStart()->format('Y-m-d');
                if ($jLog->getEnd()) {
                  $delta_T = $jLog->getEnd()->format('U') - $jLog->getStart()->format('U');
                  $duration = round($delta_T/60);
                } else {
                    $duration = null;
                }
                $jobLogsDate[$lStart] = [
                    'color' => $this->getDurationColor($duration),
                    'logs' => $jLog,
                ];
            }
            $jobLogs[$job->getName()."_".$job->getFrequency()] = $jobLogsDate;
        }

        $m = date('m');
        $de = date('d');
        $y = date('Y');
        $logDates = [];
        for ($i = 7; $i >= 0; $i--) {
            $logDates[$i] = date('Y-m-d', mktime(0, 0, 0, $m, ($de - $i), $y));
        }


        return $this->render('log/homepage.html.twig', ['job_logs' => $jobLogs, 'log_dates' => $logDates]);
    }

    /**
     * @param $duration
     *
     * @return string
     */
    private function getDurationColor($duration): string
    {
        if ($duration === null) {
            $color = 'danger';
        } elseif ($duration < 30) {
            //green
            $color = 'success';
        } elseif ($duration < 60) {
            // ligth blue
            $color = 'info';
        } elseif ($duration < 120) {
            //blue
            $color = 'primary';
        } elseif ($duration < 240) {
            //orange
            $color = 'warning';
        } else {
            //red
            $color = 'danger';
        }

        return $color;
    }
}
