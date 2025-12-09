<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;
use App\Models\Publication;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        $breakingNews = Publication::published()
            ->breaking()
            ->latest('published_at')
            // ->take(5)
            ->get();
            // 'breakingNews',

        $members = TeamMember::visible()->ordered()->get();

        return view('frontend.team', compact('members', 'breakingNews'));
    }
}
