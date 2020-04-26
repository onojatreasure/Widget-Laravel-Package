<?php

namespace App\http\Widgets;

use Treasure\Widget\Widget;

class TrendingArticles extends Widget
{
    public $title = 'Trending Articles';

    public function articles()
    {
        return ['Article 1', 'Article 2'];
    }
}