Quiz.window.CreateFormField=function(e){(e=e||{}).id||(e.id="quiz-field-window-create"),Ext.applyIf(e,{title:_("quiz_row_create"),action:"mgr/field/create"}),Quiz.window.CreateFormField.superclass.constructor.call(this,e)},Ext.extend(Quiz.window.CreateFormField,Quiz.window.Default,{getFields:function(e){return[{xtype:"hidden",name:"id",id:e.id+"-id"},{xtype:"hidden",name:"form_id",id:e.id+"-form_id"},{xtype:"hidden",name:"step_id",id:e.id+"-step_id"},{xtype:"hidden",name:"contact",id:e.id+"-contact"},{layout:"column",items:[{columnWidth:.3,layout:"form",defaults:{msgTarget:"under"},items:[{xtype:"quiz-combo-form-field-types",fieldLabel:_("quiz_field_type"),description:"<b>[[+type]]</b>",name:"type",hiddenName:"type",id:e.id+"-type",combo:e.combo,anchor:"100%",width:100,allowBlank:!1,listeners:{render:{fn:this.changeFields,scope:this},select:{fn:this.changeFields,scope:this}}}]},{columnWidth:.3,layout:"form",defaults:{msgTarget:"under"},items:[{xtype:"textfield",fieldLabel:_("quiz_field_name"),description:"<b>[[+name]]</b>",name:"name",id:e.id+"-name",anchor:"100%",width:100,allowBlank:!1},{xtype:"label",cls:"desc-under",text:_("quiz_field_name_desc"),id:Ext.id()}]},{columnWidth:.4,layout:"form",defaults:{msgTarget:"under"},items:[{xtype:"textfield",fieldLabel:_("quiz_field_classes"),description:"<b>[[+classes]]</b>",name:"classes",id:e.id+"-classes",anchor:"100%",width:100,allowBlank:!0}]}]},{layout:"column",items:[{columnWidth:.5,layout:"form",defaults:{msgTarget:"under"},items:[{xtype:"textfield",fieldLabel:_("quiz_field_placeholder"),description:"<b>[[+placeholder]]</b>",name:"placeholder",id:e.id+"-placeholder",anchor:"100%",width:100,allowBlank:!0}]},{columnWidth:.5,layout:"form",defaults:{msgTarget:"under"},items:[{xtype:"textfield",fieldLabel:_("quiz_field_label"),description:"<b>[[+label]]</b>",name:"label",id:e.id+"-label",anchor:"100%",width:100,allowBlank:!0}]}]},{xtype:"fieldset",title:_("quiz_field_value"),columnWidth:1,collapsible:!0,anchor:"99.5%",items:[{xtype:"textfield",fieldLabel:_("quiz_field_value"),description:"<b>[[+value]]</b>",name:"value",id:e.id+"-value",anchor:"100%",width:100,allowBlank:!0},{xtype:"quiz-grid-field_value",field_id:e.record?.id||0,id:e.id+"-field_value"},{xtype:"textfield",fieldLabel:_("quiz_field_default"),description:"<b>[[+default]]</b>",name:"default",id:e.id+"-default",anchor:"100%",width:100,allowBlank:!0}]},{xtype:"textarea",fieldLabel:_("quiz_field_content"),description:"<b>[[+content]]</b>",name:"content",height:100,id:e.id+"-content",anchor:"100%",width:100,allowBlank:!0,listeners:{afterrender:e=>{Quiz.utils.renderRTE(e)}}},{xtype:"textfield",fieldLabel:_("quiz_field_emailtitle"),description:"<b>[[+emailtitle]]</b>",name:"emailtitle",id:e.id+"-emailtitle",anchor:"100%",width:100,allowBlank:!0},{xtype:"checkboxgroup",hideLabel:!0,name:"checkboxgroup",columns:4,items:[{xtype:"xcheckbox",boxLabel:_("quiz_row_published"),description:"<b>[[+published]]</b>",name:"published",id:e.id+"-published",checked:!e.record||e.record.published},{xtype:"xcheckbox",boxLabel:_("quiz_field_required"),description:"<b>[[+required]]</b>",name:"required",id:e.id+"-required",checked:!e.record||e.record.required}]}]},changeFields:function(e,i){Ext.isEmpty(e.value)&&Ext.getCmp(this.id+"-type").setValue("text");var d=Ext.getCmp(this.id+"-value"),t=Ext.getCmp(this.id+"-field_value"),l=Ext.getCmp(this.id+"-content");switch(d.show(),l.show(),t.hide(),e.value){case"select":case"checkbox":case"radio":d.hide(),l.hide(),t.show()}}}),Ext.reg("quiz-field-window-create",Quiz.window.CreateFormField),Quiz.window.UpdateFormField=function(e){(e=e||{}).id||(e.id="quiz-field-window-update"),Ext.applyIf(e,{title:_("quiz_row_update")+": "+e.record.name,action:"mgr/field/update"}),Quiz.window.UpdateFormField.superclass.constructor.call(this,e)},Ext.extend(Quiz.window.UpdateFormField,Quiz.window.CreateFormField),Ext.reg("quiz-field-window-update",Quiz.window.UpdateFormField);