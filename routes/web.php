<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Home;
use App\Livewire\Menu;
use App\Livewire\Gallery;
use App\Livewire\Contact;
use App\Livewire\BlogIndex;
use App\Livewire\BlogPostShow;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function () {
    Route::get('/', Home::class)->name('home');
    Route::get('/menu/{category?}/{subcategory?}', Menu::class)->name('menu');
    Route::get('/gallery', Gallery::class)->name('gallery');
    Route::get('/our-story', \App\Livewire\OurStory::class)->name('our-story');
    Route::get('/contact', Contact::class)->name('contact');
    Route::get('/booking', \App\Livewire\BookingPage::class)->name('booking');
    Route::get('/blog', BlogIndex::class)->name('blog.index');
    Route::get('/privacy-policy', \App\Livewire\StaticPage::class)->defaults('slug', 'privacy-policy')->name('privacy-policy');
    Route::get('/terms-of-service', \App\Livewire\StaticPage::class)->defaults('slug', 'terms-of-service')->name('terms-of-service');
});
Route::get('/setup-server', function() {
    try {
        \Illuminate\Support\Facades\Artisan::call('config:clear');
        \Illuminate\Support\Facades\Artisan::call('cache:clear');
        \Illuminate\Support\Facades\Artisan::call('storage:link');
        \Illuminate\Support\Facades\Artisan::call('db:seed', ['--class' => 'SettingSeeder']);
        
        $uploadMax = ini_get('upload_max_filesize');
        $postMax = ini_get('post_max_size');
        
        return response()->json([
            'status' => 'success',
            'message' => 'Önbellek temizlendi, Storage Link oluşturuldu ve Ayarlar başarıyla eklendi.',
            'php_upload_limit' => $uploadMax,
            'php_post_limit' => $postMax,
            'warning' => ($uploadMax === '2M' || $uploadMax === '10M') ? "DİKKAT: Sunucunuzun yükleme limiti şu an {$uploadMax}. Coolify'dan Nginx/PHP ayarlarından limitleri yükseltmelisiniz." : "Yükleme limitleriniz iyi görünüyor."
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()]);
    }
});
// QR Redirect and Scan Tracking
Route::get('/qr/{id}', function ($id) {
    $qr = \App\Models\QrCode::find($id);
    if (!$qr) {
        return redirect()->route('menu');
    }
    $qr->increment('scans_count');
    
    $url = $qr->target_url;
    if (!str_starts_with($url, 'http://') && !str_starts_with($url, 'https://')) {
        $url = url($url);
    }
    return redirect()->to($url);
})->name('qr.redirect');

Route::get('/sitemap.xml', [\App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap');

// Blog posts outside prefix group to support legacy/clean URLs
Route::get('/{slug}', \App\Livewire\BlogPostShow::class)->name('blog.show');

// Admin notifications check endpoint for desktop notifications
Route::get('/admin/notifications-check', function () {
    if (!auth()->check()) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }
    $latestBooking = \App\Models\Booking::latest('id')->first();
    $latestFeedback = \App\Models\Feedback::latest('id')->first();
    return response()->json([
        'latest_booking' => $latestBooking ? [
            'id' => $latestBooking->id,
            'name' => $latestBooking->name,
            'party_size' => $latestBooking->party_size,
            'time' => $latestBooking->booking_time,
        ] : null,
        'latest_feedback' => $latestFeedback ? [
            'id' => $latestFeedback->id,
            'name' => $latestFeedback->name ?: 'Anonim Gönderici',
        ] : null,
    ]);
})->middleware(['web']);

// Web Push Public Key and Subscribe endpoints
Route::get('/admin/vapid-public-key', function () {
    if (!auth()->check()) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }
    $keys = \App\Services\WebPushService::getVapidKeys();
    return response()->json(['publicKey' => $keys['publicKey']]);
})->middleware(['web']);

Route::post('/admin/push-subscribe', function (\Illuminate\Http\Request $request) {
    if (!auth()->check()) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    $request->validate([
        'endpoint' => 'required|url',
        'public_key' => 'required|string',
        'auth_token' => 'required|string',
    ]);

    \App\Models\PushSubscription::updateOrCreate(
        ['endpoint' => $request->endpoint],
        [
            'user_id' => auth()->id(),
            'public_key' => $request->public_key,
            'auth_token' => $request->auth_token,
        ]
    );

    return response()->json(['status' => 'success', 'message' => 'Subscribed successfully.']);
})->middleware(['web']);


