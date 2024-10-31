<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Service\FileSystemService;
use Knp\Component\Pager\PaginatorInterface;

class AnalysisController extends AbstractController
{
    private FileSystemService $fileSystemService;

    public function __construct(FileSystemService $fileSystemService)
    {
      $this->fileSystemService = $fileSystemService;
    }

    #[Route('/', name: 'homePage')]
    public function index(Request $request, PaginatorInterface $paginator): Response
    {

      $readDataFromCsv = $this->fileSystemService->getCsvData();
      $pagination = $paginator->paginate(
        $readDataFromCsv,
        $request->query->getInt('page', 1),
        10
      );

      return $this->render("/analysis/index.html.twig",[
        "reports" => $pagination
      ]);
    }

    
    #[Route('/json-data', name: 'json_data')]
    public function readJsonData(Request $request, PaginatorInterface $paginator): Response
    {
        $reedJsonData = $this->fileSystemService->getJsonData();
        $pagination = $paginator->paginate(
          $reedJsonData,
          $request->query->getInt('page', 1),
          10
        );

        return $this->render('/analysis/jsonDataTable.html.twig', [
          "reports" => $pagination
        ]);
    }

    #[Route('/ldif-file-contents', name: 'ldif-file')]
    public function ldifContents(Request $request, PaginatorInterface $paginator): Response
    {
      $reports = $this->fileSystemService->fetchDataFromLdifContentTable();
      $pagination = $paginator->paginate(
        $reports,
        $request->query->getInt('page', 1),
        10
      );

      return $this->render('/analysis/ldifDataTabel.html.twig',[
        "reports" => $pagination
      ]);
    }

    #[Route('/reports', name: 'reports')]
    public function reports(Request $request): Response
    {
      $fetachDataFromAllFiles = $this->fileSystemService->mergefilesContentTogether();
      $reportThirtyTopMedicines =  $this->fileSystemService->getTopThirtyMedicines($fetachDataFromAllFiles);
      $topCountryByGroup = $this->fileSystemService->getTopCountryByGroup($fetachDataFromAllFiles);
      
      return $this->render('/analysis/reportComponentView.html.twig',[
        "reportThirtyTopMedicines" => $reportThirtyTopMedicines,
        "topCountryByGroup" => $topCountryByGroup

      ]);
    }
}
