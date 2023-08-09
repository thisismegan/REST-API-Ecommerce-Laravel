<?php

namespace App\View\Components;

use Illuminate\View\Component;

class InputGroup extends Component
{

    public function __construct(
        public string $labelName,
        public string $for
    ) {
        //
    }


    public function render()
    {

        return view('components.input-group');
    }
}
