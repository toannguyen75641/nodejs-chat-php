<?php
    $conn = mysqli_connect("localhost", "root", "", "nodejs-chat");
    $sql = "SELECT message.*, users.name AS name FROM message LEFT JOIN users ON (users.id = message.user_id);";
    $query = mysqli_query($conn, $sql);
    $result = [];
    while ($row = mysqli_fetch_assoc($query)){
      $result[] = $row;
  }
?>
<!doctype html>
<html>
  <head>
    <title>Socket.IO chat</title>
    <style>
      * { margin: 0; padding: 0; box-sizing: border-box; }
      body { font: 13px Helvetica, Arial; }
      form { background: #000; padding: 3px; position: fixed; bottom: 0; width: 100%; }
      form input { border: 0; padding: 10px; width: 90%; margin-right: .5%; }
      form button { width: 9%; background: rgb(130, 224, 255); border: none; padding: 10px; }
      #messages { list-style-type: none; margin: 0; padding: 0; }
      #messages li { padding: 5px 10px; }
      #messages li:nth-child(odd) { background: #eee; }
      #messages { margin-bottom: 40px }
    </style>
    <script src="socket.io.js"></script>
    <script src="https://code.jquery.com/jquery-1.11.1.js"></script>
    <script src="js.js"></script>
    <script>
      $(function () {
        var socket = io('http://localhost:3000');

        var name = getCookie("name");
        var id = getCookie("user_id");
        if(!name || !id) {
          window.location.href = '/nodejs-chat/login.php';
        }

        $('form').submit(function(){
          var msg = $('#m').val();
          socket.emit('chat message', {"name": name, "msg": msg});
          $('#m').val('');
          // save to db ajax
          $.ajax({
            type: "post",
            url: "xuli.php",
            data: {"msg" : msg, "user_id" : id},
            success: function(data){
              console.log(data);
            }
          });
          return false;
        });
        socket.on('chat message', function(data){
          $('#messages').append($('<li>').html("<b>" + data.name + "</b>: " + data.msg));
          window.scrollTo(0, document.body.scrollHeight);
        });
      });
    </script>
  </head>
  <body>
      <ul id="messages" name="message">
        <?php foreach($result as $item) : ?>
            <li><b><?= $item['name'] ?></b>: <?= $item['content'] ?> </li>
        <?php endforeach; ?>
      </ul>
      <form action="">
        <input id="m" autocomplete="off" /><button>Send</button>
      </form>
    
    
  </body>
</html>