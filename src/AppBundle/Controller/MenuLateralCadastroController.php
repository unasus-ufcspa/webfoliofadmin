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
use AppBundle\Controller\TurmasController;

/**
 * Description of TurmasController
 *
 * @author Marilia
 */
class MenuLateralCadastroController extends Controller {

    public $error;
    public $logControle;
    public $em;

    public function __construct() {
        $this->logControle = new LogController();
    }

    function carregarDadosMenuLateralCadastro() {
        $arrayDadosPortfolios = MenuLateralCadastroController::carregarPortfolios();
        $arrayDadosPropositores = MenuLateralCadastroController::carregarPropositores();
        $arrayDadosTutores = MenuLateralCadastroController::carregarTutoresTurma();
        $arrayDadosAlunos = MenuLateralCadastroController::carregarAlunosTurma();
        $arrayDadosMenuLateralCadastro = array(
            'arrayDadosPortfolios' => $arrayDadosPortfolios,
            'arrayDadosPropositores' => $arrayDadosPropositores,
            'arrayDadosTutores' => $arrayDadosTutores,
            'arrayDadosAlunos' =>$arrayDadosAlunos
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

        $arrayTutores = TutorController::gerarArrayTutores();
        return $arrayTutores;
    }

    function carregarAlunosTurma() {
        $arrayAlunos = AlunosController::gerarArrayAlunos();
        return $arrayAlunos;
    }

}
