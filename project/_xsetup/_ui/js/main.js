/*******************************************************************************

  CSS on Sails Framework
  Title: X-Setup
  Author: XHTMLized (http://www.xhtmlized.com/)
  Date: August 2010

*******************************************************************************/

$(document).ready(function() {
    XSetup.init();
});

var XSetup = {
    init: function() {
        XSetup.addCommon();
        XSetup.addPage();
        XSetup.remove();

        $("#content .files-list .title").live("change", function() {
            XSetup.updateNames($(this));
        });

        $("#content .pages input[type=checkbox]").live("change", function() {
            XSetup.updateStylesheetFolder($(this));
        });

        $(".pages").find('.title:last input').focus();
    },

    /**
     *Add common parts
     */
    addCommon: function() {
        $("#content .common .add a").bind("click", function() {
            $("#content .common table").append('<tr><td class="num"></td><td class="title"><input type="text" name="common_title[]" /></td><td class="file"><input type="text" name="common_file[]" /></td><td class="stylesheet"><input type="text" name="common_stylesheet[]" /></td><td class="remove"><a href="#">Remove</a></td></tr>');
            $(".common").find('.title:last input').focus();
            return false;
        });
    },

    /**
     * Add page
     */
    addPage: function() {
        $("#content .pages .add a").bind("click", function() {
            $("#content .pages table").append('<tr><td class="num"></td><td class="title"><input type="text" name="title[]" /></td><td class="file"><input type="text" name="file[]" /></td><td><input type="checkbox" checked="checked" /></td><td class="stylesheet"><input type="text" name="stylesheet[]" /></td><td class="folder"><input type="text" name="folder[]" /></td><td class="remove"><a href="#">Remove</a></td></tr>');
            $(".pages").find('.title:last input').focus();
            return false;
        });
    },

    /*
     * Remove common/page
     */
    remove: function() {
        $("#content .remove a").live("click", function() {
            $(this).parents("tr").remove();
            return false;
        });
    },

    /**
     * Create page URL, CSS and folder from page name
     * @param title object Title cell
     */
    updateNames: function(title) {
        var row = title.parent();
        var name = title.find("input").val().toLowerCase();
        name = name.replace("&", "and");
        name = name.replace(/\s+/g, "-");

        row.find(".file input").val(name + '.html');
    var stylesheet_input = row.find(".stylesheet input");
    if (stylesheet_input.val() !== 'main.css') {
          stylesheet_input.val(name + '.css');
    }
        row.find(".folder input").val(name);
    },

    /**
     * Update stylesheet and folder name
     * @param checkbox object Checkbox
     */
    updateStylesheetFolder: function(checkbox) {
        var row = checkbox.parents("tr");

        if (checkbox.is(':checked')) {
            XSetup.updateNames(row.find('.title'));
        } else {
            row.find(".stylesheet input").val('');
            row.find(".folder input").val('');
        }
    }

}
