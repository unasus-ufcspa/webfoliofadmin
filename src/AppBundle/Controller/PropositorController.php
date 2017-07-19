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
use AppBundle\Entity\TbUser;
use AppBundle\Controller\UsuarioController;

/**
 * Description of PropositorController
 *
 * @author Marilia
 */
class PropositorController extends Controller {

    public $error;
    public $logControle;
    public $em;
    public $formAdicionarPropositor;
    public $formEditarPropositor;

    public function __construct() {
        $this->logControle = new LogController();
    }

    /**
     * @Route("/propositores", name="propositores")
     */
    function propositoresAction(Request $request) {

        if (!$this->get('session')->get('idUser')) {

            return $this->redirectToRoute('login');
        } else {
            $this->em = $this->getDoctrine()->getManager();
            $arrayPropositores = $this->gerarArrayPropositores();
            $this->formEditarPropositor = UsuarioController::gerarFormulario("editar");
            $this->formAdicionarPropositor = UsuarioController::gerarFormulario("adicionar");
            $this->formEditarPropositor->handleRequest($request);
            $this->formAdicionarPropositor->handleRequest($request);

            if ($request->request->has($this->formEditarPropositor->getName())) {
                if ($this->formEditarPropositor->isSubmitted() && $this->formEditarPropositor->isValid()) {
                    $dadosFormEditarPropositor = $this->formEditarPropositor->getData();
                    UsuarioController::editarUsuario($dadosFormEditarPropositor);
                }
            } else {
                if ($this->formAdicionarPropositor->isSubmitted() && $this->formAdicionarPropositor->isValid()) {
                    $dadosFormAdicionarPropositor = $this->formAdicionarPropositor->getData();
                    $this->adicionarPropositor($dadosFormAdicionarPropositor);
                  
                }
            }
            return $this->render('propositores.html.twig', array('propositores' => $arrayPropositores,
                        'formPropositor' => $this->formEditarPropositor->createView(),
                        'formAddPropositor' => $this->formAdicionarPropositor->createView()));
        }
    }

    function gerarArrayPropositores() {
        $arrayPropositores = array();
        $propositores = $this->selecionarPropositores();
        foreach ($propositores as $proposerUser) {
            $arrayPropositores[] = array(
                'idUser' => $proposerUser['idUser'],
                'nmUser' => $proposerUser['nmUser'],
                'nuIdentification' => $proposerUser['nuIdentification'],
                'dsEmail' => $proposerUser['dsEmail'],
                'nuCellphone' => $proposerUser['nuCellphone']
            );
        }
        return $arrayPropositores;
    }

    function selecionarPropositores() {
        $idUser = $this->get('session')->get('idUser');
        $queryBuilderProposer = $this->em->createQueryBuilder();
        $queryBuilderProposer
                ->select('u')
                ->from('AppBundle:TbUser', 'u')
                ->where($queryBuilderProposer->expr()->eq('u.flProposer', "'T'"))
                ->andWhere($queryBuilderProposer->expr()->neq('u.idUser', $idUser))
                ->getQuery()
                ->execute();
        $propositores = $queryBuilderProposer->getQuery()->getArrayResult();

        return $propositores;
    }

    function adicionarPropositor($dadosFormAdicionarPropositor) {
        $this->logControle->logAdmin(print_r($dadosFormAdicionarPropositor, true));
        $novoPropositor = new TbUser();
        $this->logControle->logAdmin(($dadosFormAdicionarPropositor['DsPassword']));
        if ($dadosFormAdicionarPropositor['DsPassword'] == $dadosFormAdicionarPropositor['DsPasswordConfirm']) {
            UsuarioController::persistirObjetoUsuario($novoPropositor, $dadosFormAdicionarPropositor, 'flProposer', 'T');
        }
    }

   

}
