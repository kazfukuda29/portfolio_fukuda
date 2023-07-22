<?php

namespace App\Http\Controllers;

use App\Models\AnnouncementTag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        return response()->json(AnnouncementTag::all());
    }
}
