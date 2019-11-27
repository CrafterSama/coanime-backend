@if(Request::segment(3) == 'create' || Request::segment(4) == 'edit')

    @php /*This code replaces the Form - Froala Editor
Javascript Widget. Please verify that the HTML, CSS and JS Tabs of this same widget are empty before adding this code. This
code goes in the Javascript section of the widget. Option to set the size of uploaded files in Megabytes (eg: 1, 2, 5) */
    $fileUploadSize = 1;
    $froalaVersion = '2.8.0';
    $codeMirrorVersion = '5.30.0';
    $siteName = 'coanime.net';
    if (Request::segment(2) == 'posts'):
        $folder = '/images/posts/';
    elseif(Request::segment(2) == 'events'):
        $folder = '/images/events/';
    endif;
    @endphp
<link href="//cdnjs.cloudflare.com/ajax/libs/froala-editor/{{$froalaVersion}}/css/froala_editor.min.css" rel="stylesheet"
    type="text/css">
<link href="//cdnjs.cloudflare.com/ajax/libs/froala-editor/{{$froalaVersion}}/css/froala_style.min.css" rel="stylesheet"
    type="text/css">
<link href="//cdnjs.cloudflare.com/ajax/libs/froala-editor/{{$froalaVersion}}/css/plugins/char_counter.min.css" rel="stylesheet"
    type="text/css">
<link href="//cdnjs.cloudflare.com/ajax/libs/froala-editor/{{$froalaVersion}}/css/plugins/code_view.min.css" rel="stylesheet"
    type="text/css">
<link href="//cdnjs.cloudflare.com/ajax/libs/froala-editor/{{$froalaVersion}}/css/plugins/colors.min.css" rel="stylesheet"
    type="text/css">
<link href="//cdnjs.cloudflare.com/ajax/libs/froala-editor/{{$froalaVersion}}/css/plugins/image.min.css" rel="stylesheet"
    type="text/css">
<link href="//cdnjs.cloudflare.com/ajax/libs/froala-editor/{{$froalaVersion}}/css/plugins/image_manager.min.css" rel="stylesheet"
    type="text/css">
<link href="//cdnjs.cloudflare.com/ajax/libs/froala-editor/{{$froalaVersion}}/css/plugins/line_breaker.min.css" rel="stylesheet"
    type="text/css">
<link href="//cdnjs.cloudflare.com/ajax/libs/froala-editor/{{$froalaVersion}}/css/plugins/table.min.css" rel="stylesheet"
    type="text/css">
<link href="//cdnjs.cloudflare.com/ajax/libs/froala-editor/{{$froalaVersion}}/css/plugins/fullscreen.min.css" rel="stylesheet"
    type="text/css">
<link href="//cdnjs.cloudflare.com/ajax/libs/froala-editor/{{$froalaVersion}}/css/plugins/video.min.css" rel="stylesheet"
    type="text/css">
<link href="//cdnjs.cloudflare.com/ajax/libs/froala-editor/{{$froalaVersion}}/css/plugins/draggable.min.css" rel="stylesheet"
    type="text/css">
<link href="//cdnjs.cloudflare.com/ajax/libs/froala-editor/{{$froalaVersion}}/css/third_party/embedly.min.css" rel="stylesheet"
    type="text/css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/<?=$codeMirrorVersion?>/codemirror.min.css">

