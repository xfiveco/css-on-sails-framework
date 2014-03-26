<?php
include_once '_includes/tools.class.php';
include_once "_includes/header.php";

if (Tools::isFrameworkSetup()) {
?>
    <h2>Combine files</h2>
    <form action="combine.php" method="post" class="combine">
      <fieldset class="submit">
        <p>
          <input type="submit" value="Run" />
        </p>
      </fieldset>
    </form>

<?php
} else {
?>
    <h2>Set up CSS on Sails Framework</h2>

    <form action="setup.php" method="post" class="setup">
      <fieldset class="project">
        <h3>Project</h3>
        <ul>
          <li><label for="project_name">Project name:</label> <input type="text" name="project_name" id="project_name" value="" /></li>
          <li>
            <label for="producers">Project producer:</label>
            <select id="producers" name="producers">
              <option value="Malgorzata Jezierska">Malgorzata Jezierska</option>
              <option value="Pawel Straczek">Pawel Straczek</option>
              <option value="Bartek Piskorski">Bartek Piskorski</option>
              <option value="Stan Dzavoronok">Stan Dzavoronok</option>
            </select>
          <li><label for="developers">Developer(s):</label> <input type="text" name="developers" id="developers" value="" /></li>
        </ul>
      </fieldset>
      <fieldset class="options">
        <div>
          <h3>Markup</h3>
          <ul>
            <li>
              <input type="radio" id="html5" name="markup" value="html5" checked="checked" />
              <label for="html5"><strong>HTML5</strong></label>
            </li>
            <li>
              <input type="radio" id="xhtml" name="markup" value="xhtml" />
              <label for="xhtml"><strong>XHTML 1</strong></label>
            </li>
          </ul>
        </div>
        <div class="additional">
          <h3>Options</h3>
          <ul>
            <li>
              <input type="checkbox" name="wp" id="wp" value="wp" />
              <label for="wp" title="Adds default WP styling">WordPress</label>
            </li>
            <li>
              <input type="checkbox" name="responsive" id="responsive-optimized" value="responsive_optimized" />
              <label for="responsive-optimized" title="Adds media queries section">Responsive</label>
            </li>
            <li>
              <input type="checkbox" name="pie" id="pie" value="1" />
              <label for="pie" title="Adds the latest version of CSS3 PIE to support CSS3 in IE8-6">CSS3 PIE</label>
            </li>
            <li>
              <input type="checkbox" name="nobranding" id="nobranding" value="1" />
              <label for="nobranding" title="Removes XHTMLized branding from the framework">No branding</label>
            </li>
          </ul>
        </div>
        <div class="additional">
          <h3>jQuery version</h3>
          <div>
            <select name="jquery_version">
              <option value="1.10.2" selected="selected">1.10.2</option>
              <option value="1.8.3">1.8.3</option>
            </select>
          </div>
        </div>
      </fieldset>
      <fieldset class="files-list common">
        <h3>Common Parts</h3>
        <table>
          <tr>
            <th>#</th>
            <th>Common parts title</th>
            <th>Common parts file</th>
            <th>Stylesheet</th>
          </tr>
          <tr>
            <td class="num"></td>
            <td class="title"><input type="text" name="common_title[]" value="Common" /></td>
            <td class="file"><input type="text" name="common_file[]" value="common.html" /></td>
            <td class="stylesheet">main.css <input type="hidden" name="common_stylesheet[]" value="main.css" /></td>
            <td class="remove"></td>
          </tr>
        </table>
        <p class="add"><a href="#">+ Add Common Parts</a></p>
      </fieldset>
      <fieldset class="files-list pages">
        <h3>Pages</h3>
        <table>
          <tr>
            <th>#</th>
            <th>Page title</th>
            <th>Page file</th>
            <th></th>
            <th>Stylesheet</th>
            <th>Image folder</th>
          </tr>
          <tr>
            <td class="num"></td>
            <td class="title"><input type="text" name="title[]" value="Home" /></td>
            <td class="file"><input type="text" name="file[]" value="home.html" /></td>
            <td><input type="checkbox" checked="checked" /></td>
            <td class="stylesheet"><input type="text" name="stylesheet[]" value="home.css" /></td>
            <td class="folder"><input type="text" name="folder[]" value="home" /></td>
            <td class="remove"></td>
          </tr>
        </table>
        <p class="add"><a href="#">+ Add Page</a></p>

      </fieldset>
      <fieldset class="submit">
        <p>
          <input type="submit" value="Run" />
        </p>
      </fieldset>
    </form>

<?php

}
include_once "_includes/footer.php";
?>
