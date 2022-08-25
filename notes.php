<?php 
    session_start();
    if(!isset($_SESSION['userId'])) {
        header("Location:./");
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notes | Note Down</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
  />
    <link rel="stylesheet" href="./assets/css/style.css">
</head>

<body>

    <div class="main">
        <div class="sidebar-bg"></div>
        <div class="sidebar">
            <div class="logo">My Notes</div>
            <div class="side-links">
                <ul>
                    <li>
                        <a href="" class="addLink">
                            <span class="add-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="#fff" class="bi bi-plus-lg" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z" />
                                </svg>
                            </span>
                        </a>
                        <div class="add-link-drop" id="add-note-links">
                            <!-- <a href="" class="open_popup set_add_popup" popupId="addNote" statusId="${element.type_id}" statusColor="${element.color}" style="transition-delay: 0.${no}s;"><span style="background: ${element.color};"></span></a> -->
                            <!-- <a href="" class="add-color open_popup" popupId="addType" style="transition-delay: 0.${no}s;"><span style="background: #191719;">+</span></a> -->
                            <!-- <a href="" class="open_popup" popupId="simple" status="#eee" style="transition-delay: 0.1s;"><span style="background: #eee;"></span></a>
                            <a href="" class="open_popup" popupId="simple" status="#ffc971" style="transition-delay: 0.1s;"><span style="background: #ffc971;"></span></a>
                            <a href="" class="open_popup" popupId="simple" status="#f59474" style="transition-delay: 0.2s;"><span style="background: #f59474;"></span></a>
                            <a href="" class="open_popup" popupId="simple" status="#e4ee90" style="transition-delay: 0.3s;"><span style="background: #e4ee90;"></span></a>
                            <a href="" class="open_popup" popupId="simple" status="#b692fe" style="transition-delay: 0.4s;"><span style="background: #b692fe;"></span></a>
                            <a href="" class="add-color" style="transition-delay: 0.5s;"><span style="background: #191719;">+</span></a> -->
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-content">
            <header>
                <div class="toggle-sidebar">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
                        </svg>
                    </span>
                </div>
                <div class="search-bar">
                    <input type="text" placeholder="Search" />
                    <span class="search-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#999" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                        </svg>
                    </span>
                </div>
                <div class="user-info">
                    <div class="info-name">
                        <span><?php echo $_SESSION['userName'] ?></span>
                        <span class="info-img" id="user-img">
                            <!-- <img src="https://murtaza-khan.000webhostapp.com/assets/images/me.png" alt=""> -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#ddd" class="bi bi-person-fill" viewBox="0 0 16 16">
                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                            </svg>
                        </span>
                    </div>
                    <div class="user-info-drop">
                        <a href="./logout">Logout</a>
                    </div>
                    <?php 
                        // echo $_SESSION['userName'] ." - ". $_SESSION['userId'] 
                    ?>
                </div>
            </header>

            <section class="section-container">
                <div class="page-title">
                    <h1>Notes</h1>
                    <div class="note-filter">
                        <a class="">Filter 
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-funnel" viewBox="0 0 16 16">
                                    <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5v-2zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2h-11z"/>
                                </svg>
                            </span>
                        </a>
                        <div class="filter-drop">
                            <label>
                                <input type="radio" name="filter_type" filter_Type_id="*" />
                                <span class="check"></span>
                                <span>All</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="container m-lg-0 p-0">
                    <div class="row" id="noteCards">
                        <!-- <div class="col-lg-3">
                            <div class="note-card" style="background: #eee;">
                                <div class="note-body">
                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestias. Lorem ipsum dolor sit amet consectetur.</p>
                                </div>
                                <div class="note-footer">
                                    <div class="date"> Aug 16, 2022 </div>
                                    <div class="note-card-actions">
                                        <a href="" class="actions-drop-link">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="#191719" class="bi bi-three-dots" viewBox="0 0 16 16">
                                                <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z" />
                                            </svg>
                                        </a>
                                        <div class="note-card-actions-drop">
                                            <a href="">Edit</a>
                                            <a href="">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <!-- <div class="col-lg-3">
                            <div class="note-card" style="background: #ffc971;">
                                <div class="note-body">
                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestias. Lorem ipsum dolor sit amet consectetur.</p>
                                </div>
                                <div class="note-footer">
                                    <div class="date"> Aug 16, 2022 </div>
                                    <div class="note-card-actions">
                                        <a href="" class="actions-drop-link">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="#191719" class="bi bi-three-dots" viewBox="0 0 16 16">
                                                <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z" />
                                            </svg>
                                        </a>
                                        <div class="note-card-actions-drop">
                                            <a href="">Edit</a>
                                            <a href="">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="note-card" style="background: #f59474;">
                                <div class="note-body">
                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestias. Lorem ipsum dolor sit amet consectetur.</p>
                                </div>
                                <div class="note-footer">
                                    <div class="date"> Aug 16, 2022 </div>
                                    <div class="note-card-actions">
                                        <a href="" class="actions-drop-link">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="#191719" class="bi bi-three-dots" viewBox="0 0 16 16">
                                                <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z" />
                                            </svg>
                                        </a>
                                        <div class="note-card-actions-drop">
                                            <a href="">Edit</a>
                                            <a href="">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="note-card" style="background: #e4ee90;">
                                <div class="note-body">
                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestias. Lorem ipsum dolor sit amet consectetur.</p>
                                </div>
                                <div class="note-footer">
                                    <div class="date"> Aug 16, 2022 </div>
                                    <div class="note-card-actions">
                                        <a href="" class="actions-drop-link">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="#191719" class="bi bi-three-dots" viewBox="0 0 16 16">
                                                <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z" />
                                            </svg>
                                        </a>
                                        <div class="note-card-actions-drop">
                                            <a href="">Edit</a>
                                            <a href="">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="note-card" style="background: #b692fe;">
                                <div class="note-body">
                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestias. Lorem ipsum dolor sit amet consectetur.</p>
                                </div>
                                <div class="note-footer">
                                    <div class="date"> Aug 16, 2022 </div>
                                    <div class="note-card-actions">
                                        <a href="" class="actions-drop-link">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="#191719" class="bi bi-three-dots" viewBox="0 0 16 16">
                                                <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z" />
                                            </svg>
                                        </a>
                                        <div class="note-card-actions-drop">
                                            <a href="">Edit</a>
                                            <a href="">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
            </section>

        </div>
    </div>

    <div class="popup" id="readNote">
        <div class="popup-bg close_popup" popupId="readNote"></div>
        <div class="popup-box" style="background-color: #eee;">
                <div class="add-note">
                    
                </div>
            </form>
        </div>
    </div>
    <div class="popup" id="addNote">
        <div class="popup-bg" popupId="addNote"></div>
        <div class="popup-box">
            <form id="addNoteForm">
                <div class="add-note">
                    <input type="hidden" name="typeId" id="typeId">
                    <textarea placeholder="Type Here..." autofocus name="noteText" required></textarea>
                    <div class="popup-footer">
                        <div class="popup-action">
                            <a href="" class="close_popup note-action-btn" popupId="addNote">Cancel</a>
                            <button type="submit" class="note-action-btn">Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="popup" id="editNote">
        <div class="popup-bg" popupId="editNote"></div>
        <div class="popup-box" style="background-color: #eee;">
            <form id="editNoteForm">
                <div class="add-note edit-note">
                    <input type="hidden" name="editTypeId" id="editTypeId" />
                    <input type="hidden" name="editNoteId" id="editNoteId" />
                    <div>
                        <span class="field-title">Selet Note Type</span>
                        <div class="type-colors"></div>
                    </div>
                    <textarea placeholder="Type Here..." autofocus name="editTypeText"></textarea>
                    <div class="popup-footer">
                        <div class="popup-action">
                            <a href="" class="close_popup note-action-btn" popupId="editNote">Cancel</a>
                            <button type="submit" class="note-action-btn">Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="popup" id="addType">
        <div class="popup-bg" popupId="addType"></div>
        <div class="popup-box">
            <form id="addTypeForm" autocomplete="off">
                <div class="add-type">
                    <div>
                        <div class="input-text">
                            <span class="field-title">Type Name</span>
                            <input type="text" name="typeName" placeholder="Name" required />
                        </div>
                        <div class="row m-0">
                            <div class="col-md-5 p-0">
                                <span class="field-title">New Color</span>
                                <div class="new-type-color">
                                    <input type="color" name="type_color" />
                                </div>
                            </div>
                            <div class="col-md-7 p-0">
                                <span class="field-title">Mode (selected color)</span>
                                <div class="note-mode">
                                    <select name="type_mode" required>
                                        <option value="light">Light</option>
                                        <option value="dark">Dark</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="popup-footer">
                        <div class="popup-action">
                            <a href="" class="close_popup note-action-btn" popupId="addType">Cancel</a>
                            <button type="submit" class="note-action-btn">Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="popup" id="editType">
        <div class="popup-bg" popupId="editType"></div>
        <div class="popup-box">
            <form id="editTypeForm">
                <div class="add-note">
                    <input type="hidden" name="statusId" id="statusId">
                    <textarea placeholder="Type Here..." autofocus name="statusText"></textarea>
                    <div class="popup-footer">
                        <div class="popup-action">
                            <a href="" class="close_popup note-action-btn" popupId="editType">Cancel</a>
                            <button type="submit" class="note-action-btn">Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="./assets/js/app.js"></script>

</body>

</html>