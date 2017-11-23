<?php

namespace TheJawker\Deployer;

class DeployScriptGenerator
{
    public static function asString()
    {
        return self::bashHeader();
    }

    private static function bashHeader()
    {
        return "#!/bin/bash";
    }
}