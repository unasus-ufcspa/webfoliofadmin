<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// namespace AppBundle\Controller;
//
// use Symfony\Bundle\FrameworkBundle\Controller\Controller;
// use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
// use AppBundle\Entity\TbUser;
// use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\HttpFoundation\JsonResponse;
// use AppBundle\Controller\UsuarioController;
// use AppBundle\Controller\ManipularArquivoController;
// use AppBundle\Entity\TbClassStudent;
//
// class TutoresAlunosController extends Controller {
//
//     public $error;
//     public $logControle;
//     public $em;
//     public $formEditarAluno;
//     public $formAdicionarAluno;
//
//     public function __construct() {
//         $this->logControle = new LogController();
//     }
    //
    // /**
    //  * @Route("/tutoresAlunos", name="tutoresAlunos")
    //  */
    // function tutoresAlunosAction(Request $request) {
    //
    //     if (!$this->get('session')->get('idUser')) {
    //
    //         return $this->redirectToRoute('login');
    //     } else {
    //         $this->em = $this->getDoctrine()->getManager();
    //
    //         // $dadosMenuLateralCadastro = MenuLateralCadastroController::carregarDadosMenuLateralCadastro();
    //
    //         // return $this->render('tutoresAlunos.html.twig', array('dadosMenuLateralCadastro' => $dadosMenuLateralCadastro));
    //         return $this->render('tutoresAlunos.html.twig');
    //
    //     }
    // }

    // public function gerarArrayAlunos() {
    //     $arrayAlunos = array();
    //     $alunos = AlunosController::selecionarAlunosTurma();
    //     foreach ($alunos as $aluno) {
    //         $arrayAlunos[] = array(
    //             'idUser' => $aluno['idStudent']['idUser'],
    //             'nmUser' => $aluno['idStudent']['nmUser'],
    //             'nuIdentification' => $aluno['idStudent']['nuIdentification'],
    //             'dsEmail' => $aluno['idStudent']['dsEmail'],
    //             'nuCellphone' => $aluno['idStudent']['nuCellphone']
    //         );
    //     }
    //     return $arrayAlunos;
    // }
    //
    // public function selecionarAlunosTurma() {
    //     $idClass = $this->get('session')->get('idTurmaEdicao');
    //     $queryBuilderAluno = $this->em->createQueryBuilder();
    //     $queryBuilderAluno
    //             ->select('u,cs,c')
    //             ->from('AppBundle:TbClassStudent', "cs")
    //             ->innerJoin('cs.idStudent', 'u', 'WITH', 'u.idUser =  cs.idStudent')
    //             ->innerJoin('cs.idClass', 'c', 'WITH', 'c.idClass =  cs.idClass')
    //             ->where($queryBuilderAluno->expr()->eq('cs.idClass', $idClass))
    //             ->getQuery()
    //             ->execute();
    //     $alunosTurma = $queryBuilderAluno->getQuery()->getArrayResult();
    //     $this->logControle->logAdmin(print_r($alunosTurma, true));
    //     return $alunosTurma;
    // }

}
