<?php
class Asana_Rewrite
{
    public function __construct()
    {
        add_shortcode('asana_api', array($this, 'asanaApi'));
        wp_register_style('asana_css', plugins_url('asana/css/asana_css.css'));
    }

    public function asanaApi($atts = [], $content = null)
    {
        wp_enqueue_style('asana_css');
        $settings     = get_option(Asana::OPTION_KEY . '_settings', array());
        $access_token = $settings['access_token'];
        $asana        = new Asana_Client(array(
            'personalAccessToken' => $access_token, // 0/dbc00e35e0f54f0399b7d9584e6b8cc8
        ));
        $queryParam = array();
        if (isset($atts['project'])) {
            $projectId             = $atts['project'];
            $queryParam['project'] = $projectId;
        }

        if (isset($atts['workspace'])) {
            $queryParam['workspace'] = $atts['workspace'];
        }

        if (isset($atts['assignee'])) {
            $queryParam['assignee'] = $atts['assignee'];
        }

        if (isset($atts['workspace'])) {
            $queryParam['workspace'] = $atts['workspace'];
        }

        if (isset($atts['tag'])) {
            $queryParam['tag'] = $atts['tag'];
        }

        if (isset($atts['from'])) {

            $createdTo                    = '';
            $createdFrom                  = $atts['from'];
            $date                         = new DateTime($createdFrom);
            $createdFrom                  = $date->format('Y-m-d\TH:i:s\Z');
            $queryParam['modified_since'] = $createdFrom;

            if (isset($atts['to'])) {
                $createdTo = $atts['to'];
            }
            $result = $asana->getTasksByFilter($queryParam, array('opt_fields' => 'followers,name,notes,assignee,assignee.name,assignee.email,created_at,completed_at,modified_at,workspace'));
            $result = json_decode($result, true);

            if ($createdTo != '') {
                if ($result) {
                    $finalRes = array();
                    foreach ($result['data'] as $res) {
                        $mydate = $res['created_at'];
                        $mydate = date('Y-m-d H:i:s', strtotime($mydate));
                        if ($mydate <= $createdTo) {
                            $finalRes['data'][] = $res;
                        }
                    }
                    $result = $finalRes;
                }
            }

        } elseif (isset($atts['month'])) {

            $from = sprintf("%02d", $atts['month']);

            $date        = new DateTime(date('Y') . '-' . $from . '-01');
            $createdFrom = $date->format('Y-m-d\TH:i:s\Z');

            $date      = new DateTime(date('Y') . '-' . $from . '-' . date('t'));
            $createdTo = $date->format('Y-m-d H:i:s');

            $queryParam['modified_since'] = $createdFrom;

            $result = $asana->getTasksByFilter($queryParam, array('opt_fields' => 'followers,name,notes,assignee,assignee.name,assignee.email,created_at,completed_at,modified_at'));
            $result = json_decode($result, true);

            if ($createdTo != '') {
                if ($result) {
                    $finalRes = array();
                    foreach ($result['data'] as $res) {
                        $mydate = $res['created_at'];
                        $mydate = date('Y-m-d H:i:s', strtotime($mydate));
                        if ($mydate <= $createdTo) {
                            $finalRes['data'][] = $res;
                        }
                    }
                    $result = $finalRes;
                }
            }

        } else {

            $result = $asana->getTasksByFilter($queryParam, array('opt_fields' => 'followers,name,notes,assignee,assignee.name,assignee.email,created_at,completed_at,modified_at,tags,tags.name'));
            $result = json_decode($result, true);
              
        }

        $data = array('tasks' => $result);
        echo Asana_View::render('tasks', $data);

    }

}
