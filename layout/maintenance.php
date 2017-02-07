<?php
/**
 * @package   theme_uvirtualinvestigacion
 * @copyright 2017 leono286 - dhabernal
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$html = theme_uvirtualinvestigacion_get_html_for_settings($OUTPUT, $PAGE);
echo $OUTPUT->doctype() ?>
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
<div id="page" class="container-fluid">

    <header id="page-header" class="clearfix">
        <?php echo $OUTPUT->page_heading(); ?>
    </header>

    <div id="page-content" class="row-fluid">
        <section id="region-main" class="span12">
            <?php echo $OUTPUT->main_content(); ?>
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
</body>
</html>
