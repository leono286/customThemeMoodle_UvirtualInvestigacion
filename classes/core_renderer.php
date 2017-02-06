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
 * Renderers to align Moodle's HTML with that expected by Bootstrap
 *
 * @package    theme_bootstrapbase
 * @copyright  2012 Bas Brands, www.basbrands.nl
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


require_once($CFG->dirroot . '/theme/bootstrapbase/renderers.php');


class theme_uvirtualinvestigacion_core_renderer extends theme_bootstrapbase_core_renderer {

    /** @var custom_menu_item language The language menu if created */
    protected $language = null;

    /**
     * The standard tags that should be included in the <head> tag
     * including a meta description for the front page
     *
     * @return string HTML fragment.
     */
    public function standard_head_html() {
        global $SITE, $PAGE;

        $output = parent::standard_head_html();
        if ($PAGE->pagelayout == 'frontpage') {
            $summary = s(strip_tags(format_text($SITE->summary, FORMAT_HTML)));
            if (!empty($summary)) {
                $output .= "<meta name=\"description\" content=\"$summary\" />\n";
            }
        }

        return $output;
    }

    /*
     * This renders the navbar.
     * Uses bootstrap compatible html.
     */
    public function navbar() {
        $items = $this->page->navbar->get_items();
        if (empty($items)) {
            return '';
        }

        $breadcrumbs = array();
        foreach ($items as $item) {
            $item->hideicon = true;
            $breadcrumbs[] = $this->render($item);
        }
        $divider = '<span class="divider">'.get_separator().'</span>';
        $list_items = '<li>'.join(" $divider</li><li>", $breadcrumbs).'</li>';
        $title = '<span class="accesshide" id="navbar-label">'.get_string('pagepath').'</span>';
        return $title . '<nav aria-labelledby="navbar-label"><ul class="breadcrumb">' .
                $list_items . '</ul></nav>';
    }

    /*
     * Overriding the custom_menu function ensures the custom menu is
     * always shown, even if no menu items are configured in the global
     * theme settings page.
     */
    public function custom_menu($custommenuitems = '') {
        global $CFG;

        if (empty($custommenuitems) && !empty($CFG->custommenuitems)) {
            $custommenuitems = $CFG->custommenuitems;
        }
        $custommenu = new custom_menu($custommenuitems, current_language());
        return $this->render_custom_menu($custommenu);
    }

    /*
     * This renders the bootstrap top menu.
     *
     * This renderer is needed to enable the Bootstrap style navigation.
     */
    protected function render_custom_menu(custom_menu $menu) {

        $content = '<ul class="nav">';
        foreach ($menu->get_children() as $item) {
            $content .= $this->render_custom_menu_item($item, 1);
        }

        return $content.'</ul>';
    }

    /*
     * This code renders the custom menu items for the
     * bootstrap dropdown menu.
     */
    protected function render_custom_menu_item(custom_menu_item $menunode, $level = 0 ) {
        static $submenucount = 0;

        $content = '';
        if ($menunode->has_children()) {

            if ($level == 1) {
                $class = 'dropdown';
            } else {
                $class = 'dropdown-submenu';
            }

            if ($menunode === $this->language) {
                $class .= ' langmenu';
            }
            $content = html_writer::start_tag('li', array('class' => $class));
            // If the child has menus render it as a sub menu.
            $submenucount++;
            if ($menunode->get_url() !== null) {
                $url = $menunode->get_url();
            } else {
                $url = '#cm_submenu_'.$submenucount;
            }
            $content .= html_writer::start_tag('a', array('href'=>$url, 'class'=>'dropdown-toggle', 'data-toggle'=>'dropdown', 'title'=>$menunode->get_title()));
            $content .= $menunode->get_text();
            if ($level == 1) {
                $content .= '<b class="caret"></b>';
            }
            $content .= '</a>';
            $content .= '<ul class="dropdown-menu">';
            foreach ($menunode->get_children() as $menunode) {
                $content .= $this->render_custom_menu_item($menunode, 0);
            }
            $content .= '</ul>';
        } else {
            // The node doesn't have children so produce a final menuitem.
            // Also, if the node's text matches '####', add a class so we can treat it as a divider.
            if (preg_match("/^#+$/", $menunode->get_text())) {
                // This is a divider.
                $content = '<li class="divider">&nbsp;</li>';
            } else {
                $content = '<li>';
                if ($menunode->get_url() !== null) {
                    $url = $menunode->get_url();
                } else {
                    $url = '#';
                }
                $content .= html_writer::link($url, $menunode->get_text(), array('title' => $menunode->get_title()));
                $content .= '</li>';
            }
        }
        return $content;
    }

