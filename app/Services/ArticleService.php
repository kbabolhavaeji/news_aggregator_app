<?php

namespace App\Services;

use App\Contracts\AppConstants;
use App\Contracts\NewsApiAdapterInterface;
use App\Dto\NewsDto;
use App\Models\Article;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ArticleService implements AppConstants
{

    /**
     * Fetch news from a source
     * this method gets an endpoint and get the latest news articles
     *
     * @param $source
     * @return void
     * @throws \Exception
     */
    public function fetch($source): void
    {
        $articles = $this->makeRequest($source);
        $this->save($articles);
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
     * @param NewsDto $newsDto
     * @return void
     */
    public function save(NewsDto $newsDto): void
    {
        Article::save($newsDto->toArray());
    }

    /**
     * @param $source
     * @param array $queryParams
     * @return NewsDto
     * @throws \Exception
     */
    private function makeRequest($source, array $queryParams = []): NewsDto
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
                // @todo : how to call the resource adapter class by it's name
                return $this->adaptData($source, $response->json());
            }

            // Log the error and throw an exception if the response isn't successful
            Log::error("Request failed with status {$response->status()}: {$response->body()}");
            throw new \Exception('Failed to fetch data from the API.');
        } catch (\Exception $e) {
            Log::error("Request failed: " . $e->getMessage());
            throw new \Exception('Failed to fetch data from the API.');
        }
    }

    /**
     * Sync news API resources' response with Database.
     *
     * @param NewsApiAdapterInterface $adapter
     * @param $response mixed response of the news API endpoint
     * @return NewsDto
     */
    private function adaptData(NewsApiAdapterInterface $adapter, mixed $response)
    {
        return $adapter->sync($response);
    }

}
