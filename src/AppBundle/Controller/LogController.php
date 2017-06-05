<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Description of LogController
 *
 * @author Marilia
 */
class LogController extends Controller {

   

   

    public function logAdmin($mensagem) {
        $hoje = date("Y_m_d");

        $arquivo = fopen("../var/logs/log_Admin.$hoje.log", "ab");


        $hora = date("H:i:s T");
        fwrite($arquivo, "[$hora] $mensagem\r\n");
        fclose($arquivo);
    }

}
