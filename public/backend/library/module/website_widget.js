 $(document).ready(function(){
    let count = 1;
    $('.va_code_theme').each(function(){
        let _this = $(this);
        let data ='va_theme_' + count;
        _this.attr('id',data)
        code_theme(data)
        count++;
    })
});


 function code_theme(id){
    var editor_one = CodeMirror.fromTextArea(document.getElementById(id), {
        lineNumbers: true,
        matchBrackets: true,
        styleActiveLine: true,
        theme:"ambiance"
    });
 }