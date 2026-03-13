<?php

namespace App\Http\Controllers;

use App\Models\Vaccine;
use Illuminate\Http\Request;

class VaccineController extends Controller
{
    public function index(Request $request)
    {
        $query = Vaccine::query();
        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('type', 'like', '%' . $request->search . '%');
        }
        $vaccines = $query->latest()->get();
        return view('doctor.vaccines', compact('vaccines'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'type'         => 'required|in:Birth,6 weeks,10 weeks,14 weeks,9 months,12 months',
            'stock'        => 'required|integer|min:0',
            'price'        => 'required|numeric|min:0',
            'manufacturer' => 'required|string|max:255',
            'description'  => 'nullable|string',
        ]);

        Vaccine::create([
            'name'         => $request->name,
            'type'         => $request->type,
            'stock'        => $request->stock,
            'price'        => $request->price,
            'manufacturer' => $request->manufacturer,
            'description'  => $request->description,
            'active'       => $request->has('active'),
        ]);

        return redirect()->route('doctor.vaccines')->with('success', 'Vaccine added successfully.');
    }

    public function edit(Vaccine $vaccine)
    {
        return view('doctor.vaccines-edit', compact('vaccine'));
    }

    public function update(Request $request, Vaccine $vaccine)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'type'         => 'required|in:Birth,6 weeks,10 weeks,14 weeks,9 months,12 months',
            'stock'        => 'required|integer|min:0',
            'price'        => 'required|numeric|min:0',
            'manufacturer' => 'required|string|max:255',
            'description'  => 'nullable|string',
        ]);

        $vaccine->update([
            'name'         => $request->name,
            'type'         => $request->type,
            'stock'        => $request->stock,
            'price'        => $request->price,
            'manufacturer' => $request->manufacturer,
            'description'  => $request->description,
            'active'       => $request->has('active'),
        ]);

        return redirect()->route('doctor.vaccines')->with('success', 'Vaccine updated successfully.');
    }

    public function destroy(Vaccine $vaccine)
    {
        $vaccine->delete();
        return redirect()->route('doctor.vaccines')->with('success', 'Vaccine deleted.');
    }
}
