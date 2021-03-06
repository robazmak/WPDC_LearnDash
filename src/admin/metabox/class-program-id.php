<?php namespace WPDC_Learndash\Admin\Metabox;

/**
 * Program ID Metabox
 *
 * @package     WPDC_Learndash\Admin\Metabox
 * @since       2.0.0
 * @author      WPDevelopersClub and hellofromTonya
 * @link        http://wpdevelopersclub.com/
 * @license     GNU General Public License 2.0+
 */

use WP_Query;
use WPDevsClub_Core\Admin\Metabox\Metabox;

class Program_Id extends Metabox {

	/***********************
	 * Helpers
	 **********************/

	/**
	 * Build the Program Code HTML
	 *
	 * @since 1.1.0
	 *
	 * @param int|null $selected_program_id
	 * @return string
	 */
	protected function build_program_id_html( $selected_program_id ) {
		$query = $this->get_program_code_query();

		return $this->do_program_code_loop( $query, (int) $selected_program_id );
	}

	/**
	 * Do the program code loop
	 *
	 * @since 1.0.0
	 *
	 * @param stdClass|bool $query
	 * @param int $selected_program_id Selected Program ID
	 * @param string $html
	 *
	 * @return string
	 */
	protected function do_program_code_loop( $query, $selected_program_id, $html = '' ) {
		if ( ! is_object( $query ) ) {
			return $html;
		}

		foreach ( $query->posts as $program ) {
			$course_program_code = get_post_meta( $program->ID, $this->config->program_code_meta_key, true);

			$html .= sprintf($this->config->options_html_pattern,
				$program->ID,
				selected( $program->ID, $selected_program_id, false ),
				$course_program_code
			);

		}
		wp_reset_postdata();

		return $html;
	}

	/**
	 * Get Program Code Query
	 *
	 * @since 1.0.0
	 *
	 * @return bool|WP_Query
	 */
	protected function get_program_code_query() {
		$query = new WP_Query( $this->config->options_query_args );

		if ( ! is_object( $query ) || ! $query->have_posts() ) {
			return false;
		}

		return $query;
	}
}