<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TinymceController;

// Admin Controllers
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\YogaCenterController;
use App\Http\Controllers\Admin\FrontSettingController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\LandingPageController;
use App\Http\Controllers\Admin\SettingController;



Route::get('/', [HomeController::class, 'index']);
Route::get('/about', [HomeController::class, 'about']);
Route::get('/trainers', [HomeController::class, 'allTrainers'])->name('trainers.index');
Route::get('/trainer/{id}', [HomeController::class, 'showTrainer'])->name('trainer.show');
Route::get('/gallery', [HomeController::class, 'gallery']);

// AMP Routes
Route::get('/amp', [HomeController::class, 'ampHome'])->name('amp.home');
Route::get('/{path}/amp', [HomeController::class, 'ampPage'])->where('path', '.*')->name('amp.page');

Route::get('/contact', [HomeController::class, 'contact']);
Route::post('/submit-contact-form', [HomeController::class, 'submitContactForm'])->name('form.submit');
Route::get('/embed/contact-form/{source?}', [HomeController::class, 'embedForm'])->name('form.embed');

Route::get('/blog', [HomeController::class, 'allBlog']);
Route::get('/blog/{slug}', [HomeController::class, 'blogDetails'])->name('blog.details');
Route::get('/blog-category/{slug}', [HomeController::class, 'blogCategory'])->name('blog.category');

Route::get('/service-details/{slug}', [HomeController::class, 'serviceDetails']);
Route::get('/service/{slug}', [HomeController::class, 'allService'])->name('all-service');

Route::get('/service_details/{slug}', [HomeController::class, 'serviceDetails']);
Route::get('/service', function () {
    return redirect('/service/home-visit-yoga', 301);
})->name('service.home');
Route::get('/padmasana-lotus-pose', function () {
    return redirect('/blog/padmasana-lotus-pose', 301);
});

Route::get('/event-details/{slug}', [HomeController::class, 'eventDetails']);
Route::get('/event/{slug}', [HomeController::class, 'eventDetails'])->name('event.details');

Route::post('/get-data-for-trainer', [HomeController::class, 'get_data_for_trainer'])->name('trainer.data');

Route::get('/terms-and-condition', [HomeController::class, 'termsAndCondition']);
Route::get('/privacy-policy', [HomeController::class, 'privacyPolicy']);
Route::get('/refund-policy', [HomeController::class, 'refundPolicy']);

Route::get('/teacher-training-course', [HomeController::class, 'teacherTrainingCourse'])->name('ttc');
Route::get('/teacher-training-course/{slug}', [HomeController::class, 'eventDetails'])->name('ttc.details');

Route::get('/retreat', [HomeController::class, 'allRetreat'])->name('retreat.all');
Route::get('/retreat/{slug}', [HomeController::class, 'eventDetails'])->name('retreat.details');

Route::get('/workshop', [HomeController::class, 'allWorkshop'])->name('workshop');
Route::get('/workshop/{slug}', [HomeController::class, 'eventDetails'])->name('workshop.details');

Route::get('/yoga-center', [HomeController::class, 'allYogaCenter'])->name('yoga.center');
Route::get('/yoga-center/{slug}', [HomeController::class, 'yogaCenterDetails'])->name('yoga.center.details');

Route::get('/become-yoga-trainer', [HomeController::class, 'becomeYogaTrainer']);
Route::post('/become-yoga-trainer', [HomeController::class, 'submitTrainerForm'])->name('trainer.submit');

Route::get('/city/{slug}', [HomeController::class, 'landingPage']);

Route::get('/coming-soon', [HomeController::class, 'comingSoon']);
Route::get('/thank_you', function () {
    return view('front.thank_you');
})->name('thank_you');

Route::post('/submit-event-form', [EventController::class, 'submitEventForm'])->name('submit.event.form');
Route::get('/payment-for-event', [EventController::class, 'paymentForEvent'])->name('payment.for.event');
Route::post('/rezorpay-payment-for-event', [EventController::class, 'rezorpayPaymentForEvent'])->name('razorpay.payment.callback');
Route::get('/event-thank-you', [EventController::class, 'eventThankYou'])->name('event.thankyou');


