<?php
include_once '_includes/tools.class.php';
include_once '_includes/xcombine.class.php';
include_once '_includes/header.php';
?>
<h2>Combine Results</h2>
<section>
<?php
if (Tools::isFrameworkSetup()) {
  echo '<div class="combine-report">';
  $xcombine = new XCombine();
  $xcombine->run();
  echo '</div>';
} else {
  echo "<h3>Framework is not set up.</h3><p>There is nothing to combine, please set up the framework first.</p>";
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


