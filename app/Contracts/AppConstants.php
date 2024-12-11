<?php

namespace App\Contracts;

interface AppConstants
{
    const NEWSAPI = "NEWSAPI";
    const NEWSCRED = "NEWSCRED";
    const OPENNEWS = "OPENNEWS";
    const NEWS_SOURCES = [
        0 => self::NEWSAPI,
        1 => self::NEWSCRED,
        2 => self::OPENNEWS,
    ];
}
