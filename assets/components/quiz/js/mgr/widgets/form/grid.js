Quiz.grid.Forms=function(i){(i=i||{}).id||(i.id="quiz-grid-forms"),Ext.applyIf(i,{baseParams:{action:"mgr/form/getlist",sort:"menuindex",dir:"asc"},ddAction:"mgr/form/sort",multi_select:!0}),Quiz.grid.Forms.superclass.constructor.call(this,i)},Ext.extend(Quiz.grid.Forms,Quiz.grid.Default,{getFields:function(){return["id","formname","published","actions"]},getColumns:function(){return[{header:_("quiz_grid_id"),dataIndex:"id",sortable:!0,width:75,fixed:!0},{header:_("quiz_form_formname"),dataIndex:"formname",sortable:!0,width:"auto"},{header:_("quiz_grid_active"),dataIndex:"published",renderer:Quiz.utils.renderBoolean,sortable:!0,width:75,fixed:!0},{header:_("quiz_grid_actions"),dataIndex:"actions",renderer:Quiz.utils.renderActions,sortable:!1,width:165,fixed:!0,id:"actions",hidden:"2"!==Quiz.config.modxversion}]}}),Ext.reg("quiz-grid-forms",Quiz.grid.Forms);