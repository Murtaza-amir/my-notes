
$(document).ready(function () {

    getNotes();
    noteType();
    setTimeout(() => {
        noteTypeColors();
        getNoteLinks();
    }, 500);

    setTimeout(() => {
        popup();
    }, 1000);

    $('.toggle-sidebar span').on("click", function (e) {
        e.preventDefault();
        $('.sidebar').addClass('show');
        $('.sidebar-bg').addClass('show');
    });

    $('.sidebar-bg').on("click", function (e) {
        e.preventDefault();
        $('.sidebar').removeClass('show');
        $('.sidebar-bg').removeClass('show');
    });

    $("#addNoteForm").on("submit", function (e) {
        e.preventDefault();

        let addNewNote = new FormData(this);

        $.ajax({
            url: "./crud/notes/add",
            type: "POST",
            data: addNewNote,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data.status == true) {
                    $("#addNote").removeClass('show');
                    getNotes();
                    setTimeout(() => {
                        popup();
                    }, 500);
                }
            }
        });
    });

    $("#editNoteForm").on("submit", function (e) {
        e.preventDefault();

        let editNoteForm = new FormData(this);

        $.ajax({
            url: "./crud/notes/update",
            type: "POST",
            data: editNoteForm,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data.status == true) {
                    $("#editNote").removeClass('show');
                    getNotes();
                    setTimeout(() => {
                        popup();
                    }, 100);
                }
            }
        });
    });

    $("#addTypeForm").on("submit", function (e) {
        e.preventDefault();

        let addTypeForm = new FormData(this);

        $.ajax({
            url: "./crud/note-type/add",
            type: "POST",
            data: addTypeForm,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data.status == true) {
                    $("#addType form").trigger('reset');
                    $("#addType").removeClass('show');
                    setTimeout(() => {
                        getNoteLinks();
                        notesActions();
                        popup();
                    }, 500);
                }
            }
        });
    });


    setTimeout(() => {
        $(".filter-drop input").on("change", function () {

            let filter_Type_id = $(this).attr('filter_Type_id');

            if (filter_Type_id == '*') {
                getNotes();
            } else {
                $.ajax({
                    url: "./crud/note-type/getSingle",
                    type: "POST",
                    data: { "filter_Type_id": filter_Type_id },
                    success: function (data) {


                        $('#noteCards .note-col').each((i, element) => {

                            if (element.getAttribute('note_Type_id') !== data.type_id) {
                                element.classList.add('hide');
                                setTimeout(() => {
                                    element.style.display = "none";
                                }, 300);
                            } else {
                                setTimeout(() => {
                                    element.style.display = "block";
                                }, 300);
                                setTimeout(() => {
                                    element.classList.remove('hide');
                                }, 400);
                            }

                        });

                    }
                });
            }

        });

        $(".search-bar input").on("keyup", function () {

            let search_value = $(this).val();

            $.ajax({
                url: "./crud/notes/search",
                type: "POST",
                data: { "search_value": search_value },
                success: function (data) {

                    document.querySelector("#noteCards").innerHTML = '';
                    if (data.status !== false) {

                        data.forEach(element => {

                            let noteTextColor;

                            if (element.mode == 'dark') {
                                noteTextColor = '#fff';
                            } else {
                                noteTextColor = '#191719';
                            }

                            document.querySelector("#noteCards").insertAdjacentHTML('afterbegin', `
                                <div class="col-lg-3 col-md-4 col-sm-6 note-col" note_id="${element.id}" note_Type_id="${element.note_type}">
                                    <div class="note-card" style="background: ${element.color}; color: ${noteTextColor};">
                                        <div class="note-body">
                                            <p>${element.note_text}</p>
                                        </div>
                                        <div class="note-footer">
                                            <div class="date"> ${element.date} </div>
                                            <div class="note-card-actions">
                                                <a href="" class="actions-drop-link" style="border-color: ${noteTextColor};">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="${noteTextColor}" class="bi bi-three-dots" viewBox="0 0 16 16">
                                                        <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z" />
                                                    </svg>
                                                </a>
                                                <div class="note-card-actions-drop">
                                                    <a href="" class="noteEdit" noteTypeId="${element.note_type}" noteID="${element.id}">Edit</a>
                                                    <a href="" class="noteDelete" noteID="${element.id}">Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `);
                        });
                    } else {
                        document.querySelector("#noteCards").innerHTML = `
                            <div class="col-lg-3 col-md-4 col-sm-6 note-col">
                                <div class="text-center p-3 bg-light border rounded"> Not Found! </div>
                            </div>
                        `;
                    }

                    $(".noteEdit").on("click", function (e) {
                        e.preventDefault();

                        let noteID = $(this).attr("noteID");
                        let noteTypeId = $(this).attr("noteTypeId");

                        $.ajax({
                            url: "./crud/notes/getSingle",
                            type: "POST",
                            data: { "noteID": noteID },
                            success: function (data) {

                                let typeMode = data.mode;

                                $("#editNote #editNoteId").val(noteID);
                                $("#editNote #editTypeId").val(noteTypeId);
                                $("#editNote textarea").val(data.note_text);
                                if (typeMode == 'dark') {
                                    $("#editNote").addClass('dark')
                                }
                                $("#editNote .popup-box").css({ 'background': data.color });
                                $("#editNote").addClass('show');

                                $("#editNote .type-colors .type-color").each((i, element) => {
                                    if (element.querySelector('input').value == data.type_id) {
                                        element.querySelector('input').setAttribute("checked", 'checked');
                                    }
                                });

                                if (window.innerWidth <= 750) {
                                    document.querySelector('.sidebar').classList.remove('show');
                                }

                            }
                        });

                    });

                    $(".noteDelete").on("click", function (e) {
                        e.preventDefault();

                        if (confirm("Are you sure?") == true) {

                            let noteID = $(this).attr("noteID");

                            $.ajax({
                                url: "./crud/notes/delete",
                                type: "POST",
                                data: { "noteID": noteID },
                                success: function (data) {
                                    if (data.status = true) {
                                        getNotes();
                                        setTimeout(() => {
                                            popup();
                                            notesActions();
                                        }, 100);

                                        if (window.innerWidth <= 750) {
                                            document.querySelector('.sidebar').classList.remove('show');
                                        }

                                    }
                                }
                            });

                        }

                    });

                    setTimeout(() => {
                        popup();
                        notesActions();
                        readNote();
                    }, 100);

                }
            });

        });
    }, 1000);

});

