<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Controller\ManipularArquivoController;
use AppBundle\Controller\UsuarioController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\TbUser;
use AppBundle\Entity\TbClassTutor;

class TutorController extends Controller {

    public $error;
    public $logControle;
    public $em;
    public $formEditarTutor;
    public $formAdicionarTutor;

    public function __construct() {
        $this->logControle = new LogController();
    }

    /**
     * @Route("/tutores", name="tutores")
     */
    function tutoresAction(Request $request) {

        if (!$this->get('session')->get('idUser')) {

            return $this->redirectToRoute('login');
        } else {
            $this->em = $this->getDoctrine()->getManager();


            $arrayTutores = $this->gerarArrayTutores(); //$idClass da rota
            $this->formEditarTutor = UsuarioController::gerarFormulario("editar");
            $this->formAdicionarTutor = UsuarioController::gerarFormulario("adicionar");
            $this->formExcluirTutor = AlunosController::gerarFormExcluir("excluir");
            $this->formEditarTutor->handleRequest($request);
            $this->formAdicionarTutor->handleRequest($request);
            $this->formExcluirTutor->handleRequest($request);
            $deleteException = false;

            if ($request->request->has($this->formEditarTutor->getName())) {
                if ($this->formEditarTutor->isSubmitted() && $this->formEditarTutor->isValid()) {
                    $dadosFormEditarTutor = $this->formEditarTutor->getData();
                    UsuarioController::editarUsuario($dadosFormEditarTutor);
                    return $this->redirectToRoute('tutores');
                }
            } else if($request->request->has($this->formAdicionarTutor->getName())){
                if ($this->formAdicionarTutor->isSubmitted() && $this->formAdicionarTutor->isValid()) {
                    $dadosFormAdicionarTutor = $this->formAdicionarTutor->getData();
                    $this->adicionarTutorTurma($dadosFormAdicionarTutor);
                    return $this->redirectToRoute('tutores');
                }
            } else {
              if ($this->formExcluirTutor->isSubmitted() && $this->formExcluirTutor->isValid()) {
                  $dadosFormExcluirTutor = $this->formExcluirTutor->getData();
                  $deleteException = $this->excluirTutor($dadosFormExcluirTutor);
                  $arrayTutores = $this->gerarArrayTutores();
              }
            }

            $dadosMenuLateralCadastro = MenuLateralCadastroController::carregarDadosMenuLateralCadastro();
            return $this->render('tutores.html.twig', array('tutores' => $arrayTutores,
                        'formTutor' => $this->formEditarTutor->createView(),
                        'formAddTutor' => $this->formAdicionarTutor->createView(),
                        'dadosMenuLateralCadastro' => $dadosMenuLateralCadastro,
                        'formExcluirUser' => $this->formExcluirTutor->createView(),
                        'deleteException' => $deleteException));
        }
    }

    function adicionarTutorTurma($dadosFormAdicionarTutor) {
        $idClass = $this->get('session')->get('idTurmaEdicao');
        $this->logControle->logAdmin(print_r($dadosFormAdicionarTutor, true));
        $novoTutor = new TbUser();
        $this->logControle->logAdmin(($dadosFormAdicionarTutor['DsPassword']));
        if ($dadosFormAdicionarTutor['DsPassword'] == $dadosFormAdicionarTutor['DsPasswordConfirm']) {

            UsuarioController::persistirObjetoUsuarioAlunoTutor($novoTutor, $dadosFormAdicionarTutor);
            $validaTutorTurmaExistente = ManipularArquivoController::verificarTutorTurmaExistente($novoTutor->getIdUser(), $idClass);
            if (!$validaTutorTurmaExistente) {
                $classTutor = new TbClassTutor();
                $objetoClass = $this->em->getRepository('AppBundle:TbClass')
                        ->findOneBy(array('idClass' => $idClass));
                $classTutor->setIdClass($objetoClass);
                $classTutor->setIdTutor($novoTutor);
                $this->em->persist($classTutor);
                $this->em->flush();
            }
        }
    }

    public function gerarArrayTutores() {
        $arrayTutores = array();
        $tutores = TutorController::selecionarTutoresTurma();
        foreach ($tutores as $tutor) {
            $arrayTutores[] = array(
                'idUser' => $tutor['idTutor']['idUser'],
                'nmUser' => $tutor['idTutor']['nmUser'],
                'nuIdentification' => $tutor['idTutor']['nuIdentification'],
                'dsEmail' => $tutor['idTutor']['dsEmail'],
                'nuCellphone' => $tutor['idTutor']['nuCellphone']
            );
        }
        return $arrayTutores;
    }

