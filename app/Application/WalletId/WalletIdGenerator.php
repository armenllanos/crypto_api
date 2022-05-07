<?php

namespace App\Application\WalletId;

class WalletIdGenerator implements IdGenerator
{

    public function generateId():String
    {
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';

        return substr(str_shuffle($permitted_chars), 0, 10);
    }
}
