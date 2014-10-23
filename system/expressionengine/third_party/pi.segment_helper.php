<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$plugin_info = array(
  'pi_name' => 'Segment Helper',
  'pi_version' => '1.0.0',
  'pi_author' => 'Matt Turnure',
  'pi_author_url' => 'http://mattturnure.com/',
  'pi_description' => 'Remove Pagination Segment from URLs',
  'pi_usage' => Segment_helper::usage()
);

class Segment_helper
{
  public function clean()
  {
    $this->EE =& get_instance();
    $uri = $this->EE->uri->uri_string();
    $pattern = '/\/?P\d*\/?/';
    $url = preg_replace($pattern, '', $uri);
    return '/' . $url;
  }

  public function remove()
  {
    $this->EE =& get_instance();
    $parameter = $this->EE->TMPL->fetch_param('this_segment');
    $url = new Segment_helper();

    $segment_pattern = '/' . $parameter . '\/?/';    
    $url_sans_segment = preg_replace($segment_pattern, '', $url->clean());
    return $url_sans_segment;
  }

  // --------------------------------------------------------------------

  /**
   * Usage
   *
   * This function describes how the plugin is used.
   *
   * @access  public
   * @return  string
   */
  
  public static function usage()
  {
    ob_start(); 
?>

// Returns current URI minus any Pagination Segment
{exp:pagination_segment:clean}

For example, if the current URI is /template_group/template/permalink/P2, {exp:pagination_segment:clean} will return '/template_group/template/permalink'.

// Returns current URI minus any Pagination Segment and any segment indicated from the 'this_segment' parameter.
{exp:pagination_segment:remove this_segment="{segment_3}"}

For example, if the current URI is /current/uri/remove-this-segment, {exp:pagination_segment:remove this_segment="{segment_3}"} will return '/current/uri/'.


<?php
    $buffer = ob_get_contents();
          
    ob_end_clean(); 
        
    return $buffer;
  }
}
/* End of file pi.pagination_segment.php */ 
/* Location: ./system/expressionengine/third_party/json/pi.pagination_segment.php */
