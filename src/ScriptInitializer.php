<?php

namespace TheJawker\Deployer;

class ScriptInitializer extends BaseBashCommand implements BashCommand
{
    public function run(): void
    {
        $this->newLine();
        $this->largeComment('Initializer Section');
        $this->newLine();
        $this->comment("The error bag, this is where output of failed commands is stored.");
        $this->code("ERRORS=\"\"");
        $this->newLine();
        $this->comment('Runs the command and checks if it failed or not. Will add to the errors if it failed.');
        $this->code(
"run_command() {
    output=$($1 2>&1)

    if [ $? -ne 0 ]; then
        ERRORS=\${ERRORS}\"$1=>==\$output~@~@~\"
    fi

    echo [running] $1':'
    echo -e \${output}
    echo -e 'n'
}"
        );
        $this->comment("Timestamp to check how long the process took.");
        $this->code('TIMESTAMP=$(php -r "echo microtime(true);")');
        $this->newLine();
        $this->loadConfigCommands('deploy.commands.initialize');
    }
}