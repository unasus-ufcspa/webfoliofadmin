<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Description of PropositorController
 *
 * @author Marilia
 */
class PropositorController extends Controller {
  /**
   * @Route("/propositores", name="propositores")
   */
  function propositoresAction() {
        return $this->render("propositores.html.twig");
      }
}
