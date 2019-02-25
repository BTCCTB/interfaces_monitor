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
use Doctrine\DBAL\Types\DateTimeType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;


class LogController extends AbstractController {

  /**
   * @Route("/")
   */

  public function homepage(EntityManagerInterface $em)
  {
    $job_repository = $em->getRepository(Job::class);
    $jobs = $job_repository->findAll();
    $repository = $em->getRepository(Log::class);
    $job_logs = [];
    $job_logs_date = [];
    foreach ($jobs as $job) {
      $j_logs = $repository->findLatestByJob();
      foreach($j_logs as $j_log){
//var_dump($j_log->getStart());

       // $l_date = date("d-m-Y", strtotime($j_log->getStart()));
        $l_date = $j_log->getStart()->format('Y-m-d');
        $job_logs_date[$l_date] = $j_log;

      }

      $job_logs[$job->getName()] = $job_logs_date;
    }


    $m= date("m");

    $de= date("d");

    $y= date("Y");
    for($i=7; $i>=0; $i--){
      $log_dates[$i] = date('Y-m-d',mktime(0,0,0,$m,($de-$i),$y));
    }

      return $this->render('log/homepage.html.twig',['job_logs' => $job_logs, 'log_dates' => $log_dates]);

  }

}