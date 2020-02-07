# Scandiweb LocaleResolver Fix

Some modules are depending on locale resolver on the installation, that crashes installation process if DB is not 
initialized (empty).
