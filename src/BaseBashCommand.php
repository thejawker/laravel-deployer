<?php

namespace TheJawker\Deployer;

class BaseBashCommand
{
    public $bash;

    public function __construct()
    {
        $this->bash = collect();
    }

    /**
     * Turns the command to a bash executable.
     *
     * @return string
     */
    public function handle(): string
    {
        if ($this instanceof BashCommand) {
            $this->run();
        }
        return $this->bash->implode("\n");
    }

    protected function largeComment($title)
    {
        $title = <<<EOF
#######
# $title
####
EOF;

        $this->bash->push($title);

        return $title;
    }

    protected function comment($comment)
    {
        $this->bash->push("# $comment");
    }

    protected function code($string)
    {
        $this->bash->push($string);
    }

    protected function newLine()
    {
        $this->bash->push("\n");
    }
}