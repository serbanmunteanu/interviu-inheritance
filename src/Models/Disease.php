<?php

namespace App\Models;

class Disease
{
    private string $name;

    public static function createFromSymptoms(array $symptoms): ?Disease
    {
        $disease = null;

        if ($symptoms) {
            $disease = new Disease();
        }

        return $disease;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Disease
    {
        $this->name = $name;
        return $this;
    }
}