<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AwardController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ClientLogoController;
use App\Http\Controllers\ClientTestimonialController;
use App\Http\Controllers\ContentSectionController;
use App\Http\Controllers\CounterController;
use App\Http\Controllers\HighlightController;
use App\Http\Controllers\InsightController;
use App\Http\Controllers\JourneyController;
use App\Http\Controllers\OfferingController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TeamMemberController;
use App\Http\Controllers\TestimonialController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/admin-register', [AuthController::class, 'showRegister'])->name('admin.register');
Route::post('/admin-register', [AuthController::class, 'register'])->name('admin.register.store');

Route::get('/admin-login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::get('/', [AuthController::class, 'showLogin'])->name('admin.login');

Route::post('/admin-login', [AuthController::class, 'login'])->name('admin.login.check');

Route::post('/admin-logout', [AuthController::class, 'logout'])->name('admin.logout');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/blogs',[BlogController::class,'index'])->name('blogs.index');

    Route::post('/blogs',[BlogController::class,'store'])->name('blogs.store');

    Route::put('/blogs/{id}',[BlogController::class,'update'])->name('blogs.update');

    Route::delete('/blogs/{id}',[BlogController::class,'destroy'])->name('blogs.destroy');

    Route::get('/banners',[BannerController::class,'index'])->name('banners.index');

    Route::post('/banners',[BannerController::class,'store'])->name('banners.store');

    Route::put('/banners/{id}',[BannerController::class,'update'])->name('banners.update');

    Route::delete('/banners/{id}',[BannerController::class,'destroy'])->name('banners.destroy');

    Route::get('/counters',[CounterController::class,'index'])->name('counters.index');

    Route::post('/counters',[CounterController::class,'store'])->name('counters.store');

    Route::put('/counters/{id}',[CounterController::class,'update'])->name('counters.update');

    Route::delete('/counters/{id}',[CounterController::class,'destroy'])->name('counters.destroy');

    Route::get('/client-testimonials',[ClientTestimonialController::class,'index'])->name('client.testimonials.index');

    Route::post('/client-testimonials',[ClientTestimonialController::class,'store'])->name('client.testimonials.store');

    Route::put('/client-testimonials/{id}',[ClientTestimonialController::class,'update'])->name('client.testimonials.update');

    Route::delete('/client-testimonials/{id}',[ClientTestimonialController::class,'destroy'])->name('client.testimonials.destroy');
        
    Route::get('/testimonials',[TestimonialController::class,'index'])->name('testimonials.index');

    Route::post('/testimonials',[TestimonialController::class,'store'])->name('testimonials.store');

    Route::put('/testimonials/{id}',[TestimonialController::class,'update'])->name('testimonials.update');

    Route::delete('/testimonials/{id}',[TestimonialController::class,'destroy'])->name('testimonials.destroy');

    Route::get('/insights',[InsightController::class,'index'])->name('insights.index');

    Route::post('/insights',[InsightController::class,'store'])->name('insights.store');

    Route::put('/insights/{id}',[InsightController::class,'update'])->name('insights.update');

    Route::delete('/insights/{id}',[InsightController::class,'destroy'])->name('insights.destroy');

    Route::get('/awards',[AwardController::class,'index'])->name('awards.index');

    Route::post('/awards',[AwardController::class,'store'])->name('awards.store');

    Route::put('/awards/{id}',[AwardController::class,'update'])->name('awards.update');

    Route::delete('/awards/{id}',[AwardController::class,'destroy'])->name('awards.destroy');

    Route::get('/client-logos',[ClientLogoController::class,'index'])->name('client.logos.index');

    Route::post('/client-logos',[ClientLogoController::class,'store'])->name('client.logos.store');

    Route::put('/client-logos/{id}',[ClientLogoController::class,'update'])->name('client.logos.update');

    Route::delete('/client-logos/{id}',[ClientLogoController::class,'destroy'])->name('client.logos.destroy');
    Route::get('/journeys',[JourneyController::class,'index'])->name('journeys.index');

    Route::post('/journeys',[JourneyController::class,'store'])->name('journeys.store');

    Route::put('/journeys/{id}',[JourneyController::class,'update'])->name('journeys.update');

    Route::delete('/journeys/{id}',[JourneyController::class,'destroy'])->name('journeys.destroy');

    Route::get('/team-members',[TeamMemberController::class,'index'])->name('team.members.index');

    Route::post('/team-members',[TeamMemberController::class,'store'])->name('team.members.store');

    Route::put('/team-members/{id}',[TeamMemberController::class,'update'])->name('team.members.update');

    Route::delete('/team-members/{id}',[TeamMemberController::class,'destroy'])->name('team.members.destroy');

    Route::get('/services',[ServiceController::class,'index'])->name('services.index');

    Route::post('/services',[ServiceController::class,'store'])->name('services.store');

    Route::put('/services/{id}',[ServiceController::class,'update'])->name('services.update');

    Route::delete('/services/{id}',[ServiceController::class,'destroy'])->name('services.destroy');

    Route::get('/highlights',[HighlightController::class,'index'])->name('highlights.index');

    Route::post('/highlights',[HighlightController::class,'store'])->name('highlights.store');

    Route::put('/highlights/{id}',[HighlightController::class,'update'])->name('highlights.update');

    Route::delete('/highlights/{id}',[HighlightController::class,'destroy'])->name('highlights.destroy');



    Route::get('/offerings',[OfferingController::class,'index'])->name('offerings.index');

    Route::post('/offerings',[OfferingController::class,'store'])->name('offerings.store');

    Route::put('/offerings/{id}',[OfferingController::class,'update'])->name('offerings.update');

    Route::delete('/offerings/{id}',[OfferingController::class,'destroy'])->name('offerings.destroy');

    Route::get('/content-sections',[ContentSectionController::class,'index'])->name('content.sections.index');

    Route::post('/content-sections',[ContentSectionController::class,'store'])->name('content.sections.store');
});

