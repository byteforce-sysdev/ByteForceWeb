<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Home index view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        return view(
            'home.index',
            [ "partners" => [0,1,2,3,4,5] ]     // TODO: Placeholder Data
        );
    }

    // TODO: Implement this
    public function createContactUsMessage(Request $request) {
        return true;
    }
}
