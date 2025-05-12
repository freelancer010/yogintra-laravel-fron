<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/about', [HomeController::class, 'about']);
Route::get('/all-trainers', [HomeController::class, 'allTrainers']);
Route::get('/blog', [HomeController::class, 'allBlog']);
Route::get('/blog-details/{slug}', [HomeController::class, 'blogDetails']);
Route::get('/blog-category/{slug}', [HomeController::class, 'blogCategory']);
Route::get('/service/{slug}', [HomeController::class, 'allService'])->name('all-service');
Route::get('/service-details/{slug}', [HomeController::class, 'serviceDetails']);
Route::get('/gallery', [HomeController::class, 'gallery']);
Route::get('/contact', [HomeController::class, 'contact']);
Route::get('/event-details/{slug}', [HomeController::class, 'eventDetails']);
Route::post('/submit-contact-form', [HomeController::class, 'submitContactForm']);
Route::get('/coming-soon', [HomeController::class, 'comingSoon']);
Route::get('/teacher_training_course', [HomeController::class, 'teacherTrainingCourse'])->name('ttc');
Route::get('/terms-and-condition', [HomeController::class, 'termsAndCondition']);
Route::get('/privacy-policy', [HomeController::class, 'privacyPolicy']);
Route::get('/refund-policy', [HomeController::class, 'refundPolicy']);
Route::post('/submit-contact-form', [HomeController::class, 'submitContactForm'])->name('form.submit');;
Route::get('/yoga_center', [HomeController::class, 'allYogaCenter'])->name('yoga.center');
Route::get('/yoga-center/{slug}', [HomeController::class, 'yogaCenterDetails'])->name('yoga.center.details');
