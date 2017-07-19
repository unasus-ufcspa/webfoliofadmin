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

/**
 * Description of ManipularArquivoController
 *
 * @author Marilia
 */
class ManipularArquivoController extends Controller {

    public $logControle;
    public $csvParsingOptions = array(
        'finder_in' => 'C:/Apache24/htdocs_sfny/',
        'finder_name' => 'teste.csv',
        'ignoreFirstLine' => true
    );

    public function __construct() {
        $this->logControle = new LogController();
    }

    /**
     * @Route("/executar")
     */
    function executar() {
        $csv = $this->parseCSV();
    }
//http://tlok.eu/fputcsv-in-php-and-writing-content-to-variable.html
    function parseCSV() {
        $row = 1;
        if (($handle = fopen('C:\Apache24\htdocs_sfny\teste.csv', "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $num = count($data);
                $this->logControle->logAdmin("<p> $num campos na linha $row: <br /></p>\n");
                $row++;
                for ($c = 0; $c < $num; $c++) {
                    (print_r($data[$c],true));
                }
            }
            fclose($handle);
        }

        return $rows;
    }

}
