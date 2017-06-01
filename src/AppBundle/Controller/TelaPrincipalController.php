<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
/**
 * Description of TelaPrincipal
 *
 * @author Marilia
 */
class TelaPrincipalController extends Controller {
    /**
     * @Route("/home")
     */
    public function home(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('home.html.twig');
    }

}
