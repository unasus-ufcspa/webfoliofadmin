<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\TbUser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Controller\UsuarioController;
use AppBundle\Controller\ManipularArquivoController;
use AppBundle\Entity\TbClassStudent;
// use AppBundle\Controller\UsuarioController;

class TutoresAlunosController extends Controller {

    public $error;
    public $logControle;
    public $em;

    public function __construct() {
        $this->logControle = new LogController();
    }

    /**
     * @Route("/tutoresAlunos", name="tutoresAlunos")
     */
    function tutoresAlunosAction(Request $request) {

        if (!$this->get('session')->get('idUser')) {

            return $this->redirectToRoute('login');
        } else {
            $this->em = $this->getDoctrine()->getManager();

            $arrayTutores = TutoresAlunosController::carregarTutoresTurma();

            $dadosMenuLateralCadastro = MenuLateralCadastroController::carregarDadosMenuLateralCadastro();

            return $this->render('tutoresAlunos.html.twig', array('arrayTutores' => $arrayTutores, 'dadosMenuLateralCadastro' => $dadosMenuLateralCadastro));
        }
    }

    function carregarTutoresTurma() {

        $arrayTutores = TutorController::gerarArrayTutores();
        return $arrayTutores;
    }
}
