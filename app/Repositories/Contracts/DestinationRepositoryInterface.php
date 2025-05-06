<?php

namespace App\Repositories\Contracts;

use App\Models\Destination;
use Illuminate\Database\Eloquent\Collection;

interface DestinationRepositoryInterface
{
    public function getAllDestinations(): Collection;

    public function findDestinationById(int $id): ?Destination;
}
