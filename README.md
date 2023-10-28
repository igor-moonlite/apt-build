# APT Build

This repository holds scripts and snippets I use for building [MoonLite DEB package and APT repository](https://github.com/igor-moonlite/moonlite).

You can run `all.sh` script to perform the complete chain of operations, or run the script individially:

1) `build/build.sh` is the primary builder that fetches [MoonLite source](https://github.com/igor-moonlite/moonlite) and converts it into a complete package. 

Among other things, the builder adjusts language constants of IFrame App module to turn it into Calendar, adds a number of additional visual element to webmail templates (widgets & iframes) and removes unnecessary content (e.g. any language except for English and Russian). 

The `content` directory is copied into the package AS IS. There is also `moonlite.php` script that is invoked when the package is installed via APT, it performs initial configuration (database setup, features tweaking, adding mailserver entry, placing "Powered By" text, etc.).

The script creates .DEB package in `out` directory, as well as .ZIP archive in the current one.

2) `make.sh` creates initial directory structure for APT repository.
3) `repo.sh` takes all the packages which are there in `out` directory and adds them to repository.
4) `sign.sh` as the name suggests, signs the packages and the repository itself.
5) `upload.sh` simply copies the ready-to-use repository to its actual location, e.g. `/var/www/apt`.
