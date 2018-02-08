<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
 * Description of UsuarioController
 *
 * @author Marilia
 */
class UsuarioController extends Controller {

    public $em;
    public $logControle;

    public function __construct() {
        $this->logControle = new LogController();
    }

    function gerarFormulario($nomeFormulario) {

        $formularioTbUser = $this->get('form.factory')
                ->createNamedBuilder($nomeFormulario, FormType::class)
                ->add('NmUser', TextType::class, array('label' => false))
                ->add('IdUser', HiddenType::class, array('label' => false))
                ->add('DsEmail', EmailType::class, array('label' => false))
                ->add('DsPassword', PasswordType::class, array('label' => false))
                ->add('DsPasswordConfirm', PasswordType::class, array('label' => false))
                ->add('NuCellphone', NumberType::class, array('label' => false, 'required' => false,))
                ->add('NuIdentification', NumberType::class, array('label' => false, 'required' => false,))
                ->getForm();
        return $formularioTbUser;
    }

    function persistirObjetoUsuario($objetoUsuario, $dadosUsuario, $flag, $valor) {

        $this->em = $this->getDoctrine()->getManager();
        $this->logControle->logAdmin(print_r($dadosUsuario, true));
        $senhaFormatada = hash('sha256', $dadosUsuario['DsPassword']);
        $objetoUsuario->setDsEmail($dadosUsuario['DsEmail']);
        $objetoUsuario->setNmUser($dadosUsuario['NmUser']);
        $objetoUsuario->setDsPassword($senhaFormatada);
        $objetoUsuario->setNuCellphone($dadosUsuario['NuCellphone']);
        $objetoUsuario->setNuIdentification($dadosUsuario['NuIdentification']);

        if ($flag == "flAdmin") {
            $objetoUsuario->setFlAdmin($valor);
        } else {
            if ($flag == "flProposer") {
                $objetoUsuario->setFlProposer($valor);
            }
        }

        $this->em->persist($objetoUsuario);
        $idUser = $objetoUsuario->getIdUser();

        $this->em->flush();
    }

    function editarUsuario($dadosFormEditar) {
        $this->logControle->logAdmin(print_r($dadosFormEditar, true));

        $usuarioEditavel = $this->getDoctrine()
                ->getRepository('AppBundle:TbUser')
                ->findOneBy(array('idUser' => $dadosFormEditar['IdUser']));
         $this->logControle->logAdmin("editar usuario");
        $this->logControle->logAdmin(print_r($usuarioEditavel, true));
        UsuarioController::persistirObjetoUsuario($usuarioEditavel, $dadosFormEditar, 'T', 'F');
    }

}
