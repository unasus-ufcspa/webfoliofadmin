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
use AppBundle\Controller\UsuarioController;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\TbUser;
use AppBundle\Entity\TbClass;
use AppBundle\Entity\TbPortfolio;
use AppBundle\Entity\TbPortfolioClass;
use AppBundle\Entity\TbPortfolioStudent;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

/**
 * Description of PropositorController
 *
 * @author Marilia
 */
class PropositorController extends Controller {

    public $error;
    public $logControle;
    public $em;
    public $formAdicionarPropositor;
    public $formEditarPropositor;

    public function __construct() {
        $this->logControle = new LogController();
    }

    /**
     * @Route("/propositores", name="propositores")
     */
    function propositoresAction(Request $request) {

        if (!$this->get('session')->get('idUser')) {

            return $this->redirectToRoute('login');
        } else {
            $this->em = $this->getDoctrine()->getManager();
            $arrayPropositores = $this->gerarArrayPropositores();
            $this->formEditarPropositor = UsuarioController::gerarFormulario("editar");
            $this->formAdicionarPropositor = UsuarioController::gerarFormulario("adicionar");
            $this->formExcluirPropositor = PropositorController::gerarFormExcluir("excluir");
            $this->formEditarPropositor->handleRequest($request);
            $this->formAdicionarPropositor->handleRequest($request);
            $this->formExcluirPropositor->handleRequest($request);
            $deleteException = false;

            if ($request->request->has($this->formEditarPropositor->getName())) {
                if ($this->formEditarPropositor->isSubmitted() && $this->formEditarPropositor->isValid()) {
                    $dadosFormEditarPropositor = $this->formEditarPropositor->getData();
                    UsuarioController::editarUsuario($dadosFormEditarPropositor);
                    return $this->redirectToRoute('propositores');
                }
            } else if ($request->request->has($this->formAdicionarPropositor->getName())){
                if ($this->formAdicionarPropositor->isSubmitted() && $this->formAdicionarPropositor->isValid()) {
                    $dadosFormAdicionarPropositor = $this->formAdicionarPropositor->getData();
                    $this->adicionarPropositor($dadosFormAdicionarPropositor);
                    return $this->redirectToRoute('propositores');
                }
            }else{
              if ($this->formExcluirPropositor->isSubmitted() && $this->formExcluirPropositor->isValid()) {
                  $dadosFormExcluirPropositor = $this->formExcluirPropositor->getData();
                  $deleteException = $this->excluirPropositor($dadosFormExcluirPropositor);
                  $arrayPropositores = $this->gerarArrayPropositores();
              }
            }
            return $this->render('propositores.html.twig', array('propositores' => $arrayPropositores,
                        'formPropositor' => $this->formEditarPropositor->createView(),
                        'formAddPropositor' => $this->formAdicionarPropositor->createView(),
                        'formExcluirPropositor' => $this->formExcluirPropositor->createView(),
                        'deleteException' => $deleteException));
        }
    }

    function gerarArrayPropositores() {
        $arrayPropositores = array();
        $propositores = $this->selecionarPropositores();
        foreach ($propositores as $proposerUser) {
            $arrayPropositores[] = array(
                'idUser' => $proposerUser['idUser'],
                'nmUser' => $proposerUser['nmUser'],
                'nuIdentification' => $proposerUser['nuIdentification'],
                'dsEmail' => $proposerUser['dsEmail'],
                'nuCellphone' => $proposerUser['nuCellphone']
            );
        }
        return $arrayPropositores;
    }

    function selecionarPropositores() {
        $idUser = $this->get('session')->get('idUser');
        $queryBuilderProposer = $this->em->createQueryBuilder();
        $queryBuilderProposer
                ->select('u')
                ->from('AppBundle:TbUser', 'u')
                ->where($queryBuilderProposer->expr()->eq('u.flProposer', "'T'"))
                ->andWhere($queryBuilderProposer->expr()->neq('u.idUser', $idUser))
                ->getQuery()
                ->execute();
        $propositores = $queryBuilderProposer->getQuery()->getArrayResult();

        return $propositores;
    }

