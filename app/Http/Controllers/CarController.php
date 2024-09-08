<?php

namespace App\Http\Controllers;

use App\Http\Requests\CarRequest;
use App\Http\Resources\CarResource;
use App\Models\Car;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        $cars = Car::query()->paginate(request('per_page') ?? 3);

        return CarResource::collection($cars);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CarRequest $request): CarResource
    {
        $imagePath = null;
        $data = $request->validated();

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imagePath = $request->file('image')->store('public');
        }

        $data['image'] = $imagePath;

        $car = Car::create($data);

        return new CarResource($car);
    }

    /**
     * Display the specified resource.
     */
    public function show(Car $car): CarResource
    {
        return new CarResource($car);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CarRequest $request, Car $car): CarResource
    {
        $data = $request->all();

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            Storage::delete($car->image);
            $imagePath = $request->file('image')->store('public');
            $data['image'] = $imagePath;
        }

        $car->update($data);

        return new CarResource($car);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car): JsonResponse
    {
        if ($car->image) {
            Storage::delete($car->image);
        }

        $car->delete();

        return response()->json([
            'message' => 'Car deleted successfully!'
        ]);
    }
}
