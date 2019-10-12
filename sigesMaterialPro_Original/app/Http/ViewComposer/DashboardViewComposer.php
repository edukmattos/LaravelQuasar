<?php

namespace App\Http\ViewComposer;

use Illuminate\View\View;

class DashboardViewComposer
{
    public function compose(View $view)
    {
        if (auth()->check()) 
        {
            $view->with('companies', auth()->user()->companies);
        }
    }
}