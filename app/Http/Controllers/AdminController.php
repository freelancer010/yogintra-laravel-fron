<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

use App\Models\Setting;
use App\Models\Slider;
use App\Models\Front;
use App\Models\Service;
use App\Models\LandingPage;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Yoga;
use App\Models\Event;

class AdminController extends Controller
{
    public function dashboard()
    {
       return view('admin.dashboard', [
        'eventCount' => Event::count(),
        'serviceCount' => Service::count(),
        'yogaCenterCount' => DB::table('yoga_center')->count(),
        'blogCount' => Blog::count(),
      ]);
    }
}
