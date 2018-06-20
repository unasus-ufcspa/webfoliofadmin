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
use AppBundle\Controller\ManipularArquivoController;
use AppBundle\Entity\TbClassStudent;

class AlunosController extends Controller {

    public $error;
    public $logControle;
    public $em;
    public $formEditarAluno;
    public $formAdicionarAluno;

    public function __construct() {
        $this->logControle = new LogController();
    }

    /**
     * @Route("/alunos", name="alunos")
     */
    function alunos(Request $request) {

        if (!$this->get('session')->get('idUser')) {

            return $this->redirectToRoute('login');
        } else {
            $this->em = $this->getDoctrine()->getManager();


            $arrayAlunos = $this->gerarArrayAlunos(); //$idClass da rota
            $this->formEditarAluno = UsuarioController::gerarFormulario("editar");
            $this->formAdicionarAluno = UsuarioController::gerarFormulario("adicionar");
            $this->formEditarAluno->handleRequest($request);
            $this->formAdicionarAluno->handleRequest($request);

            if ($request->request->has($this->formEditarAluno->getName())) {
                if ($this->formEditarAluno->isSubmitted() && $this->formEditarAluno->isValid()) {
                    $dadosFormEditarAluno= $this->formEditarAluno->getData();
                    UsuarioController::editarUsuario($dadosFormEditarAluno);
                    return $this->redirectToRoute('alunos');
                }
            } else {
                if ($this->formAdicionarAluno->isSubmitted() && $this->formAdicionarAluno->isValid()) {
                    $dadosFormAdicionarAluno = $this->formAdicionarAluno->getData();
                    $this->adicionarAlunoTurma($dadosFormAdicionarAluno);
                    return $this->redirectToRoute('alunos');
                }
            }

            $dadosMenuLateralCadastro = MenuLateralCadastroController::carregarDadosMenuLateralCadastro();

            return $this->render('alunos.html.twig', array('alunos' => $arrayAlunos,
                        'formAluno' => $this->formEditarAluno->createView(),
                        'formAddAluno' => $this->formAdicionarAluno->createView(), 'dadosMenuLateralCadastro' => $dadosMenuLateralCadastro));
        }
    }

    function adicionarAlunoTurma($dadosFormAdicionarAluno) {
        $idClass = $this->get('session')->get('idTurmaEdicao');
        $this->logControle->logAdmin(print_r($dadosFormAdicionarAluno, true));
        $novoAluno = new TbUser();
        $this->logControle->logAdmin(($dadosFormAdicionarAluno['DsPassword']));
        if ($dadosFormAdicionarAluno['DsPassword'] == $dadosFormAdicionarAluno['DsPasswordConfirm']) {

            UsuarioController::persistirObjetoUsuario($novoAluno, $dadosFormAdicionarAluno, null, null);
            $validaTutorTurmaExistente = ManipularArquivoController::verificarTutorTurmaExistente($novoAluno->getIdUser(), $idClass);
            if (!$validaTutorTurmaExistente) {
                $classAluno = new TbClassStudent();
                $objetoClass = $this->em->getRepository('AppBundle:TbClass')
                        ->findOneBy(array('idClass' => $idClass));
                $classAluno->setIdClass($objetoClass);
                $classAluno->setIdStudent($novoAluno);
                $this->em->persist($classAluno);
                $this->em->flush();
            }
        }
    }

    public function gerarArrayAlunos() {
        $arrayAlunos = array();
        $alunos = AlunosController::selecionarAlunosTurma();
        $this->logControle->logAdmin("Alunos : " . print_r($alunos, true));

        foreach ($alunos as $aluno) {
            $arrayAlunos[] = array(
                'idUser' => $aluno['idStudent']['idUser'],
                'nmUser' => $aluno['idStudent']['nmUser'],
                'nuIdentification' => $aluno['idStudent']['nuIdentification'],
                'dsEmail' => $aluno['idStudent']['dsEmail'],
                'nuCellphone' => $aluno['idStudent']['nuCellphone']
            );
        }
        return $arrayAlunos;
    }

