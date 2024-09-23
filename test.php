<?php
session_start();
require_once $_SERVER["DOCUMENT_ROOT"] . "/db/connect.php";
require_once "header.php";

$id_user = $_SESSION['id_user'];

?>

<div class="serch_div">
    <div class="serch">
        <input id="searchInput" type="text" placeholder="Найти заметку">
    </div>

    <div class="filters">
        <select name="" id="statusFilter">
            <option value="" readonly>По выполненности</option>
            <option value="completed">Выполненные</option>
            <option value="not_completed">не Выполненные</option>

        </select>

        <select name="" id="dataFilter">
            <option value="" readonly>По дате</option>
            <option value="new">Новые</option>
            <option value="old">Старые</option>

        </select>

        <button id="toggleTheme"><img src="/images/team.png" alt=""></button>


    </div>
</div>

<div id="searchResults"></div>

<button type="button" class="btn create_btn" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
    <img src="/images/Add.png" alt="" draggable="false">
</button>


<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Создание задачи</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createForm">

                    <div class="modal-body">

                        <input type="hidden" value="<?= $id_user ?>" name="id_user">
                        <div class="mb-3">
                            <label for="title">Название</label>
                            <input type="text" id="title" name="title" placeholder="Назание задачи" required>
                        </div>

                        <div class="mb-3">
                            <label for="descr">Описание</label>
                            <input type="text" id="descr" name="descr" placeholder="описание задачи" required>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                        <button type="submit" class="btn btn-primary create_task" id="create_task">Создать</button>


                    </div>
                </form>
            </div>

        </div>
    </div>
</div>