<script src="//cdnjs.cloudflare.com/ajax/libs/froala-editor/{{$froalaVersion}}/js/froala_editor.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/froala-editor/{{$froalaVersion}}/js/plugins/code_view.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/froala-editor/{{$froalaVersion}}/js/plugins/table.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/froala-editor/{{$froalaVersion}}/js/plugins/colors.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/froala-editor/{{$froalaVersion}}/js/plugins/font_family.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/froala-editor/{{$froalaVersion}}/js/plugins/font_size.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/froala-editor/{{$froalaVersion}}/js/plugins/paragraph_style.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/froala-editor/{{$froalaVersion}}/js/plugins/image.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/froala-editor/{{$froalaVersion}}/js/plugins/video.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/froala-editor/{{$froalaVersion}}/js/plugins/image_manager.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/froala-editor/{{$froalaVersion}}/js/plugins/file.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/froala-editor/{{$froalaVersion}}/js/plugins/draggable.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/froala-editor/{{$froalaVersion}}/js/plugins/char_counter.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/froala-editor/{{$froalaVersion}}/js/plugins/fullscreen.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/froala-editor/{{$froalaVersion}}/js/plugins/align.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/froala-editor/{{$froalaVersion}}/js/plugins/link.min.js"></script>
{{--
<script src="//cdnjs.cloudflare.com/ajax/libs/froala-editor/{{$froalaVersion}}/js/plugins/url.min.js"></script> --}}
<script src="//cdnjs.cloudflare.com/ajax/libs/froala-editor/{{$froalaVersion}}/js/plugins/lists.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/froala-editor/{{$froalaVersion}}/js/plugins/paragraph_format.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/froala-editor/{{$froalaVersion}}/js/third_party/embedly.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/{{$codeMirrorVersion}}/codemirror.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/{{$codeMirrorVersion}}/mode/xml/xml.min.js"></script>
<script>
    $.FroalaEditor.ICON_TEMPLATES = {
            font_awesome: '<i class="fa fa-[NAME]"></i>',
        }
        $.FroalaEditor.DefineIcon('tweet', {NAME: 'twitter'});
        $.FroalaEditor.DefineIcon('sinopsis', {NAME: 'quote-left'});
        $.FroalaEditor.RegisterCommand('sinopsis', {
            title: 'Sinopsis',
            focus: true,
            undo: true,
            refreshAfterCallback: true,
            callback: function () {
                this.html.insert("<fieldset class='sinopsis'><legend>Sinopsis</legend><p>" + this.selection.ranges() + "</p></fieldset>");
            }
        });
        $('#froala-editor').froalaEditor({
        minHeight: '550',
        height: '550',
        maxHeight: '550',
        toolbarSticky: false,
        dragInline: true,
        videoResize: true,
        videoMove: true,
        videoDefaultAlign: 'center',
        videoDefaultDisplay: 'inline',
        videoInsertButtons: ['videoBack', '|', 'videoByURL', 'videoEmbed'],
        videoTextNear: true,
        imageMove: true,
        imageSplitHTML: true,
        imageDefaultDisplay: 'block',
        imagePaste: true,
        imageDefaultWidth: 0,
        imageAllowedTypes: ['jpeg', 'jpg', 'png', 'pdf', 'gif'],
        imageAltButtons: ["display", "align", "linkImage", "replaceImage", "removeImage"],
        fileAllowedTypes: ['*'],
        fileMaxSize: {{$fileUploadSize}} * 1024 * 1024,
        codeMirrorOptions: {
          indentWithTabs: true,
          lineNumbers: true,
          lineWrapping: true,
          mode: 'text/html',
          tabMode: 'indent',
          tabSize: 4
        },
        imageUploadURL: 'https://coanime.net/api/v1/post-image-upload',
        key: 'kKC1KXDF1INBh1KPe2TK==',
        toolbarButtons:   ["bold", "italic", "underline", "fontSize", "fontFamily", "color", "paragraphFormat", "inlineStyle", "align", "outdent", "indent", "formatOL", "formatUL", "sinopsis", "paragraphStyle", "createLink", "insertHR", "insertLink", "insertTable", 'embedly', "insertImage", "insertVideo", "undo", "html"],
        toolbarButtonsMD: ["bold", "italic", "underline", "fontSize", "fontFamily", "color", "paragraphFormat", "inlineStyle", "align", "outdent", "indent", "formatOL", "formatUL", "sinopsis", "paragraphStyle", "createLink", "insertHR", "insertLink", "insertTable", 'embedly', "insertImage", "insertVideo", "undo", "html"],
        toolbarButtonsSM: ["bold", "italic", "underline", "fontSize", "fontFamily", "color", "paragraphFormat", "inlineStyle", "align", "outdent", "indent", "formatOL", "formatUL", "sinopsis", "paragraphStyle", "createLink", "insertHR", "insertLink", "insertTable", 'embedly', "insertImage", "insertVideo", "undo", "html"],
        toolbarButtonsXS: ["bold", "italic", "underline", "fontSize", "fontFamily", "color", "paragraphFormat", "inlineStyle", "align", "outdent", "indent", "formatOL", "formatUL", "sinopsis", "paragraphStyle", "createLink", "insertHR", "insertLink", "insertTable", 'embedly', "insertImage", "insertVideo", "undo", "html"]
        }).on('froalaEditor.drop', function (e, editor, dropEvent) {
        // Focus at the current posisiton.
            editor.markers.insertAtPoint(dropEvent.originalEvent);
            var $marker = editor.$el.find('.fr-marker');
            $marker.replaceWith($.FroalaEditor.MARKERS);
            editor.selection.restore();

            // Save into undo stack the current position.
            if (!editor.undo.canDo()) editor.undo.saveStep();

            // Insert HTML.

            // Save into undo stack the changes.
            editor.undo.saveStep();

            // Stop event propagation.
            dropEvent.preventDefault();
            dropEvent.stopPropagation();
            return false;
        }).on('froalaEditor.image.error', function (e, editor, error, response) {
            // Bad link.
            if (error.code == 1) { console.log(error); console.log(response); }

            // No link in upload response.
            else if (error.code == 2) { console.log(error); console.log(response); }

            // Error during image upload.
            else if (error.code == 3) { console.log(error); console.log(response); }

            // Parsing response failed.
            else if (error.code == 4) { console.log(error); console.log(response); }

            // Image too text-large.
            else if (error.code == 5) { console.log(error); console.log(response); }

            // Invalid image type.
            else if (error.code == 6) { console.log(error); console.log(response); }

            // Image can be uploaded only to same domain in IE 8 and IE 9.
            else if (error.code == 7) { console.log(error); console.log(response); }

            else { console.log(error.code); }
        });

