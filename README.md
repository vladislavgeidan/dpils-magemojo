# dpils-magemojo

Local Setup: 

1. Set COMPOSER_AUTH on your machine (you can obtain credentials using Magento2 Marketplace)

export COMPOSER_AUTH='{"http-basic":{"repo.magento.com": {"username": "USERNAME", "password": "PASSWORD"}}}'

2. Generate selfsigned ssl certificates with

make cert

3. Pull the infrastructure

docker-compose -f docker-compose.yml -f docker-compose.local.yml -f docker-compose.ssl.yml pull

4. Run the infrastructure

docker-compose -f docker-compose.yml -f docker-compose.local.yml -f docker-compose.ssl.yml up -d


