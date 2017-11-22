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
use AppBundle\Entity\TbActivity;
use AppBundle\Entity\TbPortfolio;

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
     * @Route("/cadastroPortfolio/{idPortfolio}")
     */
    function cadastroPortfolio(Request $request, $idPortfolio) {
        if (!$this->get('session')->get('idUser')) {

            return $this->redirectToRoute('login');
        } else {
            $this->em = $this->getDoctrine()->getManager();

            $dadosPortfolio = array();
            $arrayAtividades = array();
            if ($idPortfolio > -1) {
              $dadosPortfolio = $this->carregarDadosPortfolio($idPortfolio);
              $arrayAtividades= $this->carregarAtividadesPortfolio($idPortfolio);
            }else{
              $dadosPortfolio = array(
                  'dsTitle' => null,
                  'dsDescription' => null
              );
              $arrayAtividades  = array();
            }

            $this->formAdicionarPortfolio = PortfoliosController::gerarFormularioPortfolio("adicionar");
            $this->formAdicionarPortfolio->handleRequest($request);

            $this->formAdicionarAtividade = PortfoliosController::gerarFormularioAddAtividade("adicionar");
            $this->formAdicionarAtividade->handleRequest($request);

            if ($request->request->has($this->formAdicionarPortfolio->getName())) {
                if ($this->formAdicionarPortfolio->isSubmitted() && $this->formAdicionarPortfolio->isValid()) {
                    $dadosFormAdicionarPortfolio = $this->formAdicionarPortfolio->getData();
                    $this->adicionarPortfolio($dadosFormAdicionarPortfolio);
                    return $this->redirectToRoute('portfolios');
                }
            }
            if ($request->request->has($this->formAdicionarAtividade->getName())) {
                if ($this->formAdicionarAtividade->isSubmitted() && $this->formAdicionarAtividade->isValid()) {
                    $dadosFormAdicionarAtividade = $this->formAdicionarAtividade->getData();
                    $this->adicionarAtividade($dadosFormAdicionarAtividade);
                }
            }

            return $this->render('cadastroPortfolio.html.twig', array('atividades' => $arrayAtividades, 'portfolio' => $dadosPortfolio, 'formPort' => $this->formAdicionarPortfolio->createView(), 'formAtiv' => $this->formAdicionarAtividade->createView()));
        }
    }

    function carregarDadosPortfolio($idPortfolio) {
        $queryBuilder = $this->em->createQueryBuilder();
        $queryBuilder
                ->select('p')
                ->from('AppBundle:TbPortfolio', 'p')
                ->where($queryBuilder->expr()->eq('p.idPortfolio', $idPortfolio))
                ->getQuery()
                ->execute();
        $portfolio = $queryBuilder->getQuery()->getArrayResult();

        foreach ($portfolio as $arrayPortfolios) {
            $dadosPortfolio = array(
                'id' => $idPortfolio,
                'dsTitle' => $arrayPortfolios['dsTitle'],
                'dsDescription' => $arrayPortfolios['dsDescription']
            );
        }
        return $dadosPortfolio;
    }

    public function carregarAtividadesPortfolio($idPortfolio) {
        $queryBuilderPort = $this->em->createQueryBuilder();
        $queryBuilderPort
                ->select('a')
                ->from('AppBundle:TbActivity', 'a')
                ->where($queryBuilderPort->expr()->eq('a.idPortfolio', $idPortfolio))
                ->getQuery()
                ->execute();
        $atividades = $queryBuilderPort->getQuery()->getArrayResult();

        foreach ($atividades as $atividade) {
            $dadosAtividades[] = array(
                'id' => $atividade['idActivity'],
                'dsTitle' => $atividade['dsTitle'],
                'dsDescription' => $atividade['dsDescription'],
                'nuOrder' => $atividade['nuOrder']
            );
        }
        return $dadosAtividades;
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

        return $idPortfolio;
    }

    function gerarFormularioAddAtividade($nomeFormulario) {

        $formularioTbActivity = $this->get('form.factory')
                ->createNamedBuilder($nomeFormulario, FormType::class)
                ->add('DsTitle', TextType::class, array('label' => false))
                ->add('DsDescription', TextareaType ::class, array('label' => false))
                ->getForm();
        return $formularioTbActivity;
    }

    function adicionarAtividade($dadosFormAdicionarAtividade) {
        $novaAtividade = new TbActivity();
        persistirObjetoAtividade($novaAtividade, $dadosFormAdicionarAtividade);
    }

    function persistirObjetoAtividade($objetoAtividade, $dadosAtividade) {
        $this->em = $this->getDoctrine()->getManager();
        $objetoAtividade->setDsTitle($dadosPortfolio['DsTitle']);
        $objetoAtividade->setDsDescription($dadosPortfolio['DsDescription']);

        $this->em->persist($objetoAtividade);
        // $idPortfolio = $objetoPortfolio->getIdUser();

        $this->em->flush();

        // return $idPortfolio;
    }

}
