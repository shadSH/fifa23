<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stichoza\GoogleTranslate\GoogleTranslate;

class GoogleTranslateController extends Controller
{
    public function translate(Request $request)
    {

        if ($request->name_en != '') {

            $name_en = $request->name_en;
            $name_ku = GoogleTranslate::trans($request->name_en, 'ckb', 'en');
            $name_ar = GoogleTranslate::trans($request->name_en, 'ar', 'en');

            return response()->json([
                'name_ku' => $name_ku,
                'name_ar' => $name_ar,
                'name_en' => $name_en,
            ]);
        }

        if ($request->name_ku != '') {

            $name_ku = $request->name_ku;
            $name_en = GoogleTranslate::trans($request->name_ku, 'en', 'ckb');
            $name_ar = GoogleTranslate::trans($request->name_ku, 'ar', 'ckb');

            return response()->json([
                'name_ku' => $name_ku,
                'name_ar' => $name_ar,
                'name_en' => $name_en,
            ]);
        }

        if ($request->name_ar != '') {

            $name_ar = $request->name_ar;
            $name_en = GoogleTranslate::trans($request->name_ar, 'en', 'ar');
            $name_ku = GoogleTranslate::trans($request->name_ar, 'ckb', 'ar');

            return response()->json([
                'name_ku' => $name_ku,
                'name_ar' => $name_ar,
                'name_en' => $name_en,
            ]);
        }
    }
}
