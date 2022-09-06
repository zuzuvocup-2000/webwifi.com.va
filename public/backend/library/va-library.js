// let notes = [];
// let selectedNote = null;
// let isNewNote = true;
// let lastId = 0;
// let showSidebar = true;


// window.addEventListener("DOMContentLoaded", (event) => {
//     add.onclick = () => {
//         reset();
//         noteinput.focus();
//     };

//     save.onclick = (event) => {
//         if (noteinput.value.length > 1) {
//             let newNote = { id: lastId, text: noteinput.value };
//             let li = document.createElement("li");
//             li.className = `note-${newNote.id}`;
//             deselectEls();
//             li.classList.add("selected");
//             li.innerHTML = newNote.text;
//             notelist.appendChild(li);
//             notes.push(newNote);
//             selectedNote = newNote;
//             isNewNote = false;
//             lastId++;
//             noteinput.focus();
//         }
//     };

//     removenote.onclick = (event) => {
//         if (selectedNote) {
//             // remove note from array
//             notes.splice(notes.indexOf(selectedNote), 1);
//             // remove el from DOM
//             let noteEl = document.getElementsByClassName(`note-${selectedNote.id}`)[0];
//             noteEl.remove();
//             reset();
//         }
//     };

//     notelist.onclick = (event) => {
//         if (event.target.tagName === "LI") {
//             let li = event.target;
//             let index = li.className[li.className.length - 1];
//             selectedNote = notes.filter((note) => note.id === +index)[0];
//             deselectEls();
//             event.target.classList.add("selected");
//             noteinput.value = selectedNote.text;
//             noteinput.focus();
//         }
//     };

//     toggle.onclick = (event) => {
//         let container = document.getElementsByClassName("va-container")[0];
//         showSidebar = !showSidebar;
//         showSidebar ? container.classList.add("active") : container.classList.remove("active");
//     };
// });

// function reset() {
//     deselectEls();
//     selectedNote = null;
//     isNewNote = true;
//     noteinput.value = "";
// }

// function deselectEls() {
//     if (selectedNote) {
//         let selectedElem = document.getElementsByClassName("selected")[0];
//         console.log(selectedElem)
//         selectedElem.classList.remove("selected");
//     }
// }
let url_insert_note = 'ajax/note/save';
let url_update_note = 'ajax/note/update';
let url_get_note = 'ajax/note/get';
let url_get_all_note = 'ajax/note/get_all';
let url_del_note = 'ajax/note/delete';
let url_get_search_note = 'ajax/note/search';

$(document).ready(function(){
    $.ajax({
        method: "POST",
        url: url_get_all_note,
        data: {},
        dataType: "json",
        cache: false,
        success: function(data){
            if(data.code == 10){
                let html = '';
                for (var i = 0; i < data.result.length; i++) {
                    html = html+'<li class="note-'+data.result[i].id+' " data-id="'+data.result[i].id+'"><div class="limit-line-2">'+data.result[i].description+'</div></li>';
                }
                $('#notelist').html(html)
            }
        }
    });
})

$(document).on('click', '#notelist li', function(){
    let _this = $(this)
    $('#notelist li').removeClass('selected')
    _this.addClass('selected')
    let id = _this.attr('data-id')
    $.ajax({
        method: "POST",
        url: url_get_note,
        data: {id: id},
        dataType: "json",
        cache: false,
        success: function(data){
            if(data.code == 10){
                $('#noteinput').val(data.result.description)
                // toastr.success(data.message);
            }else{
                toastr.error(data.message);
            }
        }
    });
})

$(document).on('click', '#add_note', function(){
    $('#noteinput').val('')
    $('#notelist li').removeClass('selected')
})

$(document).on('click', '#removenote', function(){
    let id = $('#notelist li.selected').attr('data-id')
    if(id != undefined){
        $.ajax({
            method: "POST",
            url: url_del_note,
            data: { id: id},
            dataType: "json",
            cache: false,
            success: function(data){
                if(data.code == 10){
                    $('#notelist li.selected').remove()
                    $('#noteinput').val('')
                    toastr.success(data.message);
                }else{
                    toastr.error(data.message);
                }
            }
        });
    }else{
        toastr.error('Xin vui lòng chọn ghi chú để tiến hành xoá!');
    }
})

$(document).on('click', '.btn-save-note', function(){
    let note_val = $('#noteinput').val();
    let id = $('#notelist li.selected').attr('data-id')
    if(id != undefined){
        update_note(note_val, id)
    }else{
        create_note(note_val)
    }
})

$(document).on('keyup', '#search_note', function(){
    let keyword = $(this).val()
    $.ajax({
        method: "POST",
        url: url_get_search_note,
        data: {keyword: keyword},
        dataType: "json",
        cache: false,
        success: function(data){
            if(data.code == 10){
                let html = '';
                for (var i = 0; i < data.result.length; i++) {
                    html = html+'<li class="note-'+data.result[i].id+' " data-id="'+data.result[i].id+'"><div class="limit-line-2">'+data.result[i].description+'</div></li>';
                }
                $('#notelist').html(html)
            }
        }
    });
})

function update_note(note_val, id){
    $.ajax({
        method: "POST",
        url: url_update_note,
        data: {note: note_val, id: id},
        dataType: "json",
        cache: false,
        success: function(data){
            if(data.code == 10){
                $('#notelist li.selected .limit-line-2').text(note_val)
                toastr.success(data.message);
            }else{
                toastr.error(data.message);
            }
        }
    });
}

function create_note(note_val){
    $.ajax({
        method: "POST",
        url: url_insert_note,
        data: {note: note_val},
        dataType: "json",
        cache: false,
        success: function(data){
            if(data.code == 10){
                $('#noteinput').val('')
                let html = '<li class="note-'+data.id+' " data-id="'+data.id+'"><div class="limit-line-2">'+data.note+'</div></li>';
                $('#notelist').append(html)
                toastr.success(data.message);
            }else{
                toastr.error(data.message);
            }
        }
    });
}