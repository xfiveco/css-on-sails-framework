<?php
/**
 * X-Combine
 *
 * Tool for combining CSS on Sails Framework files
 *
 * @author Lubos Kmetko <lubos@xhtmlized.com>
 */


/**
 * Config
 */
// Directories
define("PROJECT_DIR", dirname( __FILE__ ) . "/../../");
define("CSS_DIR", dirname( __FILE__ ) . "/../../_ui/css/");
define("HTML_DIR", dirname( __FILE__ ) . "/../../");

/**
 * X-Combine Class
 */
class XCombine {

  /**
   * List of common parts
   */
  private $common_parts_list = array();

  /**
   * List of pages
   */
  private $page_list = array();

  function __construct() {
  }

  /**
   * Combine files
   */
  public function run() {
    $this->common_parts_list = $this->createCommonPartsList();
    $this->page_list = $this->createPageList();
        $this->mergeStylesheets();
    $this->replaceStylesheets();
    $this->deleteStylesheets();
    $this->deleteLicense();
    $this->detachXprecise();
  }

  /**
   * Return list of common parts
   */
  private function createCommonPartsList() {

    $common_parts_list = array();

    $lines = file("commonparts.txt");

    foreach ($lines as $line_num => $line) {
      $parts = explode("|", $line);
      $common_parts_list[$line_num]['title'] = trim($parts[0]);
      $common_parts_list[$line_num]['file'] = trim($parts[1]);
      $common_parts_list[$line_num]['stylesheet'] = trim($parts[2]);
    }

    return $common_parts_list;
  }


  /**
   * Return list of pages
   */
  private function createPageList() {

    $page_list = array();

    $lines = file("pages.txt");

    foreach ($lines as $line_num => $line) {
      $parts = explode("|", $line);
      $page_list[$line_num]['title'] = trim($parts[0]);
      $page_list[$line_num]['file'] = trim($parts[1]);
      $page_list[$line_num]['stylesheet'] = trim($parts[2]);
    }

    return $page_list;
  }

  /**
   * Get list of pages
   * @return array
   */
  public function getPageList() {
    return $this->page_list;
  }

  /**
   * Merge stylesheets
   */
  private function mergeStylesheets() {

    $pages_separator = <<<EOD



/* 3. PAGES
--------------------------------------------------------------------------------
==============================================================================*/
EOD;

    echo '<h3 class="first">Merged stylesheets</h3>';

    $main_css = CSS_DIR . "main.css";
    $main_merged = "<h4>Merged into main.css:</h4>";

    // Common parts
    foreach($this->common_parts_list as $common_part) {

      if ($common_part['stylesheet'] == "main.css") {
        continue;
      }

      if ($this->mergeFiles($main_css, CSS_DIR . $common_part['stylesheet'])) {
        $main_merged .= $common_part['stylesheet'] . "<br />";
      }
    }

    // Separator
    $this->appendStringToFile($main_css, $pages_separator);

    // Pages
    foreach($this->page_list as $page) {

      if ($page['stylesheet'] == "main.css") {
        continue;
      }

      if ($this->mergeFiles($main_css, CSS_DIR . $page['stylesheet'])) {
        $main_merged .= $page['stylesheet'] . "<br />";
      }

    }

    // Responsive
    $responsive_css = CSS_DIR . "responsive.css";
    if (file_exists($responsive_css)) {
      if ($this->mergeFiles($main_css, $responsive_css)) {
        $main_merged .= "responsive.css<br />";
      }
    }

    // Print
    $print_css = CSS_DIR . "print.css";
    if (file_exists($print_css)) {
      if ($this->mergeFiles($main_css, $print_css)) {
        $main_merged .= "print.css<br />";
      }
    }

    echo $main_merged;
  }

  /**
   * Replace stylesheets
   */
  private function replaceStylesheets() {

    echo "<h3>Imported stylesheets replaced in:</h3>";

    $detached = "";

    $pages = array_merge($this->common_parts_list, $this->page_list);
    $pages[] = array("file" => "wp.html");

    foreach($pages as $page) {
      $file = HTML_DIR . $page['file'];
      if (file_exists($file)) {

        $content = file_get_contents($file);

        $content = str_replace("all.css", "main.css", $content);

        if ($this->createFile($file, $content)) {
          $detached .= $page['file'] . "<br />";
        }
      }
    }

    echo $detached;
  }

