<?php
namespace App\Services\Payments;

interface PaymentInterface
{
    public function doPayment(array $data): array;
}
