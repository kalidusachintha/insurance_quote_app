<?php

use App\Livewire\QuoteForm;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(QuoteForm::class)
        ->assertStatus(200);
});
