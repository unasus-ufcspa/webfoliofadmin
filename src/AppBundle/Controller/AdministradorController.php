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

    public $error;
    public $logControle;
    public $em;

    public function __construct() {
        $this->logControle = new LogController();
    }
 
    //TO-DO: https://stackoverflow.com/questions/19375349/how-to-make-a-post-ajax-request-with-symfony-and-jquery
    /**
     * @Route("/adicionarAdministrador", name="adicionarAdministrador")
     */
    function adicionarAdministradorAction(Request $request) {
        $user = new TbUser();

        $formNovoAdmin = $this->createFormBuilder($user)
                ->add('NmUser', TextType::class, array('label' => false))
                ->add('DsEmail', EmailType::class, array('label' => false))
                ->add('DsPassword', PasswordType::class, array('label' => false))
                ->add('DsPasswordConfirm', PasswordType::class, array('label' => false))
                ->add('NuCellphone', NumberType::class, array('label' => false))
                ->add('NuIdentification', NumberType::class, array('label' => false))
                ->getForm();

        $formNovoAdmin->handleRequest($request);

        if ($formNovoAdmin->isSubmitted() && $formNovoAdmin->isValid()) {
            $this->cadastrarAdministrador($user->getDsEmail(), $user->getDsPassword());
        }
        return $this->render('administradores.html.twig', array(
                    'form' => $formNovoAdmin, 'erro' => $this->error
        ));
    }

    /**
     * @Route("/administradores", name="administradores")
     */
    function administradoresAction() {
        if (!$this->get('session')->get('idUser')) {

            return $this->redirectToRoute('login');
        } else {
            $this->em = $this->getDoctrine()->getManager();
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
