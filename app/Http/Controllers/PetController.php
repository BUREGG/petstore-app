<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PetController extends Controller
{
    private $baseUrl = 'https://petstore.swagger.io/v2/';

    public function index()
    {
        $status = request('status', 'available');

        try {
            $response = Http::get($this->baseUrl . 'pet/findByStatus', [
                'status' => $status
            ]);

            if ($response->failed()) {
                Log::error('Nie udało się pobrać zwierząt według statusu', ['response' => $response->body()]);
                return view('pets.index')->with('error', 'Nie udało się pobrać zwierząt.');
            }

            $pets = $response->json();
            return view('pets.index', compact('pets'));

        } catch (\Exception $e) {
            Log::error('Wystąpił wyjątek podczas pobierania zwierząt', ['exception' => $e]);
            return view('pets.index')->with('error', 'Wystąpił błąd podczas pobierania zwierząt.');
        }
    }

    public function show($id)
    {
        try {
            $response = Http::get($this->baseUrl . "pet/{$id}");

            if ($response->failed()) {
                $error = $response->json();
                Log::error('Nie udało się pobrać szczegółów.', ['response' => $response->body()]);
                return redirect()->route('pets.index')->with('error', $error['message'] ?? 'Nie znaleziono');
            }

            $pet = $response->json();
            return view('pets.show', compact('pet'));

        } catch (\Exception $e) {
            Log::error('Wystąpił wyjątek podczas pobierania szczegółów.', ['exception' => $e]);
            return redirect()->route('pets.index')->with('error', 'Wystąpił błąd podczas pobierania szczegółów.');
        }
    }

    public function create()
    {
        return view('pets.create');
    }

    public function store(Request $request)
    {
        try {
            $response = Http::post($this->baseUrl . 'pet', $request->all());

            if ($response->failed()) {
                Log::error('Błąd podczas dodawania', ['response' => $response->body()]);
                return redirect()->back()->with('error', 'Błąd podczas dodawania.');
            }

            return redirect()->route('pets.index')->with('success', 'Pomyślnie dodano!');

        } catch (\Exception $e) {
            Log::error('Wystąpił wyjątek podczas dodawania', ['exception' => $e]);
            return redirect()->back()->with('error', 'Wystąpił błąd podczas dodawania.');
        }
    }

    public function edit($id)
    {
        try {
            $response = Http::get($this->baseUrl . "pet/{$id}");

            if ($response->failed()) {
                Log::error('Nie udało się pobrać szczegółów do edycji', ['response' => $response->body()]);
                return redirect()->route('pets.index')->with('error', 'Nie udało się pobrać szczegółów.');
            }

            $pet = $response->json();
            return view('pets.edit', compact('pet'));

        } catch (\Exception $e) {
            Log::error('Wystąpił wyjątek podczas pobierania szczegółów do edycji', ['exception' => $e]);
            return redirect()->route('pets.index')->with('error', 'Wystąpił błąd podczas pobierania szczegółów do edycji.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $response = Http::put($this->baseUrl . 'pet', array_merge($request->all(), ['id' => $id]));

            if ($response->failed()) {
                Log::error('Nie udało się zaktualizować', ['response' => $response->body()]);
                return redirect()->back()->with('error', 'Nie udało się zaktualizować.');
            }

            return redirect()->route('pets.index')->with('success', 'Pomyślnie zaktualizowano!');

        } catch (\Exception $e) {
            Log::error('Wystąpił wyjątek podczas aktualizacji', ['exception' => $e]);
            return redirect()->back()->with('error', 'Wystąpił błąd podczas aktualizacji.');
        }
    }

    public function destroy($id)
    {
        try {
            $response = Http::delete($this->baseUrl . "pet/{$id}");

            if ($response->failed()) {
                Log::error('Nie udało się usunąć', ['response' => $response->body()]);
                return redirect()->back()->with('error', 'Nie udało się usunąć.');
            }

            return redirect()->route('pets.index')->with('success', 'Pomyślnie usunięte!');

        } catch (\Exception $e) {
            Log::error('Wystąpił wyjątek podczas usuwania', ['exception' => $e]);
            return redirect()->back()->with('error', 'Wystąpił błąd podczas usuwania.');
        }
    }
}
