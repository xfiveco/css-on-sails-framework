<?php
/**
 * X-Setup
 *
 * Tool for setting up CSS on Sails Framework
 *
 * @author Lubos Kmetko <lubos@xhtmlized.com>
 *
 */


/**
 * Config
 */
// Directories
define("PROJECT_DIR", dirname( __FILE__ ) . "/../../");
define("IMAGES_DIR", dirname( __FILE__ ) . "/../../_ui/images/");
define("SOURCES_DIR", dirname( __FILE__ ) . "/../../_sources/");

// Templates
define("FRAMEWORK_TEMPLATE", "_templates/framework.html");
define("FRAMEWORK_NOBRANDING_TEMPLATE", "_templates/framework-nobranding.html");
define("XHTML_TEMPLATE", "_templates/xhtml.html");
define("HTML5_TEMPLATE", "_templates/html5.html");
define("WP_TEMPLATE", "_templates/wp.html");
define("CSS_TEMPLATE", "_templates/css/main.css");
define("CSS_PAGE_TEMPLATE", "_templates/css/page.css");
define("CSS_WP_TEMPLATE", "_templates/css/wp.css");
define("CSS_RESPONSIVE_TEMPLATE", "_templates/css/responsive.css");
define("CSS_PRINT_TEMPLATE", "_templates/css/print.css");
define("JS_TEMPLATE", "_templates/js/main.js");

// Other
define("FRAMEWORK", "CSS on Sails Framework");
define("AUTHOR", "Author: XHTMLized.com");

/**
 * X-Setup Class
 */
class XSetup {

  /**
   * Project name
   */
  private $project_name = "";

  /**
   * Project producers
   */
  private $producers = "";


  /**
   * Developers
   */
  private $developers = "";

  /**
   * Markup type
   */
  private $markup = "";

  /**
   * List of common parts
   */
  private $common_parts_list = array();

  /**
   * List of pages
   */
  private $page_list = array();

  /**
   * HTML Template
   */
  private $html_template = "";

  function __construct() {

    if (isset($_POST['project_name'])) {
      $this->project_name = $_POST['project_name'];
    }

    if (isset($_POST['producers'])) {
      $this->producers = $_POST['producers'];
    }

    if (isset($_POST['developers'])) {
      $this->developers = $_POST['developers'];
    }

    if (isset($_POST['markup'])) {
      $this->markup = $_POST['markup'];
    }

    // Set up HTML5 template for HTML5 projects
    if ($this->markup == 'html5') {
      $this->html_template = HTML5_TEMPLATE;
    } else {
      $this->html_template = XHTML_TEMPLATE;
    }

    // Options
    if (isset($_POST['wp'])) {
      $this->wp = true;
    } else {
      $this->wp = false;
    }

    if (isset($_POST['responsive'])) {
      $this->responsive = true;
    } else {
      $this->responsive = false;
    }

    if (isset($_POST['pie'])) {
      $this->pie = true;
    } else {
      $this->pie = false;
    }

    if (isset($_POST['nobranding'])) {
      $this->nobranding = true;
    } else {
      $this->nobranding = false;
    }

    if (isset($_POST['jquery_version'])) {
      $this->jquery_version = $_POST['jquery_version'];
    }

    // Create list of common parts
    $this->common_parts_list = $this->getPostedCommonParts();

    // Create list of posted pages
    $this->page_list = $this->getPostedPages();

  }

  /**
   * Run set up of CSS on Sails Framework
   */
  public function run() {
    $this->createFiles();
    $this->createDirectories();
    $this->createFrameworkIndex();
    $this->createConfig();
  }

  /**
   * Get list of pages details posted via user interface
   */
  public function getPostedCommonParts() {

    $common_parts_list = array();

    if (isset($_POST['common_file'])) {
      $num = count($_POST['common_file']);
      for ($i = 0; $i < $num; $i++) {
        if ($_POST['common_title'][$i] != '') {
          $common_parts_list[$i]['number'] = $i + 1;
          $common_parts_list[$i]['title'] = $_POST['common_title'][$i];
          $common_parts_list[$i]['file'] = $_POST['common_file'][$i];
          $common_parts_list[$i]['stylesheet'] =  $_POST['common_stylesheet'][$i];
        }
      }
    } else {
      echo "No common parts posted";
      exit;
    }
    return $common_parts_list;
  }

  /**
   * Get list of pages details posted via user interface
   */
  public function getPostedPages() {

    $page_list = array();

    if (isset($_POST['file'])) {
      $num = count($_POST['file']);

      for ($i = 0; $i < $num; $i++) {
        if ($_POST['title'][$i] != '') {
          $page_list[$i]['number'] = $i + 1;
          $page_list[$i]['title'] = $_POST['title'][$i];
          $page_list[$i]['file'] = $_POST['file'][$i];
          $page_list[$i]['stylesheet'] =  $_POST['stylesheet'][$i];
          $page_list[$i]['folder'] =  $_POST['folder'][$i];
        }
      }
    } else {
      echo "No pages posted";
      exit;
    }
    return $page_list;
  }

