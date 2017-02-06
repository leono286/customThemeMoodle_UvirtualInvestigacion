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
 * The one column layout.
 *
 * @package   theme_uvirtualinvestigacion
 * @copyright 2013 Moodle, moodle.org
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Get the HTML for the settings bits.
$html = theme_uvirtualinvestigacion_get_html_for_settings($OUTPUT, $PAGE);
echo $OUTPUT->doctype(); ?>
<html <?php echo $OUTPUT->htmlattributes(); ?>>
<head>
    <title><?php echo $OUTPUT->page_title(); ?></title>
    <link rel="shortcut icon" href="<?php echo $OUTPUT->favicon(); ?>" />
    <?php echo $OUTPUT->standard_head_html() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body <?php echo $OUTPUT->body_attributes(); ?>>

<?php echo $OUTPUT->standard_top_of_body_html() ?>

<?php echo $html->heading ?>
<header role="banner" class="navbar <?php echo $html->navbarclass ?> moodle-has-zindex">
    <nav role="navigation" class="navbar-inner">
        <div class="container-fluid">
            <div id="custom_menu_courses">
                <?php echo $OUTPUT->custom_menu_courses(); ?>
            </div>
            <?php echo $OUTPUT->navbar_button(); ?>
            <?php echo $OUTPUT->user_menu(); ?>
            <div class="nav-collapse collapse">
                <?php echo $OUTPUT->custom_menu(); ?>
                <ul class="nav pull-right">
                    <li><?php echo $OUTPUT->page_heading_menu(); ?></li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<div id="page" class="container-fluid">

    <div id="page-content" class="row-fluid">
        <section id="region-main" class="span12">
            <?php
            echo $OUTPUT->course_content_header();
            echo $OUTPUT->main_content();
            echo $OUTPUT->course_content_footer();
            ?>


            <div id="dynamic_container">
                <div id="initial_div">
                    <div class="section_header">
                        <img src="<?php echo $OUTPUT->pix_url('frontpage_img/banner_home', 'theme'); ?>" alt="" />
                    </div>
                    <div class="section_content">
                        <div id="main_diagram">
                            <img src="<?php echo $OUTPUT->pix_url('frontpage_img/infografico_sin_texto', 'theme'); ?>">
                            <div class="nodebtn inv_cientifica"></div>
                            <div class="nodebtn formacion_para_inv"></div>
                            <div class="nodebtn innovacion_y_trans"></div>
                            <div class="nodebtn gestion_de_inv"></div>
                            <div class="node inv_cientifica">Investigación Científica</div>
                            <div class="node formacion_para_inv">Formación<span class="text_link">para la</span >Investigación</div>
                                <div class="node innovacion_y_trans">Innovación<span class="text_link">y</span>Transferencia</div>
                                <div class="node gestion_de_inv">Gestión<span class="text_link">de la</span >Investigación</div>
                                </div>
                                <a href="http://uvirtualinvestigacion.udem.edu.co/mod/forum/view.php?id=280"><img src="<?php echo $OUTPUT->pix_url('frontpage_img/enterate', 'theme'); ?>" alt="" id="news_forum"></a>
                            </div>
                        </div>
                        <?php
                        echo $html->html_cient_inv;
                        echo $html->html_form_inv;
                        echo $html->html_trans_innov;
                        echo $html->html_inv_mang;
                        ?>

            </div>
        </section>
    </div>
</div>
<footer id="page-footer">
    <div id="course-footer"><?php echo $OUTPUT->course_footer(); ?></div>
    <p class="helplink"><?php echo $OUTPUT->page_doc_link(); ?></p>
    <?php
    echo $html->footnote;
    echo $OUTPUT->standard_footer_html();
    ?>
</footer>
<?php echo $OUTPUT->standard_end_of_body_html() ?>
<script src="<?php echo $CFG->wwwroot; ?>/theme/uvirtualinvestigacion/js/custom.js"></script>
</body>
</html>
