# ScandiPWA Cache

Provides granular cache control for ScandiPWA.

## Requirements
`scandipwa/persisted-query`: "^1.0"

## Cache markdown
Utilizes default Magento 2 cache control mechanism over `X-Magento-Tags-Pattern` header.

Provides `AddTagsToResponsePlugin` to add entity headers to each GraphQl cacheable response.

Utilizes custom `Cache` entity (singleton), to gather all entities, that were loaded during current request.

Flush happens based on default `cache_flush` events for most entities.

CMS pages has own event observers to track response/flush.
