/**
 * editor_plugin_src.js
 *
 * Copyright 2009, Moxiecode Systems AB
 * Released under LGPL License.
 *
 * License: http://tinymce.moxiecode.com/license
 * Contributing: http://tinymce.moxiecode.com/contributing
 */

(function() {
	tinymce.PluginManager.requireLangPack("Ybrowser");
	tinymce.create('tinymce.plugins.YbrowserPlugin', {
		init : function(ed, url) {
			// Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mcebrowser');
			ed.addCommand('mceYbrowser', function() {
				ed.windowManager.open({
					file : url + '/index.php',
					width : 850 + parseInt(ed.getLang('Ybrowser.delta_width', 0)),
					height : 550 + parseInt(ed.getLang('Ybrowser.delta_height', 0)),
					inline : 0,
					resizable :false
				}, {
					plugin_url : url // Plugin absolute URL
				});
			});

			// Register Ybrowser button
			ed.addButton('Ybrowser', {
				title : 'Ybrowser.desc',
				cmd : 'mceYbrowser',
				image : url + '/img/Ybrowser.gif'
			});
		},

		getInfo : function() {
			return {
				longname : 'Ybrowser plugin',
				author : 'YISI',
				authorurl : 'http://www.yiqicms.com',
				infourl : 'http://wiki.moxiecode.com/index.php/TinyMCE:Plugins/Ybrowser',
				version : "1.0"
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('Ybrowser', tinymce.plugins.YbrowserPlugin);
})();