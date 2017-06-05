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

/**
 * Description of AdministradorController
 *
 * @author Marilia
 */
class AdministradorController extends Controller {

    public $logControle;
    public $em;

    public function __construct() {
        $this->logControle = new LogController();
    }

    /**
     * @Route("/administradores", name="administradores")
     */
    function administradoresAction() {
        if (!$this->get('session')->get('idUser')) {

            return $this->redirectToRoute('login');
        } else {
            $this->em = $this->getDoctrine()->getEntityManager();
            $arrayAdministradores = $this->gerarArrayAdministradores();


            return $this->render('administradores.html.twig', array('administradores' => $arrayAdministradores));
        }
    }

    public function gerarArrayAdministradores() {
        $arrayAdministradores = array();
        $administradores = $this->selecionarAdministradores();
        foreach ($administradores as $adminUser) {
            $arrayAdministradores[] = array(
                'idUser' => $adminUser['idUser'],
                'nmUser' => $adminUser['nmUser'],
                'nuIdentification' => $adminUser['nuIdentification'],
                'dsEmail' => $adminUser['dsEmail'],
                'nuCellphone' => $adminUser['nuCellphone']
            );
        }
        return $arrayAdministradores;
    }

    public function selecionarAdministradores() {
        $idUser = $this->get('session')->get('idUser');
        $queryBuilderAdmin = $this->em->createQueryBuilder();
        $queryBuilderAdmin
                ->select('u')
                ->from('AppBundle:TbUser', 'u')
                ->where($queryBuilderAdmin->expr()->eq('u.flAdmin', "'T'"))
                ->andWhere($queryBuilderAdmin->expr()->neq('u.idUser', $idUser))
                ->getQuery()
                ->execute();
        $administradores = $queryBuilderAdmin->getQuery()->getArrayResult();
        $this->logControle->logAdmin(print_r($administradores, true));
        return $administradores;
    }

}
