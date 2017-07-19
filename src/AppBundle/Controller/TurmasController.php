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
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use AppBundle\Controller\UsuarioController;

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
     * @Route("/cadastroTurma", name="cadastroTurma")
     */
    //adicionar parametros para a rota /cadastroTurma/{idClass}

    function cadastroTurmaAction() {
        $idClass = 1;
        $this->em = $this->getDoctrine()->getManager();
        if ($idClass > -1) {
            $dadosTurma = $this->carregarDadosTurma($idClass);
        }
        $dadosMenuLateralCadastro = $this->carregarDadosMenuLateralCadastro($idClass);
        return $this->render("cadastroTurma.html.twig", array('dadosMenuLateralCadastro' => $dadosMenuLateralCadastro, 'dadosTurma' => $dadosTurma));
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

    function carregarDadosMenuLateralCadastro($idClass) {
        $arrayDadosPortfolios = $this->carregarPortfolios();
        $arrayDadosPropositores = $this->carregarPropositores();
        $arrayDadosMenuLateralCadastro = array(
            'arrayDadosPortfolios' => $arrayDadosPortfolios,
            'arrayDadosPropositores' => $arrayDadosPropositores
        );
        return $arrayDadosMenuLateralCadastro;
    }

    function carregarPortfolios() {
        $arrayDadosPortfolios = array();
        $queryBuilder = $this->em->createQueryBuilder();
        $queryBuilder
                ->select('p')
                ->from('AppBundle:TbPortfolio', 'p')
                ->getQuery()
                ->execute();
        $portfolios = $queryBuilder->getQuery()->getArrayResult();
        foreach ($portfolios as $arrayPortfolios) {
            $arrayDadosPortfolios[] = array(
                'idPortfolio' => $arrayPortfolios['idPortfolio'],
                'dsTitle' => $arrayPortfolios['dsTitle'],
            );
        }
        $this->logControle->logAdmin(print_r($arrayDadosPortfolios, true));
        return $arrayDadosPortfolios;
    }

    function carregarPropositores() {
        $arrayDadosPropositores = array();
        $queryBuilder = $this->em->createQueryBuilder();
        $queryBuilder
                ->select('u')
                ->from('AppBundle:TbUser', 'u')
                ->where($queryBuilder->expr()->eq('u.flProposer', "'T'"))
                ->getQuery()
                ->execute();
        $propositores = $queryBuilder->getQuery()->getArrayResult();
        foreach ($propositores as $arrayPropositores) {
            $arrayDadosPropositores[] = array(
                'idUser' => $arrayPropositores['idUser'],
                'nmUser' => $arrayPropositores['nmUser'],
            );
        }
        $this->logControle->logAdmin(print_r($arrayDadosPropositores, true));
        return $arrayDadosPropositores;
    }

    function carregarTutoresTurma() {
        
    }

    function carregarAlunosTurma() {
        
    }

}
