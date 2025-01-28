<?php

namespace App\Controller;

use App\DTO\CreateVehicleRequest;
use App\DTO\AddressRequest;
use App\DTO\UpdateVehicleRequest;
use App\DTO\VehicleResponse;
use App\Service\VehicleService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use OpenApi\Annotations as OA;

#[Route('/api/vehicles')]
class VehicleController
{
  private VehicleService $vehicleService;

  public function __construct(VehicleService $vehicleService)
  {
    $this->vehicleService = $vehicleService;
  }

  /**
   * @OA\Get(
   *     path="/api/vehicles",
   *     summary="Retrieve a list of vehicles",
   *     description="Returns a list of all vehicles in the database.",
   *     @OA\Response(
   *         response=200,
   *         description="List of vehicles",
   *         @OA\JsonContent(
   *             type="array",
   *             @OA\Items(ref="#/components/schemas/VehicleResponse")
   *         )
   *     )
   * )
   */
  #[Route('', methods: ['GET'])]
  public function index(Request $request): JsonResponse
  {
    $brand = $request->query->get('brand');
    $isRented = $request->query->get('isRented');

    $vehicles = $this->vehicleService->getFilteredVehicles($brand, $isRented);
    $response = array_map(fn($vehicle) => VehicleResponse::fromEntity($vehicle), $vehicles);

    return new JsonResponse($response);
  }

  /**
   * @OA\Post(
   *     path="/api/vehicles",
   *     summary="Create a new vehicle",
   *     description="Adds a new vehicle to the database.",
   *     @OA\RequestBody(
   *         required=true,
   *         @OA\JsonContent(ref="#/components/schemas/CreateVehicleRequest")
   *     ),
   *     @OA\Response(
   *         response=201,
   *         description="Vehicle created",
   *         @OA\JsonContent(ref="#/components/schemas/VehicleResponse")
   *     ),
   *     @OA\Response(
   *         response=400,
   *         description="Validation error",
   *         @OA\JsonContent(
   *             type="object",
   *             @OA\Property(property="errors", type="string")
   *         )
   *     )
   * )
   */
  #[Route('', methods: ['POST'])]
  public function create(Request $request, ValidatorInterface $validator): JsonResponse
  {
    $data = json_decode($request->getContent(), true);

    $createRequest = new CreateVehicleRequest();
    $createRequest->brand = $data['brand'] ?? null;
    $createRequest->registrationNumber = $data['registrationNumber'] ?? null;
    $createRequest->vin = $data['vin'] ?? null;
    $createRequest->email = $data['email'] ?? null;
    $createRequest->isRented = $data['isRented'] ?? false;
    $createRequest->currentLocation = $data['currentLocation'] ?? null;

    if (isset($data['address'])) {
      $addressRequest = new AddressRequest();
      $addressRequest->street = $data['address']['street'] ?? null;
      $addressRequest->city = $data['address']['city'] ?? null;
      $addressRequest->postalCode = $data['address']['postalCode'] ?? null;
      $addressRequest->country = $data['address']['country'] ?? null;

      $createRequest->address = $addressRequest;
    } else {
      $createRequest->address = null;
    }

    $errors = $validator->validate($createRequest);
    if (count($errors) > 0) {
      return new JsonResponse(['errors' => (string) $errors], 400);
    }

    $vehicle = $this->vehicleService->createVehicle($createRequest);

    return new JsonResponse(VehicleResponse::fromEntity($vehicle), 201);
  }
  /**
   * @OA\Put(
   *     path="/api/vehicles/{id}",
   *     summary="Update an existing vehicle",
   *     description="Updates the details of an existing vehicle.",
   *     @OA\Parameter(
   *         name="id",
   *         in="path",
   *         required=true,
   *         description="ID of the vehicle to update",
   *         @OA\Schema(type="integer")
   *     ),
   *     @OA\RequestBody(
   *         required=true,
   *         @OA\JsonContent(ref="#/components/schemas/UpdateVehicleRequest")
   *     ),
   *     @OA\Response(
   *         response=200,
   *         description="Vehicle updated",
   *         @OA\JsonContent(ref="#/components/schemas/VehicleResponse")
   *     ),
   *     @OA\Response(
   *         response=404,
   *         description="Vehicle not found"
   *     )
   * )
   */
  #[Route('/{id}', methods: ['PUT'])]
  public function update(int $id, Request $request, ValidatorInterface $validator): JsonResponse
  {
    $data = json_decode($request->getContent(), true);

    $updateRequest = new UpdateVehicleRequest();
    $updateRequest->brand = $data['brand'] ?? null;
    $updateRequest->registrationNumber = $data['registrationNumber'] ?? null;
    $updateRequest->vin = $data['vin'] ?? null;
    $updateRequest->email = $data['email'] ?? null;

    if (isset($data['address'])) {
      $addressRequest = new AddressRequest();
      $addressRequest->street = $data['address']['street'] ?? null;
      $addressRequest->city = $data['address']['city'] ?? null;
      $addressRequest->postalCode = $data['address']['postalCode'] ?? null;
      $addressRequest->country = $data['address']['country'] ?? null;

      $updateRequest->address = $addressRequest;
    }

    $updateRequest->isRented = $data['isRented'] ?? false;
    $updateRequest->currentLocation = $data['currentLocation'] ?? null;

    $errors = $validator->validate($updateRequest);
    if (count($errors) > 0) {
      return new JsonResponse(['errors' => (string) $errors], 400);
    }

    $vehicle = $this->vehicleService->updateVehicle($id, $updateRequest);

    if (!$vehicle) {
      return new JsonResponse(['error' => 'Pojazd nie został znaleziony'], 404);
    }

    return new JsonResponse(VehicleResponse::fromEntity($vehicle));
  }

