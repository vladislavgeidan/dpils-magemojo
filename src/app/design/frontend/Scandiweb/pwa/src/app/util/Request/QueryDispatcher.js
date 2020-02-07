/* eslint-disable no-unused-vars */
/**
 * ScandiPWA - Progressive Web App for Magento
 *
 * Copyright © Scandiweb, Inc. All rights reserved.
 * See LICENSE for license details.
 *
 * @license OSL-3.0 (Open Software License ("OSL") v. 3.0)
 * @package scandipwa/base-theme
 * @link https://github.com/scandipwa/base-theme
 */

import { listenForBroadCast, executeGet } from 'Util/Request/Request';
import { prepareQuery, Field } from 'Util/Query';
import { makeCancelable } from 'Util/Promise';

export const ONE_MONTH_IN_SECONDS = 2592000;

/**
 * Abstract request dispatcher.
 * IMPORTANT: it is required to implement `prepareRequest(options)` before using!
 * @class QueryDispatcher
 */
class QueryDispatcher {
    /**
     * Creates an instance of QueryDispatcher.
     * @param  {String} name Name of model for ServiceWorker to send BroadCasts updates to
     * @param  {Number} cacheTTL Cache TTL (in seconds) for ServiceWorker to cache responses
     * @memberof QueryDispatcher
     */
    constructor(name, cacheTTL = ONE_MONTH_IN_SECONDS) {
        this.name = name;
        this.cacheTTL = cacheTTL;
        this.promise = null;
    }

    /**
     * Is responsible for request routing and manages `onError`, `onSuccess`, `onUpdate` functions triggers.
     * @param  {Function} dispatch Store changing function from Redux (dispatches actions)
     * @param  {any} options Any options received from Container
     * @return {void}@memberof QueryDispatcher
     */
    handleData(dispatch, options) {
        const { name, cacheTTL } = this;
        const rawQueries = this.prepareRequest(options, dispatch);
        const queries = rawQueries instanceof Field ? [rawQueries] : rawQueries;

        if (this.promise) this.promise.cancel();

        this.promise = makeCancelable(
            new Promise((resolve, reject) => {
                executeGet(prepareQuery(queries), name, cacheTTL)
                    .then(
                        data => resolve(data),
                        error => reject(error)
                    );
            })
        );

        this.promise.promise.then(
            data => this.onSuccess(data, dispatch, options),
            error => this.onError(error, dispatch, options),
        );

        listenForBroadCast(name).then(
            data => this.onUpdate(data, dispatch, options),
        );
    }

    /**
     * Is triggered by BroadCast updated from ServiceWorker.
     * Should dispatch some action.
     * @param  {any} data Data received from fetch of GraphQL endpoint
     * @param  {Function} dispatch Store changing function from Redux (dispatches actions)
     * @return {void}
     * @memberof QueryDispatcher
     */
    onUpdate(data, dispatch, options) {
        this.onSuccess(data, dispatch, options);
    }

    /**
     * Is responsible for request building (request & mutation preparation)
     * @param  {any} options Any options received from Container
     * @param {Function} dispatch
     * @return {Array<Field>|Field} Array or single item of Field instances
     * @memberof QueryDispatcher
     */
    prepareRequest(options, dispatch) {}

    /**
     * Is triggered on successful fetch of GraphQL endpoint.
     * IMPORTANT: If there are any errors in response (`errors` field in JSON response from GraphQL), this function won't trigger!
     * Should dispatch some action.
     * @param  {any} data
     * @param  {any} dispatch
     * @return {void}@memberof QueryDispatcher
     */
    onSuccess(data, dispatch) {}

    /**
     * Is triggered on error in fetch of GraphQL endpoint.
     * IMPORTANT: If there are any errors in response (`errors` field in JSON response from GraphQL), this function will trigger!
     * Should dispatch some action.
     * @param  {any} error
     * @param  {any} dispatch
     * @return {void}@memberof QueryDispatcher
     */
    onError(error, dispatch) {}
}

export default QueryDispatcher;
