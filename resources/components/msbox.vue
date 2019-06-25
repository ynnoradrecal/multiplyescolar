<!-- #TEMPLATE -->
<template 
    lang="html">

    <!-- mensagem box -->
    <div class="compose col-md-6 col-xs-12" style="display: none;">
        <div class="compose-header">
            Mensagem
            <button type="button" class="close compose-close">
          <span>×</span>
        </button>
        </div>

        <div class="compose-body">
            <div id="alerts"></div>

            <div class="btn-toolbar editor" data-role="editor-toolbar" data-target="#editor">
                <div class="btn-group">
                    <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font"><i class="fa fa-font"></i><b class="caret"></b></a>
                    <ul class="dropdown-menu">
                    </ul>
                </div>

                <div class="btn-group">
                    <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font Size"><i class="fa fa-text-height"></i>&nbsp;<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a data-edit="fontSize 5">
                                <p style="font-size:17px">Huge</p>
                            </a>
                        </li>
                        <li>
                            <a data-edit="fontSize 3">
                                <p style="font-size:14px">Normal</p>
                            </a>
                        </li>
                        <li>
                            <a data-edit="fontSize 1">
                                <p style="font-size:11px">Small</p>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="btn-group">
                    <a class="btn" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="fa fa-bold"></i></a>
                    <a class="btn" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="fa fa-italic"></i></a>
                    <a class="btn" data-edit="strikethrough" title="Strikethrough"><i class="fa fa-strikethrough"></i></a>
                    <a class="btn" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i class="fa fa-underline"></i></a>
                </div>

                <div class="btn-group">
                    <a class="btn" data-edit="insertunorderedlist" title="Bullet list"><i class="fa fa-list-ul"></i></a>
                    <a class="btn" data-edit="insertorderedlist" title="Number list"><i class="fa fa-list-ol"></i></a>
                    <a class="btn" data-edit="outdent" title="Reduce indent (Shift+Tab)"><i class="fa fa-dedent"></i></a>
                    <a class="btn" data-edit="indent" title="Indent (Tab)"><i class="fa fa-indent"></i></a>
                </div>

                <div class="btn-group">
                    <a class="btn btn-info" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="fa fa-align-left"></i></a>
                    <a class="btn" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="fa fa-align-center"></i></a>
                    <a class="btn" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i class="fa fa-align-right"></i></a>
                    <a class="btn" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i class="fa fa-align-justify"></i></a>
                </div>

                <div class="btn-group">
                    <a class="btn dropdown-toggle" data-toggle="dropdown" title="Hyperlink"><i class="fa fa-link"></i></a>
                    <div class="dropdown-menu input-append">
                        <input class="span2" placeholder="URL" data-edit="createLink" type="text">
                        <button class="btn" type="button">Add</button>
                    </div>
                    <a class="btn" data-edit="unlink" title="Remove Hyperlink"><i class="fa fa-cut"></i></a>
                </div>

            </div>

            <div id="editor" class="editor-wrapper placeholderText" contenteditable="true"></div>
        </div>

        <div class="compose-footer">
            <button id="send" class="btn btn-md btn-primary" type="button"><span class="fa fa-send-o"></span> Enviar</button>
        </div>
    </div>

</template>
<!-- #SCRIPT -->
<script>

export default {

    data() {
        return {
            
        }
    },

    mounted() {
        this.init_wysiwyg();
        this.init_compose();
    },

    methods: {
        init_compose() {

            if( typeof ($.fn.slideToggle) === 'undefined'){ return; }
			console.log('init_compose');
		
			jQuery('#compose, .compose-close').click(function(event){
                event.preventDefault()
				jQuery('.compose').slideToggle();
			});
        },

        init_wysiwyg() {
			
            if( typeof ($.fn.wysiwyg) === 'undefined'){ return; }
		    console.log('init_wysiwyg');	
		

            jQuery('.editor-wrapper').each(function(){
                var id = jQuery(this).attr('id');	//editor-one
                console.log(id)
                jQuery(this).wysiwyg({
                    toolbarSelector: '[data-target="#' + id + '"]',
                });	
            });
	
        }
    }

}

</script>
<!-- #STYLE -->
<style>
#editor { height: 200px; padding: 10px; }
.compose .compose-header{
    background: #009cde;
    padding: 10px 10px;
}
</style>