Route::post('/admin/ckeditor/upload', [App\Http\Controllers\Admin\CKEditorController::class, 'upload'])->name('ckeditor.upload');

///////---------------------- |ADMIN ROUTES| -----------------------------/////////


// Route::middleware(['auth'])->prefix('admin')->group(function () {
//     Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
// });
Route::get('/admin', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    Route::post('/tinymce/upload', [App\Http\Controllers\Admin\CKEditorController::class, 'tinymceUpload'])->name('tinymce.upload');
    // Event Routes
    Route::get('/event/view_all_event', [EventController::class, 'index'])->name('event.index');
    Route::get('/event/add_new_event', [EventController::class, 'create'])->name('event.create');
    Route::post('/event/store', [EventController::class, 'store'])->name('event.store');
    Route::get('/event/edit_event/{id}', [EventController::class, 'edit'])->name('event.edit');
    Route::put('/event/update/{id}', [EventController::class, 'update'])->name('event.update');
    Route::get('/event/status/{id}/{status}', [EventController::class, 'toggleStatus'])->name('event.status');
    Route::get('/event/event_booking', [EventController::class, 'booking'])->name('event.booking');
    Route::delete('/event/delete_event/{id}', [EventController::class, 'destroy'])->name('event.destroy');
    // Route::post('/tinymce/upload', [TinymceController::class, 'upload']);
    Route::get('/event/event_booking', [EventController::class, 'booking'])->name('event.booking');

    // Service categories
    Route::get('/service/service_category', [ServiceController::class, 'serviceCategory'])->name('service.category');
    Route::get('/service/edit_category/{id}', [ServiceController::class, 'editCategory'])->name('service.edit_category');
    Route::post('/service/add_category', [ServiceController::class, 'addCategory'])->name('service.add_category');
    Route::put('/service/update_category/{id}', [ServiceController::class, 'updateCategory'])->name('service.update_category');
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

    // -- category
    Route::get('/gallery/view_all_category', [GalleryController::class, 'index'])->name('gallery.category.index');
    Route::post('/gallery/store_category', [GalleryController::class, 'store'])->name('gallery.category.store');
    Route::put('/gallery/update_category/{id}', [GalleryController::class, 'update'])->name('gallery.category.update');
    Route::delete('/gallery/delete_category/{id}', [GalleryController::class, 'destroy'])->name('gallery.category.delete');

    // 📸 Gallery Management
    Route::get('/gallery/view_all_gallery', [GalleryController::class, 'viewAllGallery'])->name('gallery.index');
    Route::post('/gallery/store_gallery', [GalleryController::class, 'storeGallery'])->name('gallery.store');
    Route::get('/gallery/edit_gallery/{id}', [GalleryController::class, 'editGallery'])->name('gallery.edit');
    Route::put('/gallery/update_gallery/{id}', [GalleryController::class, 'updateGallery'])->name('gallery.update');
    Route::delete('/gallery/delete_gallery/{id}', [GalleryController::class, 'deleteGallery'])->name('gallery.delete');


    // ------------- Blog ----------------------
    Route::get('/blog/blog-category', [BlogController::class, 'blogCategory'])->name('blog.category');
    Route::post('/blog/blog-category/store', [BlogController::class, 'storeCategory'])->name('blog_category.store');
    Route::get('/blog/blog-category/edit/{blog_category}', [BlogController::class, 'editCategory'])->name('blog_category.edit');
    Route::post('/blog/blog-category/update/{blog_category}', [BlogController::class, 'updateCategory'])->name('blog_category.update');
    Route::get('/blog/blog-category/delete/{blog_category}', [BlogController::class, 'destroyCategory'])->name('blog_category.delete');

    Route::get('/blog/add-new-post', [BlogController::class, 'create'])->name('blog.create');
    Route::post('/blog/store', [BlogController::class, 'store'])->name('blog.store');
    Route::get('/blog/view-all-post', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/blog/edit/{blog}', [BlogController::class, 'edit'])->name('blog.edit');
    Route::get('/blog/delete/{blog}', [BlogController::class, 'destroy'])->name('blog.delete');
    Route::post('/blog/update/{id}', [BlogController::class, 'update'])->name('blog.update');
    Route::post('/upload-image', [BlogController::class, 'uploadImage'])->name('ckeditor.upload');
    // ------------- END Blog ----------------------

    
    // --------------- Landing Page -------------------
    Route::get('landing-pages', [LandingPageController::class, 'index'])->name('landing-pages.index');
    Route::get('landing-pages/create', [LandingPageController::class, 'create'])->name('landing-pages.create');
    Route::post('landing-pages/store', [LandingPageController::class, 'store'])->name('landing-pages.store');
    Route::get('landing-pages/edit/{id}', [LandingPageController::class, 'edit'])->name('landing-pages.edit');
    Route::post('landing-pages/update/{id}', [LandingPageController::class, 'update'])->name('landing-pages.update');
    Route::get('landing-pages/delete/{id}', [LandingPageController::class, 'destroy'])->name('landing-pages.destroy');
    //---------------- END LANDING PAGE -------------------

    
    // --------| Front Setting |-------------------
    Route::prefix('front-setting')->name('front.')->group(function () {
        Route::get('/all-slider', [FrontSettingController::class, 'slider'])->name('slider');
        Route::get('/edit-slider/{id}', [FrontSettingController::class, 'editSlider'])->name('slider.edit');
        Route::put('/update-slider/{id}', [FrontSettingController::class, 'updateSlider'])->name('slider.update');
        Route::post('/store-slider', [FrontSettingController::class, 'storeSlider'])->name('slider.store');
        Route::get('/delete-slider/{id}', [FrontSettingController::class, 'deleteSlider'])->name('slider.delete');

        Route::get('/our-features', [FrontSettingController::class, 'ourFeatures'])->name('our_features');
        Route::post('/update-our-features-heading', [FrontSettingController::class, 'updateOurFeaturesHeading'])->name('our_features.heading.update');
        Route::post('/add-our-features', [FrontSettingController::class, 'storeOurFeature'])->name('our_features.store');
        Route::get('/edit-our-features/{id}', [FrontSettingController::class, 'editOurFeature'])->name('our_features.edit');
        Route::post('/update-our-features/{id}', [FrontSettingController::class, 'updateOurFeature'])->name('our_features.update');
        Route::get('/delete-our-features/{id}', [FrontSettingController::class, 'deleteOurFeature'])->name('our_features.delete');

        Route::get('/section-1', [FrontSettingController::class, 'section1'])->name('section1');
        Route::get('/section-2', [FrontSettingController::class, 'section2'])->name('section2');
        
        Route::post('/section-2/image/update', [FrontSettingController::class, 'updateServiceImage'])->name('section2.image.update');
        Route::post('/section-2/service/store', [FrontSettingController::class, 'storeService'])->name('section2.service.store');
        Route::get('/section-2/service/edit/{id}', [FrontSettingController::class, 'editService'])->name('section2.service.edit');
        Route::put('/section-2/service/update/{id}', [FrontSettingController::class, 'updateService'])->name('section2.service.update');
        Route::delete('/section-2/service/delete/{id}', [FrontSettingController::class, 'deleteService'])->name('section2.service.delete');

        Route::get('/testimonial', [FrontSettingController::class, 'testimonial'])->name('testimonial');
    });
    // --------| Front Setting |-------------------

    // Settings
    Route::get('/setting/application_setting', [SettingController::class, 'applicationSetting'])->name('setting.application');
    Route::post('/setting/update_application_setting/{type?}', [SettingController::class, 'updateApplicationSetting'])->name('setting.update');

    // Admin Profile Management
    Route::get('/profile/edit', [App\Http\Controllers\Admin\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [App\Http\Controllers\Admin\ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [App\Http\Controllers\Admin\ProfileController::class, 'updatePassword'])->name('profile.password');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/generate-sitemap', [\App\Http\Controllers\SitemapController::class, 'generate'])
    ->name('sitemap.generate');