function getNotes() {
    $.ajax({
        url: "./crud/notes/get",
        type: "GET",
        success: function (data) {

            document.querySelector("#noteCards").innerHTML = '';
            if (data.status !== false) {
                data.forEach(element => {

                    let noteTextColor;

                    if (element.mode == 'dark') {
                        noteTextColor = '#fff';
                    } else {
                        noteTextColor = '#191719';
                    }

                    document.querySelector("#noteCards").insertAdjacentHTML('afterbegin', `
                        <div class="col-lg-3 col-md-4 col-sm-6 note-col" note_id="${element.id}" note_Type_id="${element.note_type}">
                            <div class="note-card" style="background: ${element.color}; color: ${noteTextColor};">
                                <div class="note-body">
                                    <p>${element.note_text}</p>
                                </div>
                                <div class="note-footer">
                                    <div class="date"> ${element.date} </div>
                                    <div class="note-card-actions">
                                        <a href="" class="actions-drop-link" style="border-color: ${noteTextColor};">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="${noteTextColor}" class="bi bi-three-dots" viewBox="0 0 16 16">
                                                <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z" />
                                            </svg>
                                        </a>
                                        <div class="note-card-actions-drop">
                                            <a href="" class="noteEdit" noteTypeId="${element.note_type}" noteID="${element.id}">Edit</a>
                                            <a href="" class="noteDelete" noteID="${element.id}">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `);
                });
            } else {
                document.querySelector("#noteCards").innerHTML = `
                    <div class="note-placeholder">
                        <span><img src="./assets/images/sticky-notes.png" /></span>
                        <div>My Notes</div>
                    </div>
                `;
            }

            $(".noteEdit").on("click", function (e) {
                e.preventDefault();

                let noteID = $(this).attr("noteID");
                let noteTypeId = $(this).attr("noteTypeId");

                $.ajax({
                    url: "./crud/notes/getSingle",
                    type: "POST",
                    data: { "noteID": noteID },
                    success: function (data) {

                        let typeMode = data.mode;

                        $("#editNote #editNoteId").val(noteID);
                        $("#editNote #editTypeId").val(noteTypeId);
                        $("#editNote textarea").val(data.note_text);
                        if (typeMode == 'dark') {
                            $("#editNote").addClass('dark')
                        }
                        $("#editNote .popup-box").css({ 'background': data.color });
                        $("#editNote").addClass('show');

                        $("#editNote .type-colors .type-color").each((i, element) => {
                            if (element.querySelector('input').value == data.type_id) {
                                element.querySelector('input').setAttribute("checked", 'checked');
                            }
                        });

                        if (window.innerWidth <= 750) {
                            document.querySelector('.sidebar').classList.remove('show');
                        }

                    }
                });

            });

            $(".noteDelete").on("click", function (e) {
                e.preventDefault();

                if (confirm("Are you sure?") == true) {

                    let noteID = $(this).attr("noteID");

                    $.ajax({
                        url: "./crud/notes/delete",
                        type: "POST",
                        data: { "noteID": noteID },
                        success: function (data) {
                            if (data.status = true) {
                                getNotes();
                                setTimeout(() => {
                                    popup();
                                    notesActions();
                                }, 100);

                                if (window.innerWidth <= 750) {
                                    document.querySelector('.sidebar').classList.remove('show');
                                }

                            }
                        }
                    });

                }

            });

            setTimeout(() => {
                popup();
                notesActions();
                readNote();
            }, 100);
        }
    });

}

