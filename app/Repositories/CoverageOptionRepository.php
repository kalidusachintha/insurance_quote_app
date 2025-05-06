<?php

namespace App\Repositories;

use App\Models\CoverageOption;
use App\Repositories\Contracts\CoverageOptionsRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class CoverageOptionRepository implements CoverageOptionsRepositoryInterface
{
    /**
     * @param CoverageOption $coverageOption
     */
    public function __construct(
        public CoverageOption $coverageOption
    ){
    }

    /**
     * Returns all the coverage options
     *
     * @return Collection
     */
    public function getAllCoverageOptions(): Collection
    {
        return Cache::remember('coverage_options', now()->addHours(12), function () {
            return $this->coverageOption->select('id','name','code','price')->get();
        });
    }

    /**
     * Search by id's and returns coverage options
     *
     * @param array $ids
     * @return Collection
     */
    public function findCoverageOptionsById(array $ids): Collection
    {
        return $this->getAllCoverageOptions()->whereIn('id', $ids);
    }
}
