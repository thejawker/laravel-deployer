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

    echo $1
    echo ${output}
}

run_command 'not anything -hh'
run_command 'git anything -hh'

echo ${errors}