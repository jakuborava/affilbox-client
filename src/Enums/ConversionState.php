<?php

namespace JakubOrava\AffilboxClient\Enums;

enum ConversionState: string
{
    case Waiting = 'waiting';
    case Rejection = 'rejection';
    case Authorized = 'authorized';
    case Invoiced = 'invoiced';
}
