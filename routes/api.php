<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\MenuItem;

Route::post('/menu/like/{id}', function ($id, Request $request) {
    try {
        $item = MenuItem::findOrFail($id);
        $action = $request->input('action', 'like');

        if ($action === 'like') {
            $item->increment('likes_count');
        } elseif ($action === 'unlike' && $item->likes_count > 0) {
            $item->decrement('likes_count');
        } elseif ($action === 'set') {
            $item->likes_count = max(0, (int) $request->input('count', 0));
            $item->save();
        }

        return response()->json([
            'success' => true, 
            'likes_count' => $item->likes_count
        ]);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
    }
});
