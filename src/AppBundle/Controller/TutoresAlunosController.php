<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Controller\UsuarioController;
use AppBundle\Controller\ManipularArquivoController;
use AppBundle\Entity\TbUser;
use AppBundle\Entity\TbClassStudent;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

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

            $arrayTutores = TutorController::gerarArrayTutores();
            $dadosMenuLateralCadastro = MenuLateralCadastroController::carregarDadosMenuLateralCadastro();

            $this->formAlunoTutor = TutoresAlunosController::gerarFormAlunoTutor("alunoTutor");
            $this->formAlunoTutor->handleRequest($request);

            if ($request->request->has($this->formAlunoTutor->getName())) {
                if ($this->formAlunoTutor->isSubmitted() && $this->formAlunoTutor->isValid()) {
                    $dadosFormAlunoTutor = $this->formAlunoTutor->getData();
                    TutoresAlunosController::registrarAlunosTutor($dadosFormAlunoTutor);
                    // return $this->redirectToRoute('propositores');
                }
            }

            return $this->render('tutoresAlunos.html.twig', array('arrayTutores' => $arrayTutores,
                                                                  'dadosMenuLateralCadastro' => $dadosMenuLateralCadastro,
                                                                  'formAlunoTutor' => $this->formAlunoTutor->createView(),));
        }
    }

    function gerarFormAlunoTutor($nomeFormulario){
      $formularioAlunoTutor = $this->get('form.factory')
              ->createNamedBuilder($nomeFormulario, FormType::class)
              ->add('IdAlunosTutores', HiddenType::class, array('label' => false))
              ->getForm();
      return $formularioAlunoTutor;

    }

    function registrarAlunosTutor(){
      $idClass = $this->get('session')->get('idTurmaEdicao');

      // $newTutorPortfolio = Tb
    }
}
