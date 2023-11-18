# APT Build

This repository holds scripts and snippets I use for building [MoonLite DEB package and APT repository](https://github.com/igor-moonlite/moonlite).

1) `build/lite-build.sh` is the primary builder that fetches [MoonLite source](https://github.com/igor-moonlite/moonlite) and converts it into a complete package.

2) `build/file-build.sh` fetches [MoonFile source](https://github.com/igor-moonlite/moonfile) and builds a package.

Among other things, the builder scripts adjust language constants of IFrame App module to turn it into Calendar, add a number of visual elements to webmail templates (widgets & iframes) and remove unnecessary content (e.g. any language except for English and Russian). 

The `content` directory is copied into the package AS IS. There is also `moonlite.php` script that is invoked when the package is installed via APT, it performs initial configuration (database setup, features tweaking, adding mailserver entry, placing "Powered By" text, etc.).

Each of the builder scripts create .DEB package in `out` directory and .ZIP archive in script's directory.

3) `repo.sh` creates initial directory structure for APT repository, then takes all the packages which are there in `out` directory and adds them to repository; lastly, signs the packages and the repository itself.

4) `upload.sh` copies the ready-to-use repository to its actual location, e.g. `/var/www/apt`, and also copies ZIP archives to `/download` folder.
