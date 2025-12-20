<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use App\Models\Rubrique;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index()
    {
        $publications = Publication::published()
            ->orderBy('updated_at', 'desc')
            ->get();

        $rubriques = Rubrique::active()->get();

        return response()->view('sitemap.index', [
            'publications' => $publications,
            'rubriques' => $rubriques,
        ])->header('Content-Type', 'text/xml');
    }
}
