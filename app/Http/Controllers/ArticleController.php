<?php

namespace App\Http\Controllers;

use App\Services\ArticleService;
use Illuminate\Http\Request;

class ArticleController extends Controller
{

    private ?ArticleService $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    public function get(Request $request)
    {

        //validate the request

        return $this->articleService->get($request->only([
            'category',
            'source',
            'date'
        ]));
    }

    public function search(Request $request)
    {

        //validate the request

        return $this->articleService->search($request->get('keyword'));
    }




}
