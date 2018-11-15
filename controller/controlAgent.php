<?php

namespace SGR\controller;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use SGR\view\VueAgent;
use SGR\model\Agent;
use SGR\model\Cour;
use SGR\model\Programme;
use SGR\model\Ugp;
use SGR\model\Projet;
use SGR\model\ReceptionReso;
use SGR\model\Departement;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class controlAgent {

    private $vue;
    private $modelCour;
    private $modelProg;
    private $modelUgp;
    private $modelProjet;
    private $modelReceptionReso;
    private $modelDepartement;
    private $modelAgent;

    function __construct() {
        $this->vue = new VueAgent();
        $this->modelCour = new Cour();
        $this->modelProg = new Programme();
        $this->modelUgp = new Ugp();
        $this->modelAgent = new Agent();
        $this->modelProjet = new Projet();
        $this->modelReceptionReso = new ReceptionReso();
        $this->modelDepartement = new Departement();
    }

    public function accueil() {
        $_SESSION["count"] = 0;
        $this->vue->afficherAccueil();
    }

    public function voirResoSoumi() {
        $_SESSION["count"] = 0;
        $reso = $this->modelReceptionReso->allResolutionTrie();
        $titre = 'allResolutionSoumi';
        $this->telechargerExcel($titre, $reso);
        $this->vue->voirResoSoumi($reso);
    }

    public function telechargerExcel($titre, $reso) {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'Numéro réception');
        $sheet->setCellValue('C1', 'Sujet');
        $sheet->setCellValue('D1', 'codeUgp_id');
        $sheet->setCellValue('E1', 'Departement_id');
        $sheet->setCellValue('F1', 'Date Demande');
        $sheet->setCellValue('G1', 'Date Reception');
        $sheet->setCellValue('H1', 'Notes');
        $sheet->setCellValue('I1', 'Numéro de projet');
        $sheet->setCellValue('J1', 'agent_id');
        $y = 2;
        foreach ($reso as $value) {

            $i = 1;
            while ($i <= 11) {

                switch ($i) {
                    case 1:
                        $sheet->setCellValue('A' . $y, $value->getId());
                        break;
                    case 2:
                        $sheet->setCellValue('B' . $y, $value->getNum());
                        break;
                    case 3:
                        $sheet->setCellValue('C' . $y, $value->getSujet());
                        break;
                    case 4:
                        $sheet->setCellValue('D' . $y, $value->getCodeUgp_id());
                        break;
                    case 5:
                        $sheet->setCellValue('E' . $y, $value->getDepartement_id());
                        break;
                    case 6:
                        $sheet->setCellValue('F' . $y, $value->getDateDemande());
                        break;
                    case 7:
                        $sheet->setCellValue('G' . $y, $value->getDateReception());
                        break;
                    case 8:
                        $sheet->setCellValue('H' . $y, $value->getNotes());
                        break;
                    case 9:
                        $sheet->setCellValue('I' . $y, $value->getNumProjet_id());
                        break;
                    case 10:
                        $sheet->setCellValue('J' . $y, $value->getAgent_id());
                        break;
                }
                $i++;
            }
            $y++;
        }
        $writer = new Xlsx($spreadsheet);
        $writer->save('Excel/' . $titre . '.xlsx');
    }

}
