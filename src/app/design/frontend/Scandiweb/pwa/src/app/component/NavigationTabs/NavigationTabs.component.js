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

import NavigationAbstract from 'Component/NavigationAbstract/NavigationAbstract.component';
import './NavigationTabs.style';
import isMobile from 'Util/Mobile';

export const HOME_TAB = 'HOME_TAB';
export const MENU_TAB = 'MENU_TAB';
export const ACCOUNT_TAB = 'ACCOUNT_TAB';
export const CART_TAB = 'CART_TAB';
export const CHECKOUT_TAB = 'CHECKOUT_TAB';

class NavigationTabs extends NavigationAbstract {
    defaultStateName = MENU_TAB;

    stateMap = {
        [HOME_TAB]: {
            home: true
        },
        [MENU_TAB]: {
            menu: true
        },
        [ACCOUNT_TAB]: {
            account: true
        },
        [CART_TAB]: {
            minicart: true
        }
    };

    renderMap = {
        home: this.renderHomeButton.bind(this),
        menu: this.renderMenuButton.bind(this),
        minicart: this.renderMinicartButton.bind(this),
        account: this.renderAccountButton.bind(this)
    };

    renderHomeButton(isActive = false) {
        const { onHomeButtonClick } = this.props;

        return (
            <button
              key="home"
              block="NavigationTabs"
              elem="Button"
              aria-label="Home"
              onClick={ onHomeButtonClick }
            >
                <div
                  block="Header"
                  elem="Button"
                  mix={ { block: 'NavigationTabs', elem: 'Icon', mods: { isActive } } }
                  mods={ { type: 'home', isVisible: true } }
                />
            </button>
        );
    }

    renderMenuButton(isActive = false) {
        const { onMenuButtonClick } = this.props;

        return (
            <button
              key="menu"
              block="NavigationTabs"
              elem="Button"
              aria-label="Go to menu and search"
              onClick={ onMenuButtonClick }
            >
                <div
                  block="Header"
                  elem="Button"
                  mix={ { block: 'NavigationTabs', elem: 'Icon', mods: { isActive } } }
                  mods={ { isVisible: true, type: 'menu' } }
                />
            </button>
        );
    }

    renderAccountButton(isActive = false) {
        const { onMyAccountButtonClick } = this.props;

        return (
            <button
              key="account"
              block="NavigationTabs"
              elem="Button"
              onClick={ onMyAccountButtonClick }
              aria-label="Open my account"
            >
                <div
                  block="Header"
                  elem="Button"
                  mix={ { block: 'NavigationTabs', elem: 'Icon', mods: { isActive } } }
                  mods={ { isVisible: true, type: 'account' } }
                />
            </button>
        );
    }

    renderMinicartItemsQty() {
        const { cartTotals: { items_qty } } = this.props;

        if (!items_qty) {
            return null;
        }

        return (
            <span
              aria-label="Items in cart"
              block="Header"
              elem="MinicartItemCount"
            >
                { items_qty }
            </span>
        );
    }

    renderMinicartButton(isActive = false) {
        const { onMinicartButtonClick } = this.props;

        return (
            <button
              key="mincart"
              block="NavigationTabs"
              elem="Button"
              onClick={ onMinicartButtonClick }
              aria-label="Minicart"
            >
                <div
                  block="Header"
                  elem="Button"
                  mix={ { block: 'NavigationTabs', elem: 'Icon', mods: { isActive } } }
                  mods={ { isVisible: true, type: 'minicart' } }
                >
                    { this.renderMinicartItemsQty() }
                </div>
            </button>
        );
    }

    render() {
        const { navigationState: { isHidden } } = this.props;

        if (!isMobile.any()) {
            return null;
        }

        return (
            <footer block="NavigationTabs" mods={ { isHidden } }>
                <nav block="NavigationTabs" elem="Nav">
                    { this.renderNavigationState() }
                </nav>
            </footer>
        );
    }
}

export default NavigationTabs;
