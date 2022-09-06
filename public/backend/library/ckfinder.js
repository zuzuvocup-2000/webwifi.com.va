

$(document).ready(function(){
    $(document).on('click','.choose-image', function(){
        $('.img-thumbnail').trigger('click');
    });
	$(document).on('click','.img-thumbnail', function(){
		BrowseServerPreview($(this));
	});
    $(document).on('click','.img_version_select', function(){
        let id = $(this).attr('data-target')
        BrowseServerProduct($(this), id);
    });
    $(document).on('click','.va-img-click', function(){
        BrowseServerInput($(this));
    });
	$(document).on('click','.uploadMultiImage', function(){
        let target = $(this).attr('data-target');
		BrowseServerEditor('Images', target);
        return false;
	});
    $(document).on('click','.uploadImage', function(){
        BrowseServerImage($(this));
        return false;
    });
     $(document).on('click','.uploadIcon', function(){
        BrowseServerIcon($(this));
        return false;
    });
    $(document).on('click','.uploadFile', function(){
       BrowseServerFile($(this));
       return false;
   });
    $(document).on('click','.tv-nav-tabs>li>a ', function(){
        let _this = $(this);
        let parent = _this.closest('li.tv-block');
        let target = _this.attr('href');
        parent.find('.tab-pane').removeClass('active');
        parent.find(target).addClass('active');

        return false;
  });

});

var dem_img = 0;

function SelectBanner(object,name,count, type){
    var finder = new CKFinder();
    finder.resourceType = type;

    finder.selectActionFunction = function(fileUrl , data, allFiles ) {
        if(typeof(type) == 'undefined'){
            type = 'Images';
        }

        if(typeof(name) == 'undefined'){
            name = 'album';
        }else{
            name = name+'['+count+']';
        }

        var files = allFiles;
        var li = '';
        for(var i = 0 ; i < files.length; i++){
            fileUrl =  files[i].url.replace(BASE_URL, "/");
            li = li + '<li class="ui-state-default select_img_'+dem_img+'">';
                li = li + '<div class="thumb">';
                    li = li + '<span class="image img-scaledown">';
                        var ext = fileUrl.split('.').pop();
                        if(ext == 'mp4'){
                            li = li + '<video  ><source src="'+fileUrl+'" type="video/mp4"></video>';
                        }else{
                            li = li + '<img src="'+fileUrl+'" alt="">';
                        }
                        li = li + '<input type="hidden" value="'+fileUrl+'" class="value-img-banner" name="'+name+'[]">';
                        li = li + '<input type="hidden" value="" class="value-data-banner" name="data[]">';
                    li = li + '</span>';
                    li = li + '<div class="overlay"></div><div class="delete-image"><i class="fa fa-trash" aria-hidden="true"></i></div><div class="show-image" data-toggle="modal" data-target="#show_detail_image" data-class=".select_img_'+dem_img+'" ><i class="fa fa-search-plus" aria-hidden="true"></i></div>';
                li = li + '</div>';
            li = li + '</li>';
            dem_img++;
        }
        $('.click-to-upload').hide();
        $('.upload-list').show();
        object.parents('.album').find('.data-album').append(li);

    }
    finder.popup();
}

function BrowseServerImage  (object, type){
    if(typeof(type) == 'undefined'){
        type = 'Images';
    }
    var finder = new CKFinder();
    finder.resourceType = type;
    finder.selectActionFunction = function( fileUrl, data ) {
        fileUrl =  fileUrl.replace(BASE_URL, "/");
        path = object.parent().siblings('.ibox-content')
        path.find('img').attr('src', fileUrl);
        path.find('input').val(fileUrl);
    }
    finder.popup();
}




function BrowseServerEditor(type, field){
    var finder = new CKFinder();
    var object  = editors[field] // Xac dinh editor ma minh muon cho anh vao
    finder.resourceType = type;
    finder.selectActionData = field;

    finder.selectActionFunction = function(fileUrl , data, allFiles ) {
  	 	var files = allFiles;
        var content = '';
        for(var i = 0 ; i < files.length; i++){
            fileUrl =  files[i].url.replace(BASE_URL, "/");
            // content = content + '<img src="'+fileUrl+'" alt="'+fileUrl+'">';
            CKEDITOR.instances[field].insertHtml('<p><img src="'+fileUrl+'" alt="'+fileUrl+'"></p>');
        }
        // const viewFragment = object.data.processor.toView( content );
        // const modelFragment = object.data.toModel( viewFragment );
        // object.model.insertContent( modelFragment);
    }
    finder.popup();
}