    function adicionarPropositor($dadosFormAdicionarPropositor) {
        $this->logControle->logAdmin(print_r($dadosFormAdicionarPropositor, true));
        $novoPropositor = new TbUser();
        $this->logControle->logAdmin(($dadosFormAdicionarPropositor['DsPassword']));
        if ($dadosFormAdicionarPropositor['DsPassword'] == $dadosFormAdicionarPropositor['DsPasswordConfirm']) {
          if($this->usuarioRegistrado($dadosFormAdicionarPropositor['DsEmail'])){
            UsuarioController::editarUsuarioPropositor($dadosFormAdicionarPropositor);
          }else{
            UsuarioController::persistirObjetoUsuario($novoPropositor, $dadosFormAdicionarPropositor, 'flProposer', 'T');
          }
        }
    }

    public function usuarioRegistrado($email){

      $usuarioEditavel = $this->getDoctrine()
              ->getRepository('AppBundle:TbUser')
              ->findOneBy(array('dsEmail' => $email));
      if($usuarioEditavel == null){
        return false;
      }else{
        return true;
      }
    }

    function gerarFormExcluir($nomeFormulario){
      $formularioExcluirPropositores = $this->get('form.factory')
              ->createNamedBuilder($nomeFormulario, FormType::class)
              ->add('IdProposers', HiddenType::class, array('label' => false))
              ->getForm();
      return $formularioExcluirPropositores;
    }

    function excluirPropositor($dadosForm){
      $this->em = $this->getDoctrine()->getManager();

      $propositores = explode(";", $dadosForm['IdProposers']);

      for ($i = 0; $i < sizeof($propositores); $i++) {
        try{
          $prop = $this->getDoctrine()
                  ->getRepository('AppBundle:TbUser')
                  ->findOneBy(array('idUser' => $propositores[$i]));
          if ($prop != null) {
            $this->em->remove($prop);
            $this->em->flush();
          }
        } catch (\Exception $exception) {
            $this->logControle->logAdmin("Exception  : " . print_r($exception->getMessage(), true));
            $deleteException = true;
            return $deleteException;
        }
      }
      $this->em->flush();
    }