    public function selecionarAlunosTurma() {
        $idClass = $this->get('session')->get('idTurmaEdicao');
        $queryBuilderAluno = $this->em->createQueryBuilder();
        $queryBuilderAluno
                ->select('u,cs,c')
                ->from('AppBundle:TbClassStudent', "cs")
                ->innerJoin('cs.idStudent', 'u', 'WITH', 'u.idUser =  cs.idStudent')
                ->innerJoin('cs.idClass', 'c', 'WITH', 'c.idClass =  cs.idClass')
                ->where($queryBuilderAluno->expr()->eq('cs.idClass', $idClass))
                ->getQuery()
                ->execute();
        $alunosTurma = $queryBuilderAluno->getQuery()->getArrayResult();
        $this->logControle->logAdmin(print_r($alunosTurma, true));
        return $alunosTurma;
    }

    /**
     * @Route("/carregarAlunosArquivo")
     */
    function carregarAlunosArquivo(Request $request) {
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
        if ($_FILES['alunos']['error'] != 0) {
            $this->logControle->logAdmin('1');
            die("Não foi possível fazer o upload, erro:" . $_UP['erros'][$_FILES['alunos']['error']]);
            exit; // Para a execução do script
        }

        // Faz a verificação do tamanho do arquivo
        if ($_UP['tamanho'] < $_FILES['alunos']['size']) {
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
            $nome_final = $_FILES['alunos']['name'];
        }

        // Depois verifica se é possível mover o arquivo para a pasta escolhida
        if (move_uploaded_file($_FILES['alunos']['tmp_name'], $_UP['pasta'] . $nome_final)) {
            $this->logControle->logAdmin('6');
            // Upload efetuado com sucesso, exibe uma mensagem e um link para o arquivo
            echo "Upload efetuado com sucesso!";
            echo '<a href="' . $this->getParameter('web_dir') . 'download/' . $nome_final . '">Clique aqui para acessar o arquivo</a>';
        } else {
            $this->logControle->logAdmin('7');
            // Não foi possível fazer o upload, provavelmente a pasta está incorreta
            echo "Não foi possível enviar o arquivo, tente novamente";
        }
        ManipularArquivoController::persistirTutorAlunoTurmaArquivo($nome_final, "aluno");
        return $this->redirectToRoute('alunos');
    }

    /**
     * @Route("/removerAlunoTurma")
     */
    function removerAlunoTurma(Request $request) {
        $this->em = $this->getDoctrine()->getEntityManager();
        if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
            $data = json_decode($request->getContent(), true);
            $request->request->replace(is_array($data) ? $data : array());
            $this->logControle->logAdmin("Excluir alunos turma : " . print_r($data, true));
            $idClass =  $this->get('session')->get('idTurmaEdicao');

            foreach ($data['arrayAlunos'] as $idTutorRemover) {
                $this->em = $this->getDoctrine()->resetManager();
                $this->logControle->logAdmin("Remover  : " . print_r($idTutorRemover, true));

                try {
                    $entity = $this->em->getRepository('AppBundle:TbClassStudent')
                            ->findOneBy(array('idStudent' => $idTutorRemover));
                    if ($entity != null) {
                        $this->em->remove($entity);
                        $this->em->flush();
                    }
                } catch (\Exception $excpetion) {
                    $this->logControle->logAdmin("exception  : " . print_r($excpetion->getMessage(), true));
                }
            }

            $retornoRequest = array(
                "sucesso" => true,
            );
        } else {
            $retornoRequest = array(
                "sucesso" => false,
            );
        }
        return new JsonResponse($retornoRequest);
    }

    /**
     * @Route("/desativarAdministradorExcecao")
     */
    //TO-DO: APLICAR PARA TUTOR
    function desativarAdministradorExcecao(Request $request) {
        $this->em = $this->getDoctrine()->getEntityManager();
        if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
            $data = json_decode($request->getContent(), true);
            $request->request->replace(is_array($data) ? $data : array());
            $this->logControle->logAdmin("desativar admnistradores : " . print_r($data, true));
            foreach ($data['arrayAdministradoresDesativar'] as $idsAdministradoresDesativar) {
                $this->em = $this->getDoctrine()->resetManager();
                $this->logControle->logAdmin("desativar  : " . print_r($idsAdministradoresDesativar, true));

                $objetoUsuario = $this->em->getRepository('AppBundle:TbUser')
                        ->findOneBy(array('idUser' => $idsAdministradoresDesativar));
                if ($objetoUsuario != null) {
                    $objetoUsuario->setFlAdmin('F');
                    $this->em->flush();
                }
            }
            $retornoRequest = array(
                "sucesso" => true
            );
        } else {
            $retornoRequest = array(
                "sucesso" => false
            );
        }
        return new JsonResponse($retornoRequest);
    }

}
