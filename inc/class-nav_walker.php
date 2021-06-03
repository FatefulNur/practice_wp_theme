<?php 
function WWW() {
    class Menu_With_Description extends Walker_Nav_Menu {
        public $megaMenuID;
        public $count;

        public function __construct () {
            $this->megaMenuID = 0;
            $this->count = 0;
        }


        public function start_lvl( &$output, $depth = 0, $args = null ) {
            if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
                $t = '';
                $n = '';
            } else {
                $t = "\t";
                $n = "\n";
            }
            $indent = str_repeat( $t, $depth );
         
            // Default class.
            $classes = array( 'sub-menu', 'dropdown-menu' );
            $class_names = implode( ' ', apply_filters( 'nav_menu_submenu_css_class', $classes, $args, $depth ) );
            $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
            $output .= ($this->megaMenuID != 0 && $depth == 0) ? "{$n}{$indent}<ul class=\"row\">{$n}" : "{$n}{$indent}<ul$class_names>{$n}";
            if($this->megaMenuID != 0 && $depth == 0) {
                $output .= "<li class=\"col-sm-3\"><ul>\n";
            }
        }

        public function end_lvl( &$output, $depth = 0, $args = null ) {
            if($this->megaMenuID != 0 && $depth == 0) {
                $output .= '</ul></li>';
            }
            $output .= '</ul>';
        }



        public function start_el( &$output, $item, $depth = 0, $args = '', $id = 0 ) {

            $hasMegaMenu = get_post_meta( $item->ID, 'menu-item-megamenu', true );
            $hasColumnDivider = get_post_meta( $item->ID, 'menu-item-column-divider', true );
            $hasDivider = get_post_meta( $item->ID, 'menu-item-divider', true );
            $hasThumbnail = get_post_meta( $item->ID, 'menu-item-fea-img', true );
            $hasDesc = get_post_meta( $item->ID, 'menu-item-desc', true );

            $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
             
            $class_names = $value = '';
     
            $classes = empty( $item->classes ) ? array() : (array) $item->classes;

            if($this->megaMenuID != 0  AND $this->megaMenuID != intval( $item->menu_item_parent ) && $depth == 0) {
                /* $this->count++;
                if($this->count > 2) {
                    $output .= "</ul></li><li class=\"col-sm-3\"><ul>\n";
                    $this->count = 1;
                } */
                // $output .= $this->count;

                $this->megaMenuID = 0;

            } 
            if($hasThumbnail && $this->megaMenuID != 0) {
                array_push($classes, 'fea-img');
            }
            // $column_divider = array_search('column-divider', $classes);
            // $column_divider !== false
            if($hasColumnDivider) {
                array_push($classes, 'column-divider');
                $output .= '</ul></li><li class="col-sm-3"><ul>' . "\n";
                // unset($classes[$divider]);
            }
            // $divider = array_search('divider', $classes);
            // $divider !== false
            if($hasDivider) {
                $output .= '<li class="divider"></li>' . "\n";
                // unset($classes[$divider]);
            }
            // array_search('mega-menu', $classes) !== false 
            if($hasMegaMenu) {
                array_push($classes, 'megamenu');
                $this->megaMenuID = $item->ID;
            }


            /* ==================================Working with this================================================ */
            /* ==================================Working with this================================================ */
            /* ==================================Working with this================================================ */


            $classes[] = ($args->walker->has_children) ? 'dropdown' : '';
            $classes[] = ($item->current || $item->current_item_ancestor) ? 'active' : '';
            $classes[] = 'menu-item-' . $item->ID;
            if ($depth && $args->walker->has_children) {
                $classes[] = 'dropdown-submenu';
            } 	 
            $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ),$args, $item, $depth ) );
            $class_names = ' class="' . esc_attr( $class_names ) . '"';
     
            $output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';
     
            $attributes = ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) .'"' : '';
            $attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) .'"' : '';
            $attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) .'"' : '';
            $attributes .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) .'"' : '';
     
            $item_output = $args->before;
            $item_output .= '<a'. $attributes .'>';

            // check if item hass img
            // $has_feature_img = array_search('fea-img', $classes);
            // $has_feature_img !== false 
            if($hasThumbnail && $this->megaMenuID != 0) {
                $postID = url_to_postid( $item->url );
                $item_output .= "<img alt=\"".esc_attr( $item->attr_title )."\" src=\"".get_the_post_thumbnail_url( $postID )."\"/>";
                // unset($classes[$has_feature_img]);
            }

            $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
            $item_output .= (($depth == 0 || 1) AND $args->walker->has_children) ? '<span style="font-size: 15px"> &diams; </span></a>' : '</a>';

            if($hasDesc) {
                array_push($classes, 'desc');
            }

            $item_output .= '<span class="sub">' . $item->description . '</span>';
            $item_output .= $args->after;
     
            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
        }
    }
}
add_action( 'init', 'WWW' );