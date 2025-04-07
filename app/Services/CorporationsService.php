<?php

namespace App\Services;

use App\Models\Corporation;
use Illuminate\Support\Arr;

class CorporationsService
{
    /**
     * Create new Corporation
     *
     * @param array $params
     * @return Corporation
     */
    public function create(array $params): Corporation
    {
        return Corporation::create($params);
    }

    /**
     * Update Corporation data
     *
     * @param Corporation $corporation
     * @param array $params
     * @return Corporation
     */
    public function update(Corporation $corporation, array $params): Corporation
    {
        $corporation->update($params);

        // $corporation->ethicalLabels()->sync(Arr::get($params, 'ethical_label_ids'));

        $corporation->refresh();

        return $corporation;
    }
}
