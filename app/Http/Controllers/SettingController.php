<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Traits\UploadsImage;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Gate;

class SettingController extends Controller
{
    use UploadsImage;

    public function index()
    {
        Gate::authorize('settings-view');

        $setting = Setting::first();
        if (!$setting) {
            $setting = Setting::create(['site_name' => 'My Application']);
        }
        
        return Inertia::render('Settings/Index', [
            'setting' => $setting
        ]);
    }

    public function update(Request $request)
    {
        Gate::authorize('settings-update');

        $setting = Setting::first();

        $request->validate([
            'site_name' => 'required|string|min:2|max:100',
            'site_title' => 'nullable|string|min:2|max:150',
            'phone' => 'nullable|string|regex:/^[0-9]{7,15}$/',
            'email' => 'nullable|email:rfc,dns|max:255',
            'address' => 'nullable|string|max:500',
            'currency_name' => 'required|string|min:2|max:50',
            'currency_symbol' => 'required|string|max:10',
            'currency_code' => 'required|string|size:3|alpha',
            'currency_position' => 'required|string|in:prefix,suffix',
            'invoice_view_type' => 'required|string|in:both,logo_only,text_only',
            'pos_receipt_type' => 'required|string|in:pos,a4,a5',
            'purchase_receipt_type' => 'required|string|in:pos,a5',
            'payment_receipt_type' => 'required|string|in:pos,a4',
            'low_stock_limit' => 'required|integer|min:0|max:100000',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048|dimensions:max_width=2000,max_height=2000',
            'favicon' => 'nullable|image|mimes:jpeg,png,jpg,ico,webp|max:1024|dimensions:max_width=512,max_height=512',
        ], [
            'phone.regex' => 'The phone number must contain only numbers and be between 7 to 15 digits long.',
        ]);

        $setting->site_name = $request->site_name;
        $setting->site_title = $request->site_title;
        $setting->address = $request->address;
        $setting->phone = $request->phone;
        $setting->email = $request->email;
        $setting->currency_name = $request->currency_name;
        $setting->currency_symbol = $request->currency_symbol;
        $setting->currency_code = $request->currency_code;
        $setting->currency_position = $request->currency_position;
        $setting->pos_receipt_type = $request->pos_receipt_type;
        $setting->purchase_receipt_type = $request->purchase_receipt_type;
        $setting->payment_receipt_type = $request->payment_receipt_type;
        $setting->invoice_view_type = $request->invoice_view_type;
        $setting->low_stock_limit = $request->low_stock_limit;
        $setting->dark_mode = $request->boolean('dark_mode');

        //favicon
        if ($request->hasFile('favicon')) {
            $setting->favicon = $this->uploadImage($request->file('favicon'), 'uploads/settings', $setting->favicon);
        }

        //logo
        if ($request->hasFile('logo')) {
            $setting->logo = $this->uploadImage($request->file('logo'), 'uploads/settings', $setting->logo);
        }

        $setting->save();
        
        return redirect()->back()->with('success', 'Settings updated successfully!');
    }
}