    /**
     * @Route("/desativarPropositorExcecao")
     */
    function desativarPropositorExcecao(Request $request) {
        $this->em = $this->getDoctrine()->getEntityManager();
        if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
            $data = json_decode($request->getContent(), true);
            $request->request->replace(is_array($data) ? $data : array());
            $this->logControle->logAdmin("desativar propositores : " . print_r($data, true));
            foreach ($data['arrayPropositoresDesativar'] as $idsAdministradoresDesativar) {
                $this->em = $this->getDoctrine()->resetManager();
                $this->logControle->logAdmin("desativar  : " . print_r($idsAdministradoresDesativar, true));

                $objetoUsuario = $this->em->getRepository('AppBundle:TbUser')
                        ->findOneBy(array('idUser' => $idsAdministradoresDesativar));
                if ($objetoUsuario != null) {
                    $objetoUsuario->setFlProposer('F');
                    $this->em->flush();
                }
            }
            $retornoRequest = array(
                "sucesso" => true
            );
        } else {
            $retornoRequest = array(
                "sucesso" => false
            );
        }
        return new JsonResponse($retornoRequest);
    }

    /**
     * @Route("/portfolioPropositor", name="portfolioPropositor")
     */
    function portfolioPropositorAction(Request $request) {
        $this->em = $this->getDoctrine()->getEntityManager();
        $dadosMenuLateralCadastro = MenuLateralCadastroController::carregarDadosMenuLateralCadastro(); //carrega dados do menu lateral, chamar em todas as telas que necessario e enviar nos parametros do render

        $propositor = $this->selecionarPropositorSalvo();
        $portfolios = $this->selecionarPortfoliosSalvos();

        $this->formPortProp = PropositorController::gerarFormPropositor("salvarPortfolioPropositor");
        $this->formPortProp->handleRequest($request);

        if ($request->request->has($this->formPortProp->getName())) {
            if ($this->formPortProp->isSubmitted() && $this->formPortProp->isValid()) {
                $dadosFormPortProp = $this->formPortProp->getData();
                PropositorController::editarPortProp($dadosFormPortProp);
                $propositor = $this->selecionarPropositorSalvo();
                $portfolios = $this->selecionarPortfoliosSalvos();
            }
        }

        return $this->render("portfolioPropositor.html.twig", array('dadosMenuLateralCadastro' => $dadosMenuLateralCadastro, 'formPortProp' => $this->formPortProp->createView(), 'propositor' => $propositor, 'portfolios' => $portfolios));
    }

    function gerarFormPropositor($nomeFormulario){
      $formularioTbClass = $this->get('form.factory')
              ->createNamedBuilder($nomeFormulario, FormType::class)
              ->add('IdProposer', HiddenType::class, array('label' => false))
              ->add('IdPortfolios', HiddenType::class, array('label' => false))
              ->getForm();
      return $formularioTbClass;

    }

    function selecionarPropositorSalvo(){
        $idClass = $this->get('session')->get('idTurmaEdicao');

        $turma = $this->getDoctrine()
                ->getRepository('AppBundle:TbClass')
                ->findOneBy(array('idClass' => $idClass));
        $this->logControle->logAdmin("Dados da turma  : " . print_r($turma, true));

        $dadosPropositor = $this->getDoctrine()
                ->getRepository('AppBundle:TbUser')
                ->findOneBy(array('idUser' => $turma->getIdProposer()));
        $this->logControle->logAdmin("Dados do Propositor : " . print_r($dadosPropositor, true));

        if (count($dadosPropositor) > 0) {
          $propositor[] = array(
              'idProposer' => $dadosPropositor->getIdUser(),
              'nmProposer' => $dadosPropositor->getNmUser()
          );
        }else{
          $propositor[] = null;
        }

        $this->logControle->logAdmin("Dados do Propositor return : " . print_r($propositor, true));
        return $propositor;
    }

    function selecionarPortfoliosSalvos(){

        $dadosPortfolios = $this->selecionarPortfoliosTurma();

        $this->logControle->logAdmin("Portfólios da turma : " . print_r($dadosPortfolios, true));

        if (count($dadosPortfolios) > 0) {
          foreach ($dadosPortfolios as $p) {
            $portfolios[] = array(
                'idPortfolio' => $p['idPortfolio']['idPortfolio'],
                'nmPortfolio' => $p['idPortfolio']['dsTitle']
            );
          }
        }else{
          $portfolios[] = null;
        }

        return $portfolios;
    }

    function selecionarPortfoliosTurma(){
      $idClass = $this->get('session')->get('idTurmaEdicao');

      $queryBuilderPortClass = $this->em->createQueryBuilder();
      $queryBuilderPortClass
              ->select('pc,p')
              ->from('AppBundle:TbPortfolioClass', "pc")
              ->innerJoin('pc.idPortfolio', 'p', 'WITH', 'p.idPortfolio= pc.idPortfolio')
              ->where($queryBuilderPortClass->expr()->eq('pc.idClass', $idClass))
              ->getQuery()
              ->execute();
      $portfoliosTurma = $queryBuilderPortClass->getQuery()->getArrayResult();

      return $portfoliosTurma;
    }

    function editarPortProp($dadosForm){
      $idClass = $this->get('session')->get('idTurmaEdicao');

      $classEditar = $this->getDoctrine()
              ->getRepository('AppBundle:TbClass')
              ->findOneBy(array('idClass' => $idClass));

      PropositorController::persistirObjetoTurma($classEditar, $dadosForm);
      PropositorController::persistirObjetoPortfolio($classEditar, $dadosForm);
    }

    function persistirObjetoTurma($classEditar, $dadosForm) {
        $this->em = $this->getDoctrine()->getManager();

        $propositor = $this->getDoctrine()
                ->getRepository('AppBundle:TbUser')
                ->findOneBy(array('idUser' => $dadosForm['IdProposer']));

        $classEditar->setIdProposer($propositor);
        $this->logControle->logAdmin("Portfólio Propositor  : " . print_r($classEditar, true));

        $this->em->persist($classEditar);

        $this->em->flush();
    }

    function persistirObjetoPortfolio($classEditar, $dadosForm) {
        $this->em = $this->getDoctrine()->getManager();
        $idClass = $this->get('session')->get('idTurmaEdicao');

        $portfoliosTurmaForm = explode(";", $dadosForm['IdPortfolios']);

        for ($i=0; $i < sizeof($portfoliosTurmaForm); $i++) {
          $ptClass = $this->getDoctrine()
                  ->getRepository('AppBundle:TbPortfolioClass')
                  ->findOneBy(array('idClass' => $idClass, 'idPortfolio' => $portfoliosTurmaForm[$i]));
          $this->logControle->logAdmin("ptClass : " . print_r($ptClass, true));

          if($ptClass == null){
            $novoPortClass = new TbPortfolioClass();
            $turma = $this->getDoctrine()
                        ->getRepository('AppBundle:TbClass')
                        ->findOneBy(array('idClass' => $idClass));

            $portfolio = $this->getDoctrine()
                        ->getRepository('AppBundle:TbPortfolio')
                        ->findOneBy(array('idPortfolio' => $portfoliosTurmaForm[$i]));

            $novoPortClass->setIdClass($turma);
            $novoPortClass->setIdPortfolio($portfolio);

            $this->em->persist($novoPortClass);

            $this->em->flush();
          }
        }

        PropositorController::removerPortfolios($portfoliosTurmaForm);
        $this->em->flush();
    }

    function removerPortfolios($listaPortfolios){
      $this->em = $this->getDoctrine()->getManager();
      $idClass = $this->get('session')->get('idTurmaEdicao');

      $portfoliosSalvos = PropositorController::selecionarPortfoliosSalvos();

      foreach ($portfoliosSalvos as $ps) {
        $flag = false;
        for($i = 0; $i < sizeof($listaPortfolios); $i++){
          if($ps['idPortfolio'] == $listaPortfolios[$i]){
            $flag = true;
          }
        }
        $this->logControle->logAdmin(print_r("PS : " . $ps['idPortfolio'], true));

        if($flag == false){ // Não encontrou nenhum id na lista igual ao do portfólio salvo
          $entity = $this->em->getRepository('AppBundle:TbPortfolioClass')
                  ->findOneBy(array('idClass' => $idClass, 'idPortfolio' => $ps['idPortfolio']));
          $this->logControle->logAdmin(print_r($entity, true));
          if ($entity != null) {
              // $queryBuilderPortStudent = $this->em->createQueryBuilder();
              // $queryBuilderPortStudent
              //               ->select('ps')
              //               ->from('AppBundle:TbPortfolioStudent', "ps")
              //               ->where($queryBuilderPortStudent->expr()->eq('ps.idPortfolioClass', $entity))
              //               ->getQuery()
              //               ->execute();
              //       $portfolioStudent = $queryBuilderPortStudent->getQuery()->getArrayResult();
                    $this->logControle->logAdmin(print_r("Teste Portfólio Student", true));
                    // foreach ($portfolioStudent as $ps) {
                    //     $this->em->remove($ps);
                    //     $this->em->flush();
                    // }

              $this->em->remove($entity);
              $this->em->flush();
          }
        }
      }

      $this->em->flush();
    }
}