  /**
   * Create HTML list of pages
   */
  public function getHTMLPageList() {

    $html_page_list = "";

    foreach($this->page_list as $page) {
      $html_page_list .= '        <li><i class="fa fa-file-o"></i><a href="project/' . $page['file'] . '"><strong>' . $page['title'] . '</strong> ' . $page['file'] . "</a><i class=\"fa fa-check\"></i></li>\n";
    }

    return $html_page_list;
  }

  /**
   * Create text list of common parts
   */
  private function getTextCommonPartsList() {

    $text_common_parts_list = "";

    foreach($this->common_parts_list as $common_part) {
      $text_common_parts_list .= $common_part['title'] . '|' . $common_part['file'] . '|' . $common_part['stylesheet'] . "\n";
    }

    return $text_common_parts_list;
  }

  /**
   * Create text list of pages
   */
  private function getTextPageList() {

    $text_page_list = "";

    foreach($this->page_list as $page) {
      $text_page_list .= $page['title'] . '|' . $page['file'] . '|' . $page['stylesheet'] . "\n";
    }

    return $text_page_list;
  }

  /**
   * Get list of pages
   * @return array
   */
  public function getPageList() {
    return $this->page_list;
  }

  /**
   * Get formatted list of pages to insert into main.css
   * @return string
   */
  public function getFormattedPageList() {
    $list = "";
    $i = 1;
    $pages = $this->getPageList();
    foreach ($pages as $page) {
      $list .=  "    3." . $i . " " . $page["title"] . "\n";
      $i += 1;
    }
    return $list;
  }

  /**
   * Update framework index page
   */
  private function createFrameworkIndex() {
    // Create Framework index
    if ($this->nobranding) {
      $framework_template = file_get_contents(FRAMEWORK_NOBRANDING_TEMPLATE);
    } else {
      $framework_template = file_get_contents(FRAMEWORK_TEMPLATE);
    }

    $framework_template = $this->customizeTemplate($framework_template, 'FRAMEWORK');
    $this->createFile("../../index.html", $framework_template);
  }

  /**
   * Create config files
   */
  private function createConfig() {
    $common_parts = $this->getTextCommonPartsList();
    $pages = $this->getTextPageList();
    $this->createFile("commonparts.txt", $common_parts);
    $this->createFile("pages.txt", $pages);
  }

  /**
   * Create all HTML and CSS files based on list of common parts and pages
   */
  private function createFiles() {

    $all = "";

    // Common parts
    foreach($this->common_parts_list as $common_parts) {

      // Create HTML for common parts
      $html_template = file_get_contents($this->html_template);
      $html_template = $this->customizeTemplate($html_template, 'HTML', $common_parts);
      $this->createFile("../" . $common_parts['file'], $html_template);

      // Create CSS for common parts
      if ($common_parts['stylesheet'] == 'main.css') {
        $css_template = file_get_contents(CSS_TEMPLATE);
        $css_template =$this->customizeTemplate($css_template, 'CSS_MAIN');
      } else {
        $css_template = "";
      }
      $this->createFile("../_ui/css/" . $common_parts['stylesheet'], $css_template);
      $all .= "@import url(" . $common_parts['stylesheet'] . ");\n";

    }

    // Pages
    foreach($this->page_list as $page) {

      // Create HTML Files
      $html_template = file_get_contents($this->html_template);
      $html_template = $this->customizeTemplate($html_template, 'HTML', $page);
      $this->createFile("../" . $page['file'], $html_template);

      // Create CSS Files
      if ($page['stylesheet'] != '') {

        $css_page_template = file_get_contents(CSS_PAGE_TEMPLATE);
        $css_page_template = $this->customizeTemplate($css_page_template, 'CSS_PAGE', $page);
        $this->createFile("../_ui/css/" . $page['stylesheet'], $css_page_template);
        $all .= "@import url(" . $page['stylesheet'] . ");\n";
      }
    }

    // WP sample page
    if ($this->wp) {
      $wp_page = array("file" => "wp.html", "title" => "Sample WordPress Page");
      $html_template = file_get_contents($this->html_template);
      $html_template = $this->customizeTemplate($html_template, 'HTML', $wp_page);
      $this->createFile("../" . $wp_page['file'], $html_template);
    }

    // Responsive support
    if ($this->responsive) {
      $css_responsive_template = file_get_contents(CSS_RESPONSIVE_TEMPLATE);
      $this->createFile("../_ui/css/responsive.css", $css_responsive_template);
      $all .= "@import url(responsive.css);\n";
    }

    // Print support
    $css_print_template = file_get_contents(CSS_PRINT_TEMPLATE);
    $css_print_template = $this->customizeTemplate($css_print_template, 'CSS_PRINT');
    $this->createFile("../_ui/css/print.css", $css_print_template);
    $all .= "@import url(print.css);\n";

    // Import all stylesheets in all.css and all-ie.css
    $this->createFile("../_ui/css/all.css", $all);

    // Create _ui/js/main.js
    $js_template = file_get_contents(JS_TEMPLATE);
    $js_template =$this->customizeTemplate($js_template, 'JS');
    $this->createFile("../_ui/js/main.js", $js_template);

    // Copy PIE
    if ($this->pie) {
      $this->createFile("../.htaccess", file_get_contents("_templates/.htaccess"));
      $this->createFile("../_ui/js/PIE.htc", file_get_contents("_templates/js/PIE.htc"));
    }
  }

