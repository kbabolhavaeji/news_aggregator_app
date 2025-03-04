<?php

namespace App\Contracts;

use App\Dto\NewsDto;

/**
 * New APIs Interface - Contract
 *
 * @returns NewsDto
 */
interface NewsApiAdapterInterface
{
    public function sync($data) : NewsDto;
}
