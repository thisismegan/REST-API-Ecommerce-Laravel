<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AlertFailed extends Component
{

    public function render()
    {
        return view('auth.components.alert-failed');
    }
}
