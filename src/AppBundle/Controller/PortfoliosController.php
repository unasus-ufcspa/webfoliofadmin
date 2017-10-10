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

use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class PortfoliosController extends Controller {

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

    public function gerarArrayPortfolios() {
        $queryBuilderClass = $this->em->createQueryBuilder();
        $queryBuilderClass
                ->select('p')
                ->from('AppBundle:TbPortfolio', 'p')
                ->getQuery()
                ->execute();
        $portfolios = $queryBuilderClass->getQuery()->getArrayResult();
        foreach ($portfolios as $portfolio) {

            $queryBuilder = $this->em->createQueryBuilder();
            $queryBuilder
                    ->select('count(a.idActivity)')
                    ->from('AppBundle:TbActivity', 'a')
                    ->where($queryBuilder->expr()->eq('a.idPortfolio', $portfolio['idPortfolio']))
                    ->getQuery()
                    ->execute();
            $portfolio['nmAtividades'] = $queryBuilder->getQuery()->getSingleScalarResult();

            $arrayPortfolios[] = array(
              'idPortfolio' => $portfolio['idPortfolio'],
              'dsTitle' => $portfolio['dsTitle'],
              'nmAtividades' => $portfolio['nmAtividades']
            );
        }
        return $arrayPortfolios;
    }

    /**
     * @Route("/cadastroPortfolio")
     */
    function cadastroPortfolio(Request $request) {
        if (!$this->get('session')->get('idUser')) {

            return $this->redirectToRoute('login');
        } else {
            $this->em = $this->getDoctrine()->getManager();

            $this->formAdicionarPortfolio = PortfoliosController::gerarFormularioPortfolio("adicionar");
            $this->formAdicionarPortfolio->handleRequest($request);

            if ($request->request->has($this->formAdicionarPortfolio->getName())) {
                if ($this->formAdicionarPortfolio->isSubmitted() && $this->formAdicionarPortfolio->isValid()) {
                    $dadosFormAdicionarPortfolio = $this->formAdicionarPortfolio->getData();
                    $this->adicionarPortfolio($dadosFormAdicionarPortfolio);
                    return $this->redirectToRoute('portfolios');
                }
            }

            return $this->render('cadastroPortfolio.html.twig', array('formPort' => $this->formAdicionarPortfolio->createView(),));
        }
    }

    function gerarFormularioPortfolio($nomeFormulario) {

        $formularioTbPortfolio = $this->get('form.factory')
                ->createNamedBuilder($nomeFormulario, FormType::class)
                ->add('DsTitle', TextType::class, array('label' => false))
                ->add('DsDescription', TextareaType ::class, array('label' => false))
                ->getForm();
        return $formularioTbPortfolio;
    }

    function adicionarPortfolio($dadosFormAdicionarPortfolio) {
        $novoPortfolio = new TbPortfolio();
        persistirObjetoPortfolio($novoPortfolio, $dadosFormAdicionarPortfolio);
    }

    function persistirObjetoPortfolio($objetoPortfolio, $dadosPortfolio) {

        $this->em = $this->getDoctrine()->getManager();
        $objetoPortfolio->setDsTitle($dadosPortfolio['DsTitle']);
        $objetoPortfolio->setDsDescription($dadosPortfolio['DsDescription']);

        $this->em->persist($objetoPortfolio);
        $idPortfolio = $objetoPortfolio->getIdUser();

        $this->em->flush();
    }

    // function editarUsuario($dadosFormEditar) {
    //     $this->logControle->logAdmin(print_r($dadosFormEditar, true));
    //
    //     $usuarioEditavel = $this->getDoctrine()
    //             ->getRepository('AppBundle:TbUser')
    //             ->findOneBy(array('idUser' => $dadosFormEditar['IdUser']));
    //      $this->logControle->logAdmin("editar usuario");
    //     $this->logControle->logAdmin(print_r($usuarioEditavel, true));
    //     UsuarioController::persistirObjetoUsuario($usuarioEditavel, $dadosFormEditar, 'T', 'F');
    // }
}
