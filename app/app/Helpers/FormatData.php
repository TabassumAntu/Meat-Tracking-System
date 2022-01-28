<?php
namespace App\Helpers;

trait FormatData {
    public function getClassName($class): String
    {
       return (new \ReflectionClass($class))->getShortName();
    }
}
