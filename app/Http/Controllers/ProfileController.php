<?php

namespace App\Http\Controllers;

use App\Models\Profil;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $user   = Auth::user();
        $profil = $user->profil ?? Profil::create(['user_id' => $user->id]);
        return view('profile.edit', compact('user', 'profil'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name'             => 'required|string|max:255',
            'phone'            => 'nullable|string|max:20',
            'city'             => 'nullable|string|max:100',
            'bio'              => 'nullable|string|max:2000',
            'specialite'       => 'nullable|string|max:100',
            'tarif_jour'       => 'nullable|integer|min:0',
            'annees_experience'=> 'nullable|integer|min:0|max:50',
            'disponibilite'    => 'nullable|in:available,busy,unavailable',
            'competences'      => 'nullable|string',
            'github_url'       => 'nullable|url|max:255',
            'linkedin_url'     => 'nullable|url|max:255',
            'website_url'      => 'nullable|url|max:255',
        ]);

        $user->update([
            'name'  => $request->name,
            'phone' => $request->phone,
            'city'  => $request->city,
        ]);

        if ($user->isDeveloper()) {
            $competences = [];
            if ($request->filled('competences')) {
                $competences = array_filter(array_map('trim', explode(',', $request->competences)));
            }

            $profil = $user->profil ?? Profil::create(['user_id' => $user->id]);
            $profil->update([
                'bio'               => $request->bio,
                'specialite'        => $request->specialite,
                'tarif_jour'        => $request->tarif_jour,
                'annees_experience' => $request->annees_experience,
                'disponibilite'     => $request->disponibilite ?? 'available',
                'competences'       => array_values($competences),
                'github_url'        => $request->github_url,
                'linkedin_url'      => $request->linkedin_url,
                'website_url'       => $request->website_url,
            ]);
        }

        return back()->with('success', 'Profil mis à jour avec succès !');
    }

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $user   = Auth::user();
        $profil = $user->profil ?? Profil::create(['user_id' => $user->id]);

        if ($profil->photo) {
            Storage::disk('public')->delete($profil->photo);
        }

        $path = $request->file('photo')->store('avatars', 'public');
        $profil->update(['photo' => $path]);

        return back()->with('success', 'Photo de profil mise à jour !');
    }

    // ── Services ─────────────────────────────────────────────
    public function services()
    {
        $user     = Auth::user();
        $services = $user->services()->orderBy('created_at', 'desc')->get();
        return view('profile.services', compact('user', 'services'));
    }

    public function storeService(Request $request)
    {
        $request->validate([
            'titre'       => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'prix'        => 'required|integer|min:1000',
            'delai'       => 'nullable|string|max:100',
            'categorie'   => 'nullable|string|max:100',
        ]);

        Auth::user()->services()->create($request->only('titre','description','prix','delai','categorie'));

        return back()->with('success', 'Service ajouté avec succès !');
    }

    public function updateService(Request $request, int $id)
    {
        $service = Service::where('user_id', Auth::id())->findOrFail($id);
        $request->validate([
            'titre'       => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'prix'        => 'required|integer|min:1000',
            'delai'       => 'nullable|string|max:100',
            'categorie'   => 'nullable|string|max:100',
        ]);
        $service->update($request->only('titre','description','prix','delai','categorie'));
        return back()->with('success', 'Service mis à jour !');
    }

    public function destroyService(int $id)
    {
        $service = Service::where('user_id', Auth::id())->findOrFail($id);
        $service->delete();
        return back()->with('success', 'Service supprimé.');
    }
}
