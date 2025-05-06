<?php

namespace App\Repositories;

use App\Models\Destination;
use App\Repositories\Contracts\DestinationRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class DestinationRepository implements DestinationRepositoryInterface
{
    public function __construct(
        public Destination $destination
    ){
    }

    /**
     * Returns All the destinations
     *
     * @return Collection
     */
    public function getAllDestinations(): Collection
    {
        return Cache::remember('destinations', now()->addHours(12), function () {
            return $this->destination->select('id','name','code','base_price')->get();
        });
    }

    /**
     * Search by destination_id and returns
     *
     * @param int $id
     * @return Destination|null
     */
    public function findDestinationById(int $id): ?Destination
    {
        return Cache::remember("destination.{$id}", now()->addHours(12), function () use ($id) {
            return $this->destination->findOrFail($id);
        });
    }
}
