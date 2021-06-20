<?php

namespace App\Validator;

use App\Entity\Booking;
use App\Repository\BookingRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class BookingPeriodValidator extends ConstraintValidator
{
    public function __construct(
        private BookingRepository $bookingRepository
    ){}
    
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof BookingPeriod) {
            throw new UnexpectedTypeException($constraint, BookingPeriod::class);
        }

        if (!$value instanceof Booking) {
            throw new UnexpectedValueException($value, Booking::class);
        }

        if (!empty($this->bookingRepository->findOverlap($value))){
            $this->context->buildViolation($constraint->message)
                ->setParameters([
                    '{{ start }}' => $value->getStart()->format('d/m/Y H:i:s'),
                    '{{ finish }}' => $value->getFinish()->format('d/m/Y H:i:s'),
                ])
                ->addViolation()
            ;
        }
    }
}
