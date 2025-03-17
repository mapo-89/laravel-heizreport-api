<?php
/*
 * Projects.php
 * @author Manuel Postler <info@postler.de>
 * @copyright 2025 Manuel Postler
 */

namespace Mapo89\LaravelHeizreportApi\Api;

use Illuminate\Support\Collection;
use Mapo89\LaravelHeizreportApi\Api\Utils\ApiClient;
use Mapo89\LaravelHeizreportApi\Api\Utils\DocumentHelper;
use Mapo89\LaravelHeizreportApi\Models\HeizProject;

/**
 * Heizreport Projects Api
 *
 * @see https://heizreport.com/hilfethemen/projektliste-abrufen
 */
class Projects extends ApiClient
{
    // =========================== all ====================================

    /**
     * Return all projects.
     *
     * @return Collection
     */
    public function all(): Collection
    {
        $projects = $this->_get('', ['action' => 'getProjekte'])['projekte'];
        return Collection::make(['projekte' => $projects]);
    }
    /**
     * Return all archived projects.
     *
     * @return Collection
     */
    public function allArchived(): Collection
    {
        $projects = $this->_get('', ['action' => 'getProjekte'])['archiv'];
        return Collection::make(['projekte' => $projects]);
    }

    // =========================== create ====================================

    /**
     * Create project.
     *
     * @param array $parameters
     * @return HeizProject
     * @throws Exception
     */
    public function create(array $parameters = []): HeizProject
    {
        $projektKey = $this->_get( '', ['action' => 'createReport'])['projektHeader']['key'];
        // create parameter array
        $projectParameters  = DocumentHelper::getProjectParameters($projektKey, $parameters);
        $response = $this->_get( '', array_merge(['action' => 'editReportData'] , $projectParameters));

        // create model
        /** @var HeizProject $heizProject */
        $heizProject = HeizProject::make([
            'projektKey' => $response['projektHeader']['key'],
            'projektData' => $response['projektData'],
        ]);
        return $heizProject;
    }

    // =========================== update ====================================

    /**
     * Update an existing project.
     *
     * @param array $parameters
     * @return HeizProject
     * @throws Exception
     */
    public function update($projektKey, array $parameters = []): HeizProject
    {
        // create parameter array
        $projectParameters  = DocumentHelper::getProjectParameters($projektKey, $parameters);
        $response = $this->_get( '', array_merge(['action' => 'editReportData'] , $projectParameters));

        // create model
        /** @var HeizProject $heizProject */
        $heizProject = HeizProject::make([
            'projektKey' => $response['projektHeader']['key'],
            'projektData' => $response['projektData'],
        ]);
        return $heizProject;
    }

    // ============================= PDF-Files ==========================================

    /**
     * Handle the PDF file based on the operation.
     *
     * @param string $projektKey
     * @param string $filename
     * @param string $documentType
     * @param string $operation 'open, 'download', 'save'
     * @return void|string
     */
    public function handlePdf($projektKey, $filename, $operation = 'open', $documentType = 'getHeizreportPDF')
    {
        // Abrufen des PDF-Links
        $response = $this->_get('', [
            'projektKey' => $projektKey,
            'action' => $documentType
        ]);

        // PDF-Link
        $pdfLink = $response['linkToDocument'];

        // Je nach Operation entweder die Datei herunterladen oder speichern
        if ($operation === 'open') {
            return $pdfLink;
        } elseif ($operation === 'download') {
            return $this->getPdf($pdfLink, $filename, 'download');
        } elseif ($operation === 'save') {
            return $this->getPdf($pdfLink, $filename, 'save');
        }

        return null; // Falls eine unbekannte Operation übergeben wird
    }
}
