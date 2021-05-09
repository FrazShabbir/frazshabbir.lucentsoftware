<?php
/**
* Classes setup
*
* @package WordPress
* @subpackage Native Theme
* @since 1.0
*/


// add navigation description
// @since Native 1.0


// devo trovare una funzione che verifiche se il wp_nav_menu che chiama description_walker non sia vuoto


if(!class_exists('Description_Walker')) {
	
	class Description_Walker extends Walker_Nav_Menu
	{
			/**
			 * Start the element output.
			 *
			 * @param  string $output Passed by reference. Used to append additional content.
			 * @param  object $item   Menu item data object.
			 * @param  int $depth     Depth of menu item. May be used for padding.
			 * @param  array $args    Additional strings.
			 * @return void
			 */
				function start_el(&$output, $object, $depth = 0, $args = array(), $current_object_id = 0)
			{
					$classes     = empty ( $object->classes ) ? array () : (array) $object->classes;
	
					$class_names = join(
							' '
					,   apply_filters(
									'nav_menu_css_class'
							,   array_filter( $classes ), $object
							)
					);
	
					! empty ( $class_names )
							and $class_names = ' class="'. esc_attr( $class_names ) . '"';
	
					$output .= "<li id='menu-item-$object->ID' $class_names>";
	
					$attributes  = '';
	
					! empty( $object->attr_title )
							and $attributes .= ' title="'  . esc_attr( $object->attr_title ) .'"';
					! empty( $object->target )
							and $attributes .= ' target="' . esc_attr( $object->target     ) .'"';
					! empty( $object->xfn )
							and $attributes .= ' rel="'    . esc_attr( $object->xfn        ) .'"';
					! empty( $object->url )
							and $attributes .= ' href="'   . esc_attr( $object->url        ) .'"';
	
					// insert description for top level elements only
					// you may change this
					$description = ( ! empty ( $object->description ) and 0 == $depth )
							? '<p>' . esc_attr( $object->description ) . '</p>' : '';
	
					$title = apply_filters( 'the_title', $object->title, $object->ID );
					
					
					if(isset($args)) {
					
					 // al posto di item qui sotto c'era args e non funzionava, così pare funzionare, non visualizza più il primo però -.-
						$object_output = $args->before
								. "<a $attributes>"
								. $args->link_before
								. $title
								. '</a> '
								. $args->link_after
								. $args->after
								. $description;
					
					}
					
					// Since $output is called by reference we don't need to return anything.
					$output .= apply_filters(
							'walker_nav_menu_start_el'
					,   $object_output
					,   $object
					,   $depth
					,   $args
					);
			}
	}

}
