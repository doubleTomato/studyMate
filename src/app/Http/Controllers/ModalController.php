<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ModalController extends Controller
{
    public function withdrawalUser($id){
        return view('modal.withdrwawal', compact('id'));
    }

}