    public function custom_menu_courses() {
        global $CFG;
        $coursemenu = new custom_menu();
        if (isloggedin() && !isguestuser()) {
            $branchtitle = get_string('mycourses', 'theme_uvirtualinvestigacion');
            $branchlabel = $this->getfontawesomemarkup('briefcase')." ".$branchtitle;
            $branchurl = new moodle_url('');
            $branchsort = 200;
            $branch = $coursemenu->add($branchlabel, $branchurl, $branchtitle, $branchsort);
            $hometext = get_string('myhome');
            $homelabel = html_writer::tag('span', $this->getfontawesomemarkup('home').html_writer::tag('span', ' '.$hometext));
            $branch->add($homelabel, new moodle_url('/my/index.php'), $hometext);

            // Retrieve courses and add them to the menu when they are visible.
            $numcourses = 0;
            $courses = array();
            $direction = 'ASC';
            $sortorder = 'sortorder';
            $courses = enrol_get_my_courses(null, $sortorder.' '.$direction);

            if ($courses) {
                $mycoursesmax = PHP_INT_MAX;
                foreach ($courses as $course) {
                    if ($course->visible) {
                        $branchtitle = format_string($course->shortname);
                        $branchurl = new moodle_url('/course/view.php', array('id' => $course->id));
                        $enrolledclass = '';
                        if (!empty($course->timestart)) {
                            $enrolledclass .= ' class="onlyenrolled"';
                        }
                        $branchlabel = '<span'.$enrolledclass.'>'.$this->getfontawesomemarkup('graduation-cap')." ".format_string($course->fullname).'</span>';
                        $branch->add($branchlabel, $branchurl, $branchtitle);
                        $numcourses += 1;
                    } else if (has_capability('moodle/course:viewhiddencourses', context_course::instance($course->id))) {
                        $branchtitle = format_string($course->shortname);
                        $enrolledclass = '';
                        if (!empty($course->timestart)) {
                            $enrolledclass .= ' onlyenrolled';
                        }
                        $branchlabel = '<span class="dimmed_text'.$enrolledclass.'">'.$this->getfontawesomemarkup('eye-slash')." ".format_string($course->fullname).'</span>';
                        $branchurl = new moodle_url('/course/view.php', array('id' => $course->id));
                        $branch->add($branchlabel, $branchurl, $branchtitle);
                        $numcourses += 1;
                    }
                    if ($numcourses == $mycoursesmax) {
                        break;
                    }
                }
            }
            if ($numcourses == 0 || empty($courses)) {
                $noenrolments = get_string('noenrolments', 'theme_uvirtualinvestigacion');
                $branch->add('<em>'.$noenrolments.'</em>', new moodle_url('#'), $noenrolments);
            }
        }
        return $this->render_custom_menu($coursemenu);
    }

    /**
     * Outputs the language menu
     * @return custom_menu object
     */
    public function custom_menu_language() {
        global $CFG;
        $langmenu = new custom_menu();

        $addlangmenu = true;
        $langs = get_string_manager()->get_list_of_translations();
        if (count($langs) < 2
            or empty($CFG->langmenu)
            or ($this->page->course != SITEID and !empty($this->page->course->lang))
        ) {
            $addlangmenu = false;
        }

        if ($addlangmenu) {
            $strlang = get_string('language');
            $currentlang = current_language();
            if (isset($langs[$currentlang])) {
                $currentlang = $langs[$currentlang];
            } else {
                $currentlang = $strlang;
            }
            $this->language = $langmenu->add($this->getfontawesomemarkup('flag').$currentlang, new moodle_url('#'), $strlang, 100);
            foreach ($langs as $langtype => $langname) {
                $this->language->add($this->getfontawesomemarkup('language').$langname, new moodle_url($this->page->url,
                    array('lang' => $langtype)), $langname);
            }
        }
        return $this->render_custom_menu($langmenu);
    }


