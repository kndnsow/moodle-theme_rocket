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
 * General layout for the mymobile theme
 *
 * @package    theme
 * @subpackage rocket
 * @copyright  Julian Ridden
 * @maintaned by 2014 Dualcube {@link http://dualcube.com/}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
// Get settings.
$hasheading = ($PAGE->heading);
$hasnavbar = (empty($PAGE->layout_options['nonavbar']) && $PAGE->has_navbar());
$hasfooter = (empty($PAGE->layout_options['nofooter']));
$hassidepre = (empty($PAGE->layout_options['noblocks']) && $PAGE->blocks->region_has_content('side-pre', $OUTPUT));
$hassidepost = (empty($PAGE->layout_options['noblocks']) && $PAGE->blocks->region_has_content('side-post', $OUTPUT));
$haslogininfo = (empty($PAGE->layout_options['nologininfo']));
// Get custom region settings.
$hassearch = ($PAGE->blocks->region_has_content('search', $OUTPUT));
$hastoplinks = ($PAGE->blocks->region_has_content('toplinks', $OUTPUT));
$hashomeblock = ($PAGE->blocks->region_has_content('homeblock', $OUTPUT));
$showsidepre = ($hassidepre && !$PAGE->blocks->region_completely_docked('side-pre', $OUTPUT));
$showsidepost = ($hassidepost && !$PAGE->blocks->region_completely_docked('side-post', $OUTPUT));
$custommenu = $OUTPUT->custom_menu();
$hascustommenu = (empty($PAGE->layout_options['nocustommenu']) && !empty($custommenu));
$hasfootnote = (!empty($PAGE->theme->settings->footnote));
// Load lang strings.
$editingmode = get_string('editingmode', 'theme_rocket');
$bodyclasses = array();
if ($showsidepre && !$showsidepost) {
    $bodyclasses[] = 'side-pre-only';
} else if ($showsidepost && !$showsidepre) {
    $bodyclasses[] = 'side-post-only';
} else if (!$showsidepost && !$showsidepre) {
    $bodyclasses[] = 'content-only';
}
if ($hascustommenu) {
    $bodyclasses[] = 'has_custom_menu';
}
echo $OUTPUT->doctype() ?>
<html <?php echo $OUTPUT->htmlattributes(); ?>>
    <head>
        <title><?php echo $PAGE->title ?></title>
        <link rel="shortcut icon" href="<?php echo $OUTPUT->pix_url('favicon', 'theme')?>" />
        <?php 
        if ( $CFG->version >= 2016120500 ) {?>
            <link rel="stylesheet" type="text/css" href="<?php echo $CFG->wwwroot; ?>/theme/rocket/style/acustom.css" />

            <!-- START AUTOHIDE STATUS CHECK -->
            <?php 
        }
        if (!empty($PAGE->theme->settings->autohide)) {
            $autohide = $PAGE->theme->settings->autohide;
        } else {
            $autohide = 'disable';
        }
        if ($autohide == 'enable') {
            ?><link rel="stylesheet" type="text/css" href="<?php echo $CFG->wwwroot; ?>/theme/rocket/style/rocket_autohide.css" />
            <?php
        }?>
        <!-- END AUTOHIDE STATUS CHECK -->
        <!-- START BOOTSRTAP STATUS CHECK -->
        <?php 
        if (!empty($PAGE->theme->settings->bootstrap)) {
            $bootstrap = $PAGE->theme->settings->bootstrap;
        } else {
            $bootstrap = 'disable';
        }
        if ($bootstrap == 'enable') {
            ?><link rel="stylesheet" type="text/css" href="<?php echo $CFG->wwwroot; ?>/theme/rocket/style/rocket_bootstrap.css" /><?php
        }?>
        <!-- END BOOTSTRAP STATUS CHECK -->
        <?php 
        echo $OUTPUT->standard_head_html(); ?>
    </head>
    <body id="<?php p($PAGE->bodyid) ?>" class="<?php p($PAGE->bodyclasses.' '.join(' ', $bodyclasses)) ?>"><?php 
        echo $OUTPUT->standard_top_of_body_html() ?>
        <div id="page-wrapper">
            <div id="page"><?php 
                if ($hasheading || $hasnavbar) { ?>
                    <div id="page-header"><?php 
                        if ($hasheading) { ?>
                            <table style="width:100%; height:133px; margin: 0px;">
                                <tr>
                                    <td id="td1" style="margin:0px; padding:0px;">
                                        <a class="logo" href="<?php echo $CFG->wwwroot; ?>" title="<?php print_string('home'); ?>"></a>
                                    </td>
                                    <td id="td2" valign="bottom" style="margin:0px; padding:0px;">
                                        <div class="headermenu"><?php
                                            if($CFG->version >= 2016120500){?>
                                                <div class="duc_usermenu"><?php 
                                                    echo $OUTPUT->user_menu(); ?>
                                                </div>
                                                <div class="duc_nav_plugin_output"><?php 
                                                    echo $OUTPUT->navbar_plugin_output(); ?>
                                                </div><?php
                                            } else {
                                                if ($haslogininfo) {
                                                    echo $OUTPUT->login_info();
                                                }
                                                if (!empty($PAGE->layout_options['langmenu'])) {
                                                    echo $OUTPUT->lang_menu();
                                                }
                                                echo $PAGE->headingmenu;
                                            }?>
                                        </div>
                                        <!-- START CUSTOMMENU -->
                                        <div id="navcontainer"><?php 
                                            if ($hascustommenu) { ?>
                                                <div id="menuwrap">
                                                    <div id="custommenu" class="javascript-disabled"><?php echo $custommenu; ?>
                                                    </div>
                                                </div><?php
                                            }?>
                                        </div>
                                            <!-- END OF CUSTOMMENU -->
                                    </td>
                                </tr>
                            </table><?php
                        }?>
                    </div><?php
                }?>
                <!-- END OF HEADER -->
                <div id="editingmode"><?php echo $editingmode ?>
                </div>
                <div id="page-content">
                    <div id="hometopblocks">
                        <div class="block-region" id="toplinks">
                            <div class="region-content"><?php 
                                if ($hastoplinks) { ?><?php 
                                    echo $OUTPUT->blocks_for_region('toplinks') ?><?php
                                }?>
                            </div>
                        </div><?php
                        if($CFG->version >= 2016120500){
                            echo "<div id='homeblock'>";
                        } else { ?>
                        <div class="block-region" id="homeblock"><?php 
                        } ?>
                            <div class="region-content"><?php 
                                if ($hashomeblock) { ?><?php 
                                    echo $OUTPUT->blocks_for_region('homeblock') ?><?php
                                }?>
                            </div>
                        </div>
                    </div>
                    
                    <div id="headerstrip" class="duc_frontpage_headerstrip">
                        <div class="block-region" id="search">
                            <div class="region-content">
                                <?php 
                                if ($hassearch) { ?>
                                    <?php echo $OUTPUT->blocks_for_region('search') ?><?php
                                }?>
                            </div>
                        </div>
                        <div id="sitename"><?php echo $PAGE->theme->settings->sitename; ?>
                        </div>
                    </div>
                    <div id="region-main-box">
                        <div id="region-post-box"><?php
                            if($CFG->version >= 2016120500){?><?php 
                                if ($hassidepre) { ?>
                                    <div id="region-pre" class="block-region">
                                        <div class="region-content">
                                            <?php echo $OUTPUT->blocks_for_region('side-pre') ?>
                                        </div>
                                    </div><?php
                                }?>
                                <div id="region-main-wrap">
                                    <div id="region-main-pad">
                                        <div id="region-main">
                                            <div class="region-content">
                                                <?php echo $OUTPUT->main_content() ?>
                                            </div>
                                        </div>
                                    </div>
                                </div><?php 
                            } else {?>
                                <div id="region-main-wrap">
                                    <div id="region-main-pad">
                                        <div id="region-main">
                                            <div class="region-content">
                                                <?php echo $OUTPUT->main_content() ?>
                                            </div>
                                        </div>
                                    </div>
                                </div><?php 
                                if ($hassidepre) { ?>
                                    <div id="region-pre" class="block-region">
                                        <div class="region-content"><?php 
                                            echo $OUTPUT->blocks_for_region('side-pre') ?>
                                        </div>
                                    </div><?php
                                }
                            }?><?php 
                            if ($hassidepost) { ?>
                                <div id="region-post" class="block-region">
                                    <div class="region-content"><?php 
                                        echo $OUTPUT->blocks_for_region('side-post') ?>
                                    </div>
                                </div><?php
                            }?>
                        </div>
                    </div>
                </div>
                <!-- START OF FOOTER -->
                <?php 
                if ($hasfooter) { ?>
                    <div id="page-footer" class="clearfix">
                        <div class="footer-left"><?php 
                            if ($hasfootnote) { ?>
                                <div id="footnote"><?php echo $PAGE->theme->settings->footnote;?></div><?php
                            }?>
                            <a href="http://moodle.org" title="Moodle">
                                <div id="logo">
                                </div>
                            </a>
                        </div>
                        <div class="footer-right">
                            <div class="copyright"><?php echo $PAGE->theme->settings->copyright;?>
                            </div><?php 
                            echo $OUTPUT->login_info();?>
                        </div><?php 
                        echo $OUTPUT->standard_footer_html(); ?>
                    </div><?php
                }?>
                <div class="clearfix">
                </div>
            </div>
        </div>
        <?php echo $OUTPUT->standard_end_of_body_html() ?>
    </body>
</html>
