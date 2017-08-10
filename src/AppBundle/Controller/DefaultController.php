<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }


    /**
     * @Route("/tutoresAlunos", name="tutoresAlunos")
     */
    function tutoresAlunosAction(Request $request) {

        if (!$this->get('session')->get('idUser')) {

            return $this->redirectToRoute('login');
        } else {
            $this->em = $this->getDoctrine()->getManager();

            // $dadosMenuLateralCadastro = MenuLateralCadastroController::carregarDadosMenuLateralCadastro();

            // return $this->render('tutoresAlunos.html.twig', array('dadosMenuLateralCadastro' => $dadosMenuLateralCadastro));
            return $this->render('tutoresAlunos.html.twig');

        }
    }
}
