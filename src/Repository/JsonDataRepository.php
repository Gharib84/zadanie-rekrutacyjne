<?php

namespace App\Repository;

use App\Entity\JsonData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<JsonData>
 */
class JsonDataRepository extends ServiceEntityRepository
{
    private ManagerRegistry $registry;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, JsonData::class);
        $this->registry = $registry;
    }

    public function findAllDataForJsonFile(): array
    {
        $entityManager = $this->registry->getManager();

        return $entityManager->getRepository(JsonData::class)->findAll();
    }
}
