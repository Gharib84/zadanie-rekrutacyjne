<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\DataModelCsv;
use App\Entity\JsonData;
use App\Entity\LdifContent;
use Doctrine\ORM\EntityManagerInterface;
use App\Enums\FilePathEnum;
use App\Repository\DataModelCsvRepository;
use App\Repository\JsonDataRepository;
use App\Repository\LdifContentRepository;

class FileSystemService
{
    private EntityManagerInterface $entityManager;
    private readonly array $paths;
    private DataModelCsvRepository $dataModelCsvRepository;
    private JsonDataRepository $jsonDataRepository;
    private LdifContentRepository $ldifContentRepository;


    public function __construct(EntityManagerInterface $entityManager, DataModelCsvRepository $dataModelCsvRepository, JsonDataRepository $jsonDataRepository, LdifContentRepository $ldifContentRepository)
    {
        $this->entityManager = $entityManager;
        $this->paths = [
            "csv" => FilePathEnum::CSV,
            "json" => FilePathEnum::JSON,
            "ldif" => FilePathEnum::LDIF
        ];
        $this->dataModelCsvRepository = $dataModelCsvRepository;
        $this->jsonDataRepository = $jsonDataRepository;
        $this->ldifContentRepository = $ldifContentRepository;
    }

    public function fileProcessCsv(): array
    {
        $fileName = $this->_getSpecificPath("csv");
        $records = [];
        $file = fopen($fileName, 'r');
        fgetcsv($file, 0, '|');

        try {

            if (count($this->getCsvData()) === 0) {

                while (($data = fgetcsv($file, 0, '|')) !== false) {
                    if (count($data) === 5) {
                        $this->dataModelCsvRepository->insertCsvData($data);
                    }
                }
            }
        } catch (\Doctrine\ORM\EntityNotFoundException $e) {
            echo "błędy" . " " . $e->getMessage() . "<br/>";
        }

        $this->entityManager->flush();
        fclose($file);

        return $records;
    }

    private function _getSpecificPath(string $type): string
    {
        return $this->paths[$type]->getPath();
    }

    public function getCsvData(): array
    {
        return $this->dataModelCsvRepository->getCsvData();
    }

    public function jsonFileProcess(): array
    {
        $fileName = $this->_getSpecificPath('json');
        $records = [];
        $jsonContents = json_decode(file_get_contents($fileName), true);

        if (isset($jsonContents["data"]) && is_array($jsonContents["data"])) {
            if (count($this->getJsonData()) === 0) {

                foreach ($jsonContents["data"] as $content) {
                    if (count($content) === 5) {
                      $records[] = $this->jsonDataRepository->insertJsonData($content);
                    }
                }
            }
        }

        return $records;
    }

    public function getJsonData(): array
    {
        return $this->jsonDataRepository->findAllDataForJsonFile();
    }

    public function ldifFileService(): array
    {
        $filePath = $this->_getSpecificPath("ldif");
        $records = [];
        $fileContent = file_get_contents($filePath);
        $contents = explode("\n\n", trim($fileContent));

        foreach ($contents as $key => $content) {
            $data = [
                'Customer' => '',
                'Country' => '',
                'Order' => '',
                'Status' => '',
                'Group' => ''
            ];

            $lines = explode("\n", trim($content));

            foreach ($lines as $line) {
                if (strpos($line, ':') !== false) {
                    list($key, $value) = explode(':', $line, 2);
                    $data[trim($key)] = trim($value);
                }
            }
            
            if (!empty($data['Customer'])) {
                $this->ldifContentRepository->insertLdifData($data);
            }  
        }

        return [];
    }

    public function fetchDataFromLdifContentTable(): array
    {
        return $this->ldifContentRepository->fetchDataFromLdifContentTable();
    }

    public function mergefilesContentTogether(): array
    {
        return array_merge($this->getCsvData(), $this->getJsonData(), $this->fetchDataFromLdifContentTable());
    }

    public function getTopThirtyMedicines(array $allRecords): array
    {
        $orderCountByMedicine = [];
        foreach ($allRecords as $record) {
            $medicine = $record->getCustomerOrder();
            $orderCountByMedicine[$medicine] = ($orderCountByMedicine[$medicine] ?? 0) + 1;
        }

        arsort($orderCountByMedicine);

        return array_slice($orderCountByMedicine, 0, 30, true);
    }

    public function getTopCountryByGroup(array $allRecords): array
    {
        $groupCountries = $this->countCountriesByGroup($allRecords);

        return $this->findTopCountriesByGroup($groupCountries);
    }

    private function countCountriesByGroup(array $allRecords): array
    {
        $groupCountries = [];

        foreach ($allRecords as $record) {
            $group = $record->getCustomerGroup();
            $country = $record->getCountry();
            $groupCountries[$group][$country] = ($groupCountries[$group][$country] ?? 0) + 1;
        }

        return $groupCountries;
    }

    private function findTopCountriesByGroup(array $groupCountries): array
    {
        $result = [];

        foreach ($groupCountries as $group => $countries) {
            arsort($countries);
            $maxCount = reset($countries);

            $topCountries = array_keys(array_filter($countries, fn($count) => $count === $maxCount));
            $result[$group] = implode(', ', $topCountries);
        }

        return $result;
    }
}
