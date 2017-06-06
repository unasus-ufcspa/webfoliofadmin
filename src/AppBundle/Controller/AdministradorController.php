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


/**
 * Description of AdministradorController
 *
 * @author Marilia
 */
class AdministradorController extends Controller {

    public $error;
    public $logControle;
    public $em;
    public $formAdministrador;
    public $objetoUser;

    public function __construct() {
        $this->logControle = new LogController();
    }

    //TO-DO: https://stackoverflow.com/questions/19375349/how-to-make-a-post-ajax-request-with-symfony-and-jquery

    function gerarFormularioAdministrador() {
        $this->objetoUser = new TbUser();

        $this->formAdministrador = $this->createFormBuilder($this->objetoUser)
        ->add('NmUser', TextType::class, array('label' => false,  'data' => 'abcdef',))
        ->add('DsEmail', EmailType::class, array('label' => false))
        ->add('DsPassword', RepeatedType::class, array(
        'type' => PasswordType::class,
        'first_options' => array('label' => false),
        'second_options' => array('label' => false),
        ))
        ->add('NuCellphone', NumberType::class, array('label' => false))
                ->add('NuIdentification', NumberType::class, array('label' => false))
                ->getForm();
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
            $this->gerarFormularioAdministrador();
            $this->formAdministrador->handleRequest($request);
            if ($this->formAdministrador->isSubmitted() && $this->formAdministrador->isValid()) {
                //    $this->cadastrarAdministrador($this->objetoUser->getDsEmail(), $user->getDsPassword());
                $this->logControle->logAdmin("hty");
            }
            return $this->render('administradores.html.twig', array('administradores' => $arrayAdministradores, 'formAdmin' => $this->formAdministrador->createView()));
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
