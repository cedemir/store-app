<?php

namespace App\Enums;

enum OrderStatusEnum
{
    case WAITING_PAYMENT;
    case CUSTOMER_CANCELLED;
    case PAYMENT_CONFIRMED;

    public function color(): string
    {
        return match($this)
        {
            self::WAITING_PAYMENT => 'blue',
            self::CUSTOMER_CANCELLED => 'red',
            self::PAYMENT_CONFIRMED  => 'green'
        };
    }

    public function status(): string
    {
        return match($this)
        {
            self::WAITING_PAYMENT => 'Aguardando Pagamento',
            self::CUSTOMER_CANCELLED => 'Cancelado pelo Cliente',
            self::PAYMENT_CONFIRMED  => 'Pagamento Confirmado'
        };
    }
}
