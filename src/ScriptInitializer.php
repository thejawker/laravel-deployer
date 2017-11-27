<?php

namespace TheJawker\Deployer;

class ScriptInitializer extends BaseBashCommand implements BashCommand
{
    public function run(): void
    {
        $this->newLine();
        $this->largeComment('Runs the command and checks if it failed or not. Will add to the errors if it failed.');
        $this->code(
"run_command() {
    output=$($1 2>&1)

    if [ $? -ne 0 ]; then
        errors=\${errors}\"$1=>==\$output~@~@~\"
    fi

    echo $1
    echo \${output}
}"
        );
        $this->newLine();
        $this->comment("The error bag, this is where output of failed commands is stored.");
        $this->code("errors=\"\"");
    }
}