<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class BookingPeriod extends Constraint
{
    public $message = 'Le créneau de "{{ start }}" au "{{ finish }}" est déjà pris.';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
