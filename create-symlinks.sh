#!/bin/bash

. .env # Load environment variables from .env file

# If PROJECT_DIR doesn't exist, exit with an error.

if [ ! -d "$PROJECT_DIR" ]; then
	echo "Error: Project directory  does not exist."
	exit 1
fi

# Function to create a symlink only if it doesn't already exist

create_symlink() {
    local target="$1"
    local link_name="$2"

    # Check if the symlink already exists
    if [ -e "$link_name" ] || [ -L "$link_name" ]; then
        echo "Symlink already exists: $link_name"
    else
        echo "Creating symlink: $link_name -> $target"
        ln -s "$target" "$link_name"
    fi
}

# Ensure we're in the correct directory
cd "$PROJECT_DIR" || exit 1

# Symlink ./web/app/themes/sage to ./sage
create_symlink "$PROJECT_DIR/web/app/themes/sage" "$PROJECT_DIR/sage"

# Symlink ./sage/public/.vite to ./sage/public/build
if [ -d "$PROJECT_DIR/sage/public" ]; then
    create_symlink "$PROJECT_DIR/sage/public/.vite" "$PROJECT_DIR/sage/public/build"
else
    echo "Warning: $PROJECT_DIR/sage/public directory does not exist"
fi

# Create ./sage/scripts/ directory if it doesn't exist
if [ ! -d "$PROJECT_DIR/sage/scripts" ]; then
    echo "Creating directory: /sage/scripts"
    mkdir -p "/sage/scripts"
fi

# Create symlink to public/assets in public/build

create_symlink "$PROJECT_DIR/sage/public/assets" "$PROJECT_DIR/sage/public/build/assets"

echo "Creating symlink to public/build/assets"

# Symlink create-symlinks.sh to ./sage/scripts/create-symlinks.sh
create_symlink "$PROJECT_DIR/create-symlinks.sh" "$PROJECT_DIR/sage/scripts/create-symlinks.sh"

# Symlink .env to ./sage/.env
create_symlink "$PROJECT_DIR/.env" "$PROJECT_DIR/sage/.env"

# Symlink pint.sh to ./sage/scripts/pint.sh
create_symlink "$PROJECT_DIR/pint.sh" "$PROJECT_DIR/sage/scripts/pint.sh"

# Symlink plugins in ./manually-installed-plugins dir to ./web/app/plugins

find "$PROJECT_DIR/manually-installed-plugins" -mindepth 1 -maxdepth 1 -type d | while read -r plugin_dir; do
    plugin_name=$(basename "$plugin_dir")
    create_symlink "$plugin_dir" "$PROJECT_DIR/web/app/plugins/$plugin_name"
done

echo "Symlinks created successfully!" 