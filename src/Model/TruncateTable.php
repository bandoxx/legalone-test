<?php

namespace App\Model;

class TruncateTable
{

    private ?string $tableName = null;

    public function getTableName(): ?string
    {
        return $this->tableName;
    }

    public function setTableName(?string $tableName): self
    {
        $this->tableName = $tableName;
        return $this;
    }

}