  /**
   * Detach X-Precise
   */
  private function detachXprecise() {

    $pages = array_merge($this->common_parts_list, $this->page_list);
    $pages[] = array("file" => "wp.html");

    foreach($pages as $page) {
      $file = HTML_DIR . $page['file'];

      if (file_exists($file)) {

        $content = file_get_contents($file);

        $content = str_replace('<script type="text/javascript" src="http://cssonsails.org/xprecise/xprecise.min.js"></script>' . "\n", "", $content);
        $content = str_replace('<script src="http://cssonsails.org/xprecise/xprecise.min.js"></script>' . "\n", "", $content);
        $this->createFile($file, $content);
      }
    }
  }

  /**
   * Delete stylesheets
   */
  private function deleteStylesheets() {

    echo "<h3>Deleted stylesheets:</h3>";

    $deleted = "";

    $all[] = array('stylesheet' => 'all.css');
    $pages = array_merge($all, $this->common_parts_list, $this->page_list);

    foreach($pages as $page) {

      if ($page['stylesheet'] == "main.css") {
        continue;
      }

      $stylesheet = CSS_DIR . $page['stylesheet'];

      if ($this->deleteFile($stylesheet)) {
        $deleted .= $stylesheet . "<br />";
      }
    }

    // responsive
    $responsive_stylesheet = CSS_DIR . "responsive.css";
    if (file_exists($responsive_stylesheet)) {
      if ($this->deleteFile($responsive_stylesheet)) {
        $deleted .= $responsive_stylesheet . "<br />";
      }
    }

    // Print
    $print_stylesheet = CSS_DIR . "print.css";
    if (file_exists($print_stylesheet)) {
      if ($this->deleteFile($print_stylesheet)) {
        $deleted .= $print_stylesheet . "<br />";
      }
    }

    echo $deleted;
  }

  /**
   * Delete license file
   */
  private function deleteLicense() {

    $license = PROJECT_DIR . "../license.txt";

    if (file_exists($license)) {
      $this->deleteFile($license);
    }
  }

  /**
   * Delete file
   * @param $file string
   * @return boolean
   */
  private function deleteFile($file) {
    if (file_exists($file)) {
      if (unlink($file)) {
        return true;
      } else {
        return false;
      }
    } else {
      echo "File doesn't exist $file<br />";
    }
  }

  /**
   * Merge two files together
   */
  private function mergeFiles($first_file, $second_file) {

    // Let's make sure the file exists and is writable first.
    if (is_writable($first_file)) {

      if (!$handle = fopen($first_file, 'a')) {
         echo "Cannot open file $first_file<br />";
      }

      // Get content of second file
      if(file_exists($second_file)) {
        $content = file_get_contents($second_file);
        $content = "\n\n" . $content;

        // Write $content to the first file.
        if (fwrite($handle, $content) === FALSE) {
          echo "Cannot write to file $first_file<br />";
        } else {
          fclose($handle);
          return true;
        }
      } else {
        echo "Cannot open file $second_file<br />";
        fclose($handle);
        return false;
      }

    } else {
      echo "The file $first_file is not writable<br />";
      return false;
    }

  }

  /**
   * Append string to file
   */
  private function appendStringToFile($file, $string) {

    // Let's make sure the file exists and is writable first.
    if (is_writable($file)) {

      if (!$handle = fopen($file, 'a')) {
         echo "Cannot open file $first_file<br />";
      }

      // Write $content to the file.
      if (fwrite($handle, $string) === FALSE) {
        echo "Cannot write to file $file<br />";
      } else {
        fclose($handle);
        return true;
      }

    } else {
      echo "The file $file is not writable<br />";
      return false;
    }

  }

  /**
   * Handles creation of one file
   */
  private function createFile($filename, $content) {

    // Create file
    if (!$handle = fopen($filename, 'w+')) {
      echo "Cannot open file $filename<br />";
      exit;
    }

    // Write template content to opened file.
    if (fwrite($handle, $content) === FALSE) {
      echo "Cannot write to file<br />";
      exit;
    }

    fclose($handle);

    return true;
  }

}
?>
