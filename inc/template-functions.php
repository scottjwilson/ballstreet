<?php
/**
 * Get all athlete fields in a structured format
 * Extended version that includes all data needed for single-athlete template
 */
function get_athlete_fields($extended = false) {
    $position = get_field('position');
    $class_year = get_field('class_year') ?: get_field('year');
    $height = get_field('height');
    $weight = get_field('weight');
    $high_school = get_field('high_school');
    $high_school_location = get_field('high_school_location');
    $nil_valuation = get_field('nil_valuation') ?: get_field('valuation');
    
    // Physical stats
    $physical_stats = '';
    if ($height && $weight) {
        $physical_stats = $height . ' / ' . $weight;
    } elseif ($height) {
        $physical_stats = $height;
    } elseif ($weight) {
        $physical_stats = $weight;
    }
    
    // School
    $school = get_field('school');
    $school_id = 0;
    $school_name = '';
    $school_permalink = '';
    if ($school) {
        if (is_array($school)) $school = $school[0];
        if (is_object($school) && isset($school->ID)) {
            $school_id = $school->ID;
            $school_name = $school->post_title;
            $school_permalink = get_permalink($school->ID);
        } elseif (is_numeric($school)) {
            $school_id = $school;
            $school_name = get_the_title($school);
            $school_permalink = get_permalink($school);
        }
    }
    
    // Sponsors
    $sponsors = get_field('sponsors');
    $sponsor_images = array();
    $sponsor_data = array();
    if ($sponsors) {
        if (!is_array($sponsors)) $sponsors = array($sponsors);
        foreach ($sponsors as $sponsor) {
            $sponsor_id = 0;
            $sponsor_name = '';
            $sponsor_permalink = '';
            
            if (is_object($sponsor) && isset($sponsor->ID)) {
                $sponsor_id = $sponsor->ID;
                $sponsor_name = $sponsor->post_title;
                $sponsor_permalink = get_permalink($sponsor->ID);
            } elseif (is_numeric($sponsor)) {
                $sponsor_id = $sponsor;
                $sponsor_name = get_the_title($sponsor);
                $sponsor_permalink = get_permalink($sponsor);
            }
            
            if ($sponsor_id) {
                $img = get_the_post_thumbnail($sponsor_id, 'thumbnail');
                if ($img) {
                    $sponsor_images[] = $img;
                }
                
                // Extended data for single-athlete template
                if ($extended) {
                    $sponsor_data[] = array(
                        'id' => $sponsor_id,
                        'name' => $sponsor_name,
                        'image' => get_the_post_thumbnail($sponsor_id, 'medium', array('class' => 'sponsor-thumb')),
                        'permalink' => $sponsor_permalink
                    );
                }
            }
        }
    }
    
    $result = array(
        'position' => $position,
        'class_year' => $class_year,
        'height' => $height,
        'weight' => $weight,
        'high_school' => $high_school,
        'high_school_location' => $high_school_location,
        'physical_stats' => $physical_stats,
        'nil_valuation' => $nil_valuation,
        'school_id' => $school_id,
        'school_name' => $school_name,
        'school_permalink' => $school_permalink,
        'sponsor_images' => $sponsor_images
    );
    
    if ($extended) {
        $result['sponsor_data'] = $sponsor_data;
    }
    
    return $result;
}

/**
 * Get formatted news posts for an athlete
 */
function get_athlete_news($athlete_id = null) {
    if (!$athlete_id) {
        $athlete_id = get_the_ID();
    }
    
    $news = get_field('news', $athlete_id);
    $news_posts = array();
    
    if ($news) {
        if (!is_array($news)) {
            $news = array($news);
        }
        
        foreach ($news as $news_item) {
            $news_id = 0;
            
            if (is_object($news_item) && isset($news_item->ID)) {
                $news_id = $news_item->ID;
            } elseif (is_numeric($news_item)) {
                $news_id = $news_item;
            }
            
            if ($news_id) {
                $news_posts[] = array(
                    'id' => $news_id,
                    'title' => get_the_title($news_id),
                    'permalink' => get_permalink($news_id),
                    'excerpt' => get_the_excerpt($news_id),
                    'date' => get_the_date('F j, Y', $news_id),
                    'image' => get_the_post_thumbnail($news_id, 'medium', array('class' => 'news-thumb'))
                );
            }
        }
    }
    
    return $news_posts;
}

