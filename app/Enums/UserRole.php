<?php

namespace App\Enums;

enum UserRole: string
{
    case Donante = 'donante';
    case Admin = 'admin';
    case Centro = 'centro';
}