function BrowseServerInput  (object, type){
    if(typeof(type) == 'undefined'){
        type = 'Images';
    }
    var finder = new CKFinder();
    finder.resourceType = type;

    finder.selectActionFunction = function( fileUrl, data ) {
        console.log(fileUrl)
        fileUrl =  fileUrl.replace(BASE_URL, "/");

        object.val(fileUrl)
    }
    finder.popup();
}

function BrowseServer  (object, type){
    if(typeof(type) == 'undefined'){
        type = 'Images';
    }
    var finder = new CKFinder();
    finder.resourceType = type;
    finder.selectActionFunction = function( fileUrl, data ) {
        console.log(fileUrl)
        fileUrl =  fileUrl.replace(BASE_URL, "/");
        $(object).val(fileUrl)
    }
    finder.popup();
}
function BrowseServerIcon  (object, type){
    if(typeof(type) == 'undefined'){
        type = 'Images';
    }
    var finder = new CKFinder();
    finder.resourceType = type;
    finder.selectActionFunction = function( fileUrl, data ) {
        console.log(fileUrl)
        fileUrl =  fileUrl.replace(BASE_URL, "/");
        $('.icon-display').val(fileUrl)
    }
    finder.popup();
}

function BrowseServerFile  (object, type){
    if(typeof(type) == 'undefined'){
        type = 'Images';
    }
    var finder = new CKFinder();
    finder.resourceType = type;
    finder.selectActionFunction = function( fileUrl, data ) {
        fileUrl =  fileUrl.replace(BASE_URL, "/");
        $('.file-display').val(fileUrl)
    }
    finder.popup();
}

function BrowseServerAlbum(object,name,count, type){
    var finder = new CKFinder();
    finder.resourceType = type;

    finder.selectActionFunction = function(fileUrl , data, allFiles ) {
        if(typeof(type) == 'undefined'){
            type = 'Images';
        }

        if(typeof(name) == 'undefined'){
            name = 'album';
        }else{
            name = name+'['+count+']';
        }


        var files = allFiles;
        var li = '';
        for(var i = 0 ; i < files.length; i++){
            fileUrl =  files[i].url.replace(BASE_URL, "/");
            li = li + '<li class="ui-state-default">';
                li = li + '<div class="thumb">';
                    li = li + '<span class="image img-scaledown">';
                        li = li + '<img src="'+fileUrl+'" alt="">';
                        li = li + '<input type="hidden" value="'+fileUrl+'" name="'+name+'[]">';
                    li = li + '</span>';
                    li = li + '<div class="overlay"></div><div class="delete-image"><i class="fa fa-trash" aria-hidden="true"></i></div>';
                li = li + '</div>';
            li = li + '</li>';
        }
        $('.click-to-upload').hide();
        $('.upload-list').show();
        object.parents('.album').find('.data-album').append(li);

    }
    finder.popup();
}

function BrowseServerAlbumArticle(object,name,count, type){
    var finder = new CKFinder();
    finder.resourceType = type;

    finder.selectActionFunction = function(fileUrl , data, allFiles ) {
        if(typeof(type) == 'undefined'){
            type = 'Images';
        }

        if(typeof(name) == 'undefined'){
            name = 'album';
        }else{
            name = name+'['+count+']';
        }


        var files = allFiles;
        var li = '';
        for(var i = 0 ; i < files.length; i++){
            fileUrl =  files[i].url.replace(BASE_URL, "/");
            li = li + '<li class="ui-state-default select_img_'+dem_img+'" >';
                li = li + '<div class="thumb">';
                    li = li + '<span class="image img-scaledown">';
                        li = li + '<img src="'+fileUrl+'" alt="">';
                        li = li + '<input type="hidden" value="'+fileUrl+'" name="'+name+'[]">';
                        li = li + '<input type="hidden" value="" class="value-data-banner" name="'+name+'_title[]">';
                    li = li + '</span>';
                    li = li + '<div class="overlay"></div><div class="delete-image"><i class="fa fa-trash" aria-hidden="true"></i></div><div class="show-image" data-toggle="modal" data-target="#show_detail_image" data-class=".select_img_'+dem_img+'" ><i class="fa fa-search-plus" aria-hidden="true"></i></div>';
                li = li + '</div>';
            li = li + '</li>';
            dem_img++;
        }
        $('.click-to-upload').hide();
        $('.upload-list').show();
        object.parents('.album').find('.data-album').append(li);

    }
    finder.popup();
}

