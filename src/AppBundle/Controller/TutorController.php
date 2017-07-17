<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class TutorController extends Controller {
  /**
   * @Route("/tutores", name="tutores")
   */
  function tutoresAction() {
        return $this->render("tutores.html.twig");
      }
}