<script>
    $(document).ready(function () {
        getAllTaskByUserId();
        createTask();
        updateTask();
        checkTask();
        orderByComplit();
        orderByData();
        listenerSearch();
    });

    function createModal(task) {
        return `
                <div class="modal fade" id="exampleModal${task.id_tasks}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Редактирование задачи</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="updateForm">

      <div class="modal-body">
        <input name="id_task" type="hidden" value="${task.id_tasks}">
          <div class="mb-3">
            <label for="title">Создание</label>
            <input type="text" id="title" name="title" value="${task.title}" placeholder="Назание задачи" required>
          </div>

          <div class="mb-3">
            <label for="descr">Описание</label>
            <input type="text" id="descr" name="descr" value="${task.description}" placeholder="Описание задачи" required>
          </div>
        
      </div>
      <div class="modal-footer">
       
        <button type="submit" class="btn btn-primary">Создать</button>
      
      
      </div>
    </form>
    </div>
  </div>
</div>
            `

    }

    function orderByComplit(){
        $('#statusFilter').change(function() {
        var selectedValue = $(this).val(); // Получаем выбранное значение

        if (selectedValue === 'completed') {
            // Логика для выполненных задач
            getTaskOrderByComplit();
            console.log('Выбраны выполненные задачи');
            
        } else if (selectedValue === 'not_completed') {
            // Логика для не выполненных задач
            getTaskOrderByNotComplit();
            console.log('Выбраны не выполненные задачи');
        } else {
            // Логика для случая, когда ничего не выбрано
            getAllTaskByUserId();
            console.log('Выберите статус задачи');
        }
    });
    }

    function orderByData(){
        $('#dataFilter').change(function() {
        var selectedValue = $(this).val(); // Получаем выбранное значение

        if (selectedValue === 'new') {
            // Логика для выполненных задач
            getNewTask();
            console.log('Выбраны выполненные задачи');
            
        } else if (selectedValue === 'old') {
            // Логика для не выполненных задач
            getOldTask();
            console.log('Выбраны не выполненные задачи');
        } else {
            // Логика для случая, когда ничего не выбрано
            getAllTaskByUserId();
            console.log('Выберите статус задачи');
        }
    });
    }

    function getTaskOrderByComplit() {
        $.ajax({
            url: '/db/orderByComplit.php',
            type: 'GET',
            data: { id_user: <?= json_encode($id_user) ?> },
            success: function (response) {
                const { data } = response;
                $('#searchResults').empty();
                data.forEach(task => {
                    addTask(task)
                })
                clickBtnDel();
                updateTask();
                checkTask();
            },
            error: function (xhr, status, error) {
                console.error('Произошла ошибка: ' + status);
            }

        });
    };

    function getTaskOrderByNotComplit() {
        $.ajax({
            url: '/db/orderByNotComplit.php',
            type: 'GET',
            data: { id_user: <?= json_encode($id_user) ?> },
            success: function (response) {
                const { data } = response;
                $('#searchResults').empty();
                data.forEach(task => {
                     addTask(task)
                })
                clickBtnDel();
                updateTask();
                checkTask();
            },
            error: function (xhr, status, error) {
                console.error('Произошла ошибка: ' + status);
            }

        });
    };

    // по дате

    function getNewTask() {
        $.ajax({
            url: '/db/sortNew.php',
            type: 'GET',
            data: { id_user: <?= json_encode($id_user) ?> },
            success: function (response) {
                const { data } = response;
                $('#searchResults').empty();
                data.forEach(task => {
                    addTask(task)
                });
                clickBtnDel();
                updateTask();
                checkTask();
            },
            error: function (xhr, status, error) {
                console.error('Произошла ошибка: ' + status);
            }

        });
    };

    function getOldTask() {
        $.ajax({
            url: '/db/sortOld.php',
            type: 'GET',
            data: { id_user: <?= json_encode($id_user) ?> },
            success: function (response) {
                const { data } = response;
                $('#searchResults').empty();
                data.forEach(task => {
                    addTask(task)
                });
                clickBtnDel();
                updateTask();
                checkTask();
            },
            error: function (xhr, status, error) {
                console.error('Произошла ошибка: ' + status);
            }

        });
    };

    function getAllTaskByUserId() {
        $.ajax({
            url: '/db/viewall.php',
            type: 'GET',
            data: { id_user: <?= json_encode($id_user) ?> },
            success: function (response) {
                const { data } = response;
                $('#searchResults').empty();

                if (data.length === 0) {
                // Если нет задач, показываем изображение-заглушку
                $('#searchResults').append('<img src="/images/empty.png" alt="Нет задач" />');
                }else {
                     data.forEach(task => {
                    addTask(task)
                })
                clickBtnDel();
                updateTask();
                checkTask();
                }
               
            },
            error: function (xhr, status, error) {
                console.error('Произошла ошибка: ' + status);

            }

        });
    };

    function checkTask() {
        $('.checkbox').change(function () {
            const taskId = $(this).data('id');
            confirm('вы уверены?');
            if (confirm) {
                $.ajax({
                    url: '/db/check.php',
                    type: 'POST',
                    data: { id_task: taskId },
                    success: function (response) {
                        if (response.status === 'ok') {
                            let idd = '#' + response.id_task;
                            console.log(idd);
                            $(idd).prop('disabled', true);
                            $(idd).siblings('p:contains("Completed:")').text('Completed: ' 
                            + response.is_complited);
                        }

                    },
                    error: function (xhr, status, error) {
                        console.error('Произошла ошибка: ' + status);
                    }
                })
            }
        })
    }

    function clickBtnDel() {
        $('.delete-button').click(function (event) {
            event.preventDefault();
            const taskId = $(this).data('id');
            $.ajax({
                url: '/db/delit.php',
                type: 'GET',
                data: { id_task: taskId },
                success: function (response) {
                    console.log(response)
                    if (response.status === 'ok') {
                        // Удаление элемента из интерфейса
                        $(`#taskid${response.id_task}`).remove();
                        $(`#exampleModal${response.id_task}`).remove();


                    } else {
                       
                        alert('Ошибка при удалении задачи');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Произошла ошибка: ' + status);
                }
            });
        });

    }


    function createTask() {
        $('#createForm').on('submit', function (event) {
            event.preventDefault();


            $.ajax({
                url: '/db/newNote.php',
                type: 'POST',
                data: $(this).serialize(),
                success: function (response) {

                    console.log(response);

                    if (response.status == 'ok') {
                        // Закрываем модальное окно только после успешного ответа
                        $('#staticBackdrop').modal('hide');
                        $('#staticBackdrop input[type="text"]').val('');
                        getAllTaskByUserId();


                    }
                },
                error: function (xhr, status, error) {
                    console.error('Произошла ошибка: ' + status);
                }
            });
        });
    }


    function updateTask() {
        $(document).on('submit', '#updateForm', function (event){
         
            event.preventDefault();
            
           
            $.ajax({
                url: '/db/update.php',
                type: 'POST',
                data: $(this).serialize(),
                success: function (response) {

                    console.log(response);

                    if (response.status == 'ok') {
                        // Закрываем модальное окно только после успешного ответа
                        $(`#exampleModal${response.id_tasks}`).modal('hide');
                        $('.modal-backdrop').remove();
                       
                        getAllTaskByUserId();

                    }
                },
                error: function (xhr, status, error) {
                    console.error('Произошла ошибка: ' + status);
                }
            });
        });
    }

    function listenerSearch(){
        $('#searchInput').on('input', function(event){
        var query = $(this).val().trim();
        if (query !== '') {
            search(query);
        } else {
            getAllTaskByUserId();
        }
    });
}

// <p>Completed: ${task.is_complited}</p>
// <p>Created: ${task.created_at}</p>
//                                 <p>Updated: ${task.updated_at}</p>
// <p>${task.description}</p>

function addTask(task){
    console.log(task)
    $('#searchResults').append(`
                            <div id=taskid${task.id_tasks} class="div_task">
                                <input type="checkbox" 
                   ${task.is_complited == 1 ? 'disabled' : ''} 
                   ${task.is_complited == 1 ? 'checked' : ''} 
                   id="${task.id_tasks}" 
                   data-id="${task.id_tasks}" 
                   class="checkbox">

                    <div class="task_text_main">
                                
                   
                     <div class="task_text" id="toggleBlock${task.id_tasks}">
                                <p>${task.title}</p>
                   
                   </div>
                   <div id="hiddenBlock${task.id_tasks}" class="hidden">
                               
                                <p>${task.description}</p>
                   </div>
                   
                   
                     </div>

                 

                  

                   <div class="task_btns">
                    <button type="button" class="btn delete-button" data-id="${task.id_tasks}">
                    <img src="/images/trash.png">
                    </button>
                <div class="create">
    
                    <button type="button" class="btn update-button" data-bs-toggle="modal" data-bs-target="#exampleModal${task.id_tasks}" data-id="#exampleModal${task.id_tasks}">
                    <img src="/images/pen.png">
                    </button>
                   </div>
                               
                             
             
                </div>`);
    $('#searchResults').append(createModal(task));
    const toggleBlock = document.getElementById(`toggleBlock${task.id_tasks}`);
const hiddenBlock = document.getElementById(`hiddenBlock${task.id_tasks}`);

// Обработчик события для блока
toggleBlock.addEventListener('click', () => {
    hiddenBlock.classList.toggle('hidden'); // Переключаем класс 'hidden'
});
  
}

function search(query) {
    $.ajax({
        url: '/db/search.php',
        type: 'GET',
        data: { q: query },
        success: function(response) {
            const { data } = response;
            $('#searchResults').empty();
            data.forEach(task => {
                addTask(task)
            })
            clickBtnDel();
            updateTask();
            checkTask();
        },
        error: function(xhr, status, error) {
            console.error('Произошла ошибка: ' + status);
        }
    });
}




const toggleThemeButton = document.getElementById('toggleTheme');
const body = document.body;

// Проверяем, есть ли сохраненная тема в localStorage
const currentTheme = localStorage.getItem('theme') || 'light-theme';
body.classList.add(currentTheme);

toggleThemeButton.addEventListener('click', () => {
    if (body.classList.contains('light-theme')) {
        body.classList.replace('light-theme', 'dark-theme');
        localStorage.setItem('theme', 'dark-theme'); // Сохраняем тему
    } else {
        body.classList.replace('dark-theme', 'light-theme');
        localStorage.setItem('theme', 'light-theme'); 
    }
});




</script>

</body>

</html>