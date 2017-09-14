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

/**
 * Description of AdministradorController
 *
 * @author Marilia
 */
class PortfolioController extends Controller {

    public $error;
    public $logControle;
    public $em;

    public function __construct() {
        $this->logControle = new LogController();
    }

    /**
     * @Route("/portfolios")
     */
    function portfolios(Request $request) {
        if (!$this->get('session')->get('idUser')) {

            return $this->redirectToRoute('login');
        } else {
            $this->em = $this->getDoctrine()->getManager();

            $arrayPortfolios = $this->gerarArrayPortfolios();

            return $this->render('portfolios.html.twig', array('portfolios' => $arrayPortfolios));
        }
    }

    public function gerarArrayAdministradores() {
        $arrayPortfolios = array();
        $portfolios = $this->selecionarPortfolios();
        foreach ($portfolios as $portfolio) {
            $arrayPortfolios[] = array(
                'idPortfolio' => $portfolio['idPortfolio'],
                'dsTitle' => $portfolio['dsTitle'],
                'nmAtividades' => $portfolio['nmAtividades']
            );
        }
        return $arrayPortfolios;
    }

    public function selecionarPortfolios() {
        $idUser = $this->get('session')->get('idUser');
        $queryBuilderPort = $this->em->createQueryBuilder();
        $queryBuilderPort
                ->select('u')
                ->from('AppBundle:TbPortfolio', 'u')
                ->where($queryBuilderPort->expr()->eq('u.flAdmin', "'T'"))
                ->andWhere($queryBuilderPort->expr()->neq('u.idUser', $idUser))
                ->getQuery()
                ->execute();
        $portfolios = $queryBuilderPort->getQuery()->getArrayResult();

        return $portfolios;
    }
}