function BrowseServerAlbum1(object, type){
    var finder = new CKFinder();
    finder.resourceType = type;

    finder.selectActionFunction = function(fileUrl , data, allFiles ) {
        if(typeof(type) == 'undefined'){
            type = 'Images';
        }
        var files = allFiles;
        let album = [];
        for(var i = 0 ; i < files.length; i++){
            fileUrl =  files[i].url.replace(BASE_URL, "/");
            album.push(fileUrl);
        }
        var formURL = 'ajax/slide/echoview';
        $.post(formURL, {
            file: album, count: count
        },
        function(data){
            let json = JSON.parse(data);;
            $('#sortable').append(json.html);

        });

        $('.click-to-upload').hide();
        $('.upload-list').show();
    }
    finder.popup();
}

function BrowseServerAlbumModal(object, id , type){
    var finder = new CKFinder();
    finder.resourceType = type;
    finder.selectActionFunction = function(fileUrl , data, allFiles ) {
        if(typeof(type) == 'undefined'){
            type = 'Images';
        }

        let data_id = object.attr('data-id')
        var files = allFiles;
        var li = '';
        let album  = [];
        for(var i = 0 ; i < files.length; i++){
            fileUrl =  files[i].url.replace(BASE_URL, "/");
            album.push(fileUrl);
            if( i == 0){
                console.log(1)
                $(data_id).find('img').attr('src', fileUrl)
            }
            li = li + '<li class="ui-state-default">';
                li = li + '<div class="thumb">';
                    li = li + '<span class="image img-scaledown img-model">';
                        li = li + '<img src="'+fileUrl+'" alt="">';
                    li = li + '</span>';
                    li = li + '<div class="overlay"></div><div class="delete-image del_img_modal" data-id="#'+id+'"><i class="fa fa-trash" aria-hidden="true"></i></div>';
                li = li + '</div>';
            li = li + '</li>';
        }

        var myJSON = JSON.stringify(album);
        object.parents('.modal').find('.sort-modal').append(li);
        object.parents('.modal').find('.click-to-upload').hide();
        object.parents('.modal').find('.upload-list').show();
        let val = $(data_id).find('.input_img_version').val();
        let value  = "";
        if(val != undefined){
            let value = value_handling(val)
        }
        console.log(value)

        if(value != ''){
            myJSON = myJSON.split('[')
        }
        $(data_id).find('.input_img_version').val(value +((value == "") ? '' : ',')+ ((value == "") ? myJSON : myJSON[1]));
    }
    finder.popup();
}

function value_handling(value){
    let end = value.split("]");
    let result = end[0];
    return result;
}

function BrowseServerProduct(object,id , type){
    var finder = new CKFinder();
    finder.resourceType = type;

    finder.selectActionFunction = function(fileUrl , data, allFiles ) {
        if(typeof(type) == 'undefined'){
            type = 'Images';
        }

        var li = '';
        var files = allFiles;
        let album  = [];
        for(var i = 0 ; i < files.length; i++){
            fileUrl =  files[i].url.replace(BASE_URL, "/");
            album.push(fileUrl);
            if(i == 0){
                object.attr('src', fileUrl);
            }
        }
        var myJSON = JSON.stringify(album);
        let val = object.parents('tr').find('.input_img_version').val();
        let value  = "";
        if(val != undefined){
            let value = value_handling(val)
        }
        if(value != ''){
            myJSON = myJSON.split('[')
        }
        object.parents('tr').find('.input_img_version').val(value + ((value == "") ? '' : ',')+ ((value == "") ? myJSON : myJSON[1]));
    }
    finder.popup();
}


function BrowseServerPreview  (object, type){
	if(typeof(type) == 'undefined'){
		type = 'Images';
	}
	var finder = new CKFinder();
	finder.resourceType = type;
	 finder.selectActionFunction = function( fileUrl, data ) {
        fileUrl =  fileUrl.replace(BASE_URL, "/");
        object.attr('src', fileUrl);
        object.parent().siblings('input').val(fileUrl)
    }
    finder.popup();
}


const editors = {};
function ckeditor5(elementId){
    CKEDITOR.replace( elementId, {
            height: 250,
            removeButtons: '',
            entities: true,
            allowedContent: true,
            toolbarGroups: [
                { name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
                { name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
                { name: 'links' },
                { name: 'insert' },
                { name: 'forms' },
                { name: 'tools' },
                { name: 'document',    groups: [ 'mode', 'document', 'doctools' ] },
                { name: 'colors' },
                { name: 'others' },
                '/',
                { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
                { name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
                { name: 'styles' }
            ],
        });
}
