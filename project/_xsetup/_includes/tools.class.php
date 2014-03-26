<?php
/**
 * Tools
 *
 * Helper class
 *
 * @author Lubos Kmetko <lubos@xhtmlized.com>
 *
 */

/**
 * Tools Class
 */
class Tools {

  /**
   * Check if is framework already set up
   */
  public static function isFrameworkSetup() {
    if(file_exists("commonparts.txt") && file_exists("pages.txt")) {
      return true;
    } else {
      return false;
    }
  }

}