    private function getfontawesomemarkup($theicon, $classes = array(), $attributes = array(), $content = '') {
        $classes[] = 'fa fa-'.$theicon;
        $attributes['aria-hidden'] = 'true';
        $attributes['class'] = implode(' ', $classes);
        return html_writer::tag('span', $content, $attributes);
    }


    /**
     * This code renders the navbar button to control the display of the custom menu
     * on smaller screens.
     *
     * Do not display the button if the menu is empty.
     *
     * @return string HTML fragment
     */
    protected function navbar_button() {
        global $CFG;

        if (empty($CFG->custommenuitems) && $this->lang_menu() == '') {
            return '';
        }

        $iconbar = html_writer::tag('span', '', array('class' => 'icon-bar'));
        $button = html_writer::tag('a', $iconbar . "\n" . $iconbar. "\n" . $iconbar, array(
            'class'       => 'btn btn-navbar',
            'data-toggle' => 'collapse',
            'data-target' => '.nav-collapse'
        ));
        return $button;
    }

    /**
     * Renders tabtree
     *
     * @param tabtree $tabtree
     * @return string
     */
    protected function render_tabtree(tabtree $tabtree) {
        if (empty($tabtree->subtree)) {
            return '';
        }
        $firstrow = $secondrow = '';
        foreach ($tabtree->subtree as $tab) {
            $firstrow .= $this->render($tab);
            if (($tab->selected || $tab->activated) && !empty($tab->subtree) && $tab->subtree !== array()) {
                $secondrow = $this->tabtree($tab->subtree);
            }
        }
        return html_writer::tag('ul', $firstrow, array('class' => 'nav nav-tabs')) . $secondrow;
    }

    /**
     * Renders tabobject (part of tabtree)
     *
     * This function is called from {@link core_renderer::render_tabtree()}
     * and also it calls itself when printing the $tabobject subtree recursively.
     *
     * @param tabobject $tabobject
     * @return string HTML fragment
     */
    protected function render_tabobject(tabobject $tab) {
        if (($tab->selected and (!$tab->linkedwhenselected)) or $tab->activated) {
            return html_writer::tag('li', html_writer::tag('a', $tab->text), array('class' => 'active'));
        } else if ($tab->inactive) {
            return html_writer::tag('li', html_writer::tag('a', $tab->text), array('class' => 'disabled'));
        } else {
            if (!($tab->link instanceof moodle_url)) {
                // backward compartibility when link was passed as quoted string
                $link = "<a href=\"$tab->link\" title=\"$tab->title\">$tab->text</a>";
            } else {
                $link = html_writer::link($tab->link, $tab->text, array('title' => $tab->title));
            }
            $params = $tab->selected ? array('class' => 'active') : null;
            return html_writer::tag('li', $link, $params);
        }
    }