/**
 * Format NIL valuation for display
 */
function format_nil_valuation($valuation) {
    if (is_numeric($valuation)) {
        if ($valuation >= 1000000) {
            return '$' . number_format($valuation / 1000000, 1) . 'M';
        } elseif ($valuation >= 1000) {
            return '$' . number_format($valuation / 1000, 0) . 'K';
        } else {
            return '$' . number_format($valuation);
        }
    }
    return esc_html($valuation);
}

/**
 * Get associated athlete data from a post
 * Generic function for ACF relationship fields
 */
function get_associated_athlete($post_id = null, $field_name = 'associated_athlete') {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    $athlete = get_field($field_name, $post_id);
    $result = array(
        'id' => 0,
        'name' => '',
        'permalink' => '',
        'image' => '',
        'thumbnail' => ''
    );
    
    if ($athlete) {
        // Handle ACF relationship field (can be object, array, or ID)
        if (is_array($athlete)) {
            $athlete = $athlete[0]; // Get first athlete if multiple
        }
        
        if (is_object($athlete) && isset($athlete->ID)) {
            $result['id'] = $athlete->ID;
            $result['name'] = $athlete->post_title;
            $result['permalink'] = get_permalink($athlete->ID);
            $result['image'] = get_the_post_thumbnail($athlete->ID, 'thumbnail', array('class' => 'athlete-thumb'));
            $result['thumbnail'] = get_the_post_thumbnail($athlete->ID, 'thumbnail');
        } elseif (is_numeric($athlete)) {
            $result['id'] = $athlete;
            $result['name'] = get_the_title($athlete);
            $result['permalink'] = get_permalink($athlete);
            $result['image'] = get_the_post_thumbnail($athlete, 'thumbnail', array('class' => 'athlete-thumb'));
            $result['thumbnail'] = get_the_post_thumbnail($athlete, 'thumbnail');
        }
    }
    
    return $result;
}

/**
 * Get related posts by category
 * Returns formatted array of related post data
 */
function get_related_posts($args = array()) {
    $defaults = array(
        'post_type' => 'post',
        'posts_per_page' => 3,
        'post__not_in' => array(get_the_ID()),
        'orderby' => 'rand'
    );
    
    // Get current post categories if not specified
    if (!isset($args['category__in'])) {
        $categories = get_the_category();
        if (!empty($categories)) {
            $defaults['category__in'] = wp_list_pluck($categories, 'term_id');
        }
    }
    
    $query_args = wp_parse_args($args, $defaults);
    $related_query = new WP_Query($query_args);
    
    $related_posts = array();
    
    if ($related_query->have_posts()) {
        while ($related_query->have_posts()) {
            $related_query->the_post();
            
            $related_posts[] = array(
                'id' => get_the_ID(),
                'title' => get_the_title(),
                'permalink' => get_permalink(),
                'date' => get_the_date('M j, Y'),
                'date_full' => get_the_date('F j, Y'),
                'excerpt' => get_the_excerpt(),
                'thumbnail' => has_post_thumbnail() ? get_the_post_thumbnail(get_the_ID(), 'medium', array('class' => 'related-post-img')) : '',
                'has_thumbnail' => has_post_thumbnail()
            );
        }
        wp_reset_postdata();
    }
    
    return $related_posts;
}

/**
 * Get post categories formatted for display
 */
function get_post_categories_formatted($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    $categories = get_the_category($post_id);
    
    return array(
        'all' => $categories,
        'primary' => !empty($categories) ? $categories[0] : null,
        'first_two' => array_slice($categories, 0, 2),
        'ids' => wp_list_pluck($categories, 'term_id'),
        'names' => wp_list_pluck($categories, 'name')
    );
}

function get_single_post_data($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    return array(
        'athlete' => get_associated_athlete($post_id),
        'categories' => get_post_categories_formatted($post_id),
        'related_posts' => get_related_posts(array('posts_per_page' => 3))
    );
}

/**
 * Generic function to process ACF relationship fields
 * Handles objects, arrays, and numeric IDs
 */
