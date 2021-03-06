define(
  ["./react-es6","./PropTypes","exports"],
  function(__dependency1__, __dependency2__, __exports__) {
    "use strict";
    /** @jsx React.DOM */

    var React = __dependency1__["default"];
    var PropTypes = __dependency2__["default"];


    var Row = React.createClass({displayName: 'Row',
      propTypes: {
        componentClass: PropTypes.componentClass
      },

      getDefaultProps: function () {
        return {
          componentClass: React.DOM.div
        };
      },

      render: function () {
        var componentClass = this.props.componentClass;

        return this.transferPropsTo(
          componentClass( {className:"row"}, 
            this.props.children
          )
        );
      }
    });

    __exports__["default"] = Row;
  });