  /**
   * Create all Directories
   */
   private function createDirectories() {
    foreach($this->page_list as $page) {

      // Create _/ui/images Directories
      if ($page['folder'] != '') {
        $this->createDirectory(IMAGES_DIR . $page['folder']);
      }

      // Create _sources Directories
      if ($page['folder'] != '') {
        $this->createDirectory(SOURCES_DIR . $page['folder']);
      }
    }
  }

  /**
   * Customize HTML and CSS templates
   * @param string $template
   * @param string $type
   * @param array $page
   */
  private function customizeTemplate($template, $type, $page = "") {

    switch ($type) {
      case 'HTML':
        $template = str_replace("{page_title}", $page['title'], $template);
        $template = str_replace("{project_name}", $this->project_name, $template);
        $template = str_replace("{jquery_version}", $this->jquery_version, $template);

        // WP project
        if ($page['file'] == "wp.html") {
          $wp_template = file_get_contents(WP_TEMPLATE);
          $template = str_replace("{wp}", $wp_template, $template);
        } else {
          $template = str_replace("{wp}", "", $template);
        }

        break;

      case 'CSS_MAIN':
        $template = str_replace("{project_name}", $this->project_name, $template);
        $template = str_replace("{date}", date("F Y"), $template);
        $template = str_replace("{pages}", $this->getFormattedPageList(), $template);

        // WP default styles
        if ($this->wp) {
          $wp_styles = file_get_contents(CSS_WP_TEMPLATE);
          $template = str_replace("{wp}", $wp_styles, $template);
        } else {
          $template = str_replace("{wp}", "", $template);
        }

        if ($this->responsive) {
          $responsive_replace = "  4. RESPONSIVE";
          $print_replace = "  5. PRINT";
        } else {
          $responsive_replace = "";
          $print_replace = "  4. PRINT";
        }

        if ($this->nobranding) {
          $template = str_replace("{framework}", "", $template);
          $template = str_replace("{author}", "", $template);
        } else {
          $template = str_replace("{framework}", FRAMEWORK, $template);
          $template = str_replace("{author}", AUTHOR, $template);
        }

        $template = str_replace("{responsive}", $responsive_replace, $template);
        $template = str_replace("{print}", $print_replace, $template);
        break;

      case 'CSS_PAGE':
        $template = str_replace("{page_title}", $page['title'], $template);
        $template = str_replace("{page_number}", $page['number'], $template);
        break;

      case 'CSS_PRINT':
        if ($this->responsive) {
          $section_number = 5;
        } else {
          $section_number = 4;
        }
        $template = str_replace("{section_number}", $section_number, $template);
        break;

      case 'JS':
        $template = str_replace("{project_name}", $this->project_name, $template);
        $template = str_replace("{date}", date("F Y"), $template);

        if ($this->nobranding) {
          $template = str_replace("{framework}", "", $template);
          $template = str_replace("{author}", "", $template);
        } else {
          $template = str_replace("{framework}", FRAMEWORK, $template);
          $template = str_replace("{author}", AUTHOR, $template);
        }

        break;

      case 'FRAMEWORK':
        $template = str_replace("{project_name}", stripslashes($this->project_name), $template);
        // $template = str_replace("{project_name_archive}", str_replace(" ", "_", stripslashes($this->project_name)), $template);
        $template = str_replace("{started_on}", date("F jS, Y"), $template);
        // $template = str_replace("{pages_num}", count($this->getPageList()), $template);
        $template = str_replace("{producers}", stripslashes($this->producers), $template);
        $template = str_replace("{developers}", stripslashes($this->developers), $template);
        $template = str_replace("{pages}", $this->getHTMLPageList(), $template);
        break;
    }
    return $template;
  }

  /**
   * Handles creation of one file
   */
  private function createFile($filename, $template) {

    // Create file
    if (!$handle = fopen($filename, 'w+')) {
      echo "Cannot open file $filename";
      exit;
    }

    // Write template content to opened file.
    if (fwrite($handle, $template) === FALSE) {
      echo "Cannot write to file";
      exit;
    }

    echo '<li class="success">Success, created file '. $filename . '</li>';

    fclose($handle);
  }

  /**
   * Handles creation of directory
   * @param string $directory
   */
  private function createDirectory($directory) {
    // Check if directory exists
    if(is_dir($directory)) {
      echo '<li class="error">Directory already exists ' . $directory . '</li>';
    } else {
      if (!mkdir($directory)) {
        echo '<li class="error">Cannot create directory ' . $directory . '</li>';
      } else {
        echo '<li class="success">Success, created ' . $directory . '</li>';
      }

    }

  }

}
?>