function readNote() {
    $(".note-body").on("click", function (e) {
        e.preventDefault();

        let note_id = $(this).parents(".note-col").attr('note_id');

        $.ajax({
            url: "./crud/notes/getSingle",
            type: "POST",
            data: { "noteID": note_id },
            success: function (data) {

                $("#readNote .add-note").html(`<p>${data.note_text}</p>`);

                let typeMode = data.mode;
                if (typeMode == 'dark') {
                    $("#readNote").addClass('dark')
                }
                $("#readNote .popup-box").css({ 'background': data.color });
                $("#readNote").addClass('show');

            }
        });

    });
}

function noteTypeColors() {
    $.ajax({
        url: "./crud/note-type/get",
        type: "GET",
        success: function (data) {

            if (data.status == true) {
                data.forEach((element) => {
                    $("#editNote .type-colors").append(`
                        <label class="type-color">
                            <input type="radio" name="editTypeId" value="${element.type_id}" />
                            <span class="check"></span>
                            <span class="type-bg-color" style="background-color: ${element.color};"></span>
                        </label>
                    `)
                });
            }


        }
    });
}

function noteType() {
    $.ajax({
        url: "./crud/note-type/get",
        type: "GET",
        success: function (data) {

            if (data.status !== false) {
                data.forEach((element) => {
                    $(".note-filter .filter-drop").append(`
                        <label>
                            <input type="radio" name="filter_type" filter_Type_id="${element.type_id}" />
                            <span class="check"></span>
                            <span>${element.type}</span>
                        </label>
                    `)
                });
            }


        }
    });
}

function notesActions() {
    $(".actions-drop-link").each((i, element) => {
        element.addEventListener("click", function (e) {
            e.preventDefault();
            element.parentElement.classList.toggle('show');
            document.addEventListener("click", function (e) {
                if (e.target != element) {
                    element.parentElement.classList.remove('show');
                }
            });
        });
    });
}

function getNoteLinks() {
    $.ajax({
        url: "./crud/note-type/get",
        type: "GET",
        success: function (data) {

            if (data.status !== false) {
                $('#add-note-links').empty();

                let no = data.length;
                data.forEach(element => {
                    $('#add-note-links').prepend(`
                        <a href="" class="open_popup set_add_popup" popupId="addNote" typeId="${element.type_id}" typeColor="${element.color}" typeMode="${element.mode}" style="transition-delay: 0.${no}s;"><span style="background: ${element.color};"></span></a>
                    `);
                    no -= 1;
                });

                $('#add-note-links').append(`<a href="" class="add-color open_popup" popupId="addType" style="transition-delay: 0.${data.length + 1}s;"><span style="background: #191719;">+</span></a>`)

                popup();

            }

        }
    });
}

const mainContent = document.querySelector('.main-content');
const addLink = document.querySelector('.addLink');
const addDrop = document.querySelector('.add-link-drop');


function popup() {
    const open_popup = document.querySelectorAll(".open_popup");
    const close_popup = document.querySelectorAll(".close_popup");
    open_popup.forEach(element => {
        element.addEventListener("click", function (e) {
            e.preventDefault();
            document.getElementById(element.getAttribute('popupId')).classList.add("show");
            if (window.innerWidth <= 750) {
                document.querySelector('.sidebar').classList.remove('show');
                document.querySelector('.sidebar-bg').classList.remove('show');
            }
        });
    });
    close_popup.forEach(element => {
        element.addEventListener("click", function (e) {
            e.preventDefault();
            document.getElementById(element.getAttribute('popupId')).classList.remove("show");
            document.getElementById(element.getAttribute('popupId')).classList.remove("dark");
            if (window.innerWidth <= 750) {
                document.querySelector('.sidebar').classList.remove('show');
                document.querySelector('.sidebar-bg').classList.remove('show');
            }
        });
    });

    // Set Add Popup
    const set_add_popup = document.querySelectorAll(".set_add_popup");
    set_add_popup.forEach(element => {
        element.addEventListener("click", function (e) {
            e.preventDefault();

            let popupId = element.getAttribute('popupId');
            let typeId = element.getAttribute("typeId");
            let typeColor = element.getAttribute("typeColor");
            let typeMode = element.getAttribute("typeMode");
            document.getElementById(popupId).querySelector("textarea").value = '';
            if (typeMode == 'dark') {
                document.getElementById(popupId).classList.add('dark');
            }
            document.getElementById(popupId).querySelector(".popup-box").style.background = typeColor;
            document.getElementById(popupId).querySelector("#typeId").value = typeId;
        });
    });
    // Set Add Popup End
}

mainContent.addEventListener("scroll", function () {
    if (mainContent.scrollTop >= 10) {
        document.querySelector('header').style.boxShadow = "0 1px 20px rgba(0, 0, 0, 0.10)";
    } else {
        document.querySelector('header').style.boxShadow = "none";
    }
});


addLink.addEventListener("click", function (e) {
    e.preventDefault();
    addDrop.classList.toggle('show');
});