function get_acf_relationship_field($field_name, $post_id = null, $size = 'thumbnail', $class = '') {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    $field = get_field($field_name, $post_id);
    $result = array(
        'id' => 0,
        'name' => '',
        'permalink' => '',
        'image' => '',
        'thumbnail' => '',
        'object' => null
    );
    
    if ($field) {
        // Handle array (multiple relationships)
        if (is_array($field) && !empty($field)) {
            $field = $field[0]; // Get first item
        }
        
        // Handle object
        if (is_object($field) && isset($field->ID)) {
            $result['id'] = $field->ID;
            $result['name'] = $field->post_title;
            $result['permalink'] = get_permalink($field->ID);
            $result['image'] = get_the_post_thumbnail($field->ID, $size, array('class' => $class));
            $result['thumbnail'] = get_the_post_thumbnail($field->ID, $size);
            $result['object'] = $field;
        }
        // Handle numeric ID
        elseif (is_numeric($field)) {
            $result['id'] = $field;
            $result['name'] = get_the_title($field);
            $result['permalink'] = get_permalink($field);
            $result['image'] = get_the_post_thumbnail($field, $size, array('class' => $class));
            $result['thumbnail'] = get_the_post_thumbnail($field, $size);
            $result['object'] = get_post($field);
        }
    }
    
    return $result;
}

/**
 * Get multiple ACF relationship items
 */
function get_acf_relationship_field_multiple($field_name, $post_id = null, $size = 'thumbnail', $class = '') {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    $field = get_field($field_name, $post_id);
    $results = array();
    
    if ($field) {
        if (!is_array($field)) {
            $field = array($field);
        }
        
        foreach ($field as $item) {
            $item_id = 0;
            $item_name = '';
            $item_permalink = '';
            $item_image = '';
            
            if (is_object($item) && isset($item->ID)) {
                $item_id = $item->ID;
                $item_name = $item->post_title;
                $item_permalink = get_permalink($item->ID);
                $item_image = get_the_post_thumbnail($item->ID, $size, array('class' => $class));
            } elseif (is_numeric($item)) {
                $item_id = $item;
                $item_name = get_the_title($item);
                $item_permalink = get_permalink($item);
                $item_image = get_the_post_thumbnail($item, $size, array('class' => $class));
            }
            
            if ($item_id) {
                $results[] = array(
                    'id' => $item_id,
                    'name' => $item_name,
                    'permalink' => $item_permalink,
                    'image' => $item_image,
                    'thumbnail' => get_the_post_thumbnail($item_id, $size),
                    'object' => is_object($item) ? $item : get_post($item_id)
                );
            }
        }
    }
    
    return $results;
}

/**
 * Get formatted post data for card display
 */
function get_post_card_data($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    return array(
        'id' => $post_id,
        'title' => get_the_title($post_id),
        'permalink' => get_permalink($post_id),
        'date' => get_the_date('F j, Y', $post_id),
        'date_short' => get_the_date('M j, Y', $post_id),
        'excerpt' => get_the_excerpt($post_id),
        'thumbnail' => has_post_thumbnail($post_id) ? get_the_post_thumbnail($post_id, 'medium', array('class' => 'article-thumb')) : '',
        'has_thumbnail' => has_post_thumbnail($post_id),
        'categories' => get_post_categories_formatted($post_id)
    );
}

/**
 * Get formatted athlete card data
 */
function get_athlete_card_data($athlete_id = null) {
    if (!$athlete_id) {
        $athlete_id = get_the_ID();
    }
    
    $fields = get_athlete_fields();
    
    return array(
        'id' => $athlete_id,
        'title' => get_the_title($athlete_id),
        'permalink' => get_permalink($athlete_id),
        'thumbnail' => has_post_thumbnail($athlete_id) ? get_the_post_thumbnail($athlete_id, 'medium', array('class' => 'athlete-thumb')) : '',
        'has_thumbnail' => has_post_thumbnail($athlete_id),
        'position' => $fields['position'],
        'class_year' => $fields['class_year'],
        'physical_stats' => $fields['physical_stats'],
        'nil_valuation' => $fields['nil_valuation'],
        'school_id' => $fields['school_id'],
        'school_name' => $fields['school_name'],
        'sponsor_images' => $fields['sponsor_images']
    );
}