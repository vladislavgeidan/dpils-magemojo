'use strict';

Object.defineProperty(exports, "__esModule", {
    value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

exports.default = debounceRender;

var _react = require('react');

var _react2 = _interopRequireDefault(_react);

var _debounce = require('lodash/debounce');

var _debounce2 = _interopRequireDefault(_debounce);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

function debounceRender(ComponentToDebounce) {
    for (var _len = arguments.length, debounceArgs = Array(_len > 1 ? _len - 1 : 0), _key = 1; _key < _len; _key++) {
        debounceArgs[_key - 1] = arguments[_key];
    }

    return function (_Component) {
        _inherits(DebouncedContainer, _Component);

        function DebouncedContainer() {
            var _ref;

            var _temp, _this, _ret;

            _classCallCheck(this, DebouncedContainer);

            for (var _len2 = arguments.length, args = Array(_len2), _key2 = 0; _key2 < _len2; _key2++) {
                args[_key2] = arguments[_key2];
            }

            return _ret = (_temp = (_this = _possibleConstructorReturn(this, (_ref = DebouncedContainer.__proto__ || Object.getPrototypeOf(DebouncedContainer)).call.apply(_ref, [this].concat(args))), _this), _this.updateDebounced = _debounce2.default.apply(undefined, [_this.forceUpdate].concat(debounceArgs)), _temp), _possibleConstructorReturn(_this, _ret);
        }

        _createClass(DebouncedContainer, [{
            key: 'shouldComponentUpdate',
            value: function shouldComponentUpdate() {
                this.updateDebounced();
                return false;
            }
        }, {
            key: 'componentWillUnmount',
            value: function componentWillUnmount() {
                this.updateDebounced.cancel();
            }
        }, {
            key: 'render',
            value: function render() {
                return _react2.default.createElement(ComponentToDebounce, this.props);
            }
        }]);

        return DebouncedContainer;
    }(_react.Component);
};