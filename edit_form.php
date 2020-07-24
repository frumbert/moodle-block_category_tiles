<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Category Tiles block.
 *
 * @package    block_category_tiles
 * @copyright  1999 onwards tim.stclair@gmail.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * A block for linking to top-level categories in visual way.
 */

class block_category_tiles_edit_form extends block_edit_form {

    protected function specific_definition($mform) {
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        $mform->addElement('text', 'config_title', get_string('configtitle', 'block_category_tiles'));
        $mform->setDefault('config_title', get_string('pluginname', 'block_category_tiles'));
        $mform->setType('config_title', PARAM_TEXT);

        $mform->addElement('selectyesno', 'config_filter', get_string('configfilter', 'block_category_tiles'));
        $mform->addHelpButton('config_filter', 'configfilter', 'block_category_tiles');
        $mform->setDefault('config_filter', 0);

    }

}
