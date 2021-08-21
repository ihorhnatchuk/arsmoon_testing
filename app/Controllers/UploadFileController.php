<?php 
namespace App\Controllers;

use Core\Controller\Controller;
use App\Service\Report\ReportBuilder;
use App\Service\Upload\UploadCsvService;
use App\Service\Report\ReportBuilderManager;

class UploadFileController extends Controller
{
    public function __invoke(array $params = [])
    {
        $data = UploadCsvService::execute('csv');

        $builderManager = new ReportBuilderManager($data);
        $collection = $builderManager->setBuilder(new ReportBuilder())
            ->getCollection();

        return $this->view->render('upload', [
            'title' => 'Result Uploaded CSV Collection',
            'collection' => $collection,
        ]);
    }
}