<!DOCTYPE html>
<html>
  <head>
    <title>GuestBook</title>
    <link rel="Stylesheet" href="stylesheets/page.css" type="text/css"/>
  </head>
  <body>
    <?php
    require "core.php";
    $pid = 1;
    //save
    if (isset($_POST['name'])) {
      if ($_GB->save($pid, $_POST['email'], $_POST['name'], $_POST['comment'])) {
        echo "<div>Guest Book Entry Saved</div>";
      } else {
        echo "<div>$_GB->error</div>";
      }
    }
    //get entries
    $entries = $_GB->get($pid);
    ?>
    <!--add a new entry-->
    <form method="post" target="_self" id="gb-form">
      <label for="name">Name:</label>
      <input type="text" name="name" required/>
      <label for="email">Email:</label>
      <input type="email" name="email" required/>
      <label for="comment">Comment:</label>
      <textarea name="comment" required></textarea>
      <input type="submit" value="Sign Guestbook"/>
    </form>
    <!-- display entries-->
    <div id="gb-entries">
    <?php if (count($entries)>0) { foreach ($entries as $e) { ?>
    <div class="gb-row">
      <div class="gb-datetime"><?=$e['datetime']?></div>
      <div class="gb-name">
        <span class="gb-name-a"><?=$e['name']?></span>
        <span class="gb-name-b">signed:</span>
      </div>
      <div class="gb-comment"><?=$e['comment']?></div>
    </div>
    <?php }} ?></div>
  </body>
</html>