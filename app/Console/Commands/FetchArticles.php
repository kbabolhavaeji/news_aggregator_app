<?php

namespace App\Console\Commands;

use App\Contracts;
use App\Services\ArticleService;
use Illuminate\Console\Command;

class FetchArticles extends Command implements Contracts\AppConstants
{
    public function __construct(private ArticleService $articleService)
    {
        parent::__construct();
    }

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
    public function handle(): void
    {
        foreach (self::NEWS_SOURCES as $source) {
            $this->articleService->fetch($source);
        }
    }
}
