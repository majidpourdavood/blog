<?php

namespace App\Providers;

use App\Model\Comment;
use App\Model\Setting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use App\Model\Menu;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();


        view()->composer('site.*', function ($view) {
            $commentUnSuccessFullCount = Comment::whereApproved(0)->count();
            $commentSuccessFullCount = Comment::whereApproved(1)->count();
            $commentCount = Comment::all()->count();

            $view->with([
                'commentUnSuccessFullCount' => $commentUnSuccessFullCount,
                'commentSuccessFullCount' => $commentSuccessFullCount,
                'commentCount' => $commentCount,
            ]);
        });


        Validator::extend('recaptcha', function ($attribute, $value, $parameters, $validator) {
            $setting = \App\Model\Setting::where('key', 'RECAPTCHA_SECRET')->where('active', 1)->first();
            if (isset($setting)) {
                $RECAPTCHA_SECRET = $setting->value;
            } else {
                $RECAPTCHA_SECRET = "";

            }
            $dataQuery = 'secret=' . $RECAPTCHA_SECRET . '&response=' . $value . '&remoteip=' . request()->ip();
            $AddressServiceToken = "https://www.google.com/recaptcha/api/siteverify";

            $TokenArray = makeHttpChargeRequest('POST', $dataQuery, $AddressServiceToken);

            $decode_TokenArray = json_decode($TokenArray);
            return $decode_TokenArray->success;

        });


        view()->composer('site.view.*', function ($view) {
            $locale = app()->getLocale();

            $cachemenus = Cache::get( "menus.$locale");
            if (isset($cachemenus)) {
                $menus = $cachemenus;
            } else {
                $menus = Menu::with('children')->where('active', 1)
                    ->lang()
                    ->where('parent_id', 0)->get();

                Cache::put("menus.$locale", $menus);
            }

            $cacheIndexTitle = Cache::get("indexTitle.$locale" );
            if (isset($cacheIndexTitle)) {
                $indexTitle = $cacheIndexTitle;
            } else {
                $indexTitle = Setting::where('key', 'indexTitle') ->lang()->where('active', 1)->first();
                Cache::put("indexTitle.$locale" , $indexTitle);
            }


            $cacheIndexDescription = Cache::get("indexDescription.$locale" );
            if (isset($cacheIndexDescription)) {
                $indexDescription = $cacheIndexDescription;
            } else {
                $indexDescription = Setting::where('key', 'indexDescription') ->lang()->where('active', 1)->first();
                Cache::put("indexDescription.$locale", $indexDescription);
            }

            $cacheLogo = Cache::get("logo.$locale");
            if (isset($cacheLogo)) {
                $logo = $cacheLogo;
            } else {
                $logo = Setting::where('key', 'logo') ->lang()->where('active', 1)->first();
                Cache::put("logo.$locale", $logo);
            }

            $cachePhone = Cache::get("phone.$locale");
            if (isset($cachePhone)) {
                $phone = $cachePhone;
            } else {
                $phone = Setting::where('key', 'phone')
                    ->lang()
                    ->where('active', 1)->first();
                Cache::put("phone.$locale", $phone);
            }


            $cacheAddress = Cache::get("address.$locale");
            if (isset($cacheAddress)) {
                $address = $cacheAddress;
            } else {
                $address = Setting::where('key', 'address')
                    ->lang()
                    ->where('active', 1)->first();
                Cache::put("address.$locale", $address);
            }


            $cacheWhatsapp = Cache::get("whatsapp.$locale");
            if (isset($cacheWhatsapp)) {
                $whatsapp = $cacheWhatsapp;
            } else {
                $whatsapp = Setting::where('key', 'whatsapp') ->lang()->where('active', 1)->first();
                Cache::put("whatsapp.$locale", $whatsapp);
            }

            $cachetelegram = Cache::get("telegram.$locale");
            if (isset($cachetelegram)) {
                $telegram = $cachetelegram;
            } else {
                $telegram = Setting::where('key', 'telegram') ->lang()->where('active', 1)->first();
                Cache::put("telegram.$locale", $telegram);
            }

            $cacheinstagram = Cache::get("instagram.$locale");
            if (isset($cacheinstagram)) {
                $instagram = $cacheinstagram;
            } else {
                $instagram = Setting::where('key', 'instagram') ->lang()->where('active', 1)->first();
                Cache::put("instagram.$locale", $instagram);
            }

            $cachecopyright = Cache::get("copyright.$locale");
            if (isset($cachecopyright)) {
                $copyright = $cachecopyright;
            } else {
                $copyright = Setting::where('key', 'copyright') ->lang()->where('active', 1)->first();
                Cache::put("copyright.$locale", $copyright);
            }


            $cacheversionCss = Cache::get("versionCss.$locale");
            if (isset($cacheversionCss)) {
                $versionCss = $cacheversionCss;
            } else {
                $versionCss = Setting::where('key', 'versionCss') ->lang()->where('active', 1)->first();
                Cache::put("versionCss.$locale", $versionCss);
            }

            $cacheenamad = Cache::get("enamad.$locale");
            if (isset($cacheenamad)) {
                $enamad = $cacheenamad;
            } else {
                $enamad = Setting::where('key', 'enamad') ->lang()->where('active', 1)->first();
                Cache::put("enamad.$locale", $enamad);
            }

            $cacheGoogleSiteVerification = Cache::get("google-site-verification.$locale");
            if (isset($cacheGoogleSiteVerification)) {
                $googleSiteVerification = $cacheGoogleSiteVerification;
            } else {
                $googleSiteVerification = Setting::where('key', 'google-site-verification') ->lang()->where('active', 1)->first();
                Cache::put("google-site-verification.$locale", $googleSiteVerification);
            }


            $cacheBingSiteVerification = Cache::get("bing-site-verification.$locale");
            if (isset($cacheBingSiteVerification)) {
                $bingSiteVerification = $cacheBingSiteVerification;
            } else {
                $bingSiteVerification = Setting::where('key', 'bing-site-verification') ->lang()->where('active', 1)->first();
                Cache::put("bing-site-verification.$locale", $bingSiteVerification);
            }


            $cacheGoogletagmanager = Cache::get("googletagmanager.$locale");
            if (isset($cacheGoogletagmanager)) {
                $googletagmanager = $cacheGoogletagmanager;
            } else {
                $googletagmanager = Setting::where('key', 'googletagmanager') ->lang()->where('active', 1)->first();
                Cache::put("googletagmanager.$locale", $googletagmanager);
            }

            $cacheScriptHead = Cache::get("scriptHead.$locale");
            if (isset($cacheScriptHead)) {
                $scriptHead = $cacheScriptHead;
            } else {
                $scriptHead = Setting::where('key', 'scriptHead') ->lang()->where('active', 1)->first();
                Cache::put("scriptHead.$locale", $scriptHead);
            }


            $view->with([

                'indexTitle' => $indexTitle,
                'indexDescription' => $indexDescription,
                'logo' => $logo,
                'phone' => $phone,
                'address' => $address,
                'whatsapp' => $whatsapp,
                'telegram' => $telegram,
                'instagram' => $instagram,
                'copyright' => $copyright,
                'versionCss' => $versionCss,
                'enamad' => $enamad,
                'googleSiteVerification' => $googleSiteVerification,
                'bingSiteVerification' => $bingSiteVerification,
                'googletagmanager' => $googletagmanager,
                'scriptHead' => $scriptHead,
                'menus' => $menus,
            ]);
        });


    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