</script>
{{--
<script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey=uv4awo44pqxuyzdzr1e0v8tsvkri1foum7hcm06x6mub8c49"></script> 
<script defer>
    /*function setImageValue(url){
      $('.mce-btn.mce-open').parent().find('.mce-textbox').val(url);
    }

    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        tinymce.init({
            menubar: false,
            selector:'.form-control.textarea',
            file_browser_callback_types: 'file image media',
            min_height: 500,
            skin: 'voyager',
            plugins: 'link_ image_ code youtube giphy wordcount paste powerpaste jbimages autolink link image filemanager wpembed',
            extended_valid_elements : 'input[onclick|value|style|type]',
            invalid_styles: 'color font-size font-family background-color',
            toolbar1: 'styleselect bold italic underline | alignleft aligncenter alignright paste | bullist numlist outdent indent | link unlink image media youtube giphy | videos | sinopsis | encyclopedia | code',
            toolbar2: '',
            paste_data_images: true,
            convert_urls: true,
            remove_script_host : false,
            relative_urls: false,
            paste_auto_cleanup_on_paste : false,
            image_caption: true,
            image_title: true,
            browser_spellcheck: true,
        	setup: function (editor) {

                editor.addButton('sinopsis', {
                    text: 'Sinopsis',
                    icon: false,
                    onclick: function () {
                        editor.insertContent('&nbsp;<fieldset class="sinopsis"><legend>Sinopsis</legend><p>' + tinymce.activeEditor.selection.getContent() + '</p></fieldset>&nbsp;');
                    }
                });
                editor.addButton('videos', {
                    text: 'Videos',
                    icon: false,
                    onclick: function () {
                        editor.insertContent('&nbsp;<p class="youtube"><embed src="' + tinymce.activeEditor.selection.getContent() + '"></embed></p>&nbsp;');
                    }
                });
                editor.addButton('encyclopedia', {
                    type: 'menubutton',
                    text: 'Enciclopedia',
                    icon: false,
                    menu: [{
                        text: 'Persona',
                        icon: false,
                        onclick: function () {
                            function slug(str) {
                                str = str.replace(/^\s+|\s+$/g, ''); // trim
                                str = str.toLowerCase();

                                // remove accents, swap ñ for n, etc
                                var from = "àáäâèéëêìíïîòóöôùúüûñç@·/_,:;";
                                var to   = "aaaaeeeeiiiioooouuuunc-------";
                                for (var i=0, l=from.length ; i<l ; i++) {
                                    str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
                                }

                                str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
                                    .replace(/\s+/g, '-') // collapse whitespace and replace by -
                                    .replace(/-+/g, '-'); // collapse dashes

                                return str;
                            }
                            var text = tinymce.activeEditor.selection.getContent();
                            var slug = slug(text);
                            editor.insertContent('&nbsp;<a href="/enciclopedia/personas/' + slug + '">' + text + '</a>&nbsp;');
                        }
                    },{
                        text: 'Revistas',
                        icon: false,
                        onclick: function () {
                            function slug(str) {
                                str = str.replace(/^\s+|\s+$/g, ''); // trim
                                str = str.toLowerCase();

                                // remove accents, swap ñ for n, etc
                                var from = "àáäâèéëêìíïîòóöôùúüûñç@·/_,:;";
                                var to   = "aaaaeeeeiiiioooouuuunc-------";
                                for (var i=0, l=from.length ; i<l ; i++) {
                                    str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
                                }

                                str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
                                    .replace(/\s+/g, '-') // collapse whitespace and replace by -
                                    .replace(/-+/g, '-'); // collapse dashes

                                return str;
                            }
                            var text = tinymce.activeEditor.selection.getContent();
                            var slug = slug(text);
                            editor.insertContent('&nbsp;<a href="/enciclopedia/revistas/' + slug + '">' + text + '</a>&nbsp;');
                        }
                    },{
                        text: 'Empresas',
                        icon: false,
                        onclick: function () {
                            function slug(str) {
                                str = str.replace(/^\s+|\s+$/g, ''); // trim
                                str = str.toLowerCase();

                                // remove accents, swap ñ for n, etc
                                var from = "àáäâèéëêìíïîòóöôùúüûñç@·/_,:;";
                                var to   = "aaaaeeeeiiiioooouuuunc-------";
                                for (var i=0, l=from.length ; i<l ; i++) {
                                    str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
                                }

                                str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
                                    .replace(/\s+/g, '-') // collapse whitespace and replace by -
                                    .replace(/-+/g, '-'); // collapse dashes

                                return str;
                            }
                            var text = tinymce.activeEditor.selection.getContent();
                            var slug = slug(text);
                            editor.insertContent('&nbsp;<a href="/enciclopedia/empresas/' + slug + '">' + text + '</a>&nbsp;');
                        }
                    },{
                        text: 'Manga',
                        icon: false,
                        onclick: function () {
                            function slug(str) {
                                str = str.replace(/^\s+|\s+$/g, ''); // trim
                                str = str.toLowerCase();

                                // remove accents, swap ñ for n, etc
                                var from = "àáäâèéëêìíïîòóöôùúüûñç@·/_,:;";
                                var to   = "aaaaeeeeiiiioooouuuunc-------";
                                for (var i=0, l=from.length ; i<l ; i++) {
                                    str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
                                }

                                str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
                                    .replace(/\s+/g, '-') // collapse whitespace and replace by -
                                    .replace(/-+/g, '-'); // collapse dashes

                                return str;
                            }
                            var text = tinymce.activeEditor.selection.getContent();
                            var slug = slug(text);
                            editor.insertContent('&nbsp;<a href="/enciclopedia/titulos/manga/' + slug + '">' + text + '</a>&nbsp;');
                        }
                    },{
                        text: 'Anime',
                        icon: false,
                        onclick: function () {
                            function slug(str) {
                                str = str.replace(/^\s+|\s+$/g, ''); // trim
                                str = str.toLowerCase();

                                // remove accents, swap ñ for n, etc
                                var from = "àáäâèéëêìíïîòóöôùúüûñç@·/_,:;";
                                var to   = "aaaaeeeeiiiioooouuuunc-------";
                                for (var i=0, l=from.length ; i<l ; i++) {
                                    str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
                                }

                                str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
                                    .replace(/\s+/g, '-') // collapse whitespace and replace by -
                                    .replace(/-+/g, '-'); // collapse dashes

                                return str;
                            }
                            var text = tinymce.activeEditor.selection.getContent();
                            var slug = slug(text);
                            editor.insertContent('&nbsp;<a href="/enciclopedia/titulos/tv/' + slug + '">' + text + '</a>&nbsp;');
                        }
                    },{
                        text: 'Pelicula',
                        icon: false,
                        onclick: function () {
                            function slug(str) {
                                str = str.replace(/^\s+|\s+$/g, ''); // trim
                                str = str.toLowerCase();

                                // remove accents, swap ñ for n, etc
                                var from = "àáäâèéëêìíïîòóöôùúüûñç@·/_,:;";
                                var to   = "aaaaeeeeiiiioooouuuunc-------";
                                for (var i=0, l=from.length ; i<l ; i++) {
                                    str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
                                }

                                str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
                                    .replace(/\s+/g, '-') // collapse whitespace and replace by -
                                    .replace(/-+/g, '-'); // collapse dashes

                                return str;
                            }
                            var text = tinymce.activeEditor.selection.getContent();
                            var slug = slug(text);
                            editor.insertContent('&nbsp;<a href="/enciclopedia/titulos/pelicula/' + slug + '">' + text + '</a>&nbsp;');
                        }
                    },{
                        text: 'Ova',
                        icon: false,
                        onclick: function () {
                            function slug(str) {
                                str = str.replace(/^\s+|\s+$/g, ''); // trim
                                str = str.toLowerCase();

                                // remove accents, swap ñ for n, etc
                                var from = "àáäâèéëêìíïîòóöôùúüûñç@·/_,:;";
                                var to   = "aaaaeeeeiiiioooouuuunc-------";
                                for (var i=0, l=from.length ; i<l ; i++) {
                                    str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
                                }

                                str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
                                    .replace(/\s+/g, '-') // collapse whitespace and replace by -
                                    .replace(/-+/g, '-'); // collapse dashes

                                return str;
                            }
                            var text = tinymce.activeEditor.selection.getContent();
                            var slug = slug(text);
                            editor.insertContent('&nbsp;<a href="/enciclopedia/titulos/ova/' + slug + '">' + text + '</a>&nbsp;');
                        }
                    },{
                        text: 'Live Action',
                        icon: false,
                        onclick: function () {
                            function slug(str) {
                                str = str.replace(/^\s+|\s+$/g, ''); // trim
                                str = str.toLowerCase();

                                // remove accents, swap ñ for n, etc
                                var from = "àáäâèéëêìíïîòóöôùúüûñç@·/_,:;";
                                var to   = "aaaaeeeeiiiioooouuuunc-------";
                                for (var i=0, l=from.length ; i<l ; i++) {
                                    str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
                                }

                                str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
                                    .replace(/\s+/g, '-') // collapse whitespace and replace by -
                                    .replace(/-+/g, '-'); // collapse dashes

                                return str;
                            }
                            var text = tinymce.activeEditor.selection.getContent();
                            var slug = slug(text);
                            editor.insertContent('&nbsp;<a href="/enciclopedia/titulos/live-action/' + slug + '">' + text + '</a>&nbsp;');
                        }
                    },{
                        text: 'Manhwa',
                        icon: false,
                        onclick: function () {
                            function slug(str) {
                                str = str.replace(/^\s+|\s+$/g, ''); // trim
                                str = str.toLowerCase();

                                // remove accents, swap ñ for n, etc
                                var from = "àáäâèéëêìíïîòóöôùúüûñç@·/_,:;";
                                var to   = "aaaaeeeeiiiioooouuuunc-------";
                                for (var i=0, l=from.length ; i<l ; i++) {
                                    str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
                                }

                                str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
                                    .replace(/\s+/g, '-') // collapse whitespace and replace by -
                                    .replace(/-+/g, '-'); // collapse dashes

                                return str;
                            }
                            var text = tinymce.activeEditor.selection.getContent();
                            var slug = slug(text);
                            editor.insertContent('&nbsp;<a href="/enciclopedia/titulos/manhwa/' + slug + '">' + text + '</a>&nbsp;');
                        }
                    },{
                        text: 'Manhua',
                        icon: false,
                        onclick: function () {
                            function slug(str) {
                                str = str.replace(/^\s+|\s+$/g, ''); // trim
                                str = str.toLowerCase();

                                // remove accents, swap ñ for n, etc
                                var from = "àáäâèéëêìíïîòóöôùúüûñç@·/_,:;";
                                var to   = "aaaaeeeeiiiioooouuuunc-------";
                                for (var i=0, l=from.length ; i<l ; i++) {
                                    str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
                                }

                                str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
                                    .replace(/\s+/g, '-') // collapse whitespace and replace by -
                                    .replace(/-+/g, '-'); // collapse dashes

                                return str;
                            }
                            var text = tinymce.activeEditor.selection.getContent();
                            var slug = slug(text);
                            editor.insertContent('&nbsp;<a href="/enciclopedia/titulos/manhua/' + slug + '">' + text + '</a>&nbsp;');
                        }
                    }]
                });
        	},
            language: 'es_MX',
        	content_css: [
        		'/css/tinymce.css'
        	]
          });

      });*/

</script>
--}}
@endif