<?php
/**
 * Created by PhpStorm.
 * User: thejawker
 * Date: 11/27/17
 * Time: 4:49 PM
 */

namespace TheJawker\Deployer;


interface BashCommand
{
    /**
     * Turns the command to a bash executable.
     *
     * @return string
     */
    public function handle(): string;

    /**
     * Is run before handled.
     *
     * @return void
     */
    public function run(): void;
}