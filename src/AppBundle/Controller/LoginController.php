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

    /**
     * @Route("/login", name="login")
     */
    public function login(Request $request) {
        if ($this->get('session')->get('idUser')) {

            return $this->redirectToRoute('portfolios');
        } else {
            $user = new TbUser();

            $formUserLogin = $this->createFormBuilder($user)
                    ->add('DsEmail', TextType::class, array('label' => false))
                    ->add('DsPassword', PasswordType::class, array('label' => false))
                    
                    ->getForm();

            $formUserLogin->handleRequest($request);
        }
        if ($formUserLogin->isSubmitted() && $formUserLogin->isValid()) {
            $this->autenticacao($user->getDsEmail(), $user->getDsPassword());
        }
        return $this->render('login.html.twig', array(
                    'form' => $formUserLogin->createView(),
        ));
    }

    public function autenticacao($email, $senha) {

        $senha = hash('sha256', $senha);
        $usuarioAutenticado = $this->getDoctrine()
                ->getRepository('AppBundle:TbUser')
                ->findBy(array('dsEmail' => $email, 'dsPassword' => $senha));
        

        if (!$usuarioAutenticado) {
            throw $this->createNotFoundException(
                    'No product found for id ' . $productId
            );
        }else{
            $idUser = $usuarioAutenticado[0]->getIdUser();
             $this->get('session')->set('idUser',$idUser);
                 return $this->redirectToRoute('home');
        }
    }

}
