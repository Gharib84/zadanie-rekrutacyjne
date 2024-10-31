<?php

namespace App\Repository;

use App\Entity\DataModelCsv;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DataModelCsv>
 */
class DataModelCsvRepository extends ServiceEntityRepository
{
    private ManagerRegistry $registry;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DataModelCsv::class);
        $this->registry = $registry;
    }

    public function getCsvData(): array
    {
        $entityManager = $this->registry->getManager();

        return $entityManager->getRepository(DataModelCsv::class)->findAll();
    }
}
