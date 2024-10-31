<?php

declare(strict_types=1);

namespace App\Enums;

enum FilePathEnum: string
{
    case CSV = "/mnt/data/dataFeb-2-2017.csv";
    case JSON = "/mnt/data/dataFeb-2-2017.json";
    CASE LDIF = "/mnt/data/dataFeb-2-2017.ldif";

    public function getPath():string
    {
        return $this->value;
    }
}