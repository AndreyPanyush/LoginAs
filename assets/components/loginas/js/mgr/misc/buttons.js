/**
 * This file is part of the LoginAs extension
 *
 * Copyright (c) 2017 Andrey Panyush
 */
Ext.namespace('LoginAs.button');

LoginAs.button.Modal = function(config) {
    config = config || {};
    Ext.apply(config,{
        text: _('loginas.modal_button'),
        handler: function(btn, e) {
        },
        listeners: {
            'click': {
                fn: function(btn, e) {
                    var r = {};
                    r.context = MODx.config['default_context'];
                    this.loadWindow(btn, e, {
                        xtype: 'loginas-window-generate-token',
                        record: r,
                        params: config.params,
                        listeners: {
                            'success': {
                                fn: function (r, s) {
                                    if(r.a && r.a.result) Ext.MessageBox.prompt(_('loginas.modal_success_title'), _('loginas.modal_success_message', {'ttl': MODx.config['loginas.token_ttl']}), null, null, true, r.a.result.message);
                                }, scope: this
                            }
                        }
                    });
                },
                scope: this
            }
        }
    });
    LoginAs.button.Modal.superclass.constructor.call(this, config);
};
Ext.extend(LoginAs.button.Modal, Ext.Button, {
    handler: function() {
        console.log(222);
    },
    loadWindow: function(btn, e, win) {
        Ext.applyIf(win,{
            grid: this,
            listeners: {
                'success': {
                    fn: win.success || this.refresh,
                    scope: win.scope || this
                }
            }
        });
        LoginAs.window[win.xtype] = Ext.ComponentMgr.create(win);
        LoginAs.window[win.xtype].show(e.target);
    }
});
Ext.reg('loginas-button-modal', LoginAs.button.Modal);