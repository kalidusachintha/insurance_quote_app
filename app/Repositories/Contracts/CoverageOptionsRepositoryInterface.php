<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface CoverageOptionsRepositoryInterface
{
    public function getAllCoverageOptions(): Collection;

    public function findCoverageOptionsById(array $ids): Collection;
}
