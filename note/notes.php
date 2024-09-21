<?php 

require_once "../header.php";
session_start();

$query_tasks = mysqli_fetch_all(mysqli_query($con, "SELECT * FROM `tasks`"));


?>

    <div class="serch">
        <form action="">
            <input type="text">
        </form>

        <select name="filtr" id="filter">
            <option value="">All</option>
            <option value="complite">complite</option>
            <option value="uncomplite">uncomplite</option>

        </select>

        <div class="tem">Y</div>
    </div>

    <div class="tasks">
        <ul>
          <?php 
          foreach($query_tasks as $task){?>
            <li><input type="checkbox" id="id_task<?=$task[0]?>"><p><?=$task[2]?></p>
            <div class="icons">
              <a href="../db/delit.php?id_task=<?=$task[0]?>">удалить</a>
              
              <div class="create">
        <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal<?= $task[0] ?>">
  изменить
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal<?= $task[0] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="../db/update.php" method="post">

      <div class="modal-body">
        <input name="id_task" type="hidden" value="<?=$task[0]?>">
          <div class="mb-3">
            <label for="title"></label>
            <input type="text" id="title" name="title" value="<?=$task[2]?>" placeholder="Назание задачи">
          </div>

          <div class="mb-3">
            <label for="descr"></label>
            <input type="text" id="descr" name="descr" value="<?=$task[3]?>" placeholder="описание задачи">
          </div>
        
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
        <button type="submit" class="btn btn-primary">Save changes</button>
      
      
      </div>
    </form>
    </div>
  </div>
</div>
            </div>
          <?php }
          ?>
            
            
            </li>
        </ul>
    </div>




    <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
  создать
</button>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="../db/newNote.php" method="post">

<div class="modal-body">
    <div class="mb-3">
      <label for="title"></label>
      <input type="text" id="title" name="title" placeholder="Назание задачи">
    </div>

    <div class="mb-3">
      <label for="descr"></label>
      <input type="text" id="descr" name="descr" placeholder="описание задачи">
    </div>
  
</div>
<div class="modal-footer">
  <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
  <button type="submit" class="btn btn-primary">Save changes</button>


</div>
</form>
      </div>
      
    </div>
  </div>
</div>







    
