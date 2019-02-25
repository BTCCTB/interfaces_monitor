<?php
/**
 * Created by PhpStorm.
 * User: stephane
 * Date: 25.02.19
 * Time: 14:28
 */

namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;


class LogController {

  /**
   * @Route("/")
   */

  public function homepage()
  {
      return $this->render('log/homepage.html.twig');
  }

}