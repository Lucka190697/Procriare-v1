<?php

namespace App\Http\Controllers;

use App\Services\AnimalServices;
use App\Http\Requests\CioRequest;
use App\Models\AnimalHeat;
use App\Repositories\CioRepository;
use App\Models\Animal;
use Illuminate\Support\Facades\Request;


class AnimalHeatController extends Controller
{
    private $paginate = 10;

    public function index()
    {
        $title = 'Cio';
        $animals = Animal::all();

        $cios = AnimalHeat::paginate($this->paginate);
        return view('animals.flock.cios.index', ['cios' => $cios], compact('title', 'animals'));
    }

    public function create(Animal $animal, $id)
    {
        $title = 'Create new Animal';
        $animals = Animal::find($id);
        $flock = Animal::all();

        return view('animals.flock.cios.create', compact('animals', 'flock', 'title'));
    }

    public function store(CioRequest $request, AnimalHeat $animalHeat, AnimalServices $services)
    {
        $title = 'create-cio';
        $data = $request->all();
        $data = $services->managementFather($request, $data);
        $data = $services->status($request, $data);
        $data = $services->partoPrevisto($request, $data);
        $data = $services->create_by($request, $data);

//        $cios = AnimalHeat::create($data);
        $animalHeat->create($data);

        $mensagem = $request->mensagem;
        $request->session()->flash('alert-warning', 'Cio Atualizado !',
            'alert-danger', 'Oops! não foi possível atuaizar!');

        return redirect()->route('cio.index')->with($title);
    }

    public function edit(AnimalHeat $animalHeat, $id)
    {
        $title = 'Edit Cio';
        $cios = AnimalHeat::find($id);
        $animals = Animal::all();

        return view('animals.flock.cios.edit', compact('cios', 'animals', 'title'));
    }

    public function update(CioRequest $cioRequest, AnimalServices $animalServices,
                           Request $request, AnimalHeat $animalHeat, $id)
    {
        $title = 'edit-cio';
        $cios = AnimalHeat::find($id);
        $data = $cioRequest->all();
        $data = $animalServices->updatePartoPrevisto($request, $data);
        $data = $animalServices->status($request, $data);
        $data = $animalServices->create_by($request, $data);

        $cios->update($data);

        $mensagem = $cioRequest->mensagem;
        $cioRequest->session()->flash('alert-warning', 'Cio Atualizado !',
            'alert-danger', 'Oops! não foi possível atuaizar!');

        return redirect()->route('cio.index')->with($title);
    }

    public function show($id)
    {
        $title = 'Show Cio Details';
        $cios = AnimalHeat::find($id)->all();
        $animals = Animal::find($id)->all();
        foreach ($cios as $cio)
            $cio->id;
        foreach ($animals as $animal)
            $animal->profile;
        return view('animals.flock.cios.show', compact('cio', 'title', 'animal'));
    }
}
