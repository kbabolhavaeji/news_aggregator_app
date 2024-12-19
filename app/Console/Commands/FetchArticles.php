<?php

namespace App\Console\Commands;

use App\Contracts;
use App\Services\ArticleService;
use Illuminate\Console\Command;

class FetchArticles extends Command implements Contracts\AppConstants
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-articles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will fetch articles from APIs';

    /**
     * Execute the console command.
     * @throws \Exception
     */
    public function handle(ArticleService $articleService): void
    {
        foreach (self::NEWS_SOURCES as $source) {
            $articleService->fetch($source);
        }
    }
}
