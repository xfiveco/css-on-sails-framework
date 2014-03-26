<?php
include_once '_includes/tools.class.php';
include_once '_includes/xsetup.class.php';
include_once '_includes/header.php';
?>
<h2>Setup Results</h2>
<section>
  <?php
  if (Tools::isFrameworkSetup()) {
    echo "<h3>Framework is already set up.</h3><p>If you know what you are doing and want to set up framewok again, delete _xsetup/commonparts.txt and _xsetup/pages.txt</p>";
  } else {
    $xsetup = new XSetup();
    echo '<ul class="results">';
    $xsetup->run();
    echo '</ul>';
  }

  ?>
</section>
<ul class="back">
  <li><a href="../../index.html">Go to Project Home page</a></li>
  <li><a href="index.php">Go to X-Setup Home page</a></li>
</ul>
<?php
include_once "_includes/footer.php";
?>


