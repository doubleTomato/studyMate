<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\StudyService;


class StudyController extends Controller
{
    protected $studyService;

    public function __construct(StudyService $studyService)
    {
        $this->studyService = $studyService;
    }

    public function getOrderList(Request $request)
    {
        $filters = $request->only([
            'category', 'region', 'active', 'search', 'sort', 'pagination'
        ]);

        $study = $this->studyService->getOrderList($filters);

        // return response()->json($data);
        return view('common._list', compact('study'))->render();
    }
}