    public function selecionarTutoresTurma() {
        $idClass = $this->get('session')->get('idTurmaEdicao');
        $queryBuilderTutor = $this->em->createQueryBuilder();
        $queryBuilderTutor
                ->select('u,ct,c')
                ->from('AppBundle:TbClassTutor', "ct")
                ->innerJoin('ct.idTutor', 'u', 'WITH', 'u.idUser =  ct.idTutor')
                ->innerJoin('ct.idClass', 'c', 'WITH', 'c.idClass =  ct.idClass')
                ->where($queryBuilderTutor->expr()->eq('ct.idClass', $idClass))
                ->getQuery()
                ->execute();
        $tutoresTurma = $queryBuilderTutor->getQuery()->getArrayResult();
        $this->logControle->logAdmin(print_r($tutoresTurma, true));
        return $tutoresTurma;
    }

    function excluirClassTutor($tutor){
      $this->em = $this->getDoctrine()->getManager();
      $idClass = $this->get('session')->get('idTurmaEdicao');

      $ctExcluir = $this->getDoctrine()
                ->getRepository('AppBundle:TbClassTutor')
                ->findOneBy(array('idTutor' => $tutor, 'idClass' => $idClass));
      if ($ctExcluir != null) {
        $this->em->remove($ctExcluir);
        $this->em->flush();
      }
    }

    function excluirTutor($dadosForm){
      $this->em = $this->getDoctrine()->getManager();

      $tutores = explode(";", $dadosForm['IdUsers']);

      for ($i = 0; $i < sizeof($tutores); $i++) {
        try{
          $tutor = $this->getDoctrine()
                    ->getRepository('AppBundle:TbUser')
                    ->findOneBy(array('idUser' => $tutores[$i]));

          if ($tutor != null) {
            $this->excluirClassTutor($tutor);
            $this->em->remove($tutor);
            $this->em->flush();
          }
        } catch (\Exception $exception) {
            $this->logControle->logAdmin("Exception  : " . print_r($exception->getMessage(), true));
            $deleteException = true;
            return $deleteException;
        }
      }
      $this->em->flush();
    }

    /**
     * @Route("/carregarTutoresArquivo")
     */
    function carregarTutoresArquivo(Request $request) {
        $this->logControle->logAdmin("FILES: " . print_r($_FILES, true));

        // Pasta onde o arquivo vai ser salvo
        $_UP['pasta'] = "../web/uploads/";

        // Tamanho máximo do arquivo (em Bytes)
        $_UP['tamanho'] = 1024 * 1024 * 20; // 20Mb
        // Array com as extensões permitidas
        $_UP['extensoes'] = array('csv');

        // Renomeia o arquivo? (Se true, o arquivo será salvo como .jpg e um nome único)
        $_UP['renomeia'] = false;

        // Array com os tipos de erros de upload do PHP
        $_UP['erros'][0] = 'Não houve erro';
        $_UP['erros'][1] = 'O arquivo no upload é maior do que o limite do PHP';
        $_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
        $_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
        $_UP['erros'][4] = 'Não foi feito o upload do arquivo';

        // Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
        if ($_FILES['tutores']['error'] != 0) {
            $this->logControle->logAdmin('1');
            die("Não foi possível fazer o upload, erro:" . $_UP['erros'][$_FILES['tutores']['error']]);
            exit; // Para a execução do script
        }

        // Faz a verificação do tamanho do arquivo
        if ($_UP['tamanho'] < $_FILES['tutores']['size']) {
            $this->logControle->logAdmin('3');
            echo "O arquivo enviado é muito grande, envie arquivos de até 2Mb.";
            exit;
        }

        // O arquivo passou em todas as verificações, hora de tentar movê-lo para a pasta
        // Primeiro verifica se deve trocar o nome do arquivo
        if ($_UP['renomeia'] == true) {
            $this->logControle->logAdmin('4');
            // Cria um nome baseado no UNIX TIMESTAMP atual e com extensão .jpg
            $nome_final = md5(time()) . '.jpg';
        } else {
            $this->logControle->logAdmin('5');
            // Mantém o nome original do arquivo
            $nome_final = $_FILES['tutores']['name'];
        }

        // Depois verifica se é possível mover o arquivo para a pasta escolhida
        if (move_uploaded_file($_FILES['tutores']['tmp_name'], $_UP['pasta'] . $nome_final)) {
            $this->logControle->logAdmin('6');
            // Upload efetuado com sucesso, exibe uma mensagem e um link para o arquivo
            echo "Upload efetuado com sucesso!";
            echo '<a href="' . $this->getParameter('web_dir') . 'download/' . $nome_final . '">Clique aqui para acessar o arquivo</a>';
        } else {
            $this->logControle->logAdmin('7');
            // Não foi possível fazer o upload, provavelmente a pasta está incorreta
            echo "Não foi possível enviar o arquivo, tente novamente";
        }
        ManipularArquivoController::persistirTutorAlunoTurmaArquivo($nome_final, "tutor");
        return $this->redirectToRoute('tutores');
    }

}
