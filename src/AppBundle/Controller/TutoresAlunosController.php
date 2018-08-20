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
use AppBundle\Entity\TbPortfolioStudent;
use AppBundle\Entity\TbTutorPortfolio;
use AppBundle\Entity\TbPortfolioClass;
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

    function registrarAlunosTutor($dadosForm){
      $idClass = $this->get('session')->get('idTurmaEdicao');
      $arrays = explode(";", $dadosForm['IdAlunosTutores']);

      foreach ($arrays as $a) {
        $idUsers = explode(".", $a);

        $tutor = $this->getDoctrine()
                ->getRepository('AppBundle:TbUser')
                ->findOneBy(array('idUser' => $idUsers[0]));

        for($i = 1; $i < sizeof($idUsers); $i++){

          $queryBuilderPortStudent = $this->em->createQueryBuilder();
          $queryBuilderPortStudent
                  ->select('ps')
                  ->from('AppBundle:TbPortfolioStudent', "ps")
                  ->innerJoin('ps.idPortfolioClass', 'pc', 'WITH', 'ps.idPortfolioClass = pc.idPortfolioClass')
                  ->where($queryBuilderPortStudent->expr()->eq('pc.idClass', $idClass))
                  ->andWhere($queryBuilderPortStudent->expr()->eq('ps.idStudent', $idUsers[$i]))
                  ->getQuery()
                  ->execute();
          $portfolioStudent = $queryBuilderPortStudent->getQuery()->getArrayResult();

          if ($portfolioStudent != null) {
            $this->logControle->logAdmin("Point 2");
            $queryBuilderTutorPort = $this->em->createQueryBuilder();
            $queryBuilderTutorPort
                    ->select('tp')
                    ->from('AppBundle:TbTutorPortfolio', "tp")
                    ->where($queryBuilderTutorPort->expr()->eq('tp.idPortfolioStudent', $portfolioStudent[0]['idPortfolioStudent']))
                    ->getQuery()
                    ->execute();
            $tutorPort = $queryBuilderTutorPort->getQuery()->getResult();

            if($tutorPort == null){
              $ps = $this->getDoctrine()
                      ->getRepository('AppBundle:TbPortfolioStudent')
                      ->findOneBy(array('idPortfolioStudent' => $portfolioStudent[$i]));

              $novoTutorPort = new TbTutorPortfolio();
              $novoTutorPort->setIdTutor($tutor);
              $novoTutorPort->setIdPortfolioStudent($ps);
              $this->em->persist($novoTutorPort);
              $this->em->flush();
            }
          }
        }
      }
      $this->em->flush();
    }
}
