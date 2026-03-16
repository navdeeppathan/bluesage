<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Counter;
use App\Models\Testimonial;
use App\Models\Insight;
use App\Models\Award;
use App\Models\TeamMember;
use App\Models\Service;
use App\Models\Offering;
use App\Models\ClientLogo;
use App\Models\ClientTestimonial;
use App\Models\Journey;
use App\Models\Highlight;
use App\Models\ContentSection;

class HomeController extends Controller
{
    public function home()
    {
        $data = [
            'awards' => Award::where('status',1)->orderBy('id','desc')->get(),
            'banners' => Banner::where('status',1)->orderBy('id','desc')->get(),
            'client_logos' => ClientLogo::where('status',1)->orderBy('id','desc')->get(),
            'client_testimonials' => ClientTestimonial::where('status',1)->orderBy('id','desc')->get(),
            'counters' => Counter::where('status',1)->orderBy('id','desc')->get(),
            'highlight' => Highlight::where('status',1)->orderBy('id','desc')->first(),
            'insights' => Insight::where('status',1)->orderBy('id','desc')->get(),
            'journeys' => Journey::where('status',1)->orderBy('id','desc')->get(),
            'offerings' => Offering::where('status',1)->orderBy('id','desc')->get(),
            'services' => Service::where('status',1)->orderBy('id','desc')->get(),
            'team' => TeamMember::where('status',1)->orderBy('id','desc')->get(),
            'testimonials' => Testimonial::where('status',1)->orderBy('id','desc')->get(),
            'content_section' => ContentSection::where('status',1)->orderBy('id','desc')->first(),
        ];

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }
}