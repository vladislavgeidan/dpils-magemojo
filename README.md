# Welcome to ScandiPWA
[![Docker Cloud Build Status](https://img.shields.io/docker/cloud/build/scandipwa/base.svg)](https://hub.docker.com/r/scandipwa/base)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/d90631c26cab4c459180a57a2b1268dc)](https://www.codacy.com/app/ScandiPWA/scandipwa-base?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=scandipwa/scandipwa-base&amp;utm_campaign=Badge_Grade)

This repository is a base repository that contains Docker environment for Magento ^2.3 and is dedicated for ScandiPWA
 theme development and ScandiPWA based project development.

## Demo
You can easily access demo simply clicking [here](https://demo.scandipwa.com)

## Docs
Project docs are available on [docs.scandipwa.com](https://docs.scandipwa.com/#/)
 
## Docker
For Docker details please refer to [Docker](./DOCKER.md)

## Theme
For ScandiPWA Theme details please refer to [theme repository](https://github.com/scandipwa/base-theme)


## Modularity
The repository is based on Magento 2.3. All components and modules, except the further theme development must be 
managed by [Composer](https://getcomposer.org)

## Dependencies
-   [scandipwa/installer](https://github.com/scandipwa/installer)
-   [scandipwa/source](https://github.com/scandipwa/base-theme)
-   [scandipwa/graphql](https://github.com/scandipwa/graphql)
-   [scandipwa/catalog-graphql](https://github.com/scandipwa/catalog-graphql)
-   [scandipwa/cms-graphql](https://github.com/scandipwa/cms-graphql)
-   [scandipwa/menu-organizer](https://github.com/scandipwa/menu-organizer)
-   [scandipwa/persisted-query](https://github.com/scandipwa/persisted-query)
-   [scandipwa/slider-graphql](https://github.com/scandipwa/slider-graphql)
-   [scandipwa/slider](https://github.com/scandipwa/slider)
-   [scandipwa/route171](https://github.com/scandipwa/route717)
-   [scandiweb/module-core](https://github.com/scandiwebcom/Scandiweb-Assets-Core)

## Quick start
1.  Make sure [requirements](https://docs.scandipwa.com/#/docker/A-requirements) are met
2.  Clone the repository
```console
git clone git@github.com:scandipwa/scandipwa-base.git
```
3.  Set `COMPOSER_HOME` on your machine (you can obtain credentials using [Magento2 Marketplace](https://account.magento.com/applications/customer/login/))
```console
export COMPOSER_AUTH='{"http-basic":{"repo.magento.com": {"username": "REPLACE_THIS", "password": "REPLACE_THIS"}}}'
```

4.  Generate selfsigned ssl certificates with (more details [here](https://docs.scandipwa.com/#/docker/G-SSL-container) )
```console
make cert
```

5.  Pull and run the infrastructure
```console
docker-compose -f docker-compose.yml -f docker-compose.local.yml -f docker-compose.ssl.yml pull
``` 
```console
docker-compose -f docker-compose.yml -f docker-compose.local.yml -f docker-compose.ssl.yml up -d
```

> **NOTICE**: Do the following steps only in case you need ScandiPWA DEMO

6.  Stop the application container 
```console
docker-compose stop app
```
7.  Recreate existing database 
```console
docker-compose exec mysql mysql -u root -pscandipwa -e "DROP DATABASE magento; CREATE DATABASE magento;"
```
8.  Import DEMO ScandiPWA database: 
```console
docker-compose exec -T mysql mysql -u root -pscandipwa magento < deploy/latest.sql
```
9.  Recreate Docker infrastructure
```console
docker-compose -f docker-compose.yml -f docker-compose.local.yml -f docker-compose.ssl.yml up -d --force-recreate
```

## Media
1) Download [media](https://scandipwa-public-assets.s3-eu-west-1.amazonaws.com/2.2.x-media.tar.gz)

2) Put archive into the `src/pub/media` folder (if mounted)

3) Extract archive `tar -zxvf scandipwa_media.tgz`

## License
[![FOSSA Status](https://app.fossa.io/api/projects/git%2Bgithub.com%2Fscandipwa%2Fscandipwa-base.svg?type=large)](https://app.fossa.io/projects/git%2Bgithub.com%2Fscandipwa%2Fscandipwa-base?ref=badge_large)
