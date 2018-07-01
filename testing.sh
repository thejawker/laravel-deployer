#!/bin/bash

errors=""

#######
# Runs the command and checks if it failed or not.
# will add to the errors if it failed.
###
run_command() {
    output=$($1 2>&1)

    if [ $? -ne 0 ]; then
        errors=${errors}"$1=>==$output~@~@~"
    fi

    echo [running] $1':'
    echo -e ${output}
    echo -e '\n'
}

run_command 'echo something\n stuff'

echo ${errors}