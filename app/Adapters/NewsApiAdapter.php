<?php

namespace App\Adapters;

use App\Contracts\NewsApiAdapterInterface;
use App\Dto\NewsDto;

/**
 * News Concrete
 */
class NewsApiAdapter implements NewsApiAdapterInterface
{
    public function sync($data): NewsDto
    {
        // TODO: Implement sync() method.
    }
}
