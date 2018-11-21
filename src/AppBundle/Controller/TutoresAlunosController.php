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
            $alunosTutores = $this->selecionarAlunosTutores($arrayTutores);

            $this->formAlunoTutor = TutoresAlunosController::gerarFormAlunoTutor("alunoTutor");
            $this->formAlunoTutor->handleRequest($request);

            if ($request->request->has($this->formAlunoTutor->getName())) {
                if ($this->formAlunoTutor->isSubmitted() && $this->formAlunoTutor->isValid()) {
                    $dadosFormAlunoTutor = $this->formAlunoTutor->getData();
                    TutoresAlunosController::registrarAlunosTutor($dadosFormAlunoTutor);
                    $alunosTutores = $this->selecionarAlunosTutores($arrayTutores);
                }
            }

            return $this->render('tutoresAlunos.html.twig', array('arrayTutores' => $arrayTutores,
                                                                  'dadosMenuLateralCadastro' => $dadosMenuLateralCadastro,
                                                                  'formAlunoTutor' => $this->formAlunoTutor->createView(),
                                                                  'listaAlunosTutores' => $alunosTutores));
        }
    }

    function gerarFormAlunoTutor($nomeFormulario){
      $formularioAlunoTutor = $this->get('form.factory')
              ->createNamedBuilder($nomeFormulario, FormType::class)
              ->add('IdAlunosTutores', HiddenType::class, array('label' => false))
              ->add('DeleteAlunos', HiddenType::class, array('label' => false))
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
                      ->findOneBy(array('idPortfolioStudent' => $portfolioStudent[0]));

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

    function selecionarAlunosTutores($tutores){
      $idClass = $this->get('session')->get('idTurmaEdicao');
      $stringAlunosTutores = "";

      foreach ($tutores as $tutor) {
        $stringAlunosTutores = $stringAlunosTutores . $tutor['idUser'];

        $queryBuilderTutorPort = $this->em->createQueryBuilder();
        $queryBuilderTutorPort
            ->select('tp,ps,pc')
            ->from('AppBundle:TbTutorPortfolio', "tp")
            ->innerJoin('tp.idPortfolioStudent', 'ps', 'WITH', 'ps.idPortfolioStudent = tp.idPortfolioStudent')
            ->innerJoin('ps.idPortfolioClass', 'pc', 'WITH', 'ps.idPortfolioClass = pc.idPortfolioClass')
            ->where($queryBuilderTutorPort->expr()->eq('tp.idTutor', $tutor['idUser']))
            ->andWhere($queryBuilderTutorPort->expr()->eq('pc.idClass', $idClass))
            ->getQuery()
            ->execute();
        $tutorPort = $queryBuilderTutorPort->getQuery()->getArrayResult();

        for ($i=0; $i < sizeof($tutorPort); $i++) {
          foreach ($tutorPort[$i] as $tp) {
            $portAluno = $this->getDoctrine()
                    ->getRepository('AppBundle:TbPortfolioStudent')
                    ->findOneBy(array('idPortfolioStudent' => $tp['idPortfolioStudent']));
            if($portAluno != null){
                $aluno = $this->getDoctrine()
                ->getRepository('AppBundle:TbUser')
                ->findOneBy(array('idUser' => $portAluno->getIdStudent()));
              if($aluno != null){
                $stringAlunosTutores = $stringAlunosTutores . ".";
                $stringAlunosTutores = $stringAlunosTutores . print_r($aluno->getIdUser(),true) . "-" . print_r($aluno->getNmUser(),true) ;
              }
            }
          }
        }

        $stringAlunosTutores = $stringAlunosTutores .";";
        // $this->logControle->logAdmin("String 1: " . print_r($stringAlunosTutores, true));
      }
      // $this->logControle->logAdmin("String 2: " . print_r($stringAlunosTutores, true));
      return $stringAlunosTutores;
    }

}
