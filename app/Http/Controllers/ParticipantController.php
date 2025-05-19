<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage ;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ParticipantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $participants = Participant::all();
        return Inertia::render('Admin/Participant/Index', [
            'participants' => $participants,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Participant/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $image = $request->file('image');
        $imageName = Str::uuid()->toString().'.'.$image->getClientOriginalExtension();
        $image->storeAs('participants', $imageName, 'public');

        Participant::create([
            'name' => $request->name,
            'image' => $imageName,
        ]);

        return redirect()->route('participants.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return Inertia::render('Admin/Participant/Create', [
            'participant' => Participant::findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $participant = Participant::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if($request->hasFile('image')){
            if($participant->image && Storage::disk('public')->exists('participants/'.$participant->image)){
                Storage::disk('public')->delete('participants/'.$participant->image);
            }
            $image = $request->file('image');
            $imageName = Str::uuid()->toString().'.'.$image->getClientOriginalExtension();
            $image->storeAs('participants', $imageName, 'public');
            $participant->image = $imageName;
        }

        $participant->name = $request->name;
        $participant->update();

        return redirect()->route('participants.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $participant = Participant::findOrFail($id);

        if($participant->image && Storage::disk('public')->exists('participants/'.$participant->image)){
            Storage::disk('public')->delete('participants/'.$participant->image);
        }
        $participant->delete();

        return redirect()->route('participants.index');
    }
}
