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
use Symfony\Component\Form\Extension\Core\Type\FormType;

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
    public $formAdicionarAdministrador;

    public function __construct() {
        $this->logControle = new LogController();
    }

    function gerarFormularioAdministrador($nomeFormulario) {

        $formularioTbUser = $this->get('form.factory')
                ->createNamedBuilder($nomeFormulario, FormType::class)
                ->add('NmUser', TextType::class, array('label' => false))
                ->add('IdUser', HiddenType::class, array('label' => false))
                ->add('DsEmail', EmailType::class, array('label' => false))
                ->add('DsPassword', PasswordType::class, array('label' => false))
                ->add('DsPasswordConfirm', PasswordType::class, array('label' => false))
                ->add('NuCellphone', NumberType::class, array('label' => false))
                ->add('NuIdentification', NumberType::class, array('label' => false))
                ->getForm();
        return $formularioTbUser;
    }

    /**
     * @Route("/administradores")
     */
    function administradores(Request $request) {
        if (!$this->get('session')->get('idUser')) {

            return $this->redirectToRoute('login');
        } else {
            $this->em = $this->getDoctrine()->getManager();
            $arrayAdministradores = $this->gerarArrayAdministradores();
            $this->formEditarAdministrador = $this->gerarFormularioAdministrador("editar");
            $this->formAdicionarAdministrador = $this->gerarFormularioAdministrador("adicionar");
            $this->formEditarAdministrador->handleRequest($request);
            $this->formAdicionarAdministrador->handleRequest($request);

            if ($request->request->has($this->formEditarAdministrador->getName())) {
                if ($this->formEditarAdministrador->isSubmitted() && $this->formEditarAdministrador->isValid()) {
                    $dadosFormEditarAdministrador = $this->formEditarAdministrador->getData();
                    $this->editarAdministrador($dadosFormEditarAdministrador);
                }
            } else {
                if ($this->formAdicionarAdministrador->isSubmitted() && $this->formAdicionarAdministrador->isValid()) {
                    $dadosFormAdicionarAdministrador = $this->formAdicionarAdministrador->getData();
                    $this->adicionarAdministrador($dadosFormAdicionarAdministrador);
                    return $this->redirectToRoute('administradores');
                }
            }


            return $this->render('administradores.html.twig', array('administradores' => $arrayAdministradores,
                        'formAdmin' => $this->formEditarAdministrador->createView(),
                        'formAddAmin' => $this->formAdicionarAdministrador->createView()));
        }
    }

    function adicionarAdministrador($dadosFormAdicionarAdministrador) {
        $this->logControle->logAdmin(print_r($dadosFormAdicionarAdministrador, true));
        $novoAdministrador = new TbUser();

        $this->logControle->logAdmin(($dadosFormAdicionarAdministrador['DsPassword']));


        if ($dadosFormAdicionarAdministrador['DsPassword'] == $dadosFormAdicionarAdministrador['DsPasswordConfirm']) {
            $this->persistirObjetoAdministrador($novoAdministrador, $dadosFormAdicionarAdministrador);
        }
    }

    function editarAdministrador($dadosFormEditarAdministrador) {
        $this->logControle->logAdmin(print_r($dadosFormEditarAdministrador, true));

        $administradorEditavel = $this->getDoctrine()
                ->getRepository('AppBundle:TbUser')
                ->findBy(array('idUser' => $dadosFormEditarAdministrador['IdUser']));
        $this->logControle->logAdmin(print_r($administradorEditavel, true));
        $this->persistirObjetoAdministrador($administradorEditavel, $dadosFormEditarAdministrador);
    }

    function persistirObjetoAdministrador($objetoUsuario, $dadosUsuario) {
        $senhaFormatada = hash('sha256', $dadosUsuario['DsPassword']);
        $objetoUsuario->setDsEmail($dadosUsuario['DsEmail']);
        $objetoUsuario->setNmUser($dadosUsuario['NmUser']);
        $objetoUsuario->setDsPassword($senhaFormatada);
        $objetoUsuario->setNuCellphone($dadosUsuario['NuCellphone']);
        $objetoUsuario->setNuIdentification($dadosUsuario['NuIdentification']);
        $objetoUsuario->setFlAdmin('T');
        $this->em->persist($objetoUsuario);
        $idUser = $objetoUsuario->getIdUser();

        $this->em->flush();
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

    /**
     * @Route("/excluirAdministradores")
     */
    function excluirAdministradores(Request $request) {
        $this->em = $this->getDoctrine()->getEntityManager();
        $flagGerouExcecao = false;
        $usuariosExcecao = array();
        if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
            $data = json_decode($request->getContent(), true);
            $request->request->replace(is_array($data) ? $data : array());
            $this->logControle->logAdmin("Excluir admnistradores : " . print_r($data, true));

            foreach ($data['arrayAdministradores'] as $idsAdministradoresExclusao) {
                $this->em = $this->getDoctrine()->resetManager();
                $this->logControle->logAdmin("Excluir  : " . print_r($idsAdministradoresExclusao, true));

                try {
                    $entity = $this->em->getRepository('AppBundle:TbUser')
                            ->findOneBy(array('idUser' => $idsAdministradoresExclusao));
                    if ($entity != null) {
                        $this->em->remove($entity);
                        $this->em->flush();
                    }
                } catch (\Exception $excpetion) {
                    $this->logControle->logAdmin("exception  : " . print_r($excpetion->getMessage(), true));
                    $flagGerouExcecao = true;
                    $usuariosExcecao[] = $idsAdministradoresExclusao;
                }
            }

            $retornoRequest = array(
                "sucesso" => true,
                "usuariosExcecao" => $usuariosExcecao
            );
        } else {
            $retornoRequest = array(
                "sucesso" => false,
                "usuariosExcecao" => NULL
            );
        }
        return new JsonResponse($retornoRequest);
    }

}
