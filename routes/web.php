<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TinymceController;

use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\YogaCenterController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/about', [HomeController::class, 'about']);
Route::get('/trainers', [HomeController::class, 'allTrainers'])->name('trainers.index');
Route::post('/get_data_for_trainer', [HomeController::class, 'get_data_for_trainer']);
Route::get('/blog', [HomeController::class, 'allBlog']);
Route::get('/blog/{slug}', [HomeController::class, 'blogDetails'])->name('blog.details');
Route::get('/blog_category/{slug}', [HomeController::class, 'blogCategory'])->name('blog.category');
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
Route::get('/retreat', [HomeController::class, 'allRetreat'])->name('retreat.all');
Route::post('/submit-contact-form', [HomeController::class, 'submitContactForm'])->name('form.submit');
Route::get('/workshop', [HomeController::class, 'allWorkshop'])->name('workshop');
Route::get('/yoga_center', [HomeController::class, 'allYogaCenter'])->name('yoga.center');
Route::get('/yoga-center/{slug}', [HomeController::class, 'yogaCenterDetails'])->name('yoga.center.details');
Route::get('/become-yoga-trainer', [HomeController::class, 'becomeYogaTrainer']);
Route::get('/city/{slug}', [HomeController::class, 'landingPage']);
Route::get('/event/{slug}', [HomeController::class, 'eventDetails'])->name('event.details');
Route::post('/event/register', [EventRegistrationController::class, 'store'])->name('event.register');


///////---------------------- |ADMIN ROUTES| -----------------------------/////////


// Route::middleware(['auth'])->prefix('admin')->group(function () {
//     Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
// });
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Event Routes
    Route::get('/event/view_all_event', [EventController::class, 'index'])->name('event.index');
    Route::get('/event/add_new_event', [EventController::class, 'create'])->name('event.create');
    Route::post('/event/store', [EventController::class, 'store'])->name('event.store');
    Route::get('/event/edit_event/{id}', [EventController::class, 'edit'])->name('event.edit');
    Route::put('/event/update/{id}', [EventController::class, 'update'])->name('event.update');
    Route::get('/event/status/{id}/{status}', [EventController::class, 'toggleStatus'])->name('event.status');
    Route::get('/event/event_booking', [EventController::class, 'booking'])->name('event.booking');
    Route::delete('/event/delete_event/{id}', [EventController::class, 'destroy'])->name('event.destroy');
    Route::post('/tinymce/upload', [TinymceController::class, 'upload']);
    Route::get('/event/event_booking', [EventController::class, 'booking'])->name('event.booking');

    // Service categories
    Route::get('/service/service_category', [ServiceController::class, 'serviceCategory'])->name('service.category');
    Route::get('/service/edit_category/{id}', [ServiceController::class, 'editCategory'])->name('service.edit_category');
    Route::post('/service/add_category', [ServiceController::class, 'addCategory'])->name('service.add_category');
    Route::put('/service/update_category/{id}', [ServiceController::class, 'update'])->name('service.update_category');
    Route::delete('/service/delete_category/{id}', [ServiceController::class, 'deleteCategory'])->name('service.delete_category');
    
    // Services
    Route::get('/service/all_service', [ServiceController::class, 'index'])->name('service.index');
    Route::get('/service/create', [ServiceController::class, 'create'])->name('service.create');
    Route::post('/service/store', [ServiceController::class, 'store'])->name('service.store');
    Route::get('/service/edit/{id}', [ServiceController::class, 'edit'])->name('service.edit');
    Route::put('/service/update/{id}', [ServiceController::class, 'update'])->name('service.update');
    Route::delete('/service/delete/{id}', [ServiceController::class, 'destroy'])->name('service.destroy');

    // Yoga Center
    Route::get('/yoga_center/view_all_yoga_center', [YogaCenterController::class, 'index'])->name('yoga_centers.index');
    Route::get('/yoga_center/add_center', [YogaCenterController::class, 'create'])->name('yoga_centers.create');
    Route::post('/yoga_center/store_center', [YogaCenterController::class, 'store'])->name('yoga_centers.store');
    Route::get('/yoga_center/edit_center/{id}', [YogaCenterController::class, 'edit'])->name('yoga_centers.edit');
    Route::put('/yoga_center/update_center/{id}', [YogaCenterController::class, 'update'])->name('yoga_centers.update');
    Route::delete('/yoga_center/delete_center/{id}', [YogaCenterController::class, 'destroy'])->name('yoga_centers.destroy');

    // Gallery
    Route::get('/gallery/view_all_category', [App\Http\Controllers\AdminController::class, 'categories'])->name('gallery.categories');
    Route::get('/gallery/view_all_gallery', [App\Http\Controllers\AdminController::class, 'index'])->name('gallery.index');

    // Blog
    Route::get('/blog/blog_category', [App\Http\Controllers\AdminController::class, 'category'])->name('blog.category');
    Route::get('/blog/add_new_post', [App\Http\Controllers\AdminController::class, 'create'])->name('blog.create');
    Route::get('/blog/view_all_post', [App\Http\Controllers\AdminController::class, 'index'])->name('blog.index');

    // Landing Page
    Route::get('/landing_page/landing_page', [App\Http\Controllers\AdminController::class, 'index'])->name('landing.index');

    // Front Setting
    Route::get('/front_setting/all_slider', [App\Http\Controllers\AdminController::class, 'slider'])->name('front.slider');
    Route::get('/front_setting/section_1', [App\Http\Controllers\AdminController::class, 'section1'])->name('front.section1');
    Route::get('/front_setting/section_2', [App\Http\Controllers\AdminController::class, 'section2'])->name('front.section2');
    Route::get('/front_setting/testimonial', [App\Http\Controllers\AdminController::class, 'testimonial'])->name('front.testimonial');

    // Settings
    Route::get('/setting/application_setting', [App\Http\Controllers\AdminController::class, 'application'])->name('setting.application');

    // Profile & Password (optional, adjust as needed)
    Route::get('/update_profile/update_profile_details', [App\Http\Controllers\AdminController::class, 'edit'])->name('profile.edit');
    Route::get('/update_profile/update_profile_password', [App\Http\Controllers\AdminController::class, 'changePassword'])->name('password.change');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';