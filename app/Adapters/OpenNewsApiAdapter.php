<?php

namespace App\Adapters;

use App\Contracts\NewsApiAdapterInterface;
use App\Dto\NewsDto;

/**
 * News Concrete
 */
class OpenNewsApiAdapter implements NewsApiAdapterInterface
{
    public function sync($data): NewsDto
    {
        // TODO: Implement sync() method.
    }
}
