/**
 * This file is part of the LoginAs extension
 *
 * Copyright (c) 2017 Andrey Panyush
 */
LoginAs.window.GenerateToken = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'loginas-window-generate-token',
        title: _('loginas.window_generate_title'),
        url: LoginAs.config.connectorUrl,
        baseParams: {
            action: 'mgr/generate'
        },

        fields: [{
            xtype: 'hidden'
            ,name: 'user'
            ,value: config.params.user
        },{
            xtype: 'modx-combo-context'
            ,id: 'loginas-window-generate-token-context'
            ,name: 'context'
            ,fieldLabel: _('context')
            ,anchor: '100%'
        }],
        keys:[{
            key: Ext.EventObject.ENTER,
            shift: true,
            fn: this.submit,
            scope: this
        }]
    });
    LoginAs.window.GenerateToken.superclass.constructor.call(this,config);
};
Ext.extend(LoginAs.window.GenerateToken, MODx.Window);
Ext.reg('loginas-window-generate-token', LoginAs.window.GenerateToken);