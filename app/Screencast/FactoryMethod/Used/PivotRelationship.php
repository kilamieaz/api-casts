<?php

namespace App\Screencast\FactoryMethod\Used;

use App\Screencast\FactoryMethod\Supports\PivotSupport;

class PivotRelationship
{
    public static function connecting($product)
    {
        $support = new PivotSupport($product);
        $support->connect();
    }

    public static function disconnecting($product)
    {
        $support = new PivotSupport($product);
        $support->disconnect();
    }
}
