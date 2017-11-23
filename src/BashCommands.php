<?php

namespace TheJawker\Deployer;

class BashCommands
{
    const SET_CURRENT_DIR = 'cd "$(dirname "$0")"';
    const ARTISAN_DOWN = 'php artisan down';
}