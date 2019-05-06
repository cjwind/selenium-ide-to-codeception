#!/bin/bash

if ! test -d .git; then
    echo "Execute dev-scripts/install-git-hook.sh in the top-level directory."
    exit 1
fi

ln -sf ../../dev-scripts/pre-commit.hook .git/hooks/pre-commit || exit 1
chmod +x .git/hooks/pre-commit || exit 1

echo "Git commit hooks are installed."