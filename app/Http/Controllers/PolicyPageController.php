<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CmsPage;

class PolicyPageController extends Controller
{
    public function index(Request $request)
    {
        //$user = Auth::user();
        $policies = CmsPage::orderBy('cms_page_id', 'asc')->get();

        return  $policies;
    }
}
