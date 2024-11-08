<?php

namespace App\Http\Controllers\Modules\Menu;

use App\Models\Menu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MenuController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        try {
            $data = Menu::with('user')->get(); // Perbaikan nama relasi menjadi 'user'
            return $this->appResponse(100, $data);
        } catch (\Exception $err) {
            return $this->appResponse(2000, null, $err->getMessage());
        }
    }

    public function store(Request $request)
{
    try {
        if (!auth()->check()) {
            return $this->appResponse(2000, null, "User not authenticated.");
        }

        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'normal_price' => 'required|numeric',
            'discount_price' => 'nullable|numeric',
            'category' => 'required',
            'image' => 'required'
        ]);

        $data = Menu::create([
            'name' => $request->name,
            'description' => $request->description,
            'normal_price' => $request->normal_price,
            'discount_price' => $request->discount_price,
            'category' => $request->category,
            'image' => $request->image,
            'users_id' => auth()->user()->id,
            'status' => 'active'
        ]);

        return $this->appResponse(100, $data);
    } catch (\Exception $err) {
        return $this->appResponse(2000, null, $err->getMessage());
    }
}

}
