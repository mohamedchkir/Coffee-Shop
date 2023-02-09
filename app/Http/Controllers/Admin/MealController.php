<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MealStoreRequest;
use App\Models\Meal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class MealController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $meals = Meal::all();
        return view('admin.meals.index', ["meals" => $meals]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.meals.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MealStoreRequest $request)
    {
        $request->validate([
            'image'      => 'required|mimes:jpg,png,jpeg',
            'name'     => 'required',
            'description'   => 'required',
            'prix'         => 'required',

        ], [
            'image.required' => 'Please Input Plat image',
            'name.required' => 'Please Input Plat name',
            'description.required' => 'Please Input Plat description',
            'prix.required' => 'Please Input Plat price'

        ]);

        $plat_image = $request->file('image');
        $name_gen = hexdec(uniqid());
        $img_ext = strtolower($plat_image->getClientOriginalExtension());
        $img_name = $name_gen . '.' . $img_ext;
        $location = 'img/meals/';
        $last_img = $location . $img_name;
        $plat_image->move($location, $img_name);

        $store = Meal::insert([
            'image' => $last_img,
            'name' => $request->name,
            'description' => $request->description,
            'prix' => $request->prix,
            'created_at' => Carbon::now(),
        ]);

        return Redirect()->back()->with('success', 'Plat Inserted Successfull');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Meal $meal)
    {
        return view('admin.meals.edit', compact('meal'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Meal $meal)
    {
        $request->validate([
            'name' => 'required',
            'prix' => 'required',
            'description' => 'required',
        ]);

        $image = $meal->image;
        if ($request->file('image')) {
            Storage::delete($meal->image);
            $image = $request->file('image')->move('public/meals');
        } else {
            $meal->update([
                'name' => $request->name,
                'description' => $request->description,
                'prix' => $request->prix,
                'image' => $image
            ]);
        }
        return redirect()->route('admin.meals.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Meal $meal)
    {
        Storage::delete($meal->image);
        $meal->delete();
        return to_route('admin.meals.index');
    }
}
