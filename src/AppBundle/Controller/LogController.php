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

    public $db;

    public function __construct() {
        $this->dbConnect();
    }

    private function dbConnect() {
        require_once '../../webfolioAdmin/conexao.php';
    }

    public function logWeb($mensagem) {
        $hoje = date("Y_m_d");

        $arquivo = fopen("../var/logs/log_web.$hoje.log", "ab");

        //$mensagem = str_replace("\n", " ", $mensagem);

        $hora = date("H:i:s T");
        fwrite($arquivo, "[$hora] $mensagem\r\n");
        fclose($arquivo);
    }

    public function log($mensagem) {
        $hoje = date("Y_m_d");

        $arquivo = fopen("../var/logs/log_server.$hoje.log", "ab");

        //$mensagem = str_replace("\n", " ", $mensagem);

        $hora = date("H:i:s T");
        fwrite($arquivo, "[$hora] $mensagem\r\n");
        fclose($arquivo);
    }

    function log_up($mensagem) {
        $hoje = date("Y_m_d");

        $arquivo = fopen("../var/logs/log_uploads.$hoje.log", "ab");

        //$mensagem = str_replace("\n", " ", $mensagem);

        $hora = date("H:i:s T");
        fwrite($arquivo, "[$hora] $mensagem\r\n");
        fclose($arquivo);
    }

}
