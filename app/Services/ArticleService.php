<?php

namespace App\Services;

use App\Contracts\AppConstants;
use App\Models\Article;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ArticleService implements AppConstants
{

    /**
     * Fetch news from a source
     *
     * @param $source
     * @return void
     * @throws \Exception
     */
    public function fetch($source): void
    {
        $this->makeRequest($source);
    }

    public function get(array $request)
    {
        $query = Article::query();

        if ($request['category']) {
            $query->where('category', $request['category']);
        }
        if ($request['source']) {
            $query->where('source', $request['source']);
        }
        if ($request['date']) {
            $query->whereDate('published_at', $request['date']);
        }

        return $query->paginate(10);
    }

    public function Search($keyword)
    {
        $query = Article::query();

        if ($keyword->filled('q')) {
            $query->where('title', 'like', '%' . $keyword->q . '%')
                ->orWhere('description', 'like', '%' . $keyword->q . '%');
        }

        return $query->paginate(10);
    }

    /**
     * @param $source
     * @param array $queryParams
     * @return void
     * @throws \Exception
     */
    private function makeRequest($source, array $queryParams = []): void
    {

        try {

            $apiKey = env($source . '_API_KEY');
            $endpoint = env($source . '_API_URL');

            $response = Http::withHeaders([
                'Authorization' => "Bearer {$apiKey}",
                'Accept' => 'application/json',
            ])->get($endpoint, $queryParams);

            // Check if the response is successful
            if ($response->successful()) {
                $this->adaptData($source, $response->json());
            }

            // Log the error and throw an exception if the response isn't successful
            Log::error("Request failed with status {$response->status()}: {$response->body()}");
            throw new \Exception('Failed to fetch data from the API.');
        } catch (\Exception $e) {
            Log::error("Request failed: " . $e->getMessage());
            throw new \Exception('Failed to fetch data from the API.');
        }
    }

    private function adaptData($source, $response): static
    {
        $result = Switch::on($source)
        ->case(self::NEWSAPI, "w")
        ->case(self::NEWSCRED, "e")
        ->case(self::OPENNEWS, "r")
        ->default(fn() => 'Value is something else'); // use exception later
        return $result;
    }

    private function save()
    {

        return '$this';
    }
}
