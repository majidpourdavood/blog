<?php

namespace App\Http\Controllers\Admin;

use App\Model\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = Setting::orderBy('created_at', 'desc')->paginate(100);
        return view('site.admin.setting.all', compact('settings'));
    }


    public function getManageSite()
    {
        $locale = app()->getLocale();
        $socials = Setting::orderBy('created_at', 'desc')
            ->whereIn('key', [
                'instagram',
                'telegram',
                'facebook',
                'twitter',
                'whatsapp',
                'linkedin',
            ])
            ->where("lang", $locale)  ->get();

        $contacts = Setting::orderBy('created_at', 'desc')
            ->whereIn('key', [
                'email',
                'phone',
                'address',
                'map',
            ])
            ->where("lang", $locale)    ->get();

        $managers = Setting::orderBy('created_at', 'desc')
            ->whereIn('key', [
                'logo',
                'favicon',
                'enamad',
                'scriptHead',
                'RECAPTCHA_SECRET',
                'RECAPTCHA_KEY',
            ])
            ->where("lang", $locale)    ->get();

        $seo = Setting::orderBy('created_at', 'desc')
            ->whereIn('key', [
                'indexTitle',
                'indexDescription',
                'googletagmanager',
                'google-site-verification',
                'bing-site-verification',
            ])
            ->where("lang", $locale)    ->get();


        return view('site.admin.setting.manage', compact(['socials', 'contacts', 'managers', 'seo']));
    }


    public function manageSite(Request $request)
    {
        $BASE_PATH = env('BASE_PATH');
        $locale = app()->getLocale();

        foreach ($request->all() as $key => $item) {
            $setting = Setting::where('key', $key)
                ->where("lang", $locale)
                ->first();
            if (isset($setting)) {
                $value = $key;
                if ($setting->type == "file" && $request->hasFile($value)) {
                    $filename = $request->file($value);
                    $name = sha1(time() . $filename->getClientOriginalName());
                    $extension = $filename->getClientOriginalExtension();
                    $filename = "{$name}.{$extension}";
                    $request->$value->move(base_path($BASE_PATH . 'setting/'), $filename);
                    $setting->value = '/setting/' . $filename;
                } else {
                    $setting->value = $item;
                }
                $setting->update();

            }

            $cache = Setting::where('key', $key)
                ->where("lang", $locale)
                ->where('active', 1)->first();
            Cache::put("$key.$locale", $cache);

        }

        alert()->success(translate('The setting was successfully edited'), translate('Edit setting'))->confirmButton(translate('OK'))->autoclose('3000');
        return back();


    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('site.admin.setting.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */


    public function store(Request $request)
    {

        $this->validate($request, [
            'title' => 'required',
            'key' => 'required',
        ]);

        $setting = new Setting();
        $setting->title = $request->title;
        $setting->slug = str_replace(' ', '-', $request->title);
        $setting->key = $request->key;
        $setting->lang = $request->lang;

        $setting->active = $request->active;
        $setting->user_id = auth()->user()->id;
        $BASE_PATH = env('BASE_PATH');

        if ($request->hasFile('value')) {
            $filename = $request->file('value');
            $name = sha1(time() . $filename->getClientOriginalName());
            $extension = $filename->getClientOriginalExtension();
            $filename = "{$name}.{$extension}";
            $request->value->move(base_path($BASE_PATH . 'setting/'), $filename);
            $setting->value = '/setting/' . $filename;
        } else {
            $setting->value = $request->value;
        }

        $setting->save();

        alert()->success(translate('Setting saved successfully'), translate('Save the setting'))
            ->confirmButton(translate('OK'))->autoclose('3000');
        return redirect()->route('setting.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $setting)
    {
        return view('site.admin.setting.edit', compact('setting'));

    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'key' => 'required',
        ]);

        $setting = Setting::findOrFail($id);
        $setting->title = $request->title;
        $setting->slug = str_replace(' ', '-', $request->title);
        $setting->value = $request->value;
        $setting->key = $request->key;
        $setting->lang = $request->lang;

        $setting->active = $request->active;
        $BASE_PATH = env('BASE_PATH');
        if ($request->hasFile('value')) {
            $filename = $request->file('value');
            $name = sha1(time() . $filename->getClientOriginalName());
            $extension = $filename->getClientOriginalExtension();
            $filename = "{$name}.{$extension}";
            $request->value->move(base_path($BASE_PATH . 'setting/'), $filename);
            $setting->value = '/setting/' . $filename;
        } else {
            $setting->value = $request->value;
        }

        $setting->update();

        $locale = app()->getLocale();
        $cache = Setting::where('key', $request->key)
            ->where("lang", $locale)
            ->where('active', 1)->first();
        Cache::put("$request->key.$locale", $cache);

        alert()->success(translate('The setting was successfully edited'), translate('Edit setting'))->confirmButton(translate('OK'))->autoclose('3000');
        return redirect()->route('setting.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {

        $setting->delete();
        alert()->success(translate('Setup deleted successfully'), translate('Delete setting'))->confirmButton(translate('OK'))->autoclose('3000');
        return back();
    }
}
