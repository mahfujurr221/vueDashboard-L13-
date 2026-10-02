<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SettingController extends Controller
{
    public function index()
    {
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
        $setting = Setting::first();

        $request->validate([
            'site_name' => 'required|string|max:255',
            'currency_name' => 'required|string|max:255',
            'currency_symbol' => 'required|string|max:255',
            'currency_code' => 'required|string|max:255',
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
            if ($setting->favicon && \Illuminate\Support\Facades\Storage::disk('public')->exists($setting->favicon)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($setting->favicon);
            }
            $setting->favicon = $request->file('favicon')->store('uploads/settings', 'public');
        }

        //logo
        if ($request->hasFile('logo')) {
            if ($setting->logo && \Illuminate\Support\Facades\Storage::disk('public')->exists($setting->logo)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($setting->logo);
            }
            $setting->logo = $request->file('logo')->store('uploads/settings', 'public');
        }

        $setting->save();
        
        return redirect()->back()->with('success', 'Settings updated successfully!');
    }
}
