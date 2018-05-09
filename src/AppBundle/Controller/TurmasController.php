<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\TbClass;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use AppBundle\Controller\UsuarioController;
use AppBundle\Controller\TurmasController;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Description of TurmasController
 *
 * @author Marilia
 */
class TurmasController extends Controller {

    public $error;
    public $logControle;
    public $em;

    public function __construct() {
        $this->logControle = new LogController();
    }

    /**
     * @Route("/turmas")
     */
    function turmas(Request $request) {
        if (!$this->get('session')->get('idUser')) {

            return $this->redirectToRoute('login');
        } else {
            $this->em = $this->getDoctrine()->getManager();
            $arrayTurmas = $this->gerarArrayTurmas();

            return $this->render('turmas.html.twig', array('turmas' => $arrayTurmas));
        }
    }

    public function gerarArrayTurmas() {
        $queryBuilderClass = $this->em->createQueryBuilder();
        $queryBuilderClass
                ->select('c')
                ->from('AppBundle:TbClass', 'c')
                ->getQuery()
                ->execute();
        $class = $queryBuilderClass->getQuery()->getArrayResult();
        $this->logControle->logAdmin(print_r($class, true));
        foreach ($class as $turma) {

            $queryBuilder = $this->em->createQueryBuilder();
            $queryBuilder
                    ->select('pc, c, u,p')
                    ->from('AppBundle:TbPortfolioClass', 'pc')
                    ->innerJoin('pc.idClass', 'c', 'WITH', 'c.idClass= pc.idClass')
                    ->innerJoin('c.idProposer', 'u', 'WITH', 'c.idProposer= u.idUser')
                    ->innerJoin('pc.idPortfolio', 'p', 'WITH', 'p.idPortfolio= pc.idPortfolio')
                    ->where($queryBuilder->expr()->eq('c.idClass', $turma['idClass']))
                    ->getQuery()
                    ->execute();
            $portfolioClass = $queryBuilder->getQuery()->getArrayResult();
            $this->logControle->logAdmin(print_r($portfolioClass, true));

            if (count($portfolioClass) > 0) {
                foreach ($portfolioClass as $arrayPortfolioClass) {
                    $arrayTurmas[] = array(
                        'dsCode' => $turma["dsCode"],
                        'dsDescription' => $turma['dsDescription'],
                        'idClass' => $turma['idClass'],
                        'stStatus' => $turma['stStatus'],
                        'idPortfolio' => $arrayPortfolioClass['idPortfolio']['idPortfolio'],
                        'dsTitlePortfolio' => $arrayPortfolioClass['idPortfolio']['dsTitle']
                    );
                }
            } else {
                $arrayTurmas[] = array(
                    'dsCode' => $turma["dsCode"],
                    'dsDescription' => $turma['dsDescription'],
                    'idClass' => $turma['idClass'],
                    'stStatus' => $turma['stStatus'],
                    'idPortfolio' => -1,
                    'dsTitlePortfolio' => -1
                );
            }
        }
        $this->logControle->logAdmin(print_r($arrayTurmas, true));
        return $arrayTurmas;
    }

     /**
     * @Route("/cadastroTurma/{idClass}")
     */
    function cadastroTurma(Request $request, $idClass) {

        $this->get('session')->set('idTurmaEdicao', $idClass);
        $this->em = $this->getDoctrine()->getManager();
        $dadosTurma = array();
        if ($idClass > -1) {
            $dadosTurma = $this->carregarDadosTurma($idClass);
        }
        $this->formAddClass = TurmasController::gerarFormularioTurma("addClass");
        $this->formAddClass->handleRequest($request);

        if ($request->request->has($this->formAddClass->getName())) {
            if ($this->formAddClass->isSubmitted() && $this->formAddClass->isValid()) {
                $dadosForm = $this->formAddClass->getData();
                TurmasController::editClass($dadosForm);
                // header("Refresh:0");
            }
        }

        $dadosMenuLateralCadastro = MenuLateralCadastroController::carregarDadosMenuLateralCadastro();
        return $this->render("cadastroTurma.html.twig", array('dadosMenuLateralCadastro' => $dadosMenuLateralCadastro, 'dadosTurma' => $dadosTurma, 'formClass' => $this->formAddClass->createView()));
    }

    function carregarDadosTurma($idClass) {
        $queryBuilder = $this->em->createQueryBuilder();
        $queryBuilder
                ->select('c')
                ->from('AppBundle:TbClass', 'c')
                ->where($queryBuilder->expr()->eq('c.idClass', $idClass))
                ->getQuery()
                ->execute();
        $turma = $queryBuilder->getQuery()->getArrayResult();
        $this->logControle->logAdmin(print_r($turma, true));
        foreach ($turma as $arrayTurma) {
            if (empty($arrayTurma['dtStart'])) {
                $dtStart = null;
            } else {
                $dtStart = $arrayTurma['dtStart']->format('Y-m-d');
            }
            if (empty($arrayTurma['dtFinish'])) {
                $dtFinish = null;
            } else {
                $dtFinish = $arrayTurma['dtFinish']->format('Y-m-d');
            }
            $dadosTurma = array(
                'id' => $idClass,
                'dsCode' => $arrayTurma['dsCode'],
                'dsDescription' => $arrayTurma['dsDescription'],
                'stStatus' => $arrayTurma['stStatus'],
                'dtStart' => $dtStart,
                'dtFinish' => $dtFinish
            );
        }
        $this->logControle->logAdmin(print_r($dadosTurma, true));
        return $dadosTurma;
    }

    function gerarFormularioTurma($formName){
      $formTbClass = $this->get('form.factory')
              ->createNamedBuilder($formName, FormType::class)
              ->add('DsCode', HiddenType::class, array('label' => false))
              ->add('DsDescription', HiddenType::class, array('label' => false))
              ->add('StStatus', HiddenType::class, array('label' => false))
              ->add('DtStart', HiddenType::class, array('label' => false))
              ->add('DtFinish',  HiddenType::class, array('label' => false))
              ->getForm();
      return $formTbClass;
    }

    function editClass($dadosForm){
      $idClass = $this->get('session')->get('idTurmaEdicao');

      $classEditar = $this->getDoctrine()
              ->getRepository('AppBundle:TbClass')
              ->findOneBy(array('idClass' => $idClass));

      TurmasController::persistirObjetoTurma($classEditar, $dadosForm);
    }

    function persistirObjetoTurma($classEditar, $dadosForm) {
      $this->em = $this->getDoctrine()->getManager();

      $classEditar->setDsCode($dadosForm['DsCode']);
      $classEditar->setDsDescription($dadosForm['DsDescription']);
      $classEditar->setStStatus($dadosForm['StStatus']);

      $date = date_create_from_format('Y-m-d:H:i:s', $dadosForm['DtStart'] . ':00:00:00');
      $date->getTimestamp();
      $classEditar->setDtStart($date);

      $date = date_create_from_format('Y-m-d:H:i:s', $dadosForm['DtFinish'] . ':00:00:00');
      $date->getTimestamp();
      $classEditar->setDtFinish($date);

      $this->em->persist($classEditar);
      $this->em->flush();
    }
}