    /**
     * Produces a header for a block.
     *
     * @param block_contents $bc.
     * @return string.
     */
    protected function block_header(block_contents $bc) {
        $title = '';
        if ($bc->title) {
            $attributes = array();
            if ($bc->blockinstanceid) {
                $attributes['id'] = 'instance-'.$bc->blockinstanceid.'-header';
            }
            static $icons = array(
                'activity_modules' => 'puzzle-piece',
                'admin_bookmarks' => 'bookmark',
                'adminblock' => 'th-large',
                'blog_menu' => 'book',
                'blog_tags' => 'tags',
                'book_toc' => 'book',
                'calendar_month' => 'calendar',
                'calendar_upcoming' => 'calendar',
                'comments' => 'comments',
                'community' => 'globe',
                'completionstatus' => 'tachometer',
                'course_badges' => 'trophy',
                'course_list' => 'desktop',
                'feedback' => 'thumbs-o-up',
                'flickr' => 'flickr',
                'glossary_random' => 'lightbulb-o',
                'html' => 'list-alt',
                'iconic_html' => '', // It decides.
                'login' => 'user',
                'messages' => 'envelope',
                'mentees' => 'tags',
                'navigation' => 'sitemap',
                'news_items' => 'bullhorn',
                'myprofile' => 'user',
                'online_users' => 'users',
                'participants' => 'users',
                'private_files' => 'folder-o',
                'quiz_navblock' => 'code-fork',
                'quiz_results' => 'bar-chart',
                'recent_activity' => 'clock-o',
                'rss_client' => 'rss',
                'search_forums' => 'comments-o',
                'section_links' => 'bookmark',
                'selfcompletion' => 'tachometer',
                'settings' => 'cogs',
                'style_guide' => 'paint-brush',
                'tags' => 'tags',
                'theme_selector' => 'paint-brush',
                'twitter_search' => 'twitter',
                'youtube' => 'youtube'
            );
            if (array_key_exists($bc->attributes['data-block'], $icons)) {
                $theicon = $icons[$bc->attributes['data-block']];
            } else {
                $theicon = 'reorder';
            }
            $title = html_writer::tag('h2', $bc->title, $attributes);
            if (!empty($theicon)) {
                $title = $this->getfontawesomemarkup($theicon).$title;
            }
        }

        $blockid = null;
        if (isset($bc->attributes['id'])) {
            $blockid = $bc->attributes['id'];
        }
        $controlshtml = $this->block_controls($bc->controls, $blockid);

        $output = '';
        if ($title || $controlshtml) {
            $output .= html_writer::tag('div', html_writer::tag('div',
                html_writer::tag('div', '', array('class' => 'block_action')).$title.$controlshtml, array('class' => 'title')),
                array('class' => 'header'));
        }
        return $output;
    }

    public function custom_breadcrumb() {
        $html = html_writer::start_div('clearfix container-fluid', array('id' => 'page-navbar'));
        $html .= html_writer::tag('div', $this->navbar(), array('class' => 'breadcrumb-nav'));
        $html .= html_writer::div($this->page_heading_button(), 'breadcrumb-button');
        $html .= html_writer::end_div();
        return $html;
    }

    public function full_header() {
        $html = html_writer::start_tag('header', array('id' => 'page-header', 'class' => 'clearfix'));
        // $html .= $this->context_header();
        $html .= html_writer::tag('div', $this->course_header(), array('id' => 'course-header'));
        $html .= html_writer::end_tag('header');
        return $html;
    }

    public function course_content_header($onlyifnotcalledbefore = false) {
        global $CFG;
        $html = $this->context_header();
        if ($this->page->course->id == SITEID && $this->page->pagelayout == 'frontpage') {
            // return immediately and do not include /course/lib.php if not necessary
            return '';
        }
        static $functioncalled = false;
        if ($functioncalled && $onlyifnotcalledbefore) {
            // we have already output the content header
            return $html;
        }
        require_once($CFG->dirroot.'/course/lib.php');
        $functioncalled = true;
        $courseformat = course_get_format($this->page->course);
        if (($obj = $courseformat->course_content_header()) !== null) {
            $html .= html_writer::div($courseformat->get_renderer($this->page)->render($obj), 'course-content-header');
            return $html;
        }
        return $html;
    }

    /**
     * Internal implementation of user image rendering.
     *
     * @param user_picture $userpicture
     * @return string
     */
    protected function render_user_picture(\user_picture $userpicture) {
        if ($this->page->pagetype == 'mod-forum-discuss') {
            $userpicture->size = 1;
        } else if ((empty($userpicture->size)) || ($userpicture->size != 64)) {
            $userpicture->size = 72;
        }
        return parent::render_user_picture($userpicture);
    }




}