  /**
   * @OA\Delete(
   *     path="/api/vehicles/{id}",
   *     summary="Delete a vehicle",
   *     description="Deletes a vehicle from the database.",
   *     @OA\Parameter(
   *         name="id",
   *         in="path",
   *         required=true,
   *         description="ID of the vehicle to delete",
   *         @OA\Schema(type="integer")
   *     ),
   *     @OA\Response(
   *         response=200,
   *         description="Vehicle deleted"
   *     ),
   *     @OA\Response(
   *         response=404,
   *         description="Vehicle not found"
   *     )
   * )
   */
  #[Route('/{id}', methods: ['DELETE'])]
  public function delete(int $id): JsonResponse
  {
    $success = $this->vehicleService->deleteVehicle($id);

    if (!$success) {
      return new JsonResponse(['error' => 'Vehicle not found'], 404);
    }

    return new JsonResponse(['status' => 'Vehicle deleted']);
  }

  /**
   * @OA\Get(
   *     path="/api/vehicles/{id}",
   *     summary="Retrieve a specific vehicle by ID",
   *     description="Returns a single vehicle based on its ID.",
   *     @OA\Parameter(
   *         name="id",
   *         in="path",
   *         required=true,
   *         description="ID of the vehicle to retrieve",
   *         @OA\Schema(type="integer")
   *     ),
   *     @OA\Response(
   *         response=200,
   *         description="Vehicle details",
   *         @OA\JsonContent(ref="#/components/schemas/VehicleResponse")
   *     ),
   *     @OA\Response(
   *         response=404,
   *         description="Vehicle not found"
   *     )
   * )
   */
  #[Route('/{id}', methods: ['GET'])]
  public function getVehicleById(int $id): JsonResponse
  {
    if (!$id) {
      return new JsonResponse(['error' => 'Brak identyfikatora pojazdu'], 400);
    }

    $vehicle = $this->vehicleService->findVehicleById($id);

    if (!$vehicle) {
      return new JsonResponse(['error' => 'Pojazd nie został znaleziony'], 404);
    }

    return new JsonResponse(VehicleResponse::fromEntity($vehicle), 200);
  }

  /**
   * @OA\Patch(
   *     path="/api/vehicles/{id}/location",
   *     summary="Update the current location of a vehicle",
   *     description="Updates the current location of the vehicle in the system.",
   *     @OA\Parameter(
   *         name="id",
   *         in="path",
   *         required=true,
   *         description="Vehicle ID",
   *         @OA\Schema(type="integer")
   *     ),
   *     @OA\RequestBody(
   *         required=true,
   *         @OA\JsonContent(
   *             @OA\Property(property="currentLocation", type="string")
   *         )
   *     ),
   *     @OA\Response(
   *         response=200,
   *         description="Location updated",
   *         @OA\JsonContent(ref="#/components/schemas/VehicleResponse")
   *     ),
   *     @OA\Response(
   *         response=404,
   *         description="Vehicle not found"
   *     )
   * )
   */
  #[Route('/{id}/location', methods: ['PATCH'])]
  public function updateLocation(int $id, Request $request): JsonResponse
  {
    $data = json_decode($request->getContent(), true);
    $newLocation = $data['currentLocation'] ?? null;

    if (!$newLocation) {
      return new JsonResponse(['error' => 'Current location is required.'], 400);
    }

    $vehicle = $this->vehicleService->updateVehicleLocation($id, $newLocation);

    if (!$vehicle) {
      return new JsonResponse(['error' => 'Vehicle not found.'], 404);
    }

    return new JsonResponse(VehicleResponse::fromEntity($vehicle), 200);
  }
}
