<?php

namespace App\Http\Controllers\Admin;

use App\Model\Translation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class TranslationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $translations = Translation::latest()->paginate(1000);
        return view('site.admin.translation.all', compact('translations'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('site.admin.translation.create');
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'lang' => 'required|string|max:191',
            'name' => 'required|string|max:191',
            'key' => 'required|string|max:191',
            'value' => 'required|string|max:191',
        ]);

        $translation = new Translation();
        $translation->name = $request->name;
        $translation->key = $request->key;
        $translation->lang = $request->lang;
        $translation->value = $request->value;

        $translation->save();

//        alert()->success(translate('Translation saved successfully.'), translate('Save translation'))
//            ->confirmButton(translate('OK'))->autoclose('1000');
        return redirect()->route('translation.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Translation $translation)
    {
        return view('site.admin.translation.edit', compact(['translation']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'lang' => 'required|string|max:191',
            'name' => 'required|string|max:191',
            'key' => 'required|string|max:191',
            'value' => 'required|string|max:191',
        ]);



        $translation = Translation::findOrFail($id);

        $translation->name = $request->name;
        $translation->key = $request->key;
        $translation->lang = $request->lang;
        $translation->value = $request->value;

        $translation->update();

        alert()->success(translate('Translation edited successfully'), translate('Edit the translation'))
            ->confirmButton(translate('OK'))->autoclose('3000');
        return redirect()->route('translation.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Translation $translation)
    {

        $translation->delete();

        alert()->success(translate('Translation successfully removed'),
            translate('Remove translation'))->confirmButton(translate('OK'))->autoclose('3000');
        return back();
    }
}
