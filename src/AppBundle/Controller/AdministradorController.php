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
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Description of AdministradorController
 *
 * @author Marilia
 */
class AdministradorController extends Controller {

    public $error;
    public $logControle;
    public $em;
    public $formEditarAdministrador;
    public $objetoUser;

    public function __construct() {
        $this->logControle = new LogController();
    }

    //TO-DO: https://stackoverflow.com/questions/19375349/how-to-make-a-post-ajax-request-with-symfony-and-jquery

    function gerarFormularioAdministrador() {
        $this->objetoUser = new TbUser();

        $formularioTbUser = $this->createFormBuilder($this->objetoUser)
                ->add('NmUser', TextType::class, array('label' => false))
                ->add('IdUser', HiddenType::class, array('label' => false))
                ->add('DsEmail', EmailType::class, array('label' => false))
                ->add('DsPassword', RepeatedType::class, array(
                    'type' => PasswordType::class,
                    'first_options' => array('label' => false),
                    'second_options' => array('label' => false),
                ))
                ->add('NuCellphone', NumberType::class, array('label' => false))
                ->add('NuIdentification', NumberType::class, array('label' => false))
                ->getForm();
        return $formularioTbUser;
    }

    /**
     * @Route("/administradores", name="administradores")
     */
    function administradoresAction(Request $request) {
        if (!$this->get('session')->get('idUser')) {

            return $this->redirectToRoute('login');
        } else {
            $this->em = $this->getDoctrine()->getManager();
            $arrayAdministradores = $this->gerarArrayAdministradores();
            $this->formEditarAdministrador = $this->gerarFormularioAdministrador();

            $this->formEditarAdministrador->handleRequest($request);

            if ($this->formEditarAdministrador->isSubmitted()) {

                $dadosFormEditarAdministrador = $this->formEditarAdministrador->getData();
                $this->editarAdministrador($dadosFormEditarAdministrador);


                return new JsonResponse(array('data' => 'this is a json response'));
            }


            return $this->render('administradores.html.twig', array('administradores' => $arrayAdministradores, 'formAdmin' => $this->formEditarAdministrador->createView()));
        }
    }

    function editarAdministrador($dadosFormEditarAdministrador) {
        $this->logControle->logAdmin(print_r($dadosFormEditarAdministrador, true));
       
                 $this->logControle->logAdmin($dadosFormEditarAdministrador->getNmUser());
    }

    /**
     * @Route("/ajax", name="_recherche_ajax")
     */
    public function ajaxAction(Request $request) {
        if ($request->isXMLHttpRequest()) {
            return new JsonResponse(array('data' => 'this is a json response'));
        }

        return new Response('This is not ajax!', 400);
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

        return $administradores;
    }

}
