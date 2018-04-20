/**
 * This file is part of the LoginAs extension
 *
 * Copyright (c) 2017 Andrey Panyush
 */

var LoginAs = function(config) {
    config = config || {};
    LoginAs.superclass.constructor.call(this, config);
};
Ext.extend(LoginAs, Ext.Component, {
    window: {},
    combo: {},
    config: {}
});
Ext.reg('loginas', LoginAs);

LoginAs = new LoginAs();