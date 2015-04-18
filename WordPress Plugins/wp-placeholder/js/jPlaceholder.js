(function() {  
    tinymce.create('tinymce.plugins.placeholder', {  
        init : function(ed, url) {  
            ed.addButton('placeholder', {  
                title : 'Add an Image Placeholder',  
                image : url+'/favicon.png',  
                onclick : function() {  
                     ed.selection.setContent('[_p width="150" height="150" color="#cccccc" text="SAMPLE" align="none"]');  
  
                }  
            });  
        },  
        createControl : function(n, cm) {  
            return null;  
        },  
    });  
    tinymce.PluginManager.add('placeholder', tinymce.plugins.placeholder);  
})();
