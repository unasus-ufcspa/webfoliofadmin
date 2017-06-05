<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Controller;

/**
 * Description of LoginController
 *
 * @author Marilia
 */
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\TbUser;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class LoginController extends Controller {

    public $formUserLogin;
    public $error = null;

    /**
     * @Route("/login", name="login")
     */
    public function login(Request $request) {
        if ($this->get('session')->get('idUser')) {

            return $this->redirectToRoute('home');
        } else {

            $user = new TbUser();

            $this->formUserLogin = $this->createFormBuilder($user)
                    ->add('DsEmail', TextType::class, array('label' => false))
                    ->add('DsPassword', PasswordType::class, array('label' => false))
                    ->getForm();

            $this->formUserLogin->handleRequest($request);
        }
        if ($this->formUserLogin->isSubmitted() && $this->formUserLogin->isValid()) {
            $this->autenticacao($user->getDsEmail(), $user->getDsPassword());
        }
        return $this->render('login.html.twig', array(
                    'form' => $this->formUserLogin->createView(), 'erro' => $this->error
        ));
    }

    public function autenticacao($email, $senha) {

        $senha = hash('sha256', $senha);
        $usuarioAutenticado = $this->getDoctrine()
                ->getRepository('AppBundle:TbUser')
                ->findBy(array('dsEmail' => $email, 'dsPassword' => $senha));


        if (!$usuarioAutenticado) {
            $this->error = "usuario nao encontrado";
        } else {
            if ($usuarioAutenticado[0]->getFlAdmin() == 'T' || $usuarioAutenticado[0]->getFlProposer() == 'T') {
                $idUser = $usuarioAutenticado[0]->getIdUser();
                $this->get('session')->set('idUser', $idUser);
                return $this->redirectToRoute('home');
            } else {
                $this->error = "usuario sem permissao";
            }
        }
    }

    /**
     * @Route("/logoutAdmin")
     */
    public function logoutAdminAction() {

        $this->get('session')->invalidate();
        return $this->redirectToRoute('login');
    }

}
