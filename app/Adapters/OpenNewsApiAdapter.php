<?php

namespace App\Adapters;

use App\Contracts\NewsApiAdapterInterface;
use App\Dto\NewsDto;

/**
 * News Concrete
 */
class OpenNewsApiAdapter implements NewsApiAdapterInterface
{

    public function fetchNews(NewsDto $newsDto): NewsDto
    {
        // TODO: Implement fetchNews() method.
    }
}
