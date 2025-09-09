<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Services\LookupDbServices;
use Illuminate\Http\Request;

class LookupGetInfo extends Controller
{
    protected LookupDbServices $lookupService;
    

    public function __construct(LookupDbServices $lookupService)
    {
        $this->lookupService = $lookupService;
    }

    //
    public function getDefaultCategory(Request $request): JsonResponse
    {
        $categories = $this->lookupService->getCategories();
        return response()->json($categories);
    }

    //
    public function getDefaultRegions(Request $request): JsonResponse
    {
        $regions = $this->lookupService->getRegions();
        return response()->json($regions);
    }

}
