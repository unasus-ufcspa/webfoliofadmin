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
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Finder\Finder;
use AppBundle\Entity\TbUser;
use AppBundle\Entity\TbClassTutor;
use AppBundle\Entity\TbClassStudent;

/**
 * Description of ManipularArquivoController
 *
 * @author Marilia
 */
class ManipularArquivoController extends Controller {

    public $logControle;
    public $em;

    public function __construct() {
        $this->logControle = new LogController();
    }

    function persistirTutorAlunoTurmaArquivo($nomeArquivo, $perfil) {
        $idClass = $this->get('session')->get('idTurmaEdicao');
        header('Content-type: text/html; charset=UTF-8');
        $row = 1;
        $this->em = $this->getDoctrine()->getEntityManager();
        if (($handle = fopen('../web/uploads/' . $nomeArquivo, "r")) !== FALSE) {

            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                $num = count($data) - 1;
                $row++;
                if ($row > 6) { //pular cabeçalho do arquivo
                    $objetoUsuarioExistente = ManipularArquivoController::verificarUsuarioExistente($data[1]);
                    if (!is_object($objetoUsuarioExistente)) {
                        $objetoUsuario = new TbUser();

                        $objetoUsuario->setNmUser($data[0]);

                        $objetoUsuario->setDsEmail($data[1]);
                        $objetoUsuario->setNuIdentification($data[2]);

                        $objetoUsuario->setNuCellphone($data[3]);


                        $this->em->persist($objetoUsuario);
                        $this->em->flush();
                        if ($perfil == "tutor") {
                            $validaTutorTurmaExistente = ManipularArquivoController::verificarTutorTurmaExistente($objetoUsuario->getIdUser(), $idClass);

                            if (!$validaTutorTurmaExistente) {

                                $classTutor = new TbClassTutor();
                                $objetoClass = $this->em->getRepository('AppBundle:TbClass')
                                        ->findOneBy(array('idClass' => $idClass));
                                $classTutor->setIdClass($objetoClass);
                                $classTutor->setIdTutor($objetoUsuario);
                                $this->em->persist($classTutor);
                                $this->em->flush();
                            }
                        }
                        if ($perfil == "aluno") {
                            $validaAlunoTurmaExistente = ManipularArquivoController::verificarAlunoTurmaExistente($objetoUsuario->getIdUser(), $idClass);

                            if (!$validaAlunoTurmaExistente) {

                                $classTutor = new TbClassStudent();
                                $objetoClass = $this->em->getRepository('AppBundle:TbClass')
                                        ->findOneBy(array('idClass' => $idClass));
                                $classTutor->setIdClass($objetoClass);
                                $classTutor->setIdStudent($objetoUsuario);
                                $this->em->persist($classTutor);
                                $this->em->flush();
                            }
                        }
                    } else {
                        $this->logControle->logAdmin("usuario existente");
                        if ($perfil == "tutor") {
                            $validaTutorTurmaExistente = ManipularArquivoController::verificarTutorTurmaExistente($objetoUsuarioExistente->getIdUser(), $idClass);
                            if (!$validaTutorTurmaExistente) {
                                $classTutor = new TbClassTutor();
                                $objetoClass = $this->em->getRepository('AppBundle:TbClass')
                                        ->findOneBy(array('idClass' => $idClass));
                                $classTutor->setIdClass($objetoClass);
                                $classTutor->setIdTutor($objetoUsuarioExistente);
                                $this->em->persist($classTutor);
                                $this->em->flush();
                            }
                        }

                        if ($perfil == "aluno") {
                            $validaAlunoTurmaExistente = ManipularArquivoController::verificarAlunoTurmaExistente($objetoUsuarioExistente->getIdUser(), $idClass);

                            if (!$validaAlunoTurmaExistente) {
                                $classTutor = new TbClassStudent();
                                $objetoClass = $this->em->getRepository('AppBundle:TbClass')
                                        ->findOneBy(array('idClass' => $idClass));
                                $classTutor->setIdClass($objetoClass);
                                $classTutor->setIdStudent($objetoUsuarioExistente);
                                $this->em->persist($classTutor);
                                $this->em->flush();
                            }
                        }
                    }
                }
            }
        }
        fclose($handle);
    }

    function verificarAlunoTurmaExistente($idTutor, $idClass) {
        $queryBuilder = $this->em->createQueryBuilder();
        $queryBuilder
                ->select('cp,u,c')
                ->from('AppBundle:TbClassStudent', 'cp')
                ->innerJoin('cp.idClass', 'c', 'WITH', 'c.idClass= cp.idClass')
                ->innerJoin('cp.idStudent', 'u', 'WITH', 'cp.idStudent= u.idUser')
                ->where($queryBuilder->expr()->eq('cp.idClass', $idClass))
                ->where($queryBuilder->expr()->eq('cp.idStudent', $idTutor))
                ->getQuery()
                ->execute();
        $portfolioClass = $queryBuilder->getQuery()->getArrayResult();
        if (count($portfolioClass) > 0) {
            return true;
        } else {
            return false;
        }
    }

    function verificarTutorTurmaExistente($idTutor, $idClass) {
        $queryBuilder = $this->em->createQueryBuilder();
        $queryBuilder
                ->select('cp,u,c')
                ->from('AppBundle:TbClassTutor', 'cp')
                ->innerJoin('cp.idClass', 'c', 'WITH', 'c.idClass= cp.idClass')
                ->innerJoin('cp.idTutor', 'u', 'WITH', 'cp.idTutor= u.idUser')
                ->where($queryBuilder->expr()->eq('cp.idClass', $idClass))
                ->where($queryBuilder->expr()->eq('cp.idTutor', $idTutor))
                ->getQuery()
                ->execute();
        $portfolioClass = $queryBuilder->getQuery()->getArrayResult();
        if (count($portfolioClass) > 0) {
            return true;
        } else {
            return false;
        }
    }

    function verificarUsuarioExistente($dsEmail) {
        $objetoUsuario = $this->em->getRepository('AppBundle:TbUser')
                ->findOneBy(array('dsEmail' => $dsEmail));
        $this->logControle->logAdmin(print_r($objetoUsuario, true));
        if ($objetoUsuario) {
            $this->logControle->logAdmin("retorno existente" . $objetoUsuario->getIdUser());
            return $objetoUsuario;
        } else {
            return -1;
        }
    }

}
