import { PureComponent, createRef } from 'react';
import PropTypes from 'prop-types';
import './SharedTransition.style';

export const SHARED_ELEMENT_TRANSITION = 250;

class SharedTransition extends PureComponent {
    static propTypes = {
        state: PropTypes.shape({
            startingPosition: PropTypes.shape({
                width: PropTypes.number,
                height: PropTypes.number,
                left: PropTypes.number,
                top: PropTypes.number
            }),
            destinationPosition: PropTypes.shape({
                width: PropTypes.number,
                height: PropTypes.number,
                left: PropTypes.number,
                top: PropTypes.number
            }),
            sharedElementDestination: PropTypes.object,
            sharedElement: PropTypes.object
        }).isRequired,
        cleanUpTransition: PropTypes.func.isRequired
    };

    sharedContainer = createRef();

    animationSpeed = SHARED_ELEMENT_TRANSITION;

    setDestinationTransform = this.setTransform.bind(this, 'destinationPosition');

    setStartingTransform = this.setTransform.bind(this, 'startingPosition');

    componentDidUpdate() {
        if (this.transitionInAction) return;
        this.updateSharedElement();
    }

    setTransform(key) {
        const {
            state: {
                [key]: {
                    width,
                    height,
                    left,
                    top
                }
            }
        } = this.props;

        this.sharedContainer.current.style.cssText = `
            --shared-element-width: ${width}px;
            --shared-element-height: ${height}px;
            --shared-element-top: ${top}px;
            --shared-element-left: ${left}px;
            --shared-element-animation-speed: ${this.animationSpeed}ms;
        `;
    }

    cleanUpTransition = () => {
        const { current: wrapper } = this.sharedContainer;
        const { cleanUpTransition } = this.props;

        const range = document.createRange();
        range.selectNodeContents(wrapper);
        range.deleteContents();

        this.transitionInAction = false;
        cleanUpTransition();
    };

    updateSharedElement() {
        const {
            state: {
                sharedElementDestination,
                sharedElement
            }
        } = this.props;

        const { current: wrapper } = this.sharedContainer;

        if (
            !sharedElement
            || !sharedElementDestination
            || !wrapper
        ) return;

        this.transitionInAction = true;
        this.setStartingTransform();
        wrapper.appendChild(sharedElement);
        setTimeout(this.setDestinationTransform, 0);
        setTimeout(this.cleanUpTransition, this.animationSpeed);
    }

    render() {
        const { state: { sharedElement } } = this.props;

        return (
            <div
              block="SharedTransition"
              mods={ { isVisible: !!sharedElement } }
              ref={ this.sharedContainer }
            />
        );
    }
}

export default SharedTransition;
