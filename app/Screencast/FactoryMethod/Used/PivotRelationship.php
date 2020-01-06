<?php

namespace App\Screencast\FactoryMethod\Used;

use App\Screencast\FactoryMethod\Creators\PivotCreator;

class PivotRelationship
{
    public static function connecting(PivotCreator $support)
    {
        $support->connect();
    }

    public static function disconnecting(PivotCreator $support)
    {
        $support->disconnect();
